<?php

namespace App\Helpers;

class ViewHelpers
{
    public static function getStatusClass($status) 
    {
        return match($status) {
            'active' => 'bg-green-100 text-green-800',
            'deprecated' => 'bg-red-100 text-red-800',
            'maintenance' => 'bg-yellow-100 text-yellow-800',
            'development' => 'bg-blue-100 text-blue-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public static function formatDate($date) 
    {
        return date('d/m/Y H:i', strtotime($date));
    }
} 