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
            <div class="container mt-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Table</h5>
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Manampilkan Data dengan perulangan Foreach dari category model --}}
                                @forelse ($category as $row)

                                    <tr>
                                        <td> {{ $loop->iteration }} </td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->slug }}</td>
                                        <td><img src="{{ $row->image }}" alt="INI GAMBAR" width="100px"></td>
                                        <td>
                                            <!-- Show Using Modal With id -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#basicModal{{ $row->id }}">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            @include('home.category.include.modal-show')
                                            <!-- End Show-->

                                            {{-- Button edit with Route category.edit {{ row->id }} --}}
                                            <a href="{{ route('category.edit', $row->id) }}" class="btn btn-warning">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                        </td>
                                    </tr>
                                @empty
                                    <p>Belum ada data</p>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
