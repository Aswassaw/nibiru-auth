<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Activitylogs extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			],
			'id_users' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'null' => TRUE,
			],
			'log' => [
				'type' => 'VARCHAR',
				'constraint' => 255,
			],
		]);

		// Menambahkan field created_at
		$this->forge->addField('created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP()');

		// Primary Key
		$this->forge->addKey('id', TRUE);

		// Foreign Key
		$this->forge->addForeignKey('id_users', 'users', 'id', 'CASCADE', 'RESTRICT');

		// Index
		$this->forge->addKey('id_users');

		$this->forge->createTable('activitylogs');
	}

	public function down()
	{
		$this->forge->dropTable('activitylogs');
	}
}
