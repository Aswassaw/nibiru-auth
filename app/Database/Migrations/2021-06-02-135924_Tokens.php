<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tokens extends Migration
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
			'email' => [
				'type' => 'VARCHAR',
				'constraint' => 101,
			],
			'token' => [
				'type' => 'VARCHAR',
				'constraint' => 251,
			],
			'type' => [
				'type' => 'VARCHAR',
				'constraint' => 21,
			],
			'created_at' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
			],
		]);

		// Primary
		$this->forge->addKey('id', TRUE);

		// Index
		$this->forge->addKey('email');

		$this->forge->createTable('tokens');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('tokens');
	}
}
