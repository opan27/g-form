<?php

namespace App\Models;

use CodeIgniter\Model;

class FormResponseDataModel extends Model
{
    protected $table = 'form_response_data';
    protected $allowedFields = ['response_id', 'field_id', 'value'];
}
