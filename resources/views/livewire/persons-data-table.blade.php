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
            <th>Name</th>
            <th>Anzahl der Dateien</th>
            <th>Aktion</th>
        </tr>
        </thead>
        <tbody>
        @foreach($persons as $person)
            <tr>
                <td>{{ $person->name }}</td>
                <td>{{ $person->files->count() }}</td>
                <td>
                    <a href="{{ route('people.show', $person) }}" class="btn btn-sm btn-primary">Details</a>
                    @can('delete persons')
                    <a href="{{ route('people.delete', $person) }}" class="btn btn-sm btn-danger">Löschen</a>
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
