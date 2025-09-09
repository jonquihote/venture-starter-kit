<?php

declare(strict_types=1);

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Venture\Aeon\Console\Commands\ResetApplicationCommand;

beforeEach(function (): void {
    // Reset any mocked facades
    File::clearResolvedInstances();
});

describe('ResetApplicationCommand', function (): void {
    it('executes successfully with all operations', function (): void {
        // Mock File facade to prevent actual directory deletion
        File::shouldReceive('deleteDirectories')
            ->once()
            ->with(storage_path('app/public'))
            ->andReturn(true);

        // Create a partial mock of the command to intercept call() method
        $command = Mockery::mock(ResetApplicationCommand::class)->makePartial();
        $command->shouldReceive('call')
            ->with('migrate:fresh')
            ->once()
            ->andReturn(Command::SUCCESS);

        $command->shouldReceive('call')
            ->with('aeon:init:access')
            ->once()
            ->andReturn(Command::SUCCESS);

        $command->shouldReceive('call')
            ->with('alpha:init:engine')
            ->once()
            ->andReturn(Command::SUCCESS);

        $command->shouldReceive('call')
            ->with('db:seed')
            ->once()
            ->andReturn(Command::SUCCESS);

        // Execute the command
        $result = $command->handle();

        // Assert successful execution
        expect($result)->toBe(Command::SUCCESS);
    });

    it('calls operations in the correct order', function (): void {
        $operationOrder = [];

        // Mock File facade
        File::shouldReceive('deleteDirectories')
            ->once()
            ->with(storage_path('app/public'))
            ->andReturnUsing(function () use (&$operationOrder) {
                $operationOrder[] = 'deleteDirectories';

                return true;
            });

        // Create partial mock and track order of operations
        $command = Mockery::mock(ResetApplicationCommand::class)->makePartial();

        $command->shouldReceive('call')
            ->with('migrate:fresh')
            ->once()
            ->andReturnUsing(function () use (&$operationOrder) {
                $operationOrder[] = 'migrate:fresh';

                return Command::SUCCESS;
            });

        $command->shouldReceive('call')
            ->with('aeon:init:access')
            ->once()
            ->andReturnUsing(function () use (&$operationOrder) {
                $operationOrder[] = 'aeon:init:access';

                return Command::SUCCESS;
            });

        $command->shouldReceive('call')
            ->with('alpha:init:engine')
            ->once()
            ->andReturnUsing(function () use (&$operationOrder) {
                $operationOrder[] = 'alpha:init:engine';

                return Command::SUCCESS;
            });

        $command->shouldReceive('call')
            ->with('db:seed')
            ->once()
            ->andReturnUsing(function () use (&$operationOrder) {
                $operationOrder[] = 'db:seed';

                return Command::SUCCESS;
            });

        // Execute the command
        $command->handle();

        // Verify the correct order of operations
        expect($operationOrder)->toBe([
            'deleteDirectories',
            'migrate:fresh',
            'aeon:init:access',
            'alpha:init:engine',
            'db:seed',
        ]);
    });

    it('handles directory deletion when directory exists', function (): void {
        File::shouldReceive('deleteDirectories')
            ->once()
            ->with(storage_path('app/public'))
            ->andReturn(true);

        $command = Mockery::mock(ResetApplicationCommand::class)->makePartial();
        $command->shouldReceive('call')->andReturn(Command::SUCCESS);

        $result = $command->handle();

        expect($result)->toBe(Command::SUCCESS);
    });

    it('handles directory deletion when directory does not exist', function (): void {
        File::shouldReceive('deleteDirectories')
            ->once()
            ->with(storage_path('app/public'))
            ->andReturn(false); // Directory doesn't exist or couldn't be deleted

        $command = Mockery::mock(ResetApplicationCommand::class)->makePartial();
        $command->shouldReceive('call')->andReturn(Command::SUCCESS);

        $result = $command->handle();

        // Command should still succeed even if directory deletion returns false
        expect($result)->toBe(Command::SUCCESS);
    });

    it('continues execution even if migrate:fresh fails', function (): void {
        File::shouldReceive('deleteDirectories')->andReturn(true);

        $command = Mockery::mock(ResetApplicationCommand::class)->makePartial();

        // migrate:fresh fails
        $command->shouldReceive('call')
            ->with('migrate:fresh')
            ->once()
            ->andReturn(Command::FAILURE);

        // But other commands should still be called
        $command->shouldReceive('call')
            ->with('aeon:init:access')
            ->once()
            ->andReturn(Command::SUCCESS);

        $command->shouldReceive('call')
            ->with('alpha:init:engine')
            ->once()
            ->andReturn(Command::SUCCESS);

        $command->shouldReceive('call')
            ->with('db:seed')
            ->once()
            ->andReturn(Command::SUCCESS);

        $result = $command->handle();

        // Command should still return SUCCESS (current implementation)
        expect($result)->toBe(Command::SUCCESS);
    });

    it('continues execution even if init commands fail', function (): void {
        File::shouldReceive('deleteDirectories')->andReturn(true);

        $command = Mockery::mock(ResetApplicationCommand::class)->makePartial();

        $command->shouldReceive('call')
            ->with('migrate:fresh')
            ->once()
            ->andReturn(Command::SUCCESS);

        // aeon:init:access fails
        $command->shouldReceive('call')
            ->with('aeon:init:access')
            ->once()
            ->andReturn(Command::FAILURE);

        // alpha:init:engine fails
        $command->shouldReceive('call')
            ->with('alpha:init:engine')
            ->once()
            ->andReturn(Command::FAILURE);

        // db:seed should still be called
        $command->shouldReceive('call')
            ->with('db:seed')
            ->once()
            ->andReturn(Command::SUCCESS);

        $result = $command->handle();

        // Command should still return SUCCESS (current implementation)
        expect($result)->toBe(Command::SUCCESS);
    });

    it('continues execution even if db:seed fails', function (): void {
        File::shouldReceive('deleteDirectories')->andReturn(true);

        $command = Mockery::mock(ResetApplicationCommand::class)->makePartial();

        $command->shouldReceive('call')
            ->with('migrate:fresh')
            ->once()
            ->andReturn(Command::SUCCESS);

        $command->shouldReceive('call')
            ->with('aeon:init:access')
            ->once()
            ->andReturn(Command::SUCCESS);

        $command->shouldReceive('call')
            ->with('alpha:init:engine')
            ->once()
            ->andReturn(Command::SUCCESS);

        // db:seed fails
        $command->shouldReceive('call')
            ->with('db:seed')
            ->once()
            ->andReturn(Command::FAILURE);

        $result = $command->handle();

        // Command should still return SUCCESS (current implementation)
        expect($result)->toBe(Command::SUCCESS);
    });
});

describe('ResetApplicationCommand Properties', function (): void {
    it('has correct signature', function (): void {
        $command = new ResetApplicationCommand;
        $reflection = new ReflectionClass($command);
        $signature = $reflection->getProperty('signature');
        $signature->setAccessible(true);

        expect($signature->getValue($command))->toBe('aeon:reset-application');
    });

    it('has correct aliases', function (): void {
        $command = new ResetApplicationCommand;
        $reflection = new ReflectionClass($command);
        $aliases = $reflection->getProperty('aliases');
        $aliases->setAccessible(true);

        expect($aliases->getValue($command))->toBe(['reset']);
    });

    it('has correct description', function (): void {
        $command = new ResetApplicationCommand;
        $reflection = new ReflectionClass($command);
        $description = $reflection->getProperty('description');
        $description->setAccessible(true);

        expect($description->getValue($command))->toBe('Reset application to its pristine state');
    });
});

describe('ResetApplicationCommand Integration', function (): void {
    it('is registered and accessible via signature', function (): void {
        // Test that we can resolve the command from the container
        $command = app(ResetApplicationCommand::class);
        expect($command)->toBeInstanceOf(ResetApplicationCommand::class);

        // Test that the command has the correct signature
        expect($command->getName())->toBe('aeon:reset-application');
    });

    it('has correct aliases configured', function (): void {
        $command = app(ResetApplicationCommand::class);
        expect($command->getAliases())->toBe(['reset']);
    });

    it('has correct description configured', function (): void {
        $command = app(ResetApplicationCommand::class);
        expect($command->getDescription())->toBe('Reset application to its pristine state');
    });

    it('command exists in application and can be found', function (): void {
        // Test that the command can be found by Laravel's command resolver
        // This tests that the command is properly registered
        $exitCode = null;
        $output = [];

        try {
            $exitCode = $this->artisan('help', ['command_name' => 'aeon:reset-application'])->run();
            expect($exitCode)->toBe(0);
        } catch (\Exception $e) {
            // If the command doesn't exist, this will throw an exception
            throw new \PHPUnit\Framework\AssertionFailedError(
                'Command aeon:reset-application is not registered: ' . $e->getMessage()
            );
        }
    });

    it('alias exists and can be found', function (): void {
        // Test that the alias can be found by Laravel's command resolver
        $exitCode = null;

        try {
            $exitCode = $this->artisan('help', ['command_name' => 'reset'])->run();
            expect($exitCode)->toBe(0);
        } catch (\Exception $e) {
            // If the command doesn't exist, this will throw an exception
            throw new \PHPUnit\Framework\AssertionFailedError(
                'Command alias reset is not registered: ' . $e->getMessage()
            );
        }
    });
});
