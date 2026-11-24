<div>
    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th>Name</th>
            <th>Geändert</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($subAlbums as $subAlbum)
            <tr>
                <td>
                    <i class="far fa-folder fa-3x"></i>
                </td>
                <td>{{ $subAlbum->name }}</td>
                <td>{{ $subAlbum->updated_at }}</td>
                <td>
                    <a href="{{ route('album.show', $subAlbum) }}" class="btn btn-xs btn-primary">
                        <i class="far fa-eye"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        @foreach($files as $item)
            <tr>
                <td>
                    <a href="{{ route('file.show', $item) }}">
                    @if(File::extension($item->file) == 'xls' || File::extension($item->file) == 'xlsx')
                        <img style="max-width: 100px;" src="{{ asset('img/icons/xls.png') }}" alt="{{ $item->name }}">
                    @elseif(File::extension($item->file) == 'pdf')
                        <img style="max-width: 100px;" src="{{ asset('img/icons/pdf.png') }}" alt="{{ $item->name }}">
                    @else
                        <img style="max-width: 100px;" src="{{ route('file.downloadThumbail', $item) }}" alt="{{ $item->name }}">
                    @endif
                    </a>
                </td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->updated_at }}</td>
                <td>
                    <a href="{{ route('file.show', $item) }}" class="btn btn-xs btn-primary">
                        <i class="far fa-eye"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
