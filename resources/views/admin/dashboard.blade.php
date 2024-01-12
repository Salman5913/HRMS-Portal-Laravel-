@extends('admin.layouts.app')
@section('layout-wrapper')
<div class="row">
    <div class="col-md-3 ">
        <a class="" href="{{route('user-list')}}">
            <div class="card bg-success shadow p-2">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="card-title ">
                        <span class="h4 text-white">
                            User
                        </span>
                    </div>
                    <div class="card-text">
                        <i class="h4 bx bx-user text-white"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3 ">
        <a class="" href="{{route('manage-leave')}}">
            <div class="card bg-warning shadow p-2">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="card-title ">
                        <span class="h5 text-white">
                            Manage Leave
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
        <a href="{{route('manage-ticket')}}">
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