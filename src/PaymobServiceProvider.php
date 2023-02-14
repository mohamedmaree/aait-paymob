<?php
namespace Maree\Paymob;

use Illuminate\Support\ServiceProvider;

class PaymobServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->publishes([
            __DIR__.'/config/paymob.php' => config_path('paymob.php'),
        ],'paymob');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/paymob.php', 'paymob'
        );
    }
}
