<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserVerificationFields extends Migration
{
    public function up()
    {
        if (!$this->db->fieldExists('status', 'users')) {
            $this->forge->addColumn('users', [
                'status' => [
                    'type' => 'VARCHAR',
                    'constraint' => 45,
                    'default' => 'approved',
                ],
            ]);
        }

        if (!$this->db->fieldExists('created_at', 'users')) {
            $this->forge->addColumn('users', [
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ]);
        }

        if (!$this->db->fieldExists('verification_remark', 'users')) {
            $this->forge->addColumn('users', [
                'verification_remark' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
            ]);
        }
    }

    public function down()
    {
        foreach (['verification_remark', 'created_at'] as $field) {
            if ($this->db->fieldExists($field, 'users')) {
                $this->forge->dropColumn('users', $field);
            }
        }
    }
}
