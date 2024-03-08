@extends('home.parent')
@section('content')
    <div class="row">
        <div class="card p-4">
            <h3>Category</h3>

            <div class="d-flex justify-content-end">
                <a href="{{ route('category.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus"></i>
                    Create Category
                </a>
            </div>
            <div class="card p-4">
                <div class="row">
                    @forelse ($category as $row)
                        <div class="col-5">
                            <div class="card" style="width: 18rem;">
                                <img src="{{ $row->image }}" class="card-img-top" alt="..." width="100px" height="200px">
                                <div class="card-body ">
                                    <h5 class="card-title">{{ $row->name }}</h5>
                                    <div class="d-flex gap-3">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#basicModal{{ $row->id }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
        
                                        <a href="{{ route('category.edit', $row->id) }}" class="btn btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('category.destroy', $row->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
        
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse
        
                </div>
            </div>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('delete'))
                <div class="alert alert-dangerP">
                    {{ session('delete') }}
                </div>
            @endif
            @if (session('update'))
            <div class="alert alert-success">
                {{ session('update') }}
            </div>
        @endif

        </div>
    </div>
@endsection
