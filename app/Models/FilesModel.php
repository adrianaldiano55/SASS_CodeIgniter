<?php

namespace App\Models;

use CodeIgniter\Model;

class FilesModel extends Model
{
    protected $table = 'files';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'userId',
        'fileName',
        'fileType',
        'fileSize',
        'fileData',
        'fileRole',
        'fileStatus',
        'critic',
        'upload_at',
    ];

    protected $returnType = 'array';
}