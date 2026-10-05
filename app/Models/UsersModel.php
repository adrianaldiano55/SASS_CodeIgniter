<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'loginId',
        'password',
        'role',
        'firstname',
        'middlename',
        'lastname',
        'sex',
        'age',
        'email',
        'program',
        'year',
        'contact',
        'address',
        'login_at',
        'logout_at',
    ];

    protected $returnType = 'array';
}