<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use JetBrains\PhpStorm\NoReturn;

class HomeController extends Controller
{
    public function index(): string
    {
        $params = [
            'name' => 'TheWlabs '
        ];
        return self::render("home", $params);
    }

    public function handleContact(Request $request): string
    {
        $body = $request->getBody();
        var_dump($body);
        exit;
        return "Handling Form Submission";
    }
}
