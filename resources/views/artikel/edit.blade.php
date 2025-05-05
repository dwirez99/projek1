@extends('layouts.app')
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