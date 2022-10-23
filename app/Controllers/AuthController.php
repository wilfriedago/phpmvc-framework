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
        return $this->setLayout('auth')->render('login');
    }

    public function register(Request $request):string
    {
        if ($request->isPost()) {
            return "Submitted data";
        }
        return $this->setLayout('auth')->render('register');
    }
}
