# Laravel PHP package for PDF tools

This is a PHP wrapper for `xpdf` - `popper-utils`. See [http://doc.ubuntu-fr.org/poppler-utils](http://doc.ubuntu-fr.org/poppler-utils) or [https://www.xpdfreader.com/support.html](https://www.xpdfreader.com/support.html).



## Requirements
* __xpdf__ - `sudo apt-get install xpdf`. [https://www.xpdfreader.com/download.html](https://www.xpdfreader.com/download.html).

or

* __popper-utils__ - `sudo apt-get install popper-utils`. [http://doc.ubuntu-fr.org/poppler-utils](http://doc.ubuntu-fr.org/poppler-utils).


## Installation

Install this package through [Composer](https://getcomposer.org/).

Run `composer require dubocr/php-pdf-utils`

Publish the config `php artisan vendor:publish --provider="Dubocr\PdfUtils\Providers\PdfUtilsServiceProvider"`

If not automatically discovered, add Service Provider and Facade in your `config/app.php` file
```php
'providers' => [
	...
	
	/*
	 * Package Service Providers...
	 */
	Dubocr\PdfUtils\Providers\PdfUtilsServiceProvider::class,
	
	...
]

'aliases' => [
	...
	
	'PdfUtils' => Dubocr\PdfUtils\Facades\PdfUtils::class,
]
```


## Usage

```php
use PdfUtils;
```

```php
$pdf = PdfUtils::loadFile($file);
echo $pdf->creator; // Get the creator
echo $pdf->pages; // Get the number of pages
echo $pdf->size; // Get the size
echo $pdf->version; // Get version
//...
$images = $pdf->exportImages(); // Export all PDF images
$images = $pdf->exportImages(1, 3); // Export PDF images for pages 1-3

foreach($pdf->getPages() as $i => $page) {
    $images = $page->exportImages(); // Export current page images
}
```

## For specific laravel storage disk...
```php
$pdf = PdfUtils::disk('remote')->loadFile($file);
```


### Windows user

For user on Windows OS, download Xpdf command line tools [https://www.xpdfreader.com/download.html](https://www.xpdfreader.com/download.html)
Set `PDFUTILS_PATH="C:\\PATH_TO\\xpdf-tools-win-x.xx\\bin64"` in your `.env` file.
