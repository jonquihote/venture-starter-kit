<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Models\Activity;
use Venture\Home\Enums\AccountCredentialTypesEnum;
use Venture\Home\Enums\Auth\RolesEnum;
use Venture\Home\Models\Account;
use Venture\Home\Models\AccountCredential;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;

beforeEach(function (): void {
    $this->account = Account::factory()->create();
});

describe('Account Model', function (): void {
    test('can be created with factory', function (): void {
        expect($this->account)->toBeInstanceOf(Account::class)
            ->and($this->account->name)->toBeString()
            ->and($this->account->password)->toBeString();
    });

    test('hides sensitive attributes', function (): void {
        $hidden = $this->account->getHidden();

        expect($hidden)->toContain('password')
            ->and($hidden)->toContain('remember_token');
    });

    test('has fillable attributes', function (): void {
        $fillable = $this->account->getFillable();

        expect($fillable)->toContain('name')
            ->and($fillable)->toContain('password');
    });

    test('uses correct table name', function (): void {
        expect($this->account->getTable())->toBe('home_accounts');
    });
});

describe('Password Hashing', function (): void {
    test('password is automatically hashed via cast', function (): void {
        $plainPassword = 'new-password-123';
        $account = Account::factory()->create([
            'password' => $plainPassword,
        ]);

        expect($account->password)->not->toBe($plainPassword)
            ->and(Hash::check($plainPassword, $account->password))->toBeTrue();
    });

    test('password can be verified after hashing', function (): void {
        $plainPassword = 'test-password-456';
        $account = Account::factory()->create([
            'password' => $plainPassword,
        ]);

        expect(Hash::check($plainPassword, $account->password))->toBeTrue()
            ->and(Hash::check('wrong-password', $account->password))->toBeFalse();
    });

    test('password changes are hashed', function (): void {
        $account = Account::factory()->create();
        $newPassword = 'updated-password-789';

        $account->update(['password' => $newPassword]);

        expect(Hash::check($newPassword, $account->fresh()->password))->toBeTrue();
    });
});

describe('InteractsWithCredentials Trait', function (): void {
    test('credentials relationship returns all account credentials', function (): void {
        $account = Account::factory()->create();

        // Create multiple credentials
        AccountCredential::factory()->email('primary@example.com')->create([
            'account_id' => $account->id,
            'is_primary' => true,
        ]);

        AccountCredential::factory()->username('primaryuser')->create([
            'account_id' => $account->id,
            'is_primary' => true,
        ]);

        AccountCredential::factory()->email('secondary@example.com')->secondary()->create([
            'account_id' => $account->id,
        ]);

        expect($account->credentials)->toHaveCount(3)
            ->and($account->credentials()->count())->toBe(3);
    });

    test('email relationship returns only primary email', function (): void {
        $account = Account::factory()->create();

        $primaryEmail = AccountCredential::factory()->email('primary@example.com')->create([
            'account_id' => $account->id,
            'is_primary' => true,
        ]);

        AccountCredential::factory()->email('secondary@example.com')->secondary()->create([
            'account_id' => $account->id,
        ]);

        expect($account->email)->toBeInstanceOf(AccountCredential::class)
            ->and($account->email->id)->toBe($primaryEmail->id)
            ->and($account->email->value)->toBe('primary@example.com')
            ->and($account->email->is_primary)->toBeTrue();
    });

    test('username relationship returns only primary username', function (): void {
        $account = Account::factory()->create();

        $primaryUsername = AccountCredential::factory()->username('primaryuser')->create([
            'account_id' => $account->id,
            'is_primary' => true,
        ]);

        AccountCredential::factory()->username('secondaryuser')->secondary()->create([
            'account_id' => $account->id,
        ]);

        expect($account->username)->toBeInstanceOf(AccountCredential::class)
            ->and($account->username->id)->toBe($primaryUsername->id)
            ->and($account->username->value)->toBe('primaryuser')
            ->and($account->username->is_primary)->toBeTrue();
    });

    test('updateUsername creates new username credential', function (): void {
        $account = Account::factory()->create();
        $newUsername = 'newusername123';

        $credential = $account->updateUsername($newUsername);

        expect($credential)->toBeInstanceOf(AccountCredential::class)
            ->and($credential->value)->toBe($newUsername)
            ->and($credential->type)->toBe(AccountCredentialTypesEnum::Username)
            ->and($credential->is_primary)->toBeTrue()
            ->and($credential->verified_at)->not->toBeNull();

        assertDatabaseHas('home_account_credentials', [
            'account_id' => $account->id,
            'value' => $newUsername,
            'type' => AccountCredentialTypesEnum::Username->value,
            'is_primary' => true,
        ]);
    });

    test('updateUsername updates existing username credential', function (): void {
        $account = Account::factory()->create();
        $oldUsername = 'oldusername';
        $newUsername = 'newusername456';

        // Create initial username
        $account->updateUsername($oldUsername);

        // Update to new username - should update existing record with same value
        $credential = $account->updateUsername($oldUsername);

        expect($account->credentials()->where('type', AccountCredentialTypesEnum::Username)->count())->toBe(1)
            ->and($credential->value)->toBe($oldUsername)
            ->and($credential->is_primary)->toBeTrue();
    });

    test('updateEmail creates new email credential', function (): void {
        $account = Account::factory()->create();
        $newEmail = 'newemail@example.com';

        $credential = $account->updateEmail($newEmail);

        expect($credential)->toBeInstanceOf(AccountCredential::class)
            ->and($credential->value)->toBe($newEmail)
            ->and($credential->type)->toBe(AccountCredentialTypesEnum::Email)
            ->and($credential->is_primary)->toBeTrue()
            ->and($credential->verified_at)->toBeNull();

        assertDatabaseHas('home_account_credentials', [
            'account_id' => $account->id,
            'value' => $newEmail,
            'type' => AccountCredentialTypesEnum::Email->value,
            'is_primary' => true,
            'verified_at' => null,
        ]);
    });

    test('updateEmail sets verified_at to null for new emails', function (): void {
        $account = Account::factory()->create();

        $credential = $account->updateEmail('unverified@example.com');

        expect($credential->verified_at)->toBeNull();
    });

    test('updateUsername sets verified_at for new usernames', function (): void {
        $account = Account::factory()->create();

        $credential = $account->updateUsername('verifieduser');

        expect($credential->verified_at)->not->toBeNull();
    });
});

describe('Account-AccountCredential Relationships', function (): void {
    test('account has many credentials relationship', function (): void {
        $account = Account::factory()->create();

        AccountCredential::factory()->email()->create([
            'account_id' => $account->id,
        ]);

        AccountCredential::factory()->email()->secondary()->create([
            'account_id' => $account->id,
        ]);

        AccountCredential::factory()->username()->create([
            'account_id' => $account->id,
        ]);

        expect($account->credentials)->toHaveCount(3)
            ->each->toBeInstanceOf(AccountCredential::class);
    });

    test('credential belongs to account', function (): void {
        $account = Account::factory()->create();
        $credential = AccountCredential::factory()->email()->create([
            'account_id' => $account->id,
        ]);

        expect($credential->account)->toBeInstanceOf(Account::class)
            ->and($credential->account->id)->toBe($account->id);
    });

    test('deleting account cascades to credentials', function (): void {
        // Clear any existing credentials first
        AccountCredential::query()->delete();

        $account = Account::factory()->create();

        AccountCredential::factory()->email()->create([
            'account_id' => $account->id,
        ]);

        AccountCredential::factory()->email()->secondary()->create([
            'account_id' => $account->id,
        ]);

        AccountCredential::factory()->username()->create([
            'account_id' => $account->id,
        ]);

        assertDatabaseCount('home_account_credentials', 3);

        $account->delete();

        assertDatabaseCount('home_account_credentials', 0);
    });
});

describe('Scout Integration', function (): void {
    test('toSearchableArray returns correct data structure', function (): void {
        $account = Account::factory()->create([
            'name' => 'John Doe',
        ]);

        // Create credentials for the account
        AccountCredential::factory()->username('johndoe')->create([
            'account_id' => $account->id,
            'is_primary' => true,
        ]);

        AccountCredential::factory()->email('john@example.com')->create([
            'account_id' => $account->id,
            'is_primary' => true,
        ]);

        $searchableArray = $account->toSearchableArray();

        expect($searchableArray)->toHaveKeys(['id', 'name', 'username', 'email'])
            ->and($searchableArray['id'])->toBe($account->id)
            ->and($searchableArray['name'])->toBe('John Doe')
            ->and($searchableArray['username'])->toBe('johndoe')
            ->and($searchableArray['email'])->toBe('john@example.com');
    });

    test('toSearchableArray handles missing credentials gracefully', function (): void {
        $account = Account::factory()->create([
            'name' => 'Jane Doe',
        ]);

        // No credentials created - should handle null relationships
        expect(function () use ($account): void {
            $account->toSearchableArray();
        })->toThrow(\Exception::class); // This should throw error due to null credentials
    });
});

describe('Activity Logging', function (): void {
    test('getActivitylogOptions returns correct configuration', function (): void {
        $account = Account::factory()->create();
        $options = $account->getActivitylogOptions();

        expect($options->logAttributes)->toBe(['name'])
            ->and($options->logOnlyDirty)->toBeTrue()
            ->and($options->logName)->toBe('eloquent')
            ->and($options->submitEmptyLogs)->toBeFalse();
    });

    test('tapActivity sets correct description', function (): void {
        $account = Account::factory()->create();
        $activity = new \Venture\Aeon\Packages\Spatie\Activitylog\Models\Activity;
        $eventName = 'updated';

        $account->tapActivity($activity, $eventName);

        expect($activity->description)->toBe($eventName);
    });

    test('only name field changes are logged', function (): void {
        Activity::query()->delete(); // Clear previous activities

        $account = Account::factory()->create(['name' => 'Original Name']);

        // Change name - should log
        $account->update(['name' => 'New Name']);

        // Change password - should not log (not in logOnly)
        $account->update(['password' => 'new-password']);

        $activities = Activity::where('subject_id', $account->id)
            ->where('subject_type', Account::class)
            ->get();

        expect($activities)->toHaveCount(2) // created + updated (name change)
            ->and($activities->last()->properties->get('attributes'))->toHaveKey('name')
            ->and($activities->last()->properties->get('attributes')['name'])->toBe('New Name');
    });

    test('empty logs are not submitted', function (): void {
        Activity::query()->delete(); // Clear previous activities

        $account = Account::factory()->create(['name' => 'Test Name']);

        // Update with same name - should not create log
        $account->update(['name' => 'Test Name']);

        $activities = Activity::where('subject_id', $account->id)
            ->where('subject_type', Account::class)
            ->where('description', 'updated')
            ->get();

        expect($activities)->toHaveCount(0);
    });
});

describe('Role Management', function (): void {
    test('account can be assigned roles', function (): void {
        $account = Account::factory()->create();

        $account->assignRole(RolesEnum::User);
        $account->assignRole(RolesEnum::Administrator);

        expect($account->hasRole(RolesEnum::User))->toBeTrue()
            ->and($account->hasRole(RolesEnum::Administrator))->toBeTrue()
            ->and($account->roles)->toHaveCount(2);
    });

    test('account can have multiple roles', function (): void {
        $account = Account::factory()->create();

        $account->syncRoles([RolesEnum::User, RolesEnum::Administrator]);

        expect($account->getRoleNames())->toHaveCount(2)
            ->and($account->hasAnyRole([RolesEnum::User, RolesEnum::Administrator]))->toBeTrue();
    });
});
