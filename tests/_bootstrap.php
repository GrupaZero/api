<?php

if (file_exists(dirname(__DIR__) . '/.env.testing')) {
    (new \Dotenv\Dotenv(dirname(__DIR__), '.env.testing'))->load();
}

// Here you can initialize variables that will be available to your tests
\Codeception\Configuration::$defaultSuiteSettings['modules']['config']['Db'] = [
    'dsn'      => 'pgsql:host=' . env('DB_HOST', 'localhost') .
        ';port=' . env('DB_PORT', 5432) .
        ';dbname=' . env('DB_DATABASE', 'gzero_cms') .
        ';user=' . env('DB_USERNAME', 'postgres') .
        ';password=',
    'user'     => env('DB_USERNAME', 'postgres'),
    'password' => env('DB_PASSWORD', ''),
    'dump'     => (isPlatformRun()) ? '../testing/db/dump.sql' : 'vendor/gzero/testing/db/dump.sql',
    'populate' => true,
    'cleanup'  => true
];

function isPlatformRun()
{
    return preg_match('|vendor\/gzero\/api\/$|', \Codeception\Configuration::projectDir());
}