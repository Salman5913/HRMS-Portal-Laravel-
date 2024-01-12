@extends('employee.layouts.app')
@section('layout-wrapper')
@if(!empty(session('application_error')))
<div class="alert alert-danger">{{session('application_error')}}</div>
@endif
@error('to_time')
<div class="alert alert-danger">{{$message}}</div>
@enderror
@error('from_time')
<div class="alert alert-danger">{{$message}}</div>
@enderror
@error('to_date')
<div class="alert alert-danger">{{$message}}</div>
@enderror
@error('from_date')
<div class="alert alert-danger">{{$message}}</div>
@enderror
@error('full_day_reason')
<div class="alert alert-danger">{{$message}}</div>
@enderror
@error('half_day_reason')
<div class="alert alert-danger">{{$message}}</div>
@enderror
@error('no_of_leave')
<div class="alert alert-danger">{{$message}}</div>
@enderror
<div class="card">
    <div class="card-header h4">
        Apply for leave
    </div>
    <hr>
    <div class="card-body ms-4">
        <div class="fw-bold ">
            Leave Type
        </div>
        {{Form::open(['route'=>'add-leave'])}}
        <div class="col-md-3 my-2">
            <select name="leave_type" class="form-select " id="leaveType" onchange="ShowLeaveForm()">
                <option value="">--Select Type--</option>
                <option value="Half Day">Half Day</option>
                <option value="Full Day">Full Day</option>
            </select>
        </div>

        {{--Half day leave details--}}
        <div class="d-none col-md-12" id="halfDayForm">
            <div class="col-md-5 d-inline-block my-3">
                From time <span class="text-danger">*</span>
                <br>
                <input type="time" name="from_time" id="from_time" class="col-md-12">
            </div>
            <div class="col-md-5 d-inline-block my-3">
                To time <span class="text-danger">*</span>

                <br>
                <input type="time" name="to_time" id="to_time" class="col-md-12">
            </div>
            <div class="col-md-10 my-3">
                <label for="">Reason<span class="text-danger">*</span>
                </label><br>
                <textarea name="half_day_reason" cols="110" id="reason1" rows="3"></textarea>
            </div>
            <button class="btn btn-info col-md-2 float-end me-5" type="submit">Submit</button>
        </div>

        {{--Full day leave details--}}
        <div class="d-none col-md-12" id="fullDayForm">
            <div class="col-md-5 d-inline-block  my-3">
                From date <span class="text-danger">*</span><br>
                <input type="date" name="from_date" id="from_date" class="col-md-12">
            </div>
            <div class="col-md-3 d-inline-block  my-3">
                To date <span class="text-danger">*</span><br>
                <input type="date" name="to_date" id="to_date" class="col-md-12">
            </div>
            <div class="col-md-3 d-inline-block  my-3">
                No of leaves <span class="text-danger">*</span><br>
                <input type="number" name="no_of_leave" class="col-md-12">
            </div>
            <div class="col-md-10 my-3">
                <label for="">Reason<span class="text-danger">*</span></label><br>
                <textarea name="full_day_reason" cols="110" rows="3" id="reason2"></textarea>
            </div>
            <button class="btn btn-info col-md-2 float-end me-5" type="submit">Submit</button>
        </div>
        {{Form::close()}}
    </div>
</div>

@endsection

<script>
    function ShowLeaveForm(){
        var value = document.getElementById('leaveType').value;
        if(value == 'Half Day'){
            document.getElementById('halfDayForm').className = 'row d-block';
            document.getElementById('fullDayForm').className = 'row d-none';
            document.getElementById('from_time').setAttribute('required');
            document.getElementById('to_time').setAttribute('required');
            document.getElementById('reason1').setAttribute('required');
        }else if(value == 'Full Day'){
            document.getElementById('fullDayForm').className = 'row d-block';
            document.getElementById('halfDayForm').className = 'row d-none';
            document.getElementById('from_date').setAttribute('required');
            document.getElementById('to_date').setAttribute('required');
            document.getElementById('reason2').setAttribute('required');
        }else{
            document.getElementById('halfDayForm').className = 'row d-none';
            document.getElementById('fullDayForm').className = 'row d-none';
        }
    }
</script>