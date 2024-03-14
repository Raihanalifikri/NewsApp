@extends('home.parent')
@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-success">
            {{ session('error') }}
        </div>
    @endif


    <div class="row">
        <div class="card p-4">
            <h3 class="card-title">User</h3>
            <table class="table table-striped">
                <thead class="table">
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->email }}</td>
                            <td>{{ $row->role }}</td>
                            <td>
                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#basicModal{{ $row->id }}">
                                    <i class="bi bi-pencil"></i>
                                    Reset Password

                                </button>
                                <div class="modal fade" id="basicModal{{ $row->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><strong>Reset Password</strong> {{ $row->name }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Default Password become to <strong>123456</strong>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <form action="{{ route('resetPassword', $row->id) }}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="bi bi-pen"></i>
                                                        Reset Password
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- End Basic Modal-->
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
