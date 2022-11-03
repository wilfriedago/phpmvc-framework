<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Core\Validator;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return Response|string
     */
    public function login(Request $request): Response | string
    {
        if ($request->isPost()) {
            return (new Response())->json(["success" => "Resource created !"])->setStatus(201);
        }
        return $this->setLayout('auth')->render('login');
    }

    /**
     * @param Request $request
     * @return Response|string
     */
    public function register(Request $request): Response | string
    {
        if ($request->isPost()) {
            $user = new User($request);

            $validator = new Validator($user);
            $validator->rules([
                'firstname' => [Validator::RULE_REQUIRED],
                'lastname' => [Validator::RULE_REQUIRED],
                'username' => [Validator::RULE_REQUIRED],
                'email' => [Validator::RULE_REQUIRED, Validator::RULE_EMAIL],
                'password' => [Validator::RULE_REQUIRED, Validator::RULE_MIN => 8, Validator::RULE_MAX => 24],
                'passwordConfirm' => [Validator::RULE_REQUIRED, Validator::RULE_MATCH => 'password']
            ]);



            if (!$validator->validate()) {
                return (new Response())->json($validator->errors)->setStatus(400);
            }

            // return (new Response())->json(["success" => "Resource created !"])->setStatus(201);
        }
        return $this->setLayout('auth')->render('register');
    }
}
