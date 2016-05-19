<?php

namespace Mixdinternet\Banners\Facades;

use Illuminate\Support\Facades\Facade;

class BannersFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Mixdinternet\Banners\Facades\Banners';
    }
}