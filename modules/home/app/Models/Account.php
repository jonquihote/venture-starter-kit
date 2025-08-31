<?php

namespace Venture\Home\Models;

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
use Venture\Home\Concerns\InteractsWithFilamentUser;
use Venture\Home\Database\Factories\AccountFactory;
use Venture\Home\Enums\MigrationsEnum;
use Venture\Home\Models\Account\Concerns\ConfigureActivityLog;
use Venture\Home\Models\Account\Concerns\InteractsWithCredentials;
use Venture\Home\Models\Account\Concerns\InteractsWithTeams;
use Venture\Home\Models\Account\Events\AccountCreated;
use Venture\Home\Models\Account\Events\AccountCreating;
use Venture\Home\Models\Account\Events\AccountDeleted;
use Venture\Home\Models\Account\Events\AccountDeleting;
use Venture\Home\Models\Account\Events\AccountReplicating;
use Venture\Home\Models\Account\Events\AccountRetrieved;
use Venture\Home\Models\Account\Events\AccountSaved;
use Venture\Home\Models\Account\Events\AccountSaving;
use Venture\Home\Models\Account\Events\AccountUpdated;
use Venture\Home\Models\Account\Events\AccountUpdating;
use Venture\Home\Models\Account\Observers\AccountObserver;

#[UseFactory(AccountFactory::class)]
#[ObservedBy([AccountObserver::class])]
class Account extends Authenticatable implements FilamentUser, HasDefaultTenant, HasTenants
{
    use CausesActivity;
    use ConfigureActivityLog;
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
