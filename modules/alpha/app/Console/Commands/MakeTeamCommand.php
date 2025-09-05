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
                placeholder: 'Acme Corporation',
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
                fn () => search(
                    label: 'Search for the team owner',
                    placeholder: 'Start typing an account name...',
                    options: fn (string $value) => strlen($value) > 0
                        ? Account::where('name', 'like', "%{$value}%")
                            ->pluck('name', 'id')
                            ->all()
                        : [],
                    hint: 'The owner will have full control of this team.'
                ),
                name: 'owner_id'
            )
            ->confirm(
                label: 'Enable single team mode?',
                default: false,
                hint: 'Single team mode restricts the application to one team.',
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
