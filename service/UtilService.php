<?php

/**
 *
 * Class UtilService
 *
 */
class UtilService
{
    /**
     * Generate a random hexadecimal string
     * @return string
     */
    public function generateRandomToken($nbBytes = 16){
        return bin2hex(openssl_random_pseudo_bytes($nbBytes));
    }

}