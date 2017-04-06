<?php

namespace Mixdinternet\Banners\Http\Controllers;

use Illuminate\Http\Request;
use Mixdinternet\Banners\Banner;
use Caffeinated\Flash\Facades\Flash;
use Mixdinternet\Admix\Http\Controllers\AdmixController;
use Mixdinternet\Banners\Http\Requests\CreateEditBannersRequest;

class BannersAdminController extends AdmixController
{
    public function index(Request $request)
    {
        session()->put('backUrl', request()->fullUrl());

        $trash = ($request->segment(3) == 'trash') ? true : false;

        $query = Banner::sort();
        ($trash) ? $query->onlyTrashed() : '';

        $search = [];
        $search['status'] = $request->input('status', '');
        $search['star'] = $request->input('star', '');
        $search['name'] = $request->input('name', '');
        $search['place'] = $request->input('place', '');

        ($search['status']) ? $query->where('status', $search['status']) : '';
        ($search['star']) ? $query->where('star', $search['star']) : '';
        ($search['name']) ? $query->where('name', 'LIKE', '%' . $search['name'] . '%') : '';
        ($search['place']) ? $query->where('place', $search['place']) : '';

        $banners = $query->paginate(50);

        $vPlaces = [];
        $places = config('mbanners.places');
        foreach ($places as $slug => $place) {
            $vPlaces[$slug] = $place['name'];
        }

        $view['trash'] = $trash;
        $view['search'] = $search;
        $view['vPlaces'] = $vPlaces;
        $view['places'] = $places;
        $view['banners'] = $banners;

        return view('mixdinternet/banners::admin.index', $view);
    }

    public function create(Banner $banner)
    {
        $view['banner'] = $banner;
        $view['place'] = request()->route('place');

        return view('mixdinternet/banners::admin.form', $view);
    }

    public function store(CreateEditBannersRequest $request)
    {
        if (Banner::create($request->all())) {
            Flash::success('Item inserido com sucesso.');
        } else {
            Flash::error('Falha no cadastro.');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admin.banners.index');
    }

    public function edit(Banner $banner)
    {
        $view['banner'] = $banner;
        $view['place'] = request()->route('place');

        return view('mixdinternet/banners::admin.form', $view);
    }

    public function update(Banner $banner, CreateEditBannersRequest $request)
    {
        $input = $request->all();

        if (isset($input['remove'])) {
            foreach ($input['remove'] as $k => $v) {
                $banner->{$v}->destroy();
                $banner->{$v} = STAPLER_NULL;
            }
        }

        if ($banner->update($input)) {
            Flash::success('Item atualizado com sucesso.');
        } else {
            Flash::error('Falha na atualização.');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admin.banners.index');
    }

    public function destroy(Request $request)
    {
        if (Banner::destroy($request->input('id'))) {
            Flash::success('Item removido com sucesso.');
        } else {
            Flash::error('Falha na remoção.');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admin.banners.index');
    }

    public function restore($id)
    {
        $banner = Banner::onlyTrashed()->find($id);

        if (!$banner) {
            abort(404);
        }

        if ($banner->restore()) {
            Flash::success('Item restaurado com sucesso.');
        } else {
            Flash::error('Falha na restauração.');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admin.banners.trash');
    }
}
