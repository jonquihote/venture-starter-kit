<?php

namespace Venture\Home\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Venture\Aeon\Notifications\Notifiable;
use Venture\Home\Database\Factories\UserFactory;
use Venture\Home\Enums\MigrationsEnum;
use Venture\Home\Events\Models\UserEvent\UserCreatedEvent;
use Venture\Home\Events\Models\UserEvent\UserDeletedEvent;
use Venture\Home\Events\Models\UserEvent\UserUpdatedEvent;

#[UseFactory(UserFactory::class)]
class User extends Authenticatable
{
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
        'email',
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
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getTable(): string
    {
        return MigrationsEnum::USERS->table();
    }

    protected static function newFactory()
    {
        return UserFactory::new();
    }
}
