<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivitylogModel extends Model
{
    protected $table      = 'activitylogs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_users', 'log', 'created_at'];
}
