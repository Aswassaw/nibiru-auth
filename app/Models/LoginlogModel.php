<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginlogModel extends Model
{
    protected $table      = 'loginlogs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_users', 'ip', 'browser', 'platform'];
}
