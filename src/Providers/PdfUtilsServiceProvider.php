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
        $path = __DIR__.'/../../config/config.php';

        $this->publishes([$path => config_path('pdfutils.php')], 'config');
        $this->mergeConfigFrom($path, 'pdfutils');
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
