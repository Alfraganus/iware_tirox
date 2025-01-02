<?php

namespace App\Modules\Users\dto;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserDTO
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * Create a new UserDTO instance.
     *
     * @param string $name
     * @param string $type_user
     * @param string $email
     * @param string $password
     */
    public function __construct($name,$email, $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public static function createFromRequest(Request $request)
    {
        return new self(
            $request->input('name'),
            $request->input('email'),
            $request->input('password')
        );
    }
    public function toArray()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ];
    }

}
