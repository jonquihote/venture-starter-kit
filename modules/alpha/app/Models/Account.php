<?php

namespace Venture\Alpha\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasDefaultTenant;
use Filament\Models\Contracts\HasTenants;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;
use Venture\Aeon\Concerns\InteractsWithNotifications;
use Venture\Alpha\Concerns\InteractsWithFilamentUser;
use Venture\Alpha\Database\Factories\AccountFactory;
use Venture\Alpha\Enums\MigrationsEnum;
use Venture\Alpha\Models\Account\Concerns\ConfiguresActivityLog;
use Venture\Alpha\Models\Account\Concerns\InteractsWithCredentials;
use Venture\Alpha\Models\Account\Concerns\InteractsWithTeams;
use Venture\Alpha\Models\Account\Events\AccountCreated;
use Venture\Alpha\Models\Account\Events\AccountCreating;
use Venture\Alpha\Models\Account\Events\AccountDeleted;
use Venture\Alpha\Models\Account\Events\AccountDeleting;
use Venture\Alpha\Models\Account\Events\AccountReplicating;
use Venture\Alpha\Models\Account\Events\AccountRetrieved;
use Venture\Alpha\Models\Account\Events\AccountSaved;
use Venture\Alpha\Models\Account\Events\AccountSaving;
use Venture\Alpha\Models\Account\Events\AccountUpdated;
use Venture\Alpha\Models\Account\Events\AccountUpdating;
use Venture\Alpha\Models\Account\Observers\AccountObserver;

#[UseFactory(AccountFactory::class)]
#[ObservedBy([AccountObserver::class])]
class Account extends Authenticatable implements FilamentUser, HasDefaultTenant, HasTenants
{
    use CausesActivity;
    use ConfiguresActivityLog;
    use HasFactory;
    use HasRoles;
    use InteractsWithCredentials;
    use InteractsWithFilamentUser;
    use InteractsWithNotifications;
    use InteractsWithTeams;
    use LogsActivity;
    use Searchable;

    protected $fillable = [
        'current_team_id',

        'name',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dispatchesEvents = [
        'retrieved' => AccountRetrieved::class,
        'creating' => AccountCreating::class,
        'created' => AccountCreated::class,
        'updating' => AccountUpdating::class,
        'updated' => AccountUpdated::class,
        'saving' => AccountSaving::class,
        'saved' => AccountSaved::class,
        'deleting' => AccountDeleting::class,
        'deleted' => AccountDeleted::class,
        'replicating' => AccountReplicating::class,
    ];

    public function getTable(): string
    {
        return MigrationsEnum::Accounts->table();
    }

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username->value,
            'email' => $this->email->value,
        ];
    }
}
