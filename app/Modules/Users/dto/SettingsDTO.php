<?php

namespace App\Modules\Users\dto;

use Illuminate\Http\Request;

class SettingsDTO
{
   private $user_id;
    private $key;
    private $value;

    public function __construct($user_id, $key, $value)
    {
        $this->user_id = $user_id;
        $this->key = $key;
        $this->value = $value;
    }

    public static function createFromArray(array $data)
    {
        return new self(
            $data['user_id'] ?? null,
            $data['key'] ?? null,
            $data['value'] ?? null
        );
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getValue()
    {
        return $this->value;
    }

}
