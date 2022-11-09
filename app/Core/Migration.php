<?php

declare(strict_types=1);

namespace App\Core;

interface Migration
{
    public function up():void;
    public function down():void;
}
