<?php

namespace Venture\Alpha\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Venture\Alpha\Models\Account;
use Venture\Alpha\Models\Team;
use Venture\Alpha\Rules\ValidName;
use Venture\Alpha\Settings\TenancySettings;

use function Laravel\Prompts\form;
use function Laravel\Prompts\search;

/**
 * @codeCoverageIgnore
 */
class MakeTeamCommand extends Command
{
    protected $signature = 'alpha:make:team';

    protected $description = 'Create a new team';

    public function handle(): int
    {
        $this->components->info('Creating a new team ...');

        $data = form()
            ->text(
                label: 'Team Name',
                validate: [
                    'name' => [
                        'required',
                        new ValidName,
                    ],
                ],
                name: 'name',
                transform: function (string $value) {
                    return Str::squish($value);
                }
            )
            ->add(
                function () {
                    return search(
                        label: 'Search for the team owner',
                        options: function (string $value) {
                            return Account::query()
                                ->whereLike('name', "%{$value}%", caseSensitive: false)
                                ->get()
                                ->pluck('name', 'id')
                                ->toArray();
                        },
                    );
                },
                name: 'owner_id'
            )
            ->confirm(
                label: 'Enable Single Team Mode?',
                default: false,
                name: 'single_team_mode'
            )
            ->submit();

        $team = DB::transaction(function () use ($data) {
            $team = Team::create([
                'name' => $data['name'],
                'owner_id' => $data['owner_id'],
            ]);

            if ($data['single_team_mode']) {
                $settings = app(TenancySettings::class);
                $settings->is_single_team_mode = true;
                $settings->default_team_id = $team->id;
                $settings->save();
            }

            return $team;
        });

        $this->components->success(
            sprintf(
                'Team "%s" created successfully%s',
                $team->name,
                $data['single_team_mode'] ? ' with single team mode enabled' : ''
            )
        );

        return self::SUCCESS;
    }
}
