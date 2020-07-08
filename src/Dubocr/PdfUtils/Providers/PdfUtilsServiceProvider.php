<?php

namespace Dubocr\PdfUtils\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Dubocr\PdfUtils\Services\PdfUtilsService;

class PdfUtilsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        App::bind(PdfUtilsService::class, function($app) {
            return new PdfUtilsService($app['config']['pdfutils']);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/pdfutils.php' => config_path('pdfutils.php'),
        ]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [PdfUtilsService::class];
    }
}
