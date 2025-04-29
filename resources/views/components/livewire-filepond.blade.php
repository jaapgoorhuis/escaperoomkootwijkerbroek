<div
    wire:ignore
    x-data
    x-init="
        () => {
            const post = FilePond.create($refs.{{ $attributes->get('ref') ?? 'input' }});
            post.setOptions({
                allowMultiple: {{ $attributes->has('multiple') ? 'true' : 'false' }},
                allowReorder: true,
                server: {
                    process:(fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                        @this.upload('{{ $attributes->whereStartsWith('wire:model')->first() }}', file, load, error, progress)
                    },
                    revert: (filename, load) => {
                        @this.removeUpload('{{ $attributes->whereStartsWith('wire:model')->first() }}', filename, load)
                    },

                     remove: (source, load, error) => {
                    @this.remove('{{ $attributes->whereStartsWith('wire:model')->first() }}',source);
                    load();
                    },
                     load: (source, load, error, progress, abort, headers) => {
                    var myRequest = new Request(source);
                    fetch(myRequest).then(function(response) {
                      response.blob().then(function(myBlob) {
                        load(myBlob)
                      });
                    });
                }
                },



                onreorderfiles(files, origin, target){
                    @this.set('images', null);
                    files.forEach(function(file) {
                        @this.upload('images', file.file);
                    });
                },


                allowImagePreview: {{ $attributes->has('allowFileTypeValidation') ? 'true' : 'false' }},
                imagePreviewMaxHeight: {{ $attributes->has('imagePreviewMaxHeight') ? $attributes->get('imagePreviewMaxHeight') : '256' }},
                allowFileTypeValidation: {{ $attributes->has('allowFileTypeValidation') ? 'true' : 'false' }},
                acceptedFileTypes: {!! $attributes->get('acceptedFileTypes') ?? 'null' !!},
                allowFileSizeValidation: {{ $attributes->has('allowFileSizeValidation') ? 'true' : 'false' }},
                maxFileSize: {!! $attributes->has('maxFileSize') ? "'".$attributes->get('maxFileSize')."'" : 'null' !!}
            });

            @if(optional($this->mediaItems)) // If we are editing a post and if that post has images
                post.files =  [
                    @foreach($this->mediaItems as $image)// Loop through each image for the post
                        {
                            // the server file reference
                            source: '{{$image->getFullUrl()}}',
                             options: {
                              type: 'local'
                            }
                        },
                    @endforeach
                    ]
                @endif


        }
    "
>
    <input type="file" x-ref="{{ $attributes->get('ref') ?? 'input' }}" />
</div>


