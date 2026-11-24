<div>
    <div class="row">
        <div class="col-12">
            <div class="form-group float-left m-2">
                <label for="search">Suchen</label>
                <input type="text" name="search" wire:model="searchQuery" class="form-control">
            </div>
        </div>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>Tag</th>
            <th>Anzahl der Dateien</th>
            <th>Aktion</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tags as $tag)
            <tr>
                <td>{{ $tag->title }}</td>
                <td>{{ $tag->files->count() }}</td>
                <td>
                    <a href="{{ route('tag.show', $tag) }}" class="btn btn-sm btn-primary">Details</a>
                    @can('delete tags')
                    <a href="{{ route('tag.delete', $tag) }}" class="btn btn-sm btn-danger">Löschen</a>
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
