<?php

namespace App\Modules\SessionsModule\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use PDF;
class PdfController extends Controller
{
    public function index()
    {
    }

    public function Emargements(){
        // retreive all records from db
        $data = Employee::all();

        // share data to view
        view()->share('employee',$data);
        $pdf = PDF::loadView('emargement', $data);

        // download PDF file with download method
        return $pdf->download('pdf_file.pdf');
    }
}
