<?php

namespace App\Controllers;

use App\Models\FormModel;
use App\Models\FormFieldModel;

class PublicForm extends BaseController
{
    public function view($slug)
    {
        $formModel = new FormModel();
        $fieldModel = new FormFieldModel();

        $form = $formModel->where('slug', $slug)->first();
        if (!$form) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Form tidak ditemukan");
        }

        $fields = $fieldModel->where('form_id', $form['id'])->orderBy('urutan', 'ASC')->findAll();

        return view('form/view', [
            'form' => $form,
            'fields' => $fields
        ]);
    }

    public function submit($slug)
    {
        // proses submit bisa dibuat di tahap selanjutnya
        return redirect()->back()->with('success', 'Form berhasil dikirim (simulasi)');
    }
}
