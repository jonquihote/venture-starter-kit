<?php

namespace Venture\Alpha\Console\Commands;

use Illuminate\Console\Command;
use Venture\Alpha\Models\Application;
use Venture\Alpha\Models\Subscription;
use Venture\Alpha\Models\Team;
use Venture\Alpha\Settings\TenancySettings;

use function Laravel\Prompts\form;
use function Laravel\Prompts\search;
use function Laravel\Prompts\select;

/**
 * @codeCoverageIgnore
 */
class MakeSubscriptionCommand extends Command
{
    protected $signature = 'alpha:make:subscription';

    protected $description = 'Create a new subscription';

    public function handle(): int
    {
        $this->components->info('Creating a new subscription ...');

        $settings = app(TenancySettings::class);

        $data = form()
            ->add(
                function () {
                    $applications = Application::all();

                    return select(
                        label: 'Select Application',
                        options: $applications->pluck('name', 'id')->toArray()
                    );
                },
                name: 'application_id'
            )
            ->add(
                function ($responses) use ($settings) {
                    if ($settings->isSingleTeamMode()) {
                        return $settings->default_team_id;
                    }

                    return search(
                        label: 'Search for the team',
                        hint: 'Teams with existing subscriptions to this application are hidden',
                        options: function (string $value) use ($responses) {
                            return Team::query()
                                ->whereDoesntHave('subscriptions', function ($query) use ($responses): void {
                                    $query->where('application_id', $responses['application_id']);
                                })
                                ->whereLike('name', "%{$value}%", caseSensitive: false)
                                ->get()
                                ->pluck('name', 'id')
                                ->toArray();
                        }
                    );
                },
                name: 'team_id'
            )
            ->submit();

        $subscription = Subscription::create([
            'application_id' => $data['application_id'],
            'team_id' => $data['team_id'],
        ]);

        $this->components->success(
            sprintf(
                'Subscription for "%s" created successfully%s',
                $subscription->application->name,
                $settings->isSingleTeamMode() ? '' : sprintf(' for team "%s"', $subscription->team->name)
            )
        );

        return self::SUCCESS;
    }
}
