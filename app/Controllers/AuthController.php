<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;

class AuthController extends Controller
{
    public function login(Request $request): string
    {
        if ($request->isPost()) {
            return "Submitted data";
        }
        return self::render('login');
    }

    public function register(Request $request):string
    {
        if ($request->isPost()) {
            return "Submitted data";
        }
        return self::render('register');
    }
}
