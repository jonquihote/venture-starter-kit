<?php

return [

    'actions' => [

        'password' => [

            'heading' => 'Update Password',

            'description' => 'Changing a user\'s password will end the user\'s session. The user will be logged out immediately.',

            'fields' => [

                'password' => [

                    'label' => 'Password',

                ],

                'password_confirmation' => [

                    'label' => 'Confirm Password',

                ],

            ],

            'notifications' => [

                'success' => [

                    'title' => 'Updated!',

                ],

            ],

        ],

    ],

];
