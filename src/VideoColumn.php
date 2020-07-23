<?php

namespace Pengxul\Video;

use Encore\Admin\Admin;
use Illuminate\Support\Arr;

class VideoColumn
{
  public function setupScript($options = [])
  {

    $script = <<<SCRIPT

    $('.modal').on('show.bs.modal', function () {
      var width = $(this).find('.modal-dialog').width() - 30;
      var playerId = $(this).find("video").attr('id');
      var player = videojs(playerId, {
        playbackRates: [0.5, 1, 1.5, 2],
        width,
      });
  });

$('.modal').on('hidden.bs.modal', function () {
    var playerId = $(this).find("video").attr('id');
    var player = videojs(playerId);
    player.pause();
});

SCRIPT;

    Admin::script($script);
  }

  public static function video()
  {
    $macro = new static();

    return function ($value, $options = []) use ($macro) {

      $macro->setupScript($options);

      $url = Video::getValidUrl($value,  Arr::get($options, 'server'));

      return <<<HTML
<a class="btn btn-app grid-open-map" data-toggle="modal" data-target="#video-modal-{$this->getKey()}">
    <i class="fa fa-play"></i> Play
</a>
            
<div class="modal" id="video-modal-{$this->getKey()}" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          <span>×</span>
          </button>
          <h4 class="modal-title">Play</h4>
      </div>
      <div class="modal-body">
      <video id="video-{$this->getKey()}" height=540 class="video-js vjs-default-skin vjs-layout-medium vjs-layout-large" controls>
        <source src="{$url}" >
      </video>
      </div>
    </div>
  </div>
</div>
HTML;
    };
  }
}