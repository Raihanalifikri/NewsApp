@extends('home.parent')
@section('content')
    <div class="row">
        <div class="card p-4">
            <h3>News Index</h3>

            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('delete'))
        <div class="alert alert-danger">
            {{ session('delete') }}
        </div>
    @endif
            <div class="d-flex justify-content-end">
                <a href="{{ route('news.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus"></i>
                    Create News
                </a>
            </div>

            <div class="container">
                <div class="card p-3">
                    <h5 class="card-title">Data News</h5>
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Image News</th>
                                <th>Image category</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($news as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->title }}</td>
                                    <td>{{ $row->category->name }}</td>
                                    <td>
                                        <img src="{{ $row->image }}" alt="" width="100px">
                                    </td>
                                    <td>
                                        <img src="{{ $row->category->image }}" width="100px" alt="Ini Image category">
                                    </td>
                                    <td>
                                        <a href="{{ route('news.show', $row->id) }}" class="btn btn-info" onclick="return confirm('Apakah Anda Ingin melihat data News Ini ? 🤔')">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('news.edit', $row->id) }}" class="btn btn-warning" >
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('news.destroy', $row->id) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('DELETE') 
                                            <button class="btn btn-danger" type="submit" onclick="return confirm('Menghapus masa lalu untuk Fokus ke masa depan')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                            <p class="text-center">
                                data Masih Kosong
                            </p>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
