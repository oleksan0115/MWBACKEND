<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\Resource;
use Hashids\Hashids;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
		\Braintree\Configuration::environment(env('BRAINTREE_ENV'));
		\Braintree\Configuration::environment(env('BRAINTREE_ENV'));
		\Braintree\Configuration::merchantId(env('BRAINTREE_MERCHANT_ID'));
		\Braintree\Configuration::publicKey(env('BRAINTREE_PUBLIC_KEY'));
		\Braintree\Configuration::privateKey(env('BRAINTREE_PRIVATE_KEY'));
	    Paginator::useBootstrap();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Hashids::class, function () {
            return new Hashids(env('HASHIDS_SALT'), 10);
        });
    }
}
