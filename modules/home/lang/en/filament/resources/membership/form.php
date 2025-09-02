<?php

return [

    'fields' => [

        'account' => [
            'label' => 'Account',
        ],

        'team' => [
            'label' => 'Team',
        ],

    ],

    'validation' => [

        'unique' => [
            'account_already_member' => 'This account is already a member of the selected team.',
        ],

    ],

];
