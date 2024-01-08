<?php

namespace Config;

use CodeIgniter\Database\Config;

class Database extends Config
{
    public string $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;

    public string $defaultGroup = 'default';
    public $default = [];

    public function __construct()
    {
        $this->default = [
            'DSN' => '',
            'hostname' => 'localhost',
            'username' => 'news',
            'password' => $_ENV['database.default.password'],
            'database' => 'citizen_news',
            'DBDriver' => 'MySQLi',
            'DBPrefix' => '',
            'pConnect' => false,
            'DBDebug' => true,
            'charset' => 'utf8mb4',
            'DBCollat' => 'utf8mb4_general_ci',
            'swapPre' => '',
            'encrypt' => false,
            'compress' => false,
            'strictOn' => false,
            'failover' => [],
            'port' => 3306,
            'numberNative' => false,
        ];
    }
}