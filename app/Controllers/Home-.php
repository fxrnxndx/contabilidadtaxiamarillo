<?php

namespace App\Controllers;
// use App\Models\ModelCatalogo;
// use App\Models\ModelUsuarios;
// use App\Models\ModelCategoria;

use Dompdf\Dompdf;
use PDF_HTML;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\IOFactory;
use CodeIgniter\HTTP\Files\UploadedFile;
class Home extends BaseController
{
    public function __construct()
    {
        $this->session = \Config\Services::session();
        // $this->ModelCatalogo = new ModelCatalogo();
        // $this->ModelUsuarios = new ModelUsuarios();
        // $this->ModelCategoria = new ModelCategoria();

    }
    public function index(): string
    {
        return view('welcome_message');
    }
}
