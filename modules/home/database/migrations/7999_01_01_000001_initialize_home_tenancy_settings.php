<?php

use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;
use Venture\Home\Enums\SettingsGroupsEnum;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->inGroup(SettingsGroupsEnum::Tenancy->scope(), function (SettingsBlueprint $blueprint): void {
            $blueprint->add('is_single_team_mode', false);
            $blueprint->add('default_team_id', null);
        });
    }
};
