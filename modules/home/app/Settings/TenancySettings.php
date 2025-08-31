<?php

namespace Venture\Home\Settings;

use Spatie\LaravelSettings\Settings;
use Venture\Home\Enums\SettingsGroupsEnum;
use Venture\Home\Models\Team;

class TenancySettings extends Settings
{
    public bool $is_single_team_mode = false;

    public ?int $default_team_id = null;

    public static function group(): string
    {
        return SettingsGroupsEnum::Tenancy->scope();
    }

    public function isSingleTeamMode(): bool
    {
        return $this->is_single_team_mode;
    }

    public function defaultTeam(): Team
    {
        return Team::find($this->default_team_id);
    }
}
