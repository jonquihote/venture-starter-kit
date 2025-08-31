<?php

namespace Venture\Home\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Venture\Home\Database\Factories\MembershipFactory;
use Venture\Home\Enums\MigrationsEnum;
use Venture\Home\Models\Membership\Events\MembershipCreated;
use Venture\Home\Models\Membership\Events\MembershipCreating;
use Venture\Home\Models\Membership\Events\MembershipDeleted;
use Venture\Home\Models\Membership\Events\MembershipDeleting;
use Venture\Home\Models\Membership\Events\MembershipReplicating;
use Venture\Home\Models\Membership\Events\MembershipRetrieved;
use Venture\Home\Models\Membership\Events\MembershipSaved;
use Venture\Home\Models\Membership\Events\MembershipSaving;
use Venture\Home\Models\Membership\Events\MembershipUpdated;
use Venture\Home\Models\Membership\Events\MembershipUpdating;
use Venture\Home\Models\Membership\Observers\MembershipObserver;

#[UseFactory(MembershipFactory::class)]
#[ObservedBy([MembershipObserver::class])]
class Membership extends Model
{
    use HasFactory;

    protected $dispatchesEvents = [
        'retrieved' => MembershipRetrieved::class,
        'creating' => MembershipCreating::class,
        'created' => MembershipCreated::class,
        'updating' => MembershipUpdating::class,
        'updated' => MembershipUpdated::class,
        'saving' => MembershipSaving::class,
        'saved' => MembershipSaved::class,
        'deleting' => MembershipDeleting::class,
        'deleted' => MembershipDeleted::class,
        'replicating' => MembershipReplicating::class,
    ];

    protected $fillable = [
        'account_id',
        'team_id',
    ];

    public function getTable(): string
    {
        return MigrationsEnum::Memberships->table();
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
