<?php

namespace App\Core;

class Request
{
    public static function capture()
    {
        return new static();
    }
} 