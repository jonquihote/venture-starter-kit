<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Venture\Alpha\Models\Account;
use Venture\Alpha\Models\Account\Events\AccountCreated;
use Venture\Alpha\Models\Account\Events\AccountCreating;
use Venture\Alpha\Models\Account\Events\AccountDeleted;
use Venture\Alpha\Models\Account\Events\AccountDeleting;
use Venture\Alpha\Models\Account\Events\AccountRetrieved;
use Venture\Alpha\Models\Account\Events\AccountSaved;
use Venture\Alpha\Models\Account\Events\AccountSaving;
use Venture\Alpha\Models\Account\Events\AccountUpdated;
use Venture\Alpha\Models\Account\Events\AccountUpdating;
use Venture\Alpha\Models\Account\Observers\AccountObserver;

describe('Account Event System', function (): void {
    beforeEach(function (): void {
        Event::fake();
    });

    describe('Account Creation Events', function (): void {
        it('dispatches AccountCreating event before creation', function (): void {
            $account = Account::factory()->make([
                'name' => 'John Doe',
                'password' => 'secure-password-123',
            ]);

            $account->save();

            Event::assertDispatched(AccountCreating::class, function ($event) use ($account) {
                return $event->account->name === $account->name
                    && $event->account->password === $account->password;
            });
        });

        it('dispatches AccountCreated event after creation', function (): void {
            $account = Account::factory()->create([
                'name' => 'Jane Smith',
                'password' => 'another-secure-password',
            ]);

            Event::assertDispatched(AccountCreated::class, function ($event) use ($account) {
                return $event->account->id === $account->id
                    && $event->account->name === $account->name
                    && $event->account->exists;
            });
        });
    });

    describe('Account Update Events', function (): void {
        it('dispatches AccountUpdating event before update', function (): void {
            $account = Account::factory()->create(['name' => 'Original Name']);

            $account->name = 'Updated Name';
            $account->save();

            Event::assertDispatched(AccountUpdating::class, function ($event) use ($account) {
                return $event->account->id === $account->id
                    && $event->account->name === 'Updated Name';
            });
        });

        it('dispatches AccountUpdated event after update', function (): void {
            $account = Account::factory()->create(['name' => 'Original Name']);

            $account->update(['name' => 'Updated Name']);

            Event::assertDispatched(AccountUpdated::class, function ($event) use ($account) {
                return $event->account->id === $account->id
                    && $event->account->name === 'Updated Name'
                    && $event->account->wasChanged('name');
            });
        });
    });

    describe('Account Save Events', function (): void {
        it('dispatches AccountSaving event before save', function (): void {
            $account = Account::factory()->make([
                'name' => 'Test User',
                'password' => 'test-password',
            ]);

            $account->save();

            Event::assertDispatched(AccountSaving::class, function ($event) use ($account) {
                return $event->account->name === $account->name
                    && $event->account->password === $account->password;
            });
        });

        it('dispatches AccountSaved event after save', function (): void {
            $account = Account::factory()->create([
                'name' => 'Saved User',
                'password' => 'saved-password',
            ]);

            Event::assertDispatched(AccountSaved::class, function ($event) use ($account) {
                return $event->account->id === $account->id
                    && $event->account->name === $account->name
                    && $event->account->exists;
            });
        });
    });

    describe('Account Deletion Events', function (): void {
        it('dispatches AccountDeleting event before deletion', function (): void {
            $account = Account::factory()->create(['name' => 'To Be Deleted']);

            $account->delete();

            Event::assertDispatched(AccountDeleting::class, function ($event) use ($account) {
                return $event->account->id === $account->id
                    && $event->account->name === 'To Be Deleted';
            });
        });

        it('dispatches AccountDeleted event after deletion', function (): void {
            $account = Account::factory()->create(['name' => 'Deleted User']);
            $accountId = $account->id;

            $account->delete();

            Event::assertDispatched(AccountDeleted::class, function ($event) use ($accountId) {
                return $event->account->id === $accountId
                    && $event->account->name === 'Deleted User';
            });
        });
    });

    describe('Account Retrieval Event', function (): void {
        it('dispatches AccountRetrieved event on fetch', function (): void {
            $account = Account::factory()->create(['name' => 'Retrieved User']);

            // Clear events from creation
            Event::fake();

            // Retrieve the account to trigger the event
            $retrievedAccount = Account::find($account->id);

            Event::assertDispatched(AccountRetrieved::class, function ($event) use ($retrievedAccount) {
                return $event->account->id === $retrievedAccount->id
                    && $event->account->name === $retrievedAccount->name;
            });
        });
    });

    describe('Observer Method Invocations', function (): void {
        it('verifies observer is properly registered for Account model', function (): void {
            // Test that the Account model has the AccountObserver properly configured
            $reflection = new ReflectionClass(Account::class);
            $attributes = $reflection->getAttributes();

            $observedByAttribute = collect($attributes)
                ->first(fn ($attr) => $attr->getName() === 'Illuminate\Database\Eloquent\Attributes\ObservedBy');

            expect($observedByAttribute)->not->toBeNull();
            expect($observedByAttribute->getArguments())->toContain([AccountObserver::class]);
        });

        it('confirms AccountObserver has all required lifecycle methods', function (): void {
            $observer = new AccountObserver;

            expect(method_exists($observer, 'retrieved'))->toBeTrue();
            expect(method_exists($observer, 'creating'))->toBeTrue();
            expect(method_exists($observer, 'created'))->toBeTrue();
            expect(method_exists($observer, 'updating'))->toBeTrue();
            expect(method_exists($observer, 'updated'))->toBeTrue();
            expect(method_exists($observer, 'saving'))->toBeTrue();
            expect(method_exists($observer, 'saved'))->toBeTrue();
            expect(method_exists($observer, 'deleting'))->toBeTrue();
            expect(method_exists($observer, 'deleted'))->toBeTrue();
            expect(method_exists($observer, 'replicating'))->toBeTrue();
        });

        it('verifies observer methods accept Account parameter', function (): void {
            $observer = new AccountObserver;
            $account = Account::factory()->create();

            // Test that observer methods can be called without errors
            expect(fn () => $observer->retrieved($account))->not->toThrow(TypeError::class);
            expect(fn () => $observer->creating($account))->not->toThrow(TypeError::class);
            expect(fn () => $observer->created($account))->not->toThrow(TypeError::class);
            expect(fn () => $observer->updating($account))->not->toThrow(TypeError::class);
            expect(fn () => $observer->updated($account))->not->toThrow(TypeError::class);
            expect(fn () => $observer->saving($account))->not->toThrow(TypeError::class);
            expect(fn () => $observer->saved($account))->not->toThrow(TypeError::class);
            expect(fn () => $observer->deleting($account))->not->toThrow(TypeError::class);
            expect(fn () => $observer->deleted($account))->not->toThrow(TypeError::class);
            expect(fn () => $observer->replicating($account))->not->toThrow(TypeError::class);
        });
    });

    describe('Event Data Integrity', function (): void {
        it('ensures events contain correct Account model instance', function (): void {
            $account = Account::factory()->create([
                'name' => 'Event Test User',
                'password' => 'event-test-password',
            ]);

            Event::assertDispatched(AccountCreated::class, function ($event) use ($account) {
                return $event->account instanceof Account
                    && $event->account->id === $account->id
                    && $event->account->name === 'Event Test User'
                    && get_class($event->account) === Account::class;
            });
        });

        it('ensures events are properly serializable', function (): void {
            $account = Account::factory()->create(['name' => 'Serializable Test']);

            Event::assertDispatched(AccountCreated::class, function ($event) {
                // Test that the event can be serialized (important for queued listeners)
                $serialized = serialize($event);
                $unserialized = unserialize($serialized);

                return $unserialized->account instanceof Account
                    && $unserialized->account->name === 'Serializable Test';
            });
        });
    });
});
