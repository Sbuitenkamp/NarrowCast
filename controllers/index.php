<?php
require_once('./models/Db.php');
$db = new Db();

function load($url) {
    include(__DIR__ . '\..' . $url . '\index.php');
}

function getSettings() {
    $db = $GLOBALS['db'];
    $result = $db->select([["name", "activated", "timeout", "frequency"], "modules"]);

}