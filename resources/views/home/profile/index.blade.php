@extends('home.parent')
@section('content')
    <div class="card p-4">
        <div class="row">
            <div class="col-md-6 d-flex justify-content-center">
                <img src="https://ui-avatars.com/api/color=fffff?name={{ Auth::user()->name }}" alt="Ini Istilah User" class="w-75">
            </div>
            <div class="col-md-6">
                <h3 class="text-center">Profile</h3>
                <ul class="list-group">
                    <li class="list-group-item" aria-current="true">Name Account : <strong>{{ Auth::user()->name }}</strong></li>
                    <li class="list-group-item">Email Account : <strong>{{ Auth::user()->email }}</strong></li>
                    <li class="list-group-item">Role Acount : <strong>{{ Auth::user()->role }}</strong</li>
                  </ul><!-- End ist group with active and disabled items -->
            </div>
            
        </div>
    </div>
    
@endsection