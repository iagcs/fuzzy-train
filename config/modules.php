<?php

return [

    'stubs' => [
        'enabled'      => FALSE,
        'path'         => base_path('vendor/nwidart/laravel-modules/src/Commands/stubs'),
        'files'        => [
            'routes/web'      => 'routes/web.php',
            'routes/api'      => 'routes/api.php',
            'scaffold/config' => 'config/config.php',
            'composer'        => 'composer.json',
            'package'         => 'package.json',
        ],
        'replacements' => [
            'routes/web'      => ['LOWER_NAME', 'STUDLY_NAME', 'MODULE_NAMESPACE', 'CONTROLLER_NAMESPACE'],
            'routes/api'      => ['LOWER_NAME', 'STUDLY_NAME', 'MODULE_NAMESPACE', 'CONTROLLER_NAMESPACE'],
            'vite'            => ['LOWER_NAME', 'STUDLY_NAME'],
            'json'            => ['LOWER_NAME', 'STUDLY_NAME', 'MODULE_NAMESPACE', 'PROVIDER_NAMESPACE'],
            'views/index'     => ['LOWER_NAME'],
            'views/master'    => ['LOWER_NAME', 'STUDLY_NAME'],
            'scaffold/config' => ['STUDLY_NAME'],
            'composer'        => [
                'LOWER_NAME',
                'STUDLY_NAME',
                'VENDOR',
                'AUTHOR_NAME',
                'AUTHOR_EMAIL',
                'MODULE_NAMESPACE',
                'PROVIDER_NAMESPACE',
                'APP_FOLDER_NAME',
            ],
        ],
        'gitkeep'      => FALSE,
    ],
    'paths' => [

        'modules' => base_path('Modules'),

        'assets' => public_path('modules'),

        'migration' => base_path('database/migrations'),

        'app_folder' => 'app/',

        'generator' => [
            // app/
            'actions'         => ['path' => 'app/Actions', 'generate' => FALSE],
            'casts'           => ['path' => 'app/Casts', 'generate' => FALSE],
            'channels'        => ['path' => 'app/Broadcasting', 'generate' => FALSE],
            'class'           => ['path' => 'app/Classes', 'generate' => FALSE],
            'command'         => ['path' => 'app/Console', 'generate' => FALSE],
            'component-class' => ['path' => 'app/View/Components', 'generate' => FALSE],
            'emails'          => ['path' => 'app/Mail', 'generate' => FALSE],
            'event'           => ['path' => 'app/Events', 'generate' => FALSE],
            'enums'           => ['path' => 'app/Enums', 'generate' => FALSE],
            'exceptions'      => ['path' => 'app/Exceptions', 'generate' => FALSE],
            'jobs'            => ['path' => 'app/Jobs', 'generate' => FALSE],
            'helpers'         => ['path' => 'app/Helpers', 'generate' => FALSE],
            'interfaces'      => ['path' => 'app/Interfaces', 'generate' => FALSE],
            'listener'        => ['path' => 'app/Listeners', 'generate' => FALSE],
            'model'           => ['path' => 'app/Models', 'generate' => FALSE],
            'notifications'   => ['path' => 'app/Notifications', 'generate' => FALSE],
            'observer'        => ['path' => 'app/Observers', 'generate' => FALSE],
            'policies'        => ['path' => 'app/Policies', 'generate' => FALSE],
            'provider'        => ['path' => 'app/Providers', 'generate' => TRUE],
            'repository'      => ['path' => 'app/Repositories', 'generate' => FALSE],
            'route-provider'  => ['path' => 'app/Providers', 'generate' => TRUE],
            'rules'           => ['path' => 'app/Rules', 'generate' => FALSE],
            'services'        => ['path' => 'app/Services', 'generate' => FALSE],
            'scopes'          => ['path' => 'app/Models/Scopes', 'generate' => FALSE],
            'traits'          => ['path' => 'app/Traits', 'generate' => FALSE],

            // app/Http/
            'controller'      => ['path' => 'app/Http/Controllers', 'generate' => TRUE],
            'filter'          => ['path' => 'app/Http/Middleware', 'generate' => FALSE],
            'request'         => ['path' => 'app/Http/Requests', 'generate' => FALSE],
            'resource'        => ['path' => 'app/Http/Resources', 'generate' => FALSE],

            // config/
            'config'          => ['path' => 'config', 'generate' => TRUE],

            // database/
            'factory'         => ['path' => 'database/factories', 'generate' => TRUE],
            'migration'       => ['path' => 'database/migrations', 'generate' => TRUE],
            'seeder'          => ['path' => 'database/seeders', 'generate' => TRUE],

            // lang/
            'lang'            => ['path' => 'lang', 'generate' => FALSE],

            // resource/
            'assets'          => ['path' => 'resources/assets', 'generate' => TRUE],
            'component-view'  => ['path' => 'resources/views/components', 'generate' => FALSE],
            'views'           => ['path' => 'resources/views', 'generate' => TRUE],

            // routes/
            'routes'          => ['path' => 'routes', 'generate' => TRUE],

            // tests/
            'test-feature'    => ['path' => 'tests/Feature', 'generate' => TRUE],
            'test-unit'       => ['path' => 'tests/Unit', 'generate' => TRUE],
        ],
    ],

    'auto-discover' => [

        'migrations' => FALSE,

        'translations' => FALSE,

    ],

    'composer' => [
        'vendor'          => env('MODULE_VENDOR', 'fuzzy'),
        'author'          => [
            'name'  => env('MODULE_AUTHOR_NAME', 'fuzzy'),
            'email' => env('MODULE_AUTHOR_EMAIL', 'ti@fuzzy.ai'),
        ],
        'composer-output' => FALSE,
    ],

    'register' => [
        'translations' => FALSE,

        'files' => 'register',
    ],
];
