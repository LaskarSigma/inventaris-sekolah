<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SchoolSettings extends Settings
{
    public string $headmaster_name;

    public string $infrastructure_head_name;

    public static function group(): string
    {
        return 'school';
    }
}
