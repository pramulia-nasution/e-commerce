<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Images\ImagesRepository;
use App\Repositories\Images\EloquentImagesRepository;
use App\Repositories\Settings\SettingsRepository;
use App\Repositories\Settings\EloquentSettingsRepository;
use App\Repositories\Manufactures\ManufacturesRepository;
use App\Repositories\Manufactures\EloquentManufacturesRepository;
use App\Repositories\Categories\CategoriesRepository;
use App\Repositories\Categories\EloquentCategoriesRepository;
use App\Repositories\Attributes\AttributesRepository;
use App\Repositories\Attributes\EloquentAttributesRepository;
use App\Repositories\Products\ProductsRepository;
use App\Repositories\Products\EloquentProductsRepository;
use App\Repositories\Coupons\CouponsRepository;
use App\Repositories\Coupons\EloquentCouponsRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ImagesRepository::class, EloquentImagesRepository::class);
        $this->app->bind(SettingsRepository::class, EloquentSettingsRepository::class);
        $this->app->bind(ManufacturesRepository::class, EloquentManufacturesRepository::class);
        $this->app->bind(CategoriesRepository::class, EloquentCategoriesRepository::class);
        $this->app->bind(AttributesRepository::class, EloquentAttributesRepository::class);
        $this->app->bind(ProductsRepository::class, EloquentProductsRepository::class);
        $this->app->bind(CouponsRepository::class, EloquentCouponsRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
