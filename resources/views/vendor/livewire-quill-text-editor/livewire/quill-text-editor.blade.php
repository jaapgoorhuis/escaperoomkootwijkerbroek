<div wire:ignore>
    <div id="{{ $quillId }}"></div>
</div>

@script
<script>


    const Link = Quill.import('formats/link');

    class MyLink extends Link {
        static create(value) {
            let node = super.create(value);
            value = this.sanitize(value);
            node.setAttribute('href', value);

            node.removeAttribute('target');

            return node;
        }
    }

    Quill.register(MyLink);

    const toolbarOptions = [
        ['bold', 'italic', 'underline'],        // toggled buttons
        ['blockquote', 'code-block'],
        [ 'image', 'video','link'],       // custom button values
        [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],


             // text direction
          // custom dropdown
        [{ 'size': ['small', false, 'large', 'huge'] }],
        [{ 'header': [1, 2, 3, false] }],
        [{ 'color': ['black', '#fff','#ffd500', '#87888a', '#f2f2f2'] },{ 'background': [] } ],          // dropdown with defaults from theme

                                   // remove formatting button
    ];


    const quill = new Quill('#' + @js($quillId), {
        theme: @js($theme),
        modules: {
            toolbar: toolbarOptions,

        }
    });

    quill.root.innerHTML = $wire.get('value');



    quill.on('text-change', function () {

        let value = quill.root.innerHTML;


    @this.set('value', value);
    });
</script>
@endscript
