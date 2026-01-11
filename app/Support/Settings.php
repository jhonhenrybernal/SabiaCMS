<?php

namespace App\Support;

use App\Models\Setting;

class Settings
{
    public static function get(string $key, $default = null)
    {
        $row = Setting::where('key', $key)->first();
        return $row ? $row->value : $default;
    }

    public static function put(string $key, $value): void
    {
        Setting::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
