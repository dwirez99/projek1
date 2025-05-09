@extends('layouts.app')

@push('style')
<style>
    .headingArtikel{
        font-family: "Baloo Thambi 2", system-ui;
        font-optical-sizing: auto;
        font-weight: 700;
        font-style: normal;
        font-size:80px;
        color: aliceblue;
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
        padding-left: 50px;
        min-width: 100vw;
    }

    .containerForm{
        padding: 28px;
        display: flex;
        flex-direction: column;
        max-width: 100vw;
        position: relative;
        z-index: 1;

    }

    form{
        display: flex;
        flex-direction: column;
        color: white;
        padding: 28px;
    }

    input{
        width: auto;
        margin-bottom: 18px;
        padding: 18px;
        border: 2px solid black;
        border-radius: 7px;

    }

    .ck.ck-editor__main {
    z-index: 1;
    color: black;
    }

    .ck.ck-editor__editable_inline {
        min-height: 300px;
        background-color: white;
        z-index: 1;
    }


</style>
@endpush

@section('content')
<h2>Edit Artikel</h2>
<form action="{{ route('artikel.update', ['artikel' => $artikel->id]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <input type="text" name="judul" value="{{ $artikel->judul }}" class="form-control">
    <input type="file" name="thumbnail" class="form-control mt-2">
    @if($artikel->thumbnail)
        <img src="{{ asset('storage/' . $artikel->thumbnail) }}" class="img-fluid mt-2" style="max-width: 200px;">
    @endif
    <textarea name="konten" id="konten" rows="10" class="form-control mt-2">{{ $artikel->konten }}</textarea>
    <button type="submit" class="btn btn-primary mt-2">Update</button>
</form>
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