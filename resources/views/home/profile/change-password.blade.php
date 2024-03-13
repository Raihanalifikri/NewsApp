@extends('home.parent')
@section('content')
    {{-- // alert jika ada error --}}
    {{-- //alert success --}}

    <div class="row">

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

        <div class="card p-4">
            <h3 class="card-title">Change Password</h3>
            <form action="{{ route('profile.updatePassword') }}" method="post">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Current Password</label>
                    <div class="col-sm-10">
                        <input name="current_password" type="password" class="form-control" placeholder="Current Password">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input name="password" type="password" class="form-control" placeholder="Change Password">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input name="confirm_password" type="password" class="form-control" placeholder="Confirm Password">
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary" type="submit">
                        Change Password
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
