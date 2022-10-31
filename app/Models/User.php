<?php

namespace App\Models;

use App\Core\Model;
use App\Core\Request;

class User extends Model
{
    public string $firstname;
    public string $lastname;
    public string $username;
    public string $email;
    public string $password;
    public string $passwordConfirm;

    public function __construct(Request $request = null)
    {
        if ($request) {
            self::load($request->body);
        }
    }
}
