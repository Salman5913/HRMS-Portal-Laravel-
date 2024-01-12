@extends('employee.layouts.app')
@section('layout-wrapper')
    <div class="row">
        <div class="col-md-3">
            <a href="{{route('leave-list')}}">
                <div class="card bg-warning shadow p-2">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="card-title ">
                            <span class="h4 text-white ">
                                Leave
                            </span>
                        </div>
                        <div class="card-text">
                            <i class="h4 bx bx-book text-white"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{route('attendance-list')}}">
                <div class="card bg-info shadow p-2">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="card-title ">
                            <span class="h4 text-white ">
                                Attendance
                            </span>
                        </div>
                        <div class="card-text">
                            <i class="h4 bx bx-calendar text-white"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{route('ticket-list')}}">
                <div class="card bg-secondary shadow p-2">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="card-title ">
                            <span class="h4 text-white ">
                                Tickets
                            </span>
                        </div>
                        <div class="card-text">
                            <i class="h4 fa fa-ticket text-white"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection