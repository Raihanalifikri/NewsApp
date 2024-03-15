@extends('home.parent')
@section('content')
    <div class="row">
        <div class="card p-4">
            <h3 class="card-title">
                Create Profile {{ Auth::user()->name }}
            </h3>

           <form action="{{ route('updateProfile') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-12">
                <label for="inputNanme4" class="form-label">Your Name</label>
                <input type="text" class="form-control" name="first_name" value="{{ $user->profile->first_name }}">
              </div>
              <div class="col-12">
                <label for="inputEmail4" class="form-label">Your Image</label>
                <input type="file" class="form-control" name="image">
              </div>
              <div class="my-3">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-plus"></i>
                    Update Profile
                  </button>
              </div>
            </form>
        </div>
    </div>
@endsection