<?php

namespace Venture\Alpha\Database\Seeders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Seeder;
use Venture\Alpha\Concerns\InteractsWithModule;
use Venture\Alpha\Models\Application;
use Venture\Alpha\Models\Subscription;
use Venture\Alpha\Models\Team;

class SubscriptionSeeder extends Seeder
{
    use InteractsWithModule;

    public function run(): void
    {
        $team = Team::query()
            ->whereHas('owner', function (Builder $query): void {
                $query->whereUsername('zeus');
            })
            ->first();

        $application = Application::query()
            ->where('slug', $this->getModuleSlug())
            ->first();

        Subscription::factory()->create([
            'team_id' => $team,
            'application_id' => $application,
        ]);
    }
}
