<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;


class PdfController extends Controller
{
    //

    public function generatePdf()
    {
        // Set the URL to generate PDF from
        $url = 'https://example.com';

        // dd(base_path('node_scripts/generate-pdf.js'));

        // Set the path to save the PDF
        $pdfFilePath = public_path('pdfs/generated_pdf.pdf');

        // Use Puppeteer to generate PDF
        $process = new Process([
            'node',
            base_path('node_scripts/generatePdf.js'), // Path to your Puppeteer script
            $url,
            $pdfFilePath,
        ]);

        try {
            $process->mustRun();
            return response()->download($pdfFilePath)->deleteFileAfterSend(true);
        } catch (ProcessFailedException $exception) {
            $errorOutput = $process->getErrorOutput();
            return response()->json(['error' => $errorOutput], 500);
        }
    }

}
