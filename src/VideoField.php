<?php

namespace Pengxul\Video;

use Encore\Admin\Admin;
use Illuminate\Support\Arr;

class VideoField
{
    public function setupScript($options = [])
    {
        $script = <<<SCRIPT
            
        var playerId = $(this).find("video").attr('id');
        var player = videojs(playerId, {
          playbackRates: [0.5, 1, 1.5, 2],
        });
SCRIPT;

        Admin::script($script);
    }

    public static function video()
    {
        $macro = new static();

        return function ($options = []) use ($macro) {

            $field = $this;

            $macro->setupScript($options);

            return $this->unescape()->as(function ($value) use ($field, $options) {

                $field->wrapped = false;

                $url = Video::getValidUrl($value, Arr::get($options, 'server'));

                return <<<HTML
<video id="video-{$this->getKey()}" height=540 class="video-js vjs-default-skin vjs-layout-medium vjs-layout-large" controls>
        <source src="{$url}" >
      </video>
HTML;
            });
        };
    }
}