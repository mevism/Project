<?php

namespace App\Service;

class CustomIds
{
    public function generateId($length = 11)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_';
        $characterCount = strlen($characters);
        $id = '';

        for ($i = 0; $i < $length; $i++) {
            $randomCharacter = $characters[rand(0, $characterCount - 1)];
            $id .= $randomCharacter;
        }

        return $id;
    }
}
