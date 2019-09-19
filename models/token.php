<?php
class Token
{
    private $length;
    private $token;
    
    private function generateCsrfToken()
    {
        $this->length = 32;
        $this->token = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $this->length);
        return $this->token;
    }

    public function generate()
    {
        return $this->generateCsrfToken();
    }
}