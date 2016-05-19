@extends('admin.form')

@section('title')
    Gerenciar {{ strtolower(config('mbanners.name', 'Banners')) }}
@endsection

@section('form')
    {!! BootForm::horizontal(['model' => $banner, 'store' => 'admin.banners.store', 'update' => 'admin.banners.update'
        , 'id' => 'form-model', 'class' => 'form-horizontal form-rocket jq-form-validate jq-form-save'
        , 'files' => true ]) !!}

    @if ($banner['id'])
            {!! BootForm::text('id', 'Código', null, ['disabled' => true]) !!}
    @endif

    {!! Form::hidden('place', $place) !!}

    {!! BootForm::select('status', 'Status', ['active' => 'Ativo', 'inactive' => 'Inativo'], null
    , ['class' => 'jq-select2', 'data-rule-required' => true]) !!}

    {!! BootForm::select('star', 'Destaque', ['0' => 'Não', '1' => 'Sim'], null
        , ['class' => 'jq-select2', 'data-rule-required' => true]) !!}

    {!! BootForm::text('name', 'Nome', null, ['data-rule-required' => true, 'maxlength' => '150']) !!}

    {!! BootForm::file('image_desktop', 'Desktop (' . config('mbanners.places.'. $place .'.desktop.width') . 'x' . config('mbanners.places.'. $place .'.desktop.height') . ')', [
            'data-allowed-file-extensions' => '["jpg", "png"]',
            'data-initial-preview' => '["<img src=\"' . $banner->image_desktop->url('crop') . '\" class=\"file-preview-image\">"]',
            'data-initial-caption' => $banner->image_desktop->originalFilename(),
            'data-min-image-width' => config('mbanners.places.'. $place .'.desktop.width'),
            'data-min-image-height' => config('mbanners.places.'. $place .'.desktop.height'),
            'data-aspect-ratio' => number_format((config('mbanners.places.'. $place .'.desktop.width')/config('mbanners.places.'. $place .'.desktop.height')), 2)
    ]) !!}

    @if (config('mbanners.places.' . $place . '.tablet') !== false)
        {!! BootForm::file('image_tablet', 'Tablet (' . config('mbanners.places.'. $place .'.tablet.width') . 'x' . config('mbanners.places.'. $place .'.tablet.height') . ')', [
                'data-allowed-file-extensions' => '["jpg", "png"]',
                'data-initial-preview' => '["<img src=\"' . $banner->image_tablet->url('crop') . '\" class=\"file-preview-image\">"]',
                'data-initial-caption' => $banner->image_tablet->originalFilename(),
                'data-min-image-width' => config('mbanners.places.'. $place .'.tablet.width'),
                'data-min-image-height' => config('mbanners.places.'. $place .'.tablet.height'),
                'data-aspect-ratio' => number_format((config('mbanners.places.'. $place .'.tablet.width')/config('mbanners.places.'. $place .'.tablet.height')), 2)
        ]) !!}
    @endif

    @if (config('mbanners.places.' . $place . '.mobile') !== false)
        {!! BootForm::file('image_mobile', 'Mobile (' . config('mbanners.places.'. $place .'.mobile.width') . 'x' . config('mbanners.places.'. $place .'.mobile.height') . ')', [
                'data-allowed-file-extensions' => '["jpg", "png"]',
                'data-initial-preview' => '["<img src=\"' . $banner->image_mobile->url('crop') . '\" class=\"file-preview-image\">"]',
                'data-initial-caption' => $banner->image_mobile->originalFilename(),
                'data-min-image-width' => config('mbanners.places.'. $place .'.mobile.width'),
                'data-min-image-height' => config('mbanners.places.'. $place .'.mobile.height'),
                'data-aspect-ratio' => number_format((config('mbanners.places.'. $place .'.mobile.width')/config('mbanners.places.'. $place .'.mobile.height')), 2)
        ]) !!}
    @endif

    @if(config('mbanners.places.'. $place .'.html') == true)
        {!! BootForm::textarea('description', 'Descrição do banner', null, ['maxlength' => '1000']) !!}
    @endif

    {!! BootForm::text('link', 'Link', null) !!}
    
    {!! BootForm::select('target', 'Abrir o link', ['' => '-', '_self' => 'na mesma página', '_blank' => 'em uma nova janela'], null
        , ['class' => 'jq-select2', 'data-rule-required' => true]) !!}    

    {!! BootForm::text('published_at', 'Data de publicação', Carbon::parse($banner->published_at)->format('d/m/Y H:i')
        , ['class' => 'jq-datetimepicker', 'data-rule-required' => true, 'maxlength' => '16']) !!}
        
    {!! BootForm::text('until_then', 'Exibir até', !$banner->until_then ? null : Carbon::parse($banner->until_then)->format('d/m/Y H:i')
        , ['class' => 'jq-datetimepicker', 'maxlength' => '16']) !!}        

    {!! BootForm::close() !!}
@endsection