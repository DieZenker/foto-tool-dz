@extends('adminlte::master')

@inject('layoutHelper', \JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper)

@if($layoutHelper->isLayoutTopnavEnabled())
    @php( $def_container_class = 'container' )
@else
    @php( $def_container_class = 'container-fluid' )
@endif

@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop

@section('classes_body', $layoutHelper->makeBodyClasses())

@section('body_data', $layoutHelper->makeBodyData())

@section('body')
    <div class="wrapper">

        {{-- Top Navbar --}}
        @if($layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.navbar.navbar-layout-topnav')
        @else
            @include('adminlte::partials.navbar.navbar')
        @endif

        {{-- Left Main Sidebar --}}
        @if(!$layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.sidebar.left-sidebar')
        @endif

        {{-- Content Wrapper --}}
        <div class="content-wrapper {{ config('adminlte.classes_content_wrapper') ?? '' }}">

            @if ($errors->any())
                <div class="content-header">
                    <div class="container">
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            @if(Session::has('flash'))
                <div class="content-header">
                    <div class="container">
                        <div class="alert alert-@if(Session::has('flash-color')){{Session::get('flash-color')}}@else{{ 'primary' }}@endif fade show" role="alert">
                            @if(Session::has('flash-icon'))
                                <div class="alert-icon d-inline-block pr-3"><i class="fa fa-{{Session::get('flash-icon')}}"></i></div>
                            @endif
                            <div class="alert-text d-inline-block">{!!Session::get('flash')!!}</div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Content Header --}}
            <div class="content-header">
                <div class="{{ config('adminlte.classes_content_header') ?: $def_container_class }}">
                    @yield('content_header')
                </div>
            </div>

            {{-- Main Content --}}
            <div class="content">
                <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
                    @yield('content')

                    <div id="create-album-wrapper" style="position: absolute; z-index: 9999; display: none;">

                        <div class="row">
                            <div class="card">
                                <form action="{{ route('album.store') }}" method="post">
                                    @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="">Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Beschreibung</label>
                                        <input type="text" name="description" class="form-control" placeholder="Beschreibung">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success btn-block">Speichern</button>
                                        <a onclick="$('#create-album-wrapper').toggle()" class="btn btn-danger btn-block text-white">Abbrechen</a>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        @hasSection('footer')
            @include('adminlte::partials.footer.footer')
        @endif

        {{-- Right Control Sidebar --}}
        @if(config('adminlte.right_sidebar'))
            @include('adminlte::partials.sidebar.right-sidebar')
        @endif

    </div>
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
    <script src="/js/create-album.js"></script>
@stop
