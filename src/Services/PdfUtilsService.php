<?php

namespace Dubocr\PdfUtils\Services;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Dubocr\PdfUtils\Pdf;
use Dubocr\PdfUtils\Wrapper\QPDF;

class PdfUtilsService
{
    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct($config)
    {
        $this->binary_path = $config['binary_path'];
        $this->tmp_dir = $config['tmp_dir'];
    }

    /**
     * Load PDF file info.
     *
     * @return void
     */
    public function loadFile($file)
    {
        $process = new Process([$this->binary_path . '/pdfinfo', $file]);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        $lines = explode("\n", $process->getOutput());
        $pdf = new Pdf($this, $file);
        foreach($lines as $line) {
            $data = explode(":", $line);
            if(!empty($data[0]) && !empty($data[1])) {
                $value = trim($data[1]);
                switch($data[0]) {
                    case 'Creator': $pdf->creator = $value; break;
                    case 'Producer': $pdf->producer = $value; break;
                    case 'Tagged': $pdf->tagged = $value !== 'no'; break;
                    case 'Form': $pdf->form = $value; break;
                    case 'Pages': $pdf->pages = intVal($value); break;
                    case 'Encrypted': $pdf->encrypted = $value !== 'no'; break;
                    case 'File size': $pdf->size = intVal(str_replace(' bytes', '', $value)); break;
                    case 'Optimized': $pdf->optimized = $value !== 'no'; break;
                    case 'PDF version': $pdf->version = $value; break;
                }
            }
        }
        return $pdf;
    }

    /**
     * Export PDF images.
     *
     * @return void
     */
    public function exportImages($file, $firstPage = null, $lastPage = null, $ext = null)
    {
        $prefix = 'pdfutils_' . uniqid();

        if(!is_dir($this->tmp_dir)) {
            mkdir($this->tmp_dir, 0777);
        } else {
            foreach(glob($this->tmp_dir.'/pdfutils*') as $f){
                unlink($f);
            }
        }

        $args = [$this->binary_path . '/pdfimages'];
        if($firstPage) {
            $args[] = '-f';
            $args[] = $firstPage;
        }
        if($lastPage) {
            $args[] = '-l';
            $args[] = $lastPage;
        }
        $args[] = $file; // File path
        $args[] = $prefix; // Image prefix
        if($ext) {
            $args[] = '-' . $ext; // Image ext
        }

        $process = new Process($args, $this->tmp_dir);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $files = glob($this->tmp_dir . '/' . $prefix . '*');
        return $files;
    }

    /**
     * Export PDF pages.
     *
     * @return void
     */
    public function exportPages($source, $destination, $pages = null)
    {
        return (new QPDF)->source($source)->addPages('.', $pages)->write($destination);
    }
}
