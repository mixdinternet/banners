<?php

namespace Mixdinternet\Banners\Facades;

use Mixdinternet\Banners\Banner;

class Banners
{
    public function view($qtd = '3', $slug = null, $rand = false, $template = 'default')
    {
        $slug = ($slug == null) ? key(config('mbanners.places')) : $slug;

        $query = Banner::where('place', $slug)->active();

        if($rand == true){
            $query->rand();
        }
        else {
            $query->sort();
        }

        $view['banners'] = $query->take($qtd)->get();
        $view['slug'] = $slug;

        return view('mixdinternet/banners::frontend.' . $template, $view);
    }
}
