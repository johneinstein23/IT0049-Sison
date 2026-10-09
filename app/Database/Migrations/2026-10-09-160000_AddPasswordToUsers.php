<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPasswordToUsers extends Migration
{
    private const DEMO_PASSWORD = 'POSdemo2026!';

    public function up()
    {
        if (! $this->db->fieldExists('password', 'users')) {
            $this->forge->addColumn('users', [
                'password' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                ],
            ]);
        }

        // Existing TFA3 accounts receive a demo password as a hash, never as plain text.
        $existingUsers = $this->db->table('users')
            ->select('id')
            ->groupStart()
                ->where('password', null)
                ->orWhere('password', '')
            ->groupEnd()
            ->get()
            ->getResultArray();

        foreach ($existingUsers as $user) {
            $this->db->table('users')
                ->where('id', $user['id'])
                ->update(['password' => password_hash(self::DEMO_PASSWORD, PASSWORD_DEFAULT)]);
        }

        $this->forge->modifyColumn('users', [
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
        ]);
    }

    public function down()
    {
        if ($this->db->fieldExists('password', 'users')) {
            $this->forge->dropColumn('users', 'password');
        }
    }
}
