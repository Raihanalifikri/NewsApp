@extends('home.parent')
@section('content')
    <div class="row">
        <div class="card p-4">
            <h5 class="card-title">
                {{ $news->title }} - <span class="bagde rounded-pill bg-info text-white p-2">{{ $news->category->name }}</span>
            </h5>
            <p>
                <img src="{{ $news->image }}" alt="Gambar" width="400px">
            </p>
            <div id="editor">
                {!! $news->content !!}
            </div>

            <script>
                ClassicEditor
                        .create( document.querySelector( '#editor' ) )
                        .then( editor => {
                                console.log( editor );
                        } )
                        .catch( error => {
                                console.error( error );
                        } );
        </script>

        <div class="container">
            <div class="d-flex justify-content-end mt-2  ">
                <a href="{{ route('news.index') }}" class="btn btn-primary">
                <i class="bi bi-arrow-left"></i>
                Back
            </a>
            </div>
        </div>

            
        </div>
    </div>
@endsection