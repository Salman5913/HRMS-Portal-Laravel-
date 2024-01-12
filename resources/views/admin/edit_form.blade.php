@extends('admin.layouts.app')
@section('layout-wrapper')
{{Form::open(['route'=>['update-user','id'=>$userData->id],'method'=>'post'])}}
@csrf
<div class="form-row d-flex flex-column justify-content-center align-items-center">
    <div class="form-group col-md-6">
        <label for="inputName">Name.</label>
        @error('username')
        <span class="text-danger">
            {{$message}}
        </span>
        @enderror
        <input type="text" name="username" value="{{$userData->name}}" class="form-control" id="inputName"
            placeholder="Name">
    </div>
    <div class="form-group col-md-6">
        <label for="inputEmail4">Email.</label>
        @error('email')
        <span class="text-danger">
            {{$message}}
        </span>
        @enderror
        <input type="text" name="email" value="{{$userData->email}}" class="form-control" id="inputEmail4"
            placeholder="Email">
    </div>
    <div class="form-group col-md-6">
        <label for="inputPassword4">Password.</label>
        @error('password')
        <span class="text-danger">
            {{$message}}
        </span>
        @enderror
        <input type="password" name="password" class="form-control" id="inputPassword4" placeholder="Password">
    </div>
    <div class="form-group col-md-6">
        <label for="">Department</label>
        @error('department')
        <span class="text-danger">
            {{$message}}
        </span>
        @enderror
        <select name="department" class="form-select">
            <option value="">Choose Department</option>
            @foreach($department as $dept)
            <option value="{{$dept->id}}" @if($dept->id==$userData->depart_id){{'selected'}}@endif>{{$dept->department_name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-6">
        <label for="inputAddress">Address.</label>
        @error('address')
        <span class="text-danger">
            {{$message}}
        </span>
        @enderror
        <input type="text" name="address" value="{{$userData->address}}" class="form-control" id="inputAddress"
            placeholder="1234 Main St">
    </div>
    <div class="form-group col-md-6 my-2">
        @error('role')
        <div class="text-danger">{{$message}}</div>
        @enderror
        <select name="role" class="form-select">
            <option value="">Choose role</option>
            <option value="1" @if($userData->role == 'Admin'){{'selected'}}@endif>Admin</option>
            <option value="2" @if($userData->role == 'Employee'){{'selected'}}@endif>Employee</option>
        </select>
    </div>
    <div class="form-group col-md-6">
        <label for="">Gender.</label>
        @error('gender')
        <span class="text-danger">
            {{$message}}
        </span>
        @enderror
        <div class="form-check ms-3">
            <label for="male" class="form-check-label fw-bold">Male</label>
            <input type="radio" name="gender" value="male" @if ($userData->gender=='male' ) {{'checked'}}@endif
            id="male" class="form-check-input">
        </div>
        <div class="form-check ms-3">
            <label for="female" class="form-check-label fw-bold">Female</label>
            <input type="radio" name="gender" value="female" @if($userData->gender=='female' ){{'checked'}} @endif
            id="female" class="form-check-input">
        </div>
    </div>
    <div class="form-group col-md-6">
        <label for="inputCity">City.</label>
        @error('city')
        <span class="text-danger">
            {{$message}}
        </span>
        @enderror
        <input type="text" name="city" value="{{$userData->city}}" class="form-control" id="inputCity">
    </div>
    <div class="form-group col-md-6">
        <label for="inputContact">Contact.</label>
        @error('contact')
        <span class="text-danger">
            {{$message}}
        </span>
        @enderror
        <input type="text" name="contact" value="{{$userData->contact}}" class="form-control" id="inputContact">
    </div>
    <button type="submit" class="btn btn-primary col-md-6 mt-2">Update</button>
</div>

{{Form::close()}}
@endsection