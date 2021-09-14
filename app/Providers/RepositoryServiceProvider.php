<?php

namespace App\Providers;

use App\Repository\Eloquent\ImageRepository;
use App\Repository\Eloquent\WatermarkRepository;
use App\Repository\EloquentRepositoryInterface;
use App\Repository\ImageRepositoryInterface;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\WatermarkRepositoryInterface;
use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoryServiceProvider
 * @package App\Providers
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(ImageRepositoryInterface::class, ImageRepository::class);
        $this->app->bind(WatermarkRepositoryInterface::class, WatermarkRepository::class);

    }
}
