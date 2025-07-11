<?php

namespace Venture\Home\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Spatie\Permission\Traits\HasRoles;
use Venture\Aeon\Notifications\Notifiable;
use Venture\Home\Database\Factories\UserFactory;
use Venture\Home\Enums\MigrationsEnum;
use Venture\Home\Enums\UserCredentialTypesEnum;
use Venture\Home\Events\Models\UserEvent\UserCreatedEvent;
use Venture\Home\Events\Models\UserEvent\UserDeletedEvent;
use Venture\Home\Events\Models\UserEvent\UserUpdatedEvent;

#[UseFactory(UserFactory::class)]
class User extends Model implements AuthenticatableContract, AuthorizableContract, FilamentUser
{
    use Authenticatable;
    use Authorizable;
    use HasFactory;
    use HasRoles;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The event map for the model.
     *
     * Allows for object-based events for native Eloquent events.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => UserCreatedEvent::class,
        'updated' => UserUpdatedEvent::class,
        'deleted' => UserDeletedEvent::class,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function getTable(): string
    {
        return MigrationsEnum::USERS->table();
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function credentials(): HasMany
    {
        return $this->hasMany(UserCredential::class);
    }

    public function usernames(): HasMany
    {
        return $this->credentials()->where('type', UserCredentialTypesEnum::USERNAME);
    }

    public function username(): HasOne
    {
        return $this->credentials()->one()
            ->where('type', UserCredentialTypesEnum::USERNAME)
            ->where('is_primary', true);
    }

    public function emails(): HasMany
    {
        return $this->credentials()->where('type', UserCredentialTypesEnum::EMAIL);
    }

    public function email(): HasOne
    {
        return $this->credentials()->one()
            ->where('type', UserCredentialTypesEnum::EMAIL)
            ->where('is_primary', true);
    }

    public function addUsername(string $username): void
    {
        $this->credentials()->create([
            'type' => UserCredentialTypesEnum::USERNAME,
            'value' => $username,
            'is_primary' => true,
        ]);
    }

    public function addEmail(string $email): void
    {
        $this->credentials()->create([
            'type' => UserCredentialTypesEnum::EMAIL,
            'value' => $email,
            'is_primary' => true,
        ]);
    }
}
