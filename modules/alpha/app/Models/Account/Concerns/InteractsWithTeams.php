<?php

namespace Venture\Alpha\Models\Account\Concerns;

use Filament\Panel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Venture\Alpha\Models\Membership;
use Venture\Alpha\Models\Team;
use Venture\Alpha\Settings\TenancySettings;

trait InteractsWithTeams
{
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, Membership::class)
            ->withTimestamps()
            ->as('membership');
    }

    public function memberships(): HasMany
    {
        return $this->hasMany(Membership::class);
    }

    public function ownedTeams(): HasMany
    {
        return $this->hasMany(Team::class, 'owner_id');
    }

    public function allTeams(): Collection
    {
        return $this->teams->merge($this->ownedTeams);
    }

    public function currentTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'current_team_id');
    }

    public function getTenants(Panel $panel): Collection
    {
        $settings = App::make(TenancySettings::class);

        return $settings->isSingleTeamMode()
            ? Collection::make([$settings->defaultTeam()])
            : $this->allTeams();
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return $this->teams()->whereKey($tenant)->exists() ||
               $this->ownedTeams()->whereKey($tenant)->exists();
    }

    public function getDefaultTenant(Panel $panel): ?Model
    {
        $settings = App::make(TenancySettings::class);

        return $settings->isSingleTeamMode()
            ? $settings->defaultTeam()
            : $this->currentTeam;
    }
}
