@extends('home.parent')
@section('content')
    <div class="card p-4">
        <div class="row">
            <div class="col-md-6 d-flex justify-content-center">
                @if (empty(Auth::user()->profile->image))
                    <img src="https://ui-avatars.com/api/color=fffff?name={{ Auth::user()->name }}" alt="Ini Istilah User"
                        class="w-75">
                @else
                    <img src="{{ Auth::user()->profile->image }}" alt="Ini Gambat Profile" class="w-75">
                @endif
            </div>
            <div class="col-md-6">
                <h3 class="text-center">Profile</h3>
                <ul class="list-group">
                    <li class="list-group-item" aria-current="true">Name Account : <strong>{{ Auth::user()->name }}</strong>
                    </li>
                    <li class="list-group-item">Email Account : <strong>{{ Auth::user()->email }}</strong></li>
                    <li class="list-group-item">First Name : <strong>{{ Auth::user()->profile->first_name }}</strong></li>
                    <li class="list-group-item">Role Acount : <strong>{{ Auth::user()->role }}</strong< /li>
                </ul><!-- End ist group with active and disabled items -->
                @if (empty(Auth::user()->profile->image))
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('createProfile') }}" class="btn btn-primary m-3">
                            <i class="bi bi-plus"></i>
                            Creat Profile
                        </a>
                    </div>
                @else
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('editProfile') }}" class="btn btn-primary m-3">
                            <i class="bi bi-pencil"></i>
                            Update
                        </a>
                    </div>
                @endif


            </div>

        </div>
    </div>
@endsection
