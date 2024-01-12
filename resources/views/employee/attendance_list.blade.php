@extends('employee.layouts.app')
@section('layout-wrapper')
@if(!empty(session('success')))
<div class="alert alert-success">{{session('success')}}</div>
@endif
<div class="m-3 d-flex justify-content-end">
    <a href="{{route('mark-attendance')}}" class="btn btn-info  float-right">Mark Attendance
        <i class="bx bx-bookmark-alt-plus ms-1"></i>
    </a>
</div>
<table class="table bg-white">
    <thead class="bg-dark">
        <th class="text-white">S#</th>
        <th class="text-white">Time In</th>
        <th class="text-white">Time out</th>
        <th class="text-white">In Status</th>
        <th class="text-white">Out Status</th>
    </thead>
    <tbody>
        <?php $serial = 1;?>
        @foreach($attendanceData as $data)
        <tr>
            <td>{{$serial}}</td>
            <td>{{$data->time_in}}</td>
            <td>{{$data->time_out}}</td>
            <td>
                <span
                    class="badge rounded-pill @if($data->in_status=='Late In'){{'bg-danger'}}@else{{'bg-success'}}@endif">
                    {{$data->in_status}}
                </span>
            </td>
            <td>
                <span
                    class="badge m-0 rounded-pill @if($data->out_status=='Early Going'){{'bg-warning'}}@else{{'bg-success'}}@endif">
                    {{$data->out_status}}
                </span>
            </td>
        </tr>
        <?php $serial++; ?>
        @endforeach
    </tbody>
</table>
@endsection