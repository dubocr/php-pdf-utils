<?php

namespace Dubocr\PdfUtils;

use Dubocr\PdfUtils\Services\PdfUtilsService;

class Pdf
{
    private $_pages = null;

    public $creator;
    public $tagged = false;
    public $form;
    public $pages = 0;
    public $encrypted = false;
    public $size = 0;
    public $optimized = false;
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

    public function getPages() {
        if(!$this->_pages && $this->pages > 0) {
            $this->_pages = [];
            for($i=1; $i <= $this->pages; $i++) {
                $this->_pages[] = new PdfPage($this, $i);
            }
        }
        return $this->_pages;
    }

    public function exportImages($firstPage = null, $lastPage = null, $ext = null) {
        return $this->service->exportImages($this->path, $firstPage, $lastPage, $ext);
    }

    public function exportPages($file, $pages = null) {
        return $this->service->exportPages($this->path, $file, $pages);
    }
}
