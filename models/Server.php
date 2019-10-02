<?php
namespace NarrowCast;
use Exception;
use Ratchet\ConnectionInterface as Connection;
use Ratchet\MessageComponentInterface;
use SplObjectStorage;
require_once  __DIR__ . '/../vendor/autoload.php';

class Server implements MessageComponentInterface
{
    /**
     * @var SplObjectStorage
     */
    protected $connections;
    private $db;

    public function __construct($db = null)
    {
        $this->connections = new SplObjectStorage();
        $this->db = $db;
    }

    /**
     * @param Connection $connection
     */
    public function onOpen(Connection $connection)
    {
        $this->connections->attach($connection);
        echo "connection made\n";
    }

    /**
     * @param Connection $connection
     * @param string $message
     * @throws Exception
     */
    public function onMessage(Connection $connection, $message) // yes this method is pretty long..... meh
    {
        try {
            $message = json_decode($message, true);
            switch ($message["type"]) {
                case "module":
                    $data = $this->db->select([
                        ["name", "timeout"], // values
                        "modules", // table
                        ["activated" => true, "id" => $message["id"]], // conditions
                        1 // limit
                    ]);
                    if (isset($data[0])) {
                        $dataToSend = [
                            "type" => "html",
                            "html" => $this->loadModule($data[0]["name"]),
                            "timeout" => $data[0]["timeout"]
                        ];
                        $connection->send(json_encode($dataToSend, JSON_PRETTY_PRINT));
                    } else $connection->send(json_encode(["type" => "htmlNotFound"], JSON_PRETTY_PRINT));
                    break;
                case "init":
                    $data = $this->db->select([
                        ["name", "timeout", "activated"], // values
                        "modules", // table
                        ["activated" => true], // conditions
                        1 // limit
                    ]);
                    $settings = $this->getSettings();
                    $dataToSend = [
                        "type" => "html",
                        "html" => $this->loadModule($data[0]["name"]),
                        "timeout" => $data[0]["timeout"],
                        "settings" => $settings[0]
                    ];
                    $connection->send(json_encode($dataToSend, JSON_PRETTY_PRINT));
                    break;
                case "admin":
                    $dataToSend = $this->initAdmin();
                    $dataToSend["type"] = "admin";
                    $connection->send(json_encode($dataToSend, JSON_PRETTY_PRINT));
                    break;
                case "updateModule":
                    $params = [
                        [], // values
                        "modules", // table
                        ["id" => $message["id"]] // conditions
                    ];
                    foreach ($message["values"] as $key => $value) {
                        if ($key === "name") $value = "'" . $value . "'";
                        $params[0][$key] = $value;
                    }
                    $this->db->update($params);
                    // init again
                    $dataToSend = $this->initAdmin();
                    $dataToSend["type"] = "updatedModule";
                    $this->broadCast(json_encode($dataToSend, JSON_PRETTY_PRINT));
                    break;
                case "updateSettings":
                    $params = [
                        [], // values
                        "general_settings", // table
                        ["id" => 1] // conditions
                    ];
                    foreach ($message["values"] as $key => $value) {
                        if ($key === "load_order") $value = "'" . $value . "'";
                        $params[0][$key] = $value;
                    }
                    $dataToSend = [
                        "type" => "updatedSettings",
                        "generalSetting" => $this->db->update($params),
                    ];
                    $this->broadCast(json_encode($dataToSend, JSON_PRETTY_PRINT));
                    break;
                case "updateAnimation":
                    $params = [
                        ["current_animation" => $message["animation"]], //values
                        "general_settings", //table
                        ["id" => 1] //conditions
                    ];
                    $dataToSend = [
                        "type" => "updatedAnimation",
                        "result" => $this->db->update($params)
                    ];
                    $this->broadCast(json_encode($dataToSend, JSON_PRETTY_PRINT));
                    break;
                case "createModule":
                    $params = [
                        ["name", "activated", "timeout"], // columns
                        ["'" . $message["name"] . "'", 1, $message["timeout"]], // values
                        "modules", // table
                    ];
                    $dataToSend = [
                        "type" => "createdModule",
                        "result" => $this->db->insert($params)
                    ];
                    $this->broadCast(json_encode($dataToSend, JSON_PRETTY_PRINT));
                    break;
                case "deleteModule":
                    $params = [
                        "modules", // table
                        ["id" => $message["id"]] // conditions
                    ];
                    $this->db->delete($params);
                    $dataToSend = $this->initAdmin();
                    $dataToSend["type"] = "deletedModule";
                    $this->broadCast(json_encode($dataToSend, JSON_PRETTY_PRINT));
                    break;
                case "createUser":
                    $params = [
                        ["username", "password"], // columns
                        ["'" . $message["username"] . "'", "'" . $password = password_hash($message["password"], PASSWORD_BCRYPT) . "'"], // values
                        "users", // table
                    ];
                    $this->db->insert($params);
                    $connection->send(json_encode(["type" => "createdUser"], JSON_PRETTY_PRINT));
                    break;
                default:
                    throw new Exception("Invalid message type. (this is a human made error message)");
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @param Connection $connection
     */
    public function onClose(Connection $connection)
    {
        $this->connections->detach($connection);
    }

    /**
     * @param Connection $connection
     * @param Exception $e
     */
    public function onError(Connection $connection, Exception $e)
    {
        $connection->close();
    }

    private function broadCast(string $message)
    {
        foreach ($this->connections as $connection) $connection->send($message);
    }

    // returns the file after execution in plaintext html format
    private function loadModule(string $url)
    {
        ob_start();
        include __DIR__ . "\..\modules\\". $url . "\index.php";
        return ob_get_clean();
    }

    // get the general settings
    private function getSettings()
    {
        return $this->db->select([
            ["current_animation AS currentAnimation", "load_order AS loadOrder", "people_watched AS peopleWatched"], // values
            "general_settings", // table
            [], // conditions
            1 // limit
        ]);
    }

    // get settings + all modulesettings
    private function initAdmin()
    {
        $modules = $this->db->select([
            ["*"], // values
            "modules", // table
            [], // conditions
            null
        ]);
        $settings = $this->getSettings();
        return [
            "moduleSettings" => $modules,
            "generalSettings" => $settings[0],
            "type" => ''
        ];
    }
}