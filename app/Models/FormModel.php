<?php

namespace App\Models;

use CodeIgniter\Model;

class FormModel extends Model
{
    protected $table = 'forms';
    protected $allowedFields = ['judul', 'deskripsi', 'slug','gambar'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = ''; // ← Kosongkan agar tidak digunakan

}
