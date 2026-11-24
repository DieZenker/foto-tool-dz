@extends('adminlte::page')

@section('plugins.Select2', true)

@section('adminlte_css')
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
          integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw=="
          crossorigin="anonymous"/>
@endsection

@section('adminlte_js')
    <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.8/dist/clipboard.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
            integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ=="
            crossorigin="anonymous"></script>
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

            $('#platforms').select2({
                tags: true,
                placeholder: "Bitte wählen",
            })

            $('.date').datepicker({
                format: 'dd.mm.yyyy',
            });
        });
    </script>
    <script src="/js/create-album.js"></script>
@endsection

@section('title', $file->name)

@section('content_header')
    <div class="d-inline-block">
        <div>
            <h1 class="d-inline-block m-0 text-dark">{{ $file->name }}</h1>
            <a href="{{ route('file.download', $file) }}" class="d-inline-block btn btn-xs btn-info text-white"><i class="fa fa-download"></i> Download</a>
            <button type="button" class="d-inline-block btn btn-xs btn-secondary btn-clipboard" data-clipboard-text="{{ url()->full() }}">Copy URL</button>
        </div>
        <p class="m-0 text-dark">{!! $file->album->getBreadcrumps() !!}</p>
    </div>
@stop

@section('content')
    <form action="{{ route('file.update', $file) }}" method="post">
        @csrf
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="card card-widget">
                    <div class="card-header">
                        <h3 class="card-title">
                            {{ $file->name }}
                            @if(Gate::check('edit files') || ($file->user && $file->user->is(Auth::user())))
                            <button type="button" class="btn btn-xs btn-info" onclick="$('#edit-wrapper').toggle()">Bearbeiten</button>
                            @endif
                        </h3><br>
                        <p class="description">
                            {{ \Carbon\Carbon::parse($file->created_at)->format('d.m.Y') }}
                        </p>
                        <div id="edit-wrapper" class="row" style="display: none; width: 100%">
                            <div class="input-group mb-3">
                                <input name="name" type="text" class="form-control" placeholder="Neuer Dateiname">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-outline-success">Speichern</button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="file-preview">
                            <img style="width: 100%;" src="{{ route('file.downloadThumbail', $file) }}" alt="{{ $file->name }}">
                            <p>{{ $file->description }}</p>
                        </div>
                        <hr>
                            <div class="input-group input-group-sm mb-0">
                                <input name="comment" class="form-control form-control-sm" placeholder="Kommentar">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">Senden</button>
                                </div>
                            </div>
                        @foreach($file->comments as $comment)
                            <div class="post clearfix">
                                <div class="user-block">
                                    <img class="img-circle img-bordered-sm" src="/img/user_icon.png" alt="user icon">
                                    <span class="username">
                                  <a href="#">{{ $comment->user->name }}</a>
                                </span>
                                    <span
                                        class="description">{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</span>
                                </div>
                                <!-- /.user-block -->
                                <p>
                                    {{ $comment->comment }}
                                </p>
                                <!--<p>
                                    <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                                    <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                                    <span class="float-right">
                                  <a href="#" class="link-black text-sm">
                                    <i class="far fa-comments mr-1"></i> Comments (5)
                                  </a>
                                </span>
                                </p>-->
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>

            <div class="col-lg-6 col-sm-12">
                <div class="row">
                    <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Tags</h3>
                                </div>
                                <div class="card-body">
                                    @if($file->tags->count())
                                        <label for="">Vorhandene Tags</label>
                                        <div class="tag-list">
                                            @foreach($file->tags as $tag)
                                                <small class="badge badge-primary p-2 pl-3 pr-1 mb-2 mr-2">
                                                    {{ $tag->title }}
                                                    <a href="{{ route('file.tag.delete', ['file' => $file->id, 'tag' => $tag->id]) }}"
                                                       class="btn-tool"><i class="fas fa-times"></i></a>
                                                </small>
                                            @endforeach
                                        </div>
                                    @else
                                        <p>Dieses Bild hat noch keine Tags</p>
                                    @endif
                                    @can('create tags')
                                    <hr>
                                    <div>
                                        <label for="tags">Neue Tags hinzufügen</label>
                                        <select class="select2 form-control" id="tags" name="tags[]" multiple="multiple"
                                                placeholder="Bitte wählen">
                                            @foreach(\App\Models\Tag::whereNotIn('title', $file->tags->pluck('title')->toArray())->get() as $tag)
                                                <option value="{{ $tag->title }}">{{ $tag->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endcan
                                </div>
                                @can('create tags')
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success">Speichern</button>
                                </div>
                                @endcan
                            </div>
                    </div>
                    <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Personen</h3>
                                </div>
                                <div class="card-body">
                                    @if($file->people->count())
                                        <label for="">Markierte Personen</label>
                                        <div class="tag-list">
                                            @foreach($file->people as $person)
                                                <small class="badge badge-primary p-2 pl-3 pr-1  mb-2 mr-2">
                                                    {{ $person->name }}
                                                    <a href="{{ route('file.mark.delete', ['file' => $file->id, 'person' => $person->id]) }}"
                                                       class="btn-tool"><i class="fas fa-times"></i></a>
                                                </small>
                                            @endforeach
                                        </div>
                                    @else
                                        <p>Dieses Bild hat noch keine markierungen</p>
                                    @endif
                                    @can('create persons')
                                    <hr>
                                    <div>
                                        <label for="tags">Neue markierung hinzufügen</label>
                                        <select class="select2 form-control" id="persons" name="persons[]" multiple="multiple"
                                                placeholder="Bitte wählen">
                                            @foreach(\App\Models\Person::whereNotIn('name', $file->people->pluck('name')->toArray())->get() as $person)
                                                <option value="{{ $person->name }}">{{ $person->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endcan
                                </div>
                                @can('create persons')
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success">Speichern</button>
                                </div>
                                @endcan
                            </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3>Datei löschen</h3>
                            </div>
                            <div class="card-body">
                                <a href="{{ route('file.delete', $file) }}" class="btn btn-danger">
                                    <i class="glyphicon glyphicon-trash"></i>
                                    <span>Löschen</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Veröffentlichungen</h3>
                        </div>
                        <div class="card-body">
                            @if($file->publications->count())
                                <label for="">Bereits veröffentlicht</label>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Platform</th>
                                        <th>Link</th>
                                        <th>Datum</th>
                                        <th>Kommentar</th>
                                        @can('delete publications')
                                        <th>Aktion</th>
                                        @endcan
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($file->publications as $publication)
                                        <tr>
                                            <td>{{ $publication->platform->name }}</td>
                                            <td><a href="{{ $publication->link }}">{{ $publication->link }}</a></td>
                                            <td>@if(!is_null($publication->publication_date)) {{ \Carbon\Carbon::parse($publication->publication_date)->format('d.m.Y') }} @endif</td>
                                            <td>{{ $publication->comment }}</td>
                                            @can('delete publications')
                                            <td>
                                                <a href="{{ route('file.publication.delete', [$file, $publication]) }}" class="btn btn-danger">Löschen</a>
                                            </td>
                                            @endcan
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>Dieses Bild wurde noch nicht veröffentlicht.</p>
                            @endif
                            @can('create publications')
                            <hr>
                            <div class="row">

                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="tags">Platform</label>
                                        <select class="select2 form-control" id="platforms" name="platform"
                                                placeholder="Bitte wählen oder neue eingeben">
                                            <option></option>
                                            @foreach(\App\Models\Platform::all() as $platform)
                                                <option value="{{ $platform->name }}">{{ $platform->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="tags">Link</label>
                                        <input class="form-control" name="link"/>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Datum:</label>
                                        <div class="input-group date" data-provide="datepicker">
                                            <input type="text" class="form-control" name="publication_date"
                                                   id="publication_date">
                                            <div class="input-group-append" data-target="#publication_date">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="">Kommentar</label>
                                        <textarea name="publication_comment" id="comment" rows="3" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            @endcan
                        </div>
                        @can('create publications')
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Speichern</button>
                        </div>
                        @endcan
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Log</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>User</th>
                                <th>Datum</th>
                                <th>Message</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($file->logs()->orderBy('created_at', 'desc')->get() as $log)
                                <tr>
                                    <td>{{ $log->user->name }}</td>
                                    <td>{{ \Illuminate\Support\Carbon::parse($log->created_at)->format('d.m.Y H:i') }}</td>
                                    <td>{!! $log->message !!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop
