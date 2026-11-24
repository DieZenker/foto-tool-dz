@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('plugins.Select2', true)

@section('adminlte_css')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
@endsection

@section('adminlte_js')
    <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.8/dist/clipboard.min.js"></script>
    <script>
        function setTooltip(message) {
            $('.btn-clipboard').tooltip('hide')
                .attr('data-original-title', message)
                .tooltip('show');
        }

        function hideTooltip() {
            setTimeout(function() {
                $('.btn-clipboard').tooltip('hide');
            }, 1000);
        }

        $(document).ready(function () {
            $('.btn-clipboard').tooltip({
                trigger: 'click',
                placement: 'bottom'
            });

            var clipboard = new ClipboardJS('.btn-clipboard');
            clipboard.on('success', function(e) {
                setTooltip('In die Zwischenablage kopiert!');
                hideTooltip();
            });

            clipboard.on('error', function(e) {
                setTooltip('Failed!');
                hideTooltip();
            });

            $('.select2').select2({
                tags: true,
            });

            $('#movealbum').select2({
                templateResult: function (idioma) {
                    console.log(idioma);
                    var components = idioma.text.split('|');
                    console.log(components);
                    var $span = $("<span>"+components[0]+"<br><small>"+components[1]+"</small></span>");
                    return $span;
                },
                templateSelection: function (idioma) {
                    console.log(idioma);
                    var components = idioma.text.split('|');
                    console.log(components);
                    var $span = $("<span>"+components[0]+"</span>");
                    return $span;
                }
            });

            /*$('.date').datepicker({
                format: 'dd.mm.yyyy',
            });*/
        });
    </script>

    <script src="/js/create-album.js"></script>
@endsection

@section('content_header')
    <div>
        <h1 class="d-inline-block m-0 text-dark">{{ $album->name }}</h1>
        <button type="button" class="d-inline-block btn btn-xs btn-secondary btn-clipboard" data-clipboard-text="{{ url()->full() }}">Copy URL</button>
    </div>
    <p class="m-0 text-dark">
        {{ $album->description }}
        @if(Gate::check('edit files') || ($album->user && $album->user->is(Auth::user())))
        <button type="button" class="btn btn-xs btn-info" onclick="$('#edit-wrapper').toggle()">Bearbeiten</button>
        @endif
    </p>
    <div id="edit-wrapper" class="row" style="display: none; width: 100%">
        <form action="{{ route('album.update', $album) }}" method="post" style="width: 100%">
            @csrf
            <div class="col-lg-3 col-sm-12">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input name="name" type="text" class="form-control" id="name" placeholder="Neuer Albumname" value="{{ $album->name }}">
                </div>
            </div>
            <div class="col-lg-3 col-sm-12">
                <div class="form-group">
                    <label for="name">Name</label>
                    <textarea name="description" id="album_description" class="form-control" rows="3" placeholder="Beschreibung">{{ $album->description }}</textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="input-group-append mb-4">
                    <button type="submit" class="btn btn-outline-success">Speichern</button>
                </div>
            </div>
        </form>
    </div>
    <p class="m-0 text-dark">{!! $album->getBreadcrumps() !!}</p>
    <p>
        <a href="{{ route('album.download', $album) }}" class="btn btn-xs btn-info text-white"><i class="fa fa-download"></i> Download</a>
    </p>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-8 col-sm-12">
            <div class="card">
                <div class="card-body p-0">
                    <livewire:file-list :files="$album->files" :subAlbums="$album->subAlbums" />
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-sm-12">

            <div class="row">

                @can('create files')
                <div class="col-12">
                    @livewire('file-uploader', ['album' => $album])
                </div>
                @endcan
                @can('create albums')
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>Unteralbum anlegen</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('album.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="{{ $album->id }}" name="parent_id">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input name="name" type="text" class="form-control" id="name" placeholder="Name">
                                </div>
                                <div class="form-group">
                                    <label for="description">Beschreibung</label>
                                    <textarea name="description" id="description" class="form-control" rows="3" placeholder="Beschreibung"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary start">
                                    <i class="glyphicon glyphicon-check"></i>
                                    <span>Speichern</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3>Album verschieben</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('album.move', $album) }}" method="post">
                                    @csrf
                                    <input type="hidden" value="{{ $album->id }}" name="parent_id">
                                    <div class="form-group">
                                        <label for="tags">Übergeordnetes Album auswählen</label>
                                        <select class="select2 form-control" id="movealbum" name="parent_album_id"
                                                placeholder="Bitte wählen">
                                            <option value="0">Dashboard</option>
                                            @foreach(\App\Models\Album::all() as $tag)
                                                <option value="{{ $tag->id }}">{{ $tag->name }}|{{ $tag->getBreadcrumps('', false) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary start">
                                        <i class="glyphicon glyphicon-check"></i>
                                        <span>Move</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Album löschen</h3>
                                </div>
                                <div class="card-body">
                                    <a href="{{ route('album.delte', $album) }}" class="btn btn-danger">
                                        <i class="glyphicon glyphicon-trash"></i>
                                        <span>Löschen</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                @endcan
            </div>


        </div>

    </div>
@stop
