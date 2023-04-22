<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModels extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'username', 'password'];
}
