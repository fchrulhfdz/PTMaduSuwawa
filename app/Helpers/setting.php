<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    function setting($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('setting');
        }

        return app('setting')->get($key, $default);
    }
}