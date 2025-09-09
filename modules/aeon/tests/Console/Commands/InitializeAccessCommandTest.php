<?php

declare(strict_types=1);

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Venture\Aeon\Console\Commands\InitializeAccessCommand;
use Venture\Aeon\Facades\Access;

beforeEach(function (): void {
    // Clear facade resolved instances
    Access::clearResolvedInstances();
});

describe('InitializeAccessCommand', function (): void {
    it('executes successfully with permissions', function (): void {
        // Simple test with string permissions
        $testPermissions = new Collection(['dashboard', 'users.view', 'posts.create']);

        // Mock Access facade to return test permissions
        Access::shouldReceive('permissions')
            ->once()
            ->andReturn($testPermissions);

        // Test via artisan call to verify the command works
        $exitCode = $this->artisan('aeon:init:access')->run();

        expect($exitCode)->toBe(Command::SUCCESS);
    });

    it('handles empty permissions collection gracefully', function (): void {
        $emptyPermissions = new Collection;

        // Mock Access facade to return empty collection
        Access::shouldReceive('permissions')
            ->once()
            ->andReturn($emptyPermissions);

        $exitCode = $this->artisan('aeon:init:access')->run();

        expect($exitCode)->toBe(Command::SUCCESS);
    });
});

describe('InitializeAccessCommand Registration', function (): void {
    it('is registered in the application', function (): void {
        $command = app(InitializeAccessCommand::class);
        expect($command)->toBeInstanceOf(InitializeAccessCommand::class);
        expect($command->getName())->toBe('aeon:init:access');
    });
});
