<?php

namespace Config;

use CodeIgniter\Database\Config;

class Database extends Config
{
    public string $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;

    public string $defaultGroup = 'default';

    public array $default = [
        'DSN'      => '',
        'hostname' => env('database.default.hostname', 'localhost'),
        'username' => env('database.default.username', 'root'),
        'password' => env('database.default.password', ''),
        'database' => env('database.default.database', 'pos_database'),
        'DBDriver' => env('database.default.DBDriver', 'MySQLi'),
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug'  => true,
        'charset'  => 'utf8mb4',
        'DBCollat' => 'utf8mb4_general_ci',
        'swapPre'  => '',
        'encrypt'  => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port'     => (int) env('database.default.port', 3306),
    ];
}
