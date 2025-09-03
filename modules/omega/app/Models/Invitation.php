<?php

namespace Venture\Omega\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use InvitationFactory;
use Venture\Omega\Enums\MigrationsEnum;

#[UseFactory(InvitationFactory::class)]
class Invitation extends Model
{
    use HasFactory;

    public function getTable(): string
    {
        return MigrationsEnum::Invitations->table();
    }
}
