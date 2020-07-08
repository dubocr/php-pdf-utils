<?php

namespace Dubocr\PdfUtils;

use Dubocr\PdfUtils\Services\PdfUtilsService;

class Pdf
{
    private $_pages = null;

    public $creator;
    public $tagged;
    public $form;
    public $pages;
    public $encrypted;
    public $size;
    public $optimized;
    public $version;

    /**
     * Create a new pdf instance.
     *
     * @return void
     */
    public function __construct(PdfUtilsService $service, $path)
    {
        $this->path = $path;
        $this->service = $service;
    }

    public function exportImages($firstPage = null, $lastPage = null) {
        return $this->service->exportImages($this->path, $firstPage, $lastPage);
    }

    public function getPages() {
        if(!$this->_pages && $this->pages > 0) {
            $this->_pages = [];
            for($i=1; $i <= $this->pages; $i++) {
                $this->_pages[] = new PdfPage($this, $i);
            }
        }
        return $this->_pages;
    }
}
