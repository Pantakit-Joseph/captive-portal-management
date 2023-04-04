<?php

namespace App\Models\Issues;

use CodeIgniter\Model;

class IssueFilesModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'app_issue_files';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'issue_id',
        'file',
    ];
}
