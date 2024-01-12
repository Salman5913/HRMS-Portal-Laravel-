@extends('employee.layouts.app')
@section('layout-wrapper')
<div class="card">
    <div class="card-header h4">
        mark Attendance
    </div>
    <hr>
    <div class="card-body ms-4">
        {{Form::open(['route'=>'add-attendance','method' => 'POST'])}}
        @csrf()
        <div class="col-md-12" id="halfDayForm">
            <div class="col-md-5 d-inline-block my-3">
                Employee Id<span class="text-danger">*</span>
                @error('emp_code')
                    <span class="text-danger">{{$message}}</span>
                @enderror
                </span>
                <br>
                <input name="emp_code" class="col-md-12">
            </div>
            <button class="btn btn-primary" type="submit" >Mark</button>
        </div>
        {{Form::close()}}
    </div>
</div>
@endsection