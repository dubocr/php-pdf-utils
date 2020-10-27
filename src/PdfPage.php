<?php

namespace Dubocr\PdfUtils;

use Dubocr\PdfUtils\Services\PdfUtilsService;

class PdfPage
{
    /**
     * Create a new pdf instance.
     *
     * @return void
     */
    public function __construct($pdf, $page)
    {
        $this->pdf = $pdf;
        $this->page = $page;
    }

    public function exportImages($ext = null) {
        return $this->pdf->exportImages($this->page, $this->page, $ext);
    }

    public function exportPage($file) {
        return $this->service->exportPages($this->path, $file, $this->page);
    }
}
