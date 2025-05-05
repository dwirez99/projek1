@extends('layouts.app')
@section('content')

<div class="headingArtikel">
    <h2>Buat Artikel baru</h2>
</div>

<div class="containerForm">
    <form action="{{ route('artikel.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="text" name="judul" placeholder="Judul Artikel" class="judulArtikel">
    <input type="file" name="thumbnail" class="thumbnailArtikel">
    <textarea name="konten" id="konten" class="kontenArtikel" cols="30" rows="10"></textarea>
    <button type="submit" class="btn-artikel">Simpan</button>

    </form>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#konten'), {
            ckfinder: {
                uploadUrl: '{{ route('ckeditor.upload') }}?_token={{ csrf_token() }}'
            },
            toolbar: [
                'heading', '|',
                'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                'blockQuote', 'insertTable', 'uploadImage', 'codeBlock', '|',
                'undo', 'redo'
            ]
        })
        .catch(error => console.error(error));
</script>

@endsection