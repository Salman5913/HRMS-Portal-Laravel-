<style>
    .brdr_btm {
        border-radius: 5px 5px 0px 0px;
        border-bottom: 1px solid #2196f3;
        border-radius: 5px 5px 0px 0px;
        background-color: #fff;
    }

    .brdr_lft {
        border-right: 1px solid #2196f3;
        margin: 5px 0px;
    }

    .mrgn_top {
        margin-top: 5px;
    }

    .emp_detail {
        font-size: 12px;
        border: 2px solid #2196f3;
        border-radius: 5px;
    }
    .emp_hdr p {
        margin-left: 1.2rem !important;
        font-size: 16px;
        color: #fff;
        font-weight: 600;
    }
</style>
@extends('employee.layouts.app')
@section('layout-wrapper')
@if(!empty(session('success')))
<div class="alert alert-success">{{session('success')}}</div>
@endif
<div class="m-3 d-flex justify-content-end">
    <a href="/apply-leave" class="btn btn-info  float-right">Apply Leave
        <i class="bx bx-exit ms-1"></i>
    </a>
</div>
<table class="table bg-white">
    <thead class="bg-dark">
        <tr>
            <th class="text-white">S#</th>
            <th class="text-white">Leave Type</th>
            <th class="text-white">Duration</th>
            <th class="text-white">No of leaves/Total hours & minutes</th>
            <th class="text-white">Reason</th>
            <th class="text-white">Status</th>
            <th class="text-white">Action</th>
        </tr>
    </thead>
    <?php
    $serial = 1;
    ?>
    @foreach($leaveData as $data)
    <tr class="text-center">
        <td>{{$serial}}</td>
        <td>{{$data->leave_type}}</td>
        <td>
            @if(empty($data->from_time))
            {{date('Y-m-d',strtotime($data->from_date)).' to '.date('Y-m-d',strtotime($data->to_date))}}
            @else
            {{date('h:i A',strtotime($data->from_time)).' to '.date('h:i A',strtotime($data->to_time))}}
            @endif
        </td>
        <td>
            @if($data->number_of_leaves == 0)
            {{'Half Day'}}
            @else
            {{$data->number_of_leaves}}
            @endif
        </td>
        <td>{{$data->reason}}</td>
        <td>
            <span
                class="badge p-2 rounded-pill @if($data->leave_status=='Accepted'){{'bg-success'}}@elseif($data->leave_status=='Rejected'){{'bg-danger'}}@else{{'bg-warning'}}@endif">
                @if(!empty($data->leave_status))
                {{$data->leave_status}}
                @else
                {{'Pending'}}
                @endif
            </span>
        </td>
        <td>
            <a class="btn btn-primary text-white" data-toggle="modal" data-target="#status{{$data->id}}">Record</a>
            <div id="status{{$data->id}}" class="modal fade" tabindex="-1">
                <div class="modal-dialog modal-bg">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #2196f3; color: #ffff; ">
                            <h5 class="modal-title text-white" id="exampleModalLabel"
                                style="margin-bottom: 10px !important;">
                                Leave Details
                            </h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12 px-4 m-auto rmv-flex">
                                <div class="row emp_detail mt-3">
                                    <div class="col-md-12  emp_name brdr_btm py-1 d-flex">
                                        <div class="col-md-6 d-inline-block brdr_lft">
                                            <p class=" mb-0"> <b>Leave Type: </b></p>
                                        </div>
                                        <div class="col-md-6 d-inline-block mrgn_top ">
                                            <p class=" mb-0">{{!empty($data->leave_type) ? $data->leave_type :'---' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-12  emp_name brdr_btm py-1 d-flex">
                                        <div class="col-md-6 d-inline-block brdr_lft">
                                            <p class=" mb-0"> <b>From: </b></p>
                                        </div>
                                        <div class="col-md-6 d-inline-block mrgn_top">
                                            <p class=" mb-0">{{ !empty($data->from_time)? date('h:i
                                                A',strtotime($data->from_time)) : date('Y-m-d',strtotime($data->from_date)) }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12  emp_name brdr_btm py-1 d-flex">
                                        <div class="col-md-6 d-inline-block brdr_lft">
                                            <p class=" mb-0"> <b>To: </b></p>
                                        </div>
                                        <div class="col-md-6 d-inline-block mrgn_top ">
                                            <p class=" mb-0">{{ !empty($data->to_time)? date('h:i
                                                A',strtotime($data->to_time)) :date('Y-m-d',strtotime($data->to_date)) }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12  emp_name brdr_btm py-1 d-flex">
                                        <div class="col-md-6 d-inline-block brdr_lft">
                                            <p class=" mb-0"> <b>No of leaves: </b></p>
                                        </div>
                                        <div class="col-md-6 d-inline-block mrgn_top">
                                            <p class=" mb-0">{{$data->number_of_leaves }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12  emp_name brdr_btm py-1 d-flex">
                                        <div class="col-md-2 d-inline-block brdr_lft">
                                            <p class=" mb-0"> <b>Reason: </b></p>
                                        </div>
                                        <div class="col-md-10 d-inline-block mrgn_top ">
                                            <p class=" mb-0">{{!empty($data->reason) ? $data->reason :'---' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    @endforeach
</table>
@endsection