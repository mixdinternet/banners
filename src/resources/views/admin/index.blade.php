@extends('mixdinternet/admix::index')

@section('title')
    Listagem de {{ strtolower(config('mbanners.name', 'Banners')) }}
@endsection

@section('btn-insert')
    @if((!checkRule('admin.banners.create')) && (!$trash))
        @include('mixdinternet/admix::partials.actions.btn.insert', ['route' => route('admin.banners.create', ['place' => ''])])
    @endif
    @if((!checkRule('admin.banners.trash')) && (!$trash))
        @include('mixdinternet/admix::partials.actions.btn.trash', ['route' => route('admin.banners.trash')])
    @endif
    @if($trash)
        @include('mixdinternet/admix::partials.actions.btn.list', ['route' => route('admin.banners.index')])
    @endif
@endsection

@section('btn-delete-all')
    @if((!checkRule('admin.banners.destroy')) && (!$trash))
        @include('mixdinternet/admix::partials.actions.btn.delete-all', ['route' => route('admin.banners.destroy')])
    @endif
@endsection

@section('search')
    {!! Form::model($search, ['route' => ($trash) ? 'admin.banners.trash' : 'admin.banners.index', 'method' => 'get', 'id' => 'form-search'
        , 'class' => '']) !!}
    <div class="row">
        <div class="col-md-3">
            {!! BootForm::select('status', 'Status', ['' => '-', 'active' => 'Ativo', 'inactive' => 'Inativo'], null
                , ['class' => 'jq-select2']) !!}
        </div>
        <div class="col-md-3">
            {!! BootForm::select('star', 'Destaque', ['' => '-', '1' => 'Sim', '0' => 'Não'], null
                , ['class' => 'jq-select2']) !!}
        </div>
        <div class="col-md-3">
            {!! BootForm::text('name', 'Nome') !!}
        </div>
        @if(count($places) > 1)
            <div class="col-md-3">
                {!! BootForm::select('place', 'Localização', ['' => '-'] + $vPlaces, null
                    , ['class' => 'jq-select2']) !!}
            </div>
        @endif
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="pull-right">
                <a href="{{ route(($trash) ? 'admin.banners.trash' : 'admin.banners.index') }}"
                   class="btn btn-default btn-flat">
                    <i class="fa fa-list"></i>
                    <i class="fs-normal hidden-xs">Mostrar tudo</i>
                </a>
                <button class="btn btn-success btn-flat">
                    <i class="fa fa-search"></i>
                    <i class="fs-normal hidden-xs">Buscar</i>
                </button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('table')
    @if (count($banners) > 0)
        <table class="table table-striped table-hover table-action jq-table-rocket">
            <thead>
            <tr>
                @if((!checkRule('admin.banners.destroy')) && (!$trash))
                    <th>
                        <div class="checkbox checkbox-flat">
                            <input type="checkbox" id="checkbox-all">
                            <label for="checkbox-all">
                            </label>
                        </div>
                    </th>
                @endif
                <th>{!! columnSort('#', ['field' => 'id', 'sort' => 'asc']) !!}</th>
                @if(count($places) > 1)
                    <th>{!! columnSort('Localização', ['field' => 'place', 'sort' => 'asc']) !!}</th>
                @endif
                <th>{!! columnSort('Nome', ['field' => 'name', 'sort' => 'asc']) !!}</th>
                <th>{!! columnSort('Data de Publicação', ['field' => 'published_at', 'sort' => 'asc']) !!}</th>
                <th>{!! columnSort('Destaque', ['field' => 'star', 'sort' => 'asc']) !!}</th>
                <th>{!! columnSort('Status', ['field' => 'status', 'sort' => 'asc']) !!}</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($banners as $banner)
                <tr>
                    @if((!checkRule('admin.banners.destroy')) && (!$trash))
                        <td>
                            @include('mixdinternet/admix::partials.actions.checkbox', ['row' => $banner])
                        </td>
                    @endif
                    <td>{{ $banner->id }}</td>
                    @if(count($places) > 1)
                        <td>{{ $vPlaces[$banner->place] }}</td>
                    @endif
                    <td>{{ $banner->name }}</td>
                    <td>{{ Carbon::parse($banner->published_at)->format('d/m/Y H:i') }}</td>
                    <td>@include('mixdinternet/admix::partials.label.yes-no', ['yesNo' => $banner->star])</td>
                    <td>@include('mixdinternet/admix::partials.label.status', ['status' => $banner->status])</td>
                    <td>
                        @if((!checkRule('admin.banners.edit')) && (!$trash))
                            @include('mixdinternet/admix::partials.actions.btn.edit', ['route' => route('admin.banners.edit', ['id' => $banner->id, 'place' => $banner->place])])
                        @endif
                        @if((!checkRule('admin.banners.destroy')) && (!$trash))
                            @include('mixdinternet/admix::partials.actions.btn.delete', ['route' => route('admin.banners.destroy'), 'id' => $banner->id])
                        @endif
                        @if($trash)
                            @include('mixdinternet/admix::partials.actions.btn.restore', ['route' => route('admin.banners.restore', $banner->id)])
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        @include('mixdinternet/admix::partials.nothing-found')
    @endif
@endsection

@section('pagination')
    {!! $banners->appends(request()->except(['page']))->render() !!}
@endsection

@section('pagination-showing')
    @include('mixdinternet/admix::partials.pagination-showing', ['model' => $banners])
@endsection

@section('footer-scripts')
    <script>
        $(function () {
            $('.jq-actions .jq-modal-create').on('click', function (e) {
                e.preventDefault();
                var _this = $(this);
                @if(count($places) == 1)
                    window.location.href = _this.attr('href') + '/{{ key($places) }}';
                @else
                    bootbox.prompt({
                    title: "Qual a localização?",
                    inputType: 'select',
                    inputOptions: [
                        {
                            text: '-',
                            value: ''
                        },
                            @foreach($places as $slug => $place)
                        {
                            text: '{{ $place['name'] }} ({{ $place['desktop']['width'] }}x{{ $place['desktop']['height'] }})',
                            value: '{{ $slug }}'
                        },
                        @endforeach
                    ],
                    buttons: {
                        cancel: {
                            label: 'Cancelar',
                            className: 'btn-default btn-flat'
                        },
                        confirm: {
                            label: 'Continuar',
                            className: 'btn-primary btn-flat'
                        }
                    },
                    callback: function (result) {
                        if (result == '') {
                            $('.bootbox-form').addClass('has-error');
                            return false;
                        }

                        if(result) {
                            window.location.href = _this.attr('href') + '/' + result;
                        }
                    }
                });
                @endif
            });
        });
    </script>
@endsection