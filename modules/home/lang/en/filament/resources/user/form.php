<?php

return [

    'sections' => [

        'usernames' => [

            'label' => 'Usernames',
            'add-action-label' => 'Add username',

            'validation-messages' => [

                'at-least-one-true' => 'User is required to have at least one primary username.',

            ],

        ],

        'emails' => [

            'label' => 'Emails',
            'add-action-label' => 'Add email',

            'validation-messages' => [

                'at-least-one-true' => 'User is required to have at least one primary email.',

            ],

        ],

        'roles' => [

            'label' => 'Roles',

        ],

    ],

    'fields' => [

        'name' => [

            'label' => 'Name',

        ],

        'password' => [

            'label' => 'Password',

        ],

        'password_confirmation' => [

            'label' => 'Confirm Password',

        ],

    ],

];
