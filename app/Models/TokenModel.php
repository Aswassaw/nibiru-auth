<?php

namespace App\Models;

use CodeIgniter\Model;

class TokenModel extends Model
{
    protected $table      = 'tokens';
    protected $primaryKey = 'id';
    protected $allowedFields = ['email', 'token', 'type', 'created_at'];
}
