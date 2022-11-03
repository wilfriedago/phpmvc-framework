<?php

declare(strict_types=1);

namespace App\Core;

class Model
{
    /**
     * @param array $data
     * @return void
     */
    public function load(array $data): void
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }
}
