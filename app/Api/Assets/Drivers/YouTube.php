<?php

namespace GetCandy\Api\Assets\Drivers;

use GetCandy\Api\Assets\Models\Asset;

class YouTube extends BaseUrlDriver
{
    /**
     * @var Alaouy\Youtube\Youtube
     */
    protected $manager;

    /**
     * @var string
     */
    protected $handle = 'youtube';

    /**
     * @var string
     */
    protected $oemUrl = 'https://www.youtube.com/oembed';

    public function __construct()
    {
        $this->manager = app('youtube');
    }

    public function getUniqueId($url)
    {
        return $this->manager->parseVidFromURL($url);
    }

    public function getVideoInfo($url)
    {
        if (!$this->info) {
            return $this->info = $this->getOemData([
                'format' => 'json',
                'url' => $url
            ]);
        }
        return $this->info;
    }
}
