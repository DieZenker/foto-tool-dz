<div class="card">
    <div class="card-header">
        <h3>Dateien hochladen</h3>
    </div>
    <div class="card-body">
        @error('upload') <span class="error">{{ $message }}</span> @enderror
        @if (session()->has('uploadmessage'))
            <div class="alert alert-info">
                {{ session('uploadmessage') }}
            </div>
        @endif

        @if ($files)
            <div class="mb-2" wire:ignore>
                <label for="tags">Tags für alle Bilder</label>
                <select wire:model="tags" class="select2 form-control" id="tags" name="tags[]" multiple="multiple"
                        placeholder="Bitte wählen">
                    @foreach(\App\Models\Tag::all() as $tag)
                        <option value="{{ $tag->title }}">{{ $tag->title }}</option>
                    @endforeach
                </select>
                <script>
                    $(document).ready(function() {
                        $('#tags').select2({
                            tags: true,
                        });
                        $('#tags').on('change', function (e) {
                            var data = $('#tags').select2("val");
                        @this.set('tags', data);
                            console.log(data);
                        });
                    });
                </script>
            </div>
            <button wire:loading.remove wire:click.prevent="save" class="w-full p-2 text-white rounded shadow-lg d-none">Speichern & Hochladen</button>
        @endif

        <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
             x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false"
             x-on:livewire-upload-progress="progress = $event.detail.progress">

            @if($files)
                <button wire:loading.remove wire:click.prevent="save" class="btn btn-primary btn-block">Speichern & Hochladen</button>
            @else
                <button class="btn btn-primary btn-block" @click="$refs.fileinput.click()">Dateien auswählen</button>
            @endif

            <input x-ref="fileinput" type="file" multiple wire:model="files" class="d-none" />

            <!-- Progress Bar -->
            <div x-show="isUploading">
                <progress max="100" x-bind:value="progress"></progress>
            </div>
        </div>

        <div wire:loading wire:target="files" class="w-full p-2 rounded shadow-lg">
            <i class="fas fa-spinner fa-spin text-2xl"></i> Analysiere Bilder
        </div>

        <div wire:loading wire:target="save" class="w-full p-2 rounded shadow-lg">
            <i class="fas fa-spinner fa-spin text-2xl"></i> Uploading
        </div>
        @if ($files)
            @foreach($files as $file)
                <div class="row" wire:key="{{$loop->index}}" class="pb-2">
                    <div class="col-10">
                        @if($file->getClientOriginalExtension() == 'pdf')
                            <img src="/img/icons/{{ $file->getClientOriginalExtension() }}.png" width="100">
                        @else
                            <img src="{{ $file->temporaryUrl() }}" style="width: 100%">
                        @endif
                    </div>
                    <div class="col-2">
                        <i class="fas fa-times-circle text-gray-700 text-2xl float-right cursor-pointer"
                           style="cursor: pointer"
                           wire:click="remove({{$loop->index}})"></i>
                    </div>
                </div>


                <!--<div class="p-4 my-3 rounded-lg shadow-lg transition-all duration-500"
                     style="background-image: radial-gradient( circle farthest-corner at 14.2% 27.5%,  rgba(104,199,255,1) 0%, rgba(181,126,255,1) 90% );"
                     ">
                    <i class="fas fa-times-circle text-gray-700 text-2xl float-right cursor-pointer"
                       wire:click="remove({{$loop->index}})"></i>
                    <div class="flex justify-center">
                        {{ $loop->index }}
                        @if($file->getClientOriginalExtension() == 'pdf')
                            <img src="/img/icons/{{ $file->getClientOriginalExtension() }}.png" width="100">
                        @else
                            <img src="{{ $file->temporaryUrl() }}" width="100">
                        @endif
                    </div>
                </div>-->
            @endforeach
        @endif
    </div>
</div>
