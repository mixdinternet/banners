<?php

namespace Mixdinternet\Banners\Facades;

use Mixdinternet\Banners\Banner;

class Banners
{
    public function view($qtd = '3', $place = null, $rand = false, $template = 'mixdinternet/banners::frontend.default')
    {
        $place = ($place == null) ? key(config('mbanners.places')) : $place;

        $query = Banner::where('place', $place)->active();

        if($rand == true){
            $query->rand();
        }
        else {
            $query->sort();
        }

        $view['banners'] = $query->take($qtd)->get();
        $view['slug'] = $place;

        return view($template, $view);
    }
}
