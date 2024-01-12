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
@extends('admin.layouts.app')
@section('layout-wrapper')
@if(!empty(session('success')))
<div class="alert alert-success">{{session('success')}}</div>
@endif
<table class="table bg-white">
    <thead class="bg-dark">
        <tr>
            <th class="text-white">S#</th>
            <th class="text-white">Leave Type</th>
            <th class="text-white">Duration</th>
            <th class="text-white">No of leaves/Total hours & minutes</th>
            <th class="text-white">Status</th>
            <th class="text-white text-center" colspan="2">Action</th>
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
        <td class="p-0">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Action
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <!-- Button trigger modals -->
                    <button class="dropdown-item" data-toggle="modal" data-target="#status{{$data->id}}">Record</button>
                    <button class="dropdown-item" data-toggle="modal"
                        data-target="{{'#exampleModal'.$data->id}}">Decision</button>
                </div>
            </div>
            <!-- Record Modal -->
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
                                                A',strtotime($data->from_time)) :
                                                date('Y-m-d',strtotime($data->from_date)) }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12  emp_name brdr_btm py-1 d-flex">
                                        <div class="col-md-6 d-inline-block brdr_lft">
                                            <p class=" mb-0"> <b>To: </b></p>
                                        </div>
                                        <div class="col-md-6 d-inline-block mrgn_top ">
                                            <p class=" mb-0">{{ !empty($data->to_time)? date('h:i
                                                A',strtotime($data->to_time)) :date('Y-m-d',strtotime($data->to_date))
                                                }}</p>
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
            <!-- Decision Modal -->
            <div class="modal fade" id="{{'exampleModal'.$data->id}}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-bg">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #2196f3; color: #ffff; ">
                            <h5 class="modal-title text-white" id="exampleModalLabel"
                                style="margin-bottom: 10px !important;">
                              Reason
                            </h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{$data->reason}}
                        </div>
                        {{Form::open(['route' => 'save-leave-status' ,'method' => 'post'])}}
                        <div class="modal-footer">
                            <input type="hidden" name="leave_id" value="{{$data->id}}">
                            @if(empty($data->leave_status))
                            <button type="submit" class="btn btn-success" name="leave_status"
                                value="Accepted">Accept</button>
                            <button type="submit" class="btn btn-danger" name="leave_status"
                                value="Rejected">Reject</button>
                            @endif
                        </div>
                        {{Form::close()}}
                    </div>
                </div>
            </div>
        </td>
    </tr>
    <?php $serial++ ?>
    @endforeach
</table>
@endsection