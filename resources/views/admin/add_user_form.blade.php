@extends('admin.layouts.app')
@section('layout-wrapper')
{{Form::open(['route'=>'add-user','method'=>'post'])}}
@csrf
<div class="form-row d-flex flex-column justify-content-center align-items-center">
    <div class="form-group col-md-6">
        <label for="inputName">Name.</label>
        @error('username')
        <span class="text-danger">
            {{$message}}
        </span>
        @enderror
        <input type="text" name="username" value="{{old('username')}}"
            class="form-control" id="inputName" placeholder="Name">
    </div>
    <div class="form-group col-md-6">
        <label for="inputEmail4">Email.</label>
        @error('email')
        <span class="text-danger">
            {{$message}}
        </span>
        @enderror
        <input type="text" name="email" value="{{old('email')}}" class="form-control"
            id="inputEmail4" placeholder="Email">
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
        <label for="">Employee Code.</label>
        @error('emp_code')
        <span class="text-danger">
            {{$message}}
        </span>
        @enderror
        <input name="emp_code" class="form-control" value="{{old('emp_code')}}"  placeholder="Employee code">
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
            <option value="{{$dept->id}}" @if($dept->id==old('department')){{'selected'}}@endif>{{$dept->department_name}}</option>
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
        <input type="text" name="address" value="{{old('address')}}"
            class="form-control" id="inputAddress" placeholder="1234 Main St">
    </div>
    <div class="form-group col-md-6">
        <label for="">Gender.</label>
        @error('gender')
        <span class="text-danger">
            {{$message}}
        </span>
        @enderror
        <div class="form-check ms-3">
            <label for="male" class="form-check-label fw-bold me-5">Male</label>
            <input type="radio" name="gender" value="male" @if (old('gender')=='male' ) {{'checked'}}@endif
                id="male" class="form-check-input">
            <label for="female" class="form-check-label fw-bold me-5">Female</label>
            <input type="radio" name="gender" value="female" @if(old('gender')=='female' ){{'checked'}} @endif
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
        <input type="text" name="city" value="{{old('city')}}" class="form-control"
            id="inputCity">
    </div>
    <div class="form-group col-md-6">
        <label for="inputContact">Contact.</label>
        @error('contact')
        <span class="text-danger">
            {{$message}}
        </span>
        @enderror
        <input type="text" name="contact" value="{{old('contact')}}"
            class="form-control" id="inputContact">
    </div>
    <button type="submit" class="btn btn-primary col-md-6 mt-2">Add</button>
</div>

{{Form::close()}}
@endsection