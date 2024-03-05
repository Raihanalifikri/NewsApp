@extends('home.parent')
@section('content')
    
    <div class="row">
        <div class="card p-4">
            <h3>News Create</h3>

            <form action="{{ route('news.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')

            {{-- Field untuk Title  --}}
            {{-- Name berfungsi untuk mengirimkan data ke controller --}}
            {{-- Value = old untuk  --}}
                <div class="mb-3">
                    <label for="inputTitle" name="title" class="form-label">News Title</label>
                    <input type="text" class="form-control" id="inputTitle" name="title" value="{{ old('title') }}">
                </div>

                 {{-- Field untuk Image  --}}
            {{-- Name berfungsi untuk mengirimkan data ke controller --}}
            {{-- Value = old untuk  --}}
            <div class="mb-3">
                <label for="inputImage" name="image" class="form-label">News Image</label>
                <input type="file" class="form-control" id="inputImage" name="Image" value="{{ old('title') }}">
            </div>

            <div class="mb-3">
                <label class="col-sm-2 col-form-label">Select</label>
                <div class="col-10">
                  <select name="category_id" class="form-select" aria-label="Default select example">
                    <option selected>==== Choose Category ====</option>
                    @foreach ($category as $row)
                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                    @endforeach
                    
                  </select>
                </div>
            </div>


            {{-- Field Untuk Content --}}
            {{-- menggunakan ckeditor untuk menampilkan content --}}
            {{-- Name berfungsi untuk mengirimkan data ke controller --}}
            <div class="mb-2">
                <label class="col col-form-label">Content News</label>
                <textarea id="editor" name="content"></textarea>
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

       <div class="justify-content-end d-flex">
        <button class="btn btn-primary" type="submit">
            <i class="bi bi-plus"></i>
            Create News
        </button>
       </div>
            </form>
        </div>
    </div>

@endsection