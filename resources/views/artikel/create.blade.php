@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" type="image/png" href="https://ckeditor.com/assets/images/favicons/32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="https://ckeditor.com/assets/images/favicons/96x96.png" sizes="96x96">
<link rel="apple-touch-icon" type="image/png" href="https://ckeditor.com/assets/images/favicons/120x120.png" sizes="120x120">
<link rel="apple-touch-icon" type="image/png" href="https://ckeditor.com/assets/images/favicons/152x152.png" sizes="152x152">
<link rel="apple-touch-icon" type="image/png" href="https://ckeditor.com/assets/images/favicons/167x167.png" sizes="167x167">
<link rel="apple-touch-icon" type="image/png" href="https://ckeditor.com/assets/images/favicons/180x180.png" sizes="180x180">
<link rel="stylesheet" href="{{asset('ckeditor/style.css')}}">
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/45.0.0/ckeditor5.css" crossorigin>
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
        padding: 28px;
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
@push('script')
<script src="https://cdn.ckeditor.com/ckeditor5/45.0.0/ckeditor5.umd.js" crossorigin></script>

<script>
	const {
		ClassicEditor,
		Autoformat,
		AutoImage,
		AutoLink,
		Autosave,
		BalloonToolbar,
		BlockQuote,
		Bold,
		Bookmark,
		Code,
		CodeBlock,
		Essentials,
		FindAndReplace,
		FontBackgroundColor,
		FontColor,
		FontFamily,
		FontSize,
		FullPage,
		Fullscreen,
		GeneralHtmlSupport,
		Heading,
		Highlight,
		HorizontalLine,
		HtmlComment,
		HtmlEmbed,
		ImageBlock,
		ImageCaption,
		ImageInline,
		ImageInsert,
		ImageInsertViaUrl,
		ImageResize,
		ImageStyle,
		ImageTextAlternative,
		ImageToolbar,
		ImageUpload,
		Indent,
		IndentBlock,
		Italic,
		Link,
		LinkImage,
		List,
		ListProperties,
		MediaEmbed,
		PageBreak,
		Paragraph,
		PasteFromOffice,
		RemoveFormat,
		ShowBlocks,
		SimpleUploadAdapter,
		SourceEditing,
		SpecialCharacters,
		SpecialCharactersArrows,
		SpecialCharactersCurrency,
		SpecialCharactersEssentials,
		SpecialCharactersLatin,
		SpecialCharactersMathematical,
		SpecialCharactersText,
		Strikethrough,
		Subscript,
		Superscript,
		Table,
		TableCaption,
		TableCellProperties,
		TableColumnResize,
		TableLayout,
		TableProperties,
		TableToolbar,
		TextTransformation,
		TodoList,
		Underline
	} = window.CKEDITOR;

	const LICENSE_KEY =
		'eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3NzgxOTgzOTksImp0aSI6IjA5MDNiMjJhLWI3YWUtNDVlYi05MWM5LWM1NjhhNmQ5NjI1YSIsImxpY2Vuc2VkSG9zdHMiOlsiMTI3LjAuMC4xIl0sInVzYWdlRW5kcG9pbnQiOiJodHRwczovL3Byb3h5LWV2ZW50LmNrZWRpdG9yLmNvbSIsImRpc3RyaWJ1dGlvbkNoYW5uZWwiOlsiY2xvdWQiLCJkcnVwYWwiXSwiZmVhdHVyZXMiOlsiRFJVUCJdLCJ2YyI6ImJkZDc4N2VjIn0.d-BqNP26xkRECdqqLNLBdQG5vIBO7MJQdeqtB_RW0YD2bHclpSsD4G0ZQDyVNtZc1op6VRBzsaOLMZqkAxqu1g';

	const editorConfig = {
		
		toolbar: {
			items: [
				'sourceEditing',
				'showBlocks',
				'fullscreen',
				'|',
				'heading',
				'|',
				'fontSize',
				'fontFamily',
				'fontColor',
				'fontBackgroundColor',
				'|',
				'bold',
				'italic',
				'underline',
				'|',
				'link',
				'insertImage',
				'insertTable',
				'insertTableLayout',
				'highlight',
				'blockQuote',
				'codeBlock',
				'|',
				'bulletedList',
				'numberedList',
				'todoList',
				'outdent',
				'indent'
			],
			shouldNotGroupWhenFull: false
		},
		plugins: [
			Autoformat,
			AutoImage,
			AutoLink,
			Autosave,
			BalloonToolbar,
			BlockQuote,
			Bold,
			Bookmark,
			Code,
			CodeBlock,
			Essentials,
			FindAndReplace,
			FontBackgroundColor,
			FontColor,
			FontFamily,
			FontSize,
			FullPage,
			Fullscreen,
			GeneralHtmlSupport,
			Heading,
			Highlight,
			HorizontalLine,
			HtmlComment,
			HtmlEmbed,
			ImageBlock,
			ImageCaption,
			ImageInline,
			ImageInsert,
			ImageInsertViaUrl,
			ImageResize,
			ImageStyle,
			ImageTextAlternative,
			ImageToolbar,
			ImageUpload,
			Indent,
			IndentBlock,
			Italic,
			Link,
			LinkImage,
			List,
			ListProperties,
			MediaEmbed,
			PageBreak,
			Paragraph,
			PasteFromOffice,
			RemoveFormat,
			ShowBlocks,
			SimpleUploadAdapter,
			SourceEditing,
			SpecialCharacters,
			SpecialCharactersArrows,
			SpecialCharactersCurrency,
			SpecialCharactersEssentials,
			SpecialCharactersLatin,
			SpecialCharactersMathematical,
			SpecialCharactersText,
			Strikethrough,
			Subscript,
			Superscript,
			Table,
			TableCaption,
			TableCellProperties,
			TableColumnResize,
			TableLayout,
			TableProperties,
			TableToolbar,
			TextTransformation,
			TodoList,
			Underline
		],
		balloonToolbar: ['bold', 'italic', '|', 'link', 'insertImage', '|', 'bulletedList', 'numberedList'],
		fontFamily: {
			supportAllValues: true
		},
		fontSize: {
			options: [10, 12, 14, 'default', 18, 20, 22],
			supportAllValues: true
		},
		fullscreen: {
			onEnterCallback: container =>
				container.classList.add(
					'editor-container',
					'editor-container_classic-editor',
					'editor-container_include-fullscreen',
					'main-container'
				)
		},
		heading: {
			options: [
				{
					model: 'paragraph',
					title: 'Paragraph',
					class: 'ck-heading_paragraph'
				},
				{
					model: 'heading1',
					view: 'h1',
					title: 'Heading 1',
					class: 'ck-heading_heading1'
				},
				{
					model: 'heading2',
					view: 'h2',
					title: 'Heading 2',
					class: 'ck-heading_heading2'
				},
				{
					model: 'heading3',
					view: 'h3',
					title: 'Heading 3',
					class: 'ck-heading_heading3'
				},
				{
					model: 'heading4',
					view: 'h4',
					title: 'Heading 4',
					class: 'ck-heading_heading4'
				},
				{
					model: 'heading5',
					view: 'h5',
					title: 'Heading 5',
					class: 'ck-heading_heading5'
				},
				{
					model: 'heading6',
					view: 'h6',
					title: 'Heading 6',
					class: 'ck-heading_heading6'
				}
			]
		},
		htmlSupport: {
			allow: [
				{
					name: /^.*$/,
					styles: true,
					attributes: true,
					classes: true
				}
			]
		},
		image: {
			toolbar: [
				'toggleImageCaption',
				'imageTextAlternative',
				'|',
				'imageStyle:inline',
				'imageStyle:wrapText',
				'imageStyle:breakText',
				'|',
				'resizeImage'
			]
		},
		licenseKey: LICENSE_KEY,
		link: {
			addTargetToExternalLinks: true,
			defaultProtocol: 'https://',
			decorators: {
				toggleDownloadable: {
					mode: 'manual',
					label: 'Downloadable',
					attributes: {
						download: 'file'
					}
				}
			}
		},
		list: {
			properties: {
				styles: true,
				startIndex: true,
				reversed: true
			}
		},
		menuBar: {
			isVisible: true
		},
		simpleUpload: {
			uploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
		},
		table: {
			contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties']
		}
	};

	document.addEventListener('DOMContentLoaded', function () {
		ClassicEditor.create(document.querySelector('#konten'), editorConfig);
	});

    // Preview gambar thumbnail
    document.getElementById('thumbnail').addEventListener('change', function (event) {
        const [file] = this.files;
        if (file) {
            const preview = document.getElementById('preview-thumbnail');
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    });

	console.log("CKEditor Upload URL: {{ route('ckeditor.upload') }}");
    console.log("CSRF Token: {{ csrf_token() }}");

</script>
@endpush
@section('content')

<div class="headingArtikel">
    <h2>Buat Artikel baru</h2>
</div>

<div class="containerForm">
    <form action="{{ route('artikel.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="judul"><h2>Judul Artikel</h2></label>
    <input type="text" name="judul" placeholder="Judul Artikel" class="judulArtikel">
    
    <label for="thumbnail"><h2>Thumbnail Artikel:</h2></label>
    <input type="file" name="thumbnail" class="thumbnailArtikel" id="thumbnail" accept="image/*">

    <label for="konten"><h2>Konten Artikel:</h2></label>
    <img id="preview-thumbnail" src="#" alt="Preview Thumbnail" style="max-width: 300px; display: none;">

    <textarea name="konten" id="konten" class="kontenArtikel" cols="30" rows="10"></textarea>
	{{-- <script>
		ClassicEditor
			.create(document.querySelector('#konten'), {
				simpleUpload: {
					uploadUrl: '{{ route('ckeditor.upload') }}',
					headers: {
						'X-CSRF-TOKEN': '{{ csrf_token() }}'
					}
				}
			})
			.then(editor => {
				window.editor = editor;
			})
			.catch(error => {
				console.error(error);
			});
		</script> --}}
    <button type="submit" class="btn-artikel">Simpan</button>
    </form>
</div>

@endsection
