<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Venture\Home\Models\Account;
use Venture\Home\Models\Account\Events\AccountCreated;
use Venture\Home\Models\Account\Events\AccountCreating;
use Venture\Home\Models\Account\Events\AccountDeleted;
use Venture\Home\Models\Account\Events\AccountDeleting;
use Venture\Home\Models\Account\Events\AccountEvent;
use Venture\Home\Models\Account\Events\AccountReplicating;
use Venture\Home\Models\Account\Events\AccountRetrieved;
use Venture\Home\Models\Account\Events\AccountSaved;
use Venture\Home\Models\Account\Events\AccountSaving;
use Venture\Home\Models\Account\Events\AccountUpdated;
use Venture\Home\Models\Account\Events\AccountUpdating;

describe('AccountEvent Base Class', function (): void {
    test('base AccountEvent has correct properties and traits', function (): void {
        $account = Account::factory()->make();
        $event = new class($account) extends AccountEvent {};

        expect($event)->toHaveProperty('account')
            ->and($event->account)->toBe($account)
            ->and(method_exists($event, '__construct'))->toBeTrue();
    });

    test('AccountEvent uses correct traits', function (): void {
        $traits = class_uses(AccountEvent::class);

        expect($traits)->toContain('Illuminate\Broadcasting\InteractsWithSockets')
            ->and($traits)->toContain('Illuminate\Foundation\Events\Dispatchable')
            ->and($traits)->toContain('Illuminate\Queue\SerializesModels');
    });

    test('AccountEvent constructor accepts Account instance', function (): void {
        $account = Account::factory()->make(['name' => 'Test Account']);
        $event = new class($account) extends AccountEvent {};

        expect($event->account)->toBe($account)
            ->and($event->account->name)->toBe('Test Account');
    });
});

describe('Account Event Classes', function (): void {
    test('all event classes extend AccountEvent', function (): void {
        $eventClasses = [
            AccountCreating::class,
            AccountCreated::class,
            AccountUpdating::class,
            AccountUpdated::class,
            AccountSaving::class,
            AccountSaved::class,
            AccountDeleting::class,
            AccountDeleted::class,
            AccountRetrieved::class,
            AccountReplicating::class,
        ];

        foreach ($eventClasses as $eventClass) {
            expect(is_subclass_of($eventClass, AccountEvent::class))->toBeTrue("$eventClass should extend AccountEvent");
        }
    });

    test('event classes can be instantiated with Account', function (): void {
        $account = Account::factory()->make();

        $events = [
            new AccountCreating($account),
            new AccountCreated($account),
            new AccountUpdating($account),
            new AccountUpdated($account),
            new AccountSaving($account),
            new AccountSaved($account),
            new AccountDeleting($account),
            new AccountDeleted($account),
            new AccountRetrieved($account),
            new AccountReplicating($account),
        ];

        foreach ($events as $event) {
            expect($event)->toBeInstanceOf(AccountEvent::class)
                ->and($event->account)->toBe($account);
        }
    });
});

describe('Event Dispatching', function (): void {
    test('events are dispatched during account creation', function (): void {
        Event::fake();

        $account = Account::factory()->create();

        Event::assertDispatched(AccountCreating::class, function ($event) use ($account) {
            return $event->account->name === $account->name;
        });

        Event::assertDispatched(AccountCreated::class, function ($event) use ($account) {
            return $event->account->id === $account->id;
        });

        Event::assertDispatched(AccountSaving::class, function ($event) use ($account) {
            return $event->account->name === $account->name;
        });

        Event::assertDispatched(AccountSaved::class, function ($event) use ($account) {
            return $event->account->id === $account->id;
        });
    });

    test('events are dispatched during account update', function (): void {
        Event::fake();

        $account = Account::factory()->create();
        Event::fake(); // Reset to ignore creation events

        $account->update(['name' => 'Updated Name']);

        Event::assertDispatched(AccountUpdating::class, function ($event) use ($account) {
            return $event->account->id === $account->id;
        });

        Event::assertDispatched(AccountUpdated::class, function ($event) use ($account) {
            return $event->account->id === $account->id && $event->account->name === 'Updated Name';
        });

        Event::assertDispatched(AccountSaving::class);
        Event::assertDispatched(AccountSaved::class);
    });

    test('events are dispatched during account deletion', function (): void {
        Event::fake();

        $account = Account::factory()->create();
        $accountId = $account->id;
        Event::fake(); // Reset to ignore creation events

        $account->delete();

        Event::assertDispatched(AccountDeleting::class, function ($event) use ($accountId) {
            return $event->account->id === $accountId;
        });

        Event::assertDispatched(AccountDeleted::class, function ($event) use ($accountId) {
            return $event->account->id === $accountId;
        });
    });

    test('AccountRetrieved event is dispatched when account is retrieved', function (): void {
        Event::fake();

        $account = Account::factory()->create();
        Event::fake(); // Reset to ignore creation events

        // Retrieve account from database
        Account::find($account->id);

        Event::assertDispatched(AccountRetrieved::class, function ($event) use ($account) {
            return $event->account->id === $account->id;
        });
    });

    test('AccountReplicating event is dispatched during replication', function (): void {
        Event::fake();

        $account = Account::factory()->create();
        Event::fake(); // Reset to ignore creation events

        $account->replicate();

        Event::assertDispatched(AccountReplicating::class, function ($event) use ($account) {
            return $event->account->name === $account->name;
        });
    });

    test('events contain correct account data', function (): void {
        Event::fake();

        $accountData = [
            'name' => 'Event Test Account',
            'password' => 'test-password-123',
        ];

        $account = Account::factory()->create($accountData);

        Event::assertDispatched(AccountCreated::class, function ($event) use ($accountData) {
            return $event->account->name === $accountData['name'];
        });

        Event::assertDispatched(AccountCreating::class, function ($event) use ($accountData) {
            return $event->account->name === $accountData['name'];
        });
    });

    test('multiple events can be dispatched for same account', function (): void {
        Event::fake();

        $account = Account::factory()->create(['name' => 'Original Name']);
        Event::fake(); // Reset to ignore creation events

        $account->update(['name' => 'First Update']);
        $account->update(['name' => 'Second Update']);

        Event::assertDispatchedTimes(AccountUpdating::class, 2);
        Event::assertDispatchedTimes(AccountUpdated::class, 2);
    });

    test('events are not dispatched when model is not actually changed', function (): void {
        Event::fake();

        $account = Account::factory()->create(['name' => 'Unchanged Name']);
        Event::fake(); // Reset to ignore creation events

        // Update with same value - should not trigger update events
        $account->update(['name' => 'Unchanged Name']);

        Event::assertNotDispatched(AccountUpdating::class);
        Event::assertNotDispatched(AccountUpdated::class);
    });

    test('events work with different account instances', function (): void {
        Event::fake();

        $account1 = Account::factory()->create(['name' => 'Account One']);
        $account2 = Account::factory()->create(['name' => 'Account Two']);

        Event::assertDispatchedTimes(AccountCreated::class, 2);

        Event::assertDispatched(AccountCreated::class, function ($event) {
            return $event->account->name === 'Account One';
        });

        Event::assertDispatched(AccountCreated::class, function ($event) {
            return $event->account->name === 'Account Two';
        });
    });
});

describe('Event Serialization', function (): void {
    test('events can be serialized and unserialized', function (): void {
        $account = Account::factory()->create();
        $event = new AccountCreated($account);

        $serialized = serialize($event);
        $unserialized = unserialize($serialized);

        expect($unserialized)->toBeInstanceOf(AccountCreated::class)
            ->and($unserialized->account->id)->toBe($account->id)
            ->and($unserialized->account->name)->toBe($account->name);
    });

    test('events maintain account relationship after serialization', function (): void {
        $account = Account::factory()->create(['name' => 'Serialization Test']);
        $event = new AccountUpdated($account);

        $serialized = serialize($event);
        $unserialized = unserialize($serialized);

        expect($unserialized->account)->toBeInstanceOf(Account::class)
            ->and($unserialized->account->name)->toBe('Serialization Test')
            ->and($unserialized->account->exists)->toBeTrue();
    });
});
