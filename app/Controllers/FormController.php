<?php

namespace App\Controllers;
use App\Models\FormFieldModel;
use App\Models\FormModel;
use App\Models\FormResponseModel;
use App\Models\FormResponseDataModel;
use CodeIgniter\HTTP\ResponseInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;




class FormController extends BaseController
{   

    public function newForm()
{
    return view('admin/form/new');
}


    public function index()
    {
        $model = new FormModel();
        $data['forms'] = $model->findAll();
        return view('admin/form/index', $data);
    }
    
public function create()
{
    $formModel = new \App\Models\FormModel();

    $judul = $this->request->getPost('judul');
    $slug  = url_title($judul, '-', true);
    $deskripsi = $this->request->getPost('deskripsi');

    // ✅ Handle file upload
    $file = $this->request->getFile('gambar');
    $gambarName = null;

    if ($file && $file->isValid() && !$file->hasMoved()) {
        $gambarName = $file->getRandomName();
        $file->move('uploads/forms', $gambarName);
    }

    $formId = $formModel->insert([
        'judul' => $judul,
        'slug'  => $slug,
        'deskripsi' => $deskripsi,
        'gambar' => $gambarName // ✅ simpan ke DB
    ]);

    return redirect()->to("/admin/forms/$formId/fields")
        ->with('success', 'Form berhasil dibuat. Silakan tambahkan pertanyaan.');
}

   public function store()
{
    $formModel = new \App\Models\FormModel();

    $judul = $this->request->getPost('judul');
    $slug = url_title($judul, '-', true);
    $deskripsi = $this->request->getPost('deskripsi');

    // Proses upload gambar
    $file = $this->request->getFile('gambar');
    $namaFile = null;
    if ($file && $file->isValid() && !$file->hasMoved()) {
        $namaFile = $file->getRandomName();
        $file->move('uploads/forms/', $namaFile);
    }

    // Simpan ke database
    $formModel->insert([
        'judul'     => $judul,
        'slug'      => $slug,
        'deskripsi' => $deskripsi,
        'gambar'    => $namaFile
    ]);

    return redirect()->to('/admin/forms')->with('success', 'Form berhasil dibuat.');
}

    public function delete($id)
    {
        $model = new FormModel();
        $model->delete($id);
        return redirect()->to('/admin/forms')->with('success', 'Form dihapus.');
    }
    public function fields($form_id)
{
    $formModel = new \App\Models\FormModel();
    $fieldModel = new \App\Models\FormFieldModel();

    $form = $formModel->find($form_id);
    if (!$form) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Form tidak ditemukan");
    }

    $fields = $fieldModel->where('form_id', $form_id)->orderBy('urutan', 'ASC')->findAll();

    return view('admin/form/fields', [
        'form' => $form,
        'fields' => $fields
    ]);
}

public function addField($form_id)
{
    $fieldModel = new FormFieldModel();

    $type = $this->request->getPost('type');
    $options = in_array($type, ['radio', 'checkbox', 'select']) 
        ? json_encode(explode("\n", trim($this->request->getPost('options')))) 
        : null;

    $fieldModel->insert([
        'form_id' => $form_id,
        'label' => $this->request->getPost('label'),
        'type' => $type,
        'options' => $options,
        'required' => $this->request->getPost('required') ? 1 : 0,
        'urutan' => $this->request->getPost('urutan') ?? 1,
    ]);

    // Buat / perbarui tabel jawaban form flat
    $this->createResponseTableForForm($form_id);

    return redirect()->to("/admin/forms/$form_id/fields")->with('success', 'Pertanyaan ditambahkan.');
}

    public function editField($form_id, $field_id)
{
    $fieldModel = new \App\Models\FormFieldModel();
    $field = $fieldModel->find($field_id);

    if (!$field || $field['form_id'] != $form_id) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Pertanyaan tidak ditemukan");
    }

    return view('admin/form/edit_field', [
        'form_id' => $form_id,
        'field' => $field
    ]);
}
    public function updateField($form_id, $field_id)
{
    $fieldModel = new \App\Models\FormFieldModel();
    $type = $this->request->getPost('type');

    $options = in_array($type, ['radio', 'checkbox', 'select']) 
        ? json_encode(explode("\n", trim($this->request->getPost('options'))))
        : null;

    $fieldModel->update($field_id, [
        'label' => $this->request->getPost('label'),
        'type' => $type,
        'options' => $options,
        'required' => $this->request->getPost('required') ? 1 : 0,
    ]);

    return redirect()->to("/admin/forms/$form_id/fields")->with('success', 'Pertanyaan berhasil diperbarui.');
}
public function deleteField($form_id, $field_id)
{
    $fieldModel = new \App\Models\FormFieldModel();
    $field = $fieldModel->find($field_id);

    if ($field && $field['form_id'] == $form_id) {
        $fieldModel->delete($field_id);
    }

    return redirect()->to("/admin/forms/$form_id/fields")->with('success', 'Pertanyaan berhasil dihapus.');
}
public function responses($form_id)
{
    $formModel = new \App\Models\FormModel();
    $fieldModel = new \App\Models\FormFieldModel();
    $responseModel = new \App\Models\FormResponseModel();
    $responseDataModel = new \App\Models\FormResponseDataModel();

    $form = $formModel->find($form_id);
    if (!$form) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Form tidak ditemukan");
    }

    $fields = $fieldModel->where('form_id', $form_id)->orderBy('id', 'asc')->findAll();
    $responses = $responseModel->where('form_id', $form_id)->orderBy('id', 'desc')->findAll();

    // AMBIL ID response
    $responseIDs = array_column($responses, 'id');

    // AMAN: hanya ambil response data jika response_ids tidak kosong
    $responseData = [];
    if (!empty($responseIDs)) {
        $responseData = $responseDataModel
            ->whereIn('response_id', $responseIDs)
            ->findAll();
    }

    // Kelompokkan data jawaban per response_id
    $grouped = [];
    foreach ($responseData as $d) {
        $grouped[$d['response_id']][$d['field_id']] = $d['value'];
    }

    return view('admin/form/responses', [
        'form' => $form,
        'fields' => $fields,
        'responses' => $responses,
        'data' => $grouped
    ]);
}
public function submit($slug)
{
    $formModel = new \App\Models\FormModel();
    $fieldModel = new \App\Models\FormFieldModel();
    $responseModel = new \App\Models\FormResponseModel();
    $responseDataModel = new \App\Models\FormResponseDataModel();

    $form = $formModel->where('slug', $slug)->first();
    if (!$form) throw new \CodeIgniter\Exceptions\PageNotFoundException("Form tidak ditemukan");

    // Simpan respon utama
    $responseId = $responseModel->insert([
        'form_id' => $form['id'],
        'created_at' => date('Y-m-d H:i:s')
    ]);

    // Simpan data per pertanyaan
    $fields = $fieldModel->where('form_id', $form['id'])->findAll();

    foreach ($fields as $f) {
        $key = 'field_' . $f['id'];
        $val = $this->request->getPost($key);
        if (is_array($val)) $val = implode(', ', $val);

        $responseDataModel->insert([
            'response_id' => $responseId,
            'field_id' => $f['id'],
            'value' => $val ?? ''
        ]);
    }

    return redirect()->to("/form/$slug")->with('success', 'Terima kasih, jawaban Anda sudah terkirim.');
}


public function view($slug)
{
    $formModel = new FormModel();
    $fieldModel = new FormFieldModel();

    $form = $formModel->where('slug', $slug)->first();
    if (!$form) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Form tidak ditemukan");
    }

    $fields = $fieldModel->where('form_id', $form['id'])->orderBy('id', 'asc')->findAll();

    return view('form/view', [
        'form' => $form,
        'fields' => $fields
    ]);
}
public function export($form_id)
{
    $formModel = new FormModel();
    $fieldModel = new FormFieldModel();
    $responseModel = new FormResponseModel();
    $responseDataModel = new FormResponseDataModel();

    $form = $formModel->find($form_id);
    if (!$form) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Form tidak ditemukan");
    }

    $fields = $fieldModel->where('form_id', $form_id)->orderBy('id', 'asc')->findAll();
    $responses = $responseModel->where('form_id', $form_id)->orderBy('id', 'asc')->findAll();
    $responseData = $responseDataModel->whereIn('response_id', array_column($responses, 'id'))->findAll();

    // Gabungkan data berdasarkan response_id
    $grouped = [];
    foreach ($responseData as $d) {
        $grouped[$d['response_id']][$d['field_id']] = $d['value'];
    }

    // Inisialisasi spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set header kolom
    $header = ['Tanggal'];
    foreach ($fields as $f) {
        $header[] = $f['label'];
    }

    // Tulis header ke baris pertama (row 1)
    foreach ($header as $colIndex => $colName) {
        $cell = $this->columnFromIndex($colIndex) . '1';
        $sheet->setCellValue($cell, $colName);
    }

    // Tulis isi datanya
    $rowNum = 2;
    foreach ($responses as $r) {
        $sheet->setCellValue('A' . $rowNum, $r['created_at']);

        foreach ($fields as $i => $f) {
            $colLetter = $this->columnFromIndex($i + 1); // +1 karena kolom A dipakai tanggal
            $value = $grouped[$r['id']][$f['id']] ?? '';
            $sheet->setCellValue($colLetter . $rowNum, $value);
        }

        $rowNum++;
    }

    // Download sebagai file Excel
    $filename = 'form_' . $form['slug'] . '_responses.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}


private function createResponseTableForForm($form_id)
{
    $db = \Config\Database::connect();
    $forge = \Config\Database::forge($db); // ✅ perbaikan disini

    $tableName = 'form_' . $form_id . '_responses';

    $fields = (new \App\Models\FormFieldModel())
        ->where('form_id', $form_id)
        ->orderBy('id', 'asc')
        ->findAll();

    $columns = [
        'id' => [
            'type'           => 'INT',
            'constraint'     => 11,
            'unsigned'       => true,
            'auto_increment' => true,
        ],
        'created_at' => [
            'type' => 'DATETIME',
            'null' => true,
        ],
    ];

    foreach ($fields as $f) {
        $colName = strtolower(preg_replace('/[^a-zA-Z0-9_]/', '_', $f['label']));
        $columns[$colName] = [
            'type' => 'TEXT',
            'null' => true,
        ];
    }

    if (!$db->tableExists($tableName)) {
        $forge->addField($columns);
        $forge->addKey('id', true);
        $forge->createTable($tableName);
    }
}
private function columnFromIndex($index)
{
    $letter = '';
    while ($index >= 0) {
        $letter = chr($index % 26 + 65) . $letter;
        $index = intval($index / 26) - 1;
    }
    return $letter;
}


}
