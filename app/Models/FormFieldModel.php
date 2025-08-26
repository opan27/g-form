<?php

namespace App\Models;

use CodeIgniter\Model;

class FormFieldModel extends Model
{
    protected $table = 'form_fields';
    protected $allowedFields = ['form_id', 'label', 'type', 'options', 'required', 'urutan'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = ''; // ← Kosongkan agar tidak digunakan

}
