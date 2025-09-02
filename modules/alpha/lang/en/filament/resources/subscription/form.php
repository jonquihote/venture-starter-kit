<?php

return [

    'fields' => [

        'team' => [
            'label' => 'Team',
        ],

        'application' => [
            'label' => 'Application',
        ],

    ],

    'validation' => [

        'unique' => [
            'team_already_subscribed' => 'This team is already subscribed to the selected application.',
        ],

    ],

];
