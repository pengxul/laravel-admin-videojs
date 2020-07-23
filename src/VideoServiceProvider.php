<?php

namespace Pengxul\Video;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Column;
use Encore\Admin\Show\Field;
use Illuminate\Support\ServiceProvider;

class VideoServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(Video $extension)
    {
        if (!Video::boot()) {
            return;
        }

        if ($this->app->runningInConsole() && $assets = $extension->assets()) {
            $this->publishes(
                [$assets => public_path('vendor/laravel-admin-ext/laravel-admin-video')],
                'laravel-admin-video'
            );
        }

        Admin::booting(function () {

            Admin::js('vendor/laravel-admin-ext/laravel-admin-video/js/video.min.js');
            Admin::js('vendor/laravel-admin-ext/laravel-admin-video/js/video-contrib-hls.min.js');
            Admin::css('vendor/laravel-admin-ext/laravel-admin-video/css/video-js.min.css');

            Field::macro('cvideo', VideoField::video());

            Column::extend('cvideo', VideoColumn::video());
        });
    }
}