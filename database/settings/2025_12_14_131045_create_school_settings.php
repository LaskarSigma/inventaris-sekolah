<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('school.headmaster_name', 'Saiful Anwar, S.Pd.');
        $this->migrator->add('school.infrastructure_head_name', 'Tias Rahmawati. O, S.Pd.');
    }
};
