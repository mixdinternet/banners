<div class="banner-wrapper">
    <div class="slider-home">
        @foreach($banners as $k => $banner)
            <div class="index">
                <a @if($banner->link != '') href="{{ $banner->link }}" @endif target="{{ $banner->target }}" class="banner"
                    @if (config('mbanners.places.' . $slug . '.mobile') !== false) data-mobile="{{ $banner->image_mobile->url('crop') }}" @endif
                    @if (config('mbanners.places.' . $slug . '.tablet') !== false) data-tablet="{{ $banner->image_tablet->url('crop') }}" @endif
                    data-desktop="{{ $banner->image_desktop->url('crop') }}">
                </a>
            </div>
        @endforeach
    </div>
    @if(count($banners) > 1)
        <div class="slider-controllers">
            <div class="base-header">
                <div class="controllers-content">
                    <a href="#" class="btn-prev"><</a>
                    @foreach($banners as $k => $banner)
                        <a href="#" class="btn-position @if($k == 0) active @endif" data-position="{{ ($k+1) }}">{{ ($k+1) }}</a>
                    @endforeach
                    <a href="#" class="btn-next">></a>
                </div>
            </div>
        </div>
    @endif
</div>
