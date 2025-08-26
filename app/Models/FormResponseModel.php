<?php

namespace App\Models;

use CodeIgniter\Model;

class FormResponseModel extends Model
{
    protected $table = 'form_responses';
    protected $allowedFields = ['form_id'];
    protected $useTimestamps = true;
}
