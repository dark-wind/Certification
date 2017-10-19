<?php

namespace Darkwind\Certification;

use Illuminate\Support\ServiceProvider;

class CertificationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //配置文件
        $this->publishes([__DIR__ . '/src/config/certification.php' => config_path('certification.php'),]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
