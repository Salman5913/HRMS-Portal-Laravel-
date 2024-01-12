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

    #msg_container {
        background-color: rgb(239, 239, 239);
        border-radius: 100px;
    }

    #username_container {
        font-size: 12px !important;
    }

    .chat-container {
        max-height: 300px;
        overflow-y: scroll;
    }
    /* hides scrollbar */
    .chat-container::-webkit-scrollbar{
        display:none;
    }

    #msg_inp {
        border-radius: 100px;
        border-end-end-radius: 0;
        border-start-end-radius: 0;
        border-right: 0;
    }

    .btn_primary {
        background-color: rgb(88, 117, 171) !important;
        border-end-end-radius: 100px !important;
        border-start-end-radius: 100px !important;
        margin: 0;
        width: 100px;
        height: 43px;
    }
</style>
@extends('Employee.layouts.app')
@section('layout-wrapper')
<div class="card">
    <div class="card-title h4 m-4">Ticket number : {{$ticket_details->ticket_number}} </div>
    <hr>
    <div class="card-body">
        <div class="row emp_detail m-3">
            <div class="col-md-12  emp_name brdr_btm py-1 d-flex">
                <div class="col-md-3 d-inline-block brdr_lft">
                    <p class=" mb-0"> <b>Issued By</b></p>
                </div>
                <div class="col-md-3 d-inline-block mrgn_top brdr_lft ">
                    <p class=" mb-0">{{$ticket_details->name}}</p>
                </div>
                <div class="col-md-3 d-inline-block brdr_lft">
                    <p class=" mb-0"> <b>Employee Code:</b></p>
                </div>
                <div class="col-md-3 d-inline-block mrgn_top ">
                    <p class=" mb-0">{{$ticket_details->emp_code}}</p>
                </div>
            </div>
            <div class="col-md-12  emp_name brdr_btm py-1 d-flex">
                <div class="col-md-3 d-inline-block brdr_lft">
                    <p class=" mb-0"> <b>Department</b></p>
                </div>
                <div class="col-md-3 d-inline-block mrgn_top brdr_lft ">
                    <p class=" mb-0">{{$ticket_details->department_name}}</p>
                </div>
                <div class="col-md-3 d-inline-block brdr_lft">
                    <p class=" mb-0"> <b>Issue Category:</b></p>
                </div>
                <div class="col-md-3 d-inline-block mrgn_top ">
                    <p class=" mb-0">{{$ticket_details->category}}</p>
                </div>
            </div>
            <div class="col-md-12  emp_name brdr_btm py-1 d-flex">
                <div class="col-md-3 d-inline-block brdr_lft">
                    <p class=" mb-0"> <b>Subject:</b></p>
                </div>
                <div class="col-md-3 d-inline-block mrgn_top brdr_lft ">
                    <p class=" mb-0">{{$ticket_details->subject}}</p>
                </div>
                <div class="col-md-3 d-inline-block brdr_lft">
                    <p class=" mb-0"> <b>Submit Date & Time:</b></p>
                </div>
                <div class="col-md-3 d-inline-block mrgn_top ">
                    <p class=" mb-0">{{date('jS M Y H:i a',strtotime($ticket_details->created_at))}}</p>
                </div>
            </div>
        </div>
        <table class="table w-full">
            <th class="bg-dark  p-3">
                <span class="h5 text-white">Details</span>
            </th>
            <tr>
                <td class="p-4">
                    <div>
                        {{$ticket_details->detail}}
                    </div>
                </td>
            </tr>
        </table>
        <div class="h4 w-full text-center py-3 my-4 bg-primary text-white">
            Ticket messaging
        </div>
        <div class="chat-container" id="chat_container">
            @foreach($messages as $msg)
            <div
                class="d-flex flex-column justify-content-around mt-2 mx-4 @if(Session::get('emp_id')==$msg->user_id){{'align-items-end'}} @else {{'align-items-start'}} @endif    ">
                <div id="username_container" class=" text-muted">
                    <span id="username">
                        @if(Session::get('emp_id') != $msg->user_id)
                        {{$msg->name.', '}}
                        @endif
                    </span>
                    <!--taking the time out of condition because it will be displayed with both side messages-->
                    {{date('g:i A',strtotime($msg->reply_at))}}
                </div>
                <span id="msg_container" class="py-1 px-3 mt-1">{{$msg->reply}}</span>
                <input type="hidden" id="user_id" value="{{$msg->user_id}}">
            </div>
            @endforeach
            <input type="hidden" id="login_user_id" value="{{Session::get('emp_id') }}" >
        </div>

        <div class="m-auto mt-2 col-md-12">
            {{Form::open(['method'=>'post','id'=>'messageForm'])}}
            @csrf
            <input type="hidden" name="username" id="username_inp" value="{{$ticket_details->name}}">
            <input type="hidden" name="ticket_id" id="ticket_id_inp" value="{{$ticket_details->id}}">
            <span>
                <input type="text" name="message" placeholder="Enter you message" class="col-md-9" id="msg_inp">
                <button class="btn_primary text-white mb-2 py-2  " type="submit">Send</button>
            </span>
            {{Form::close()}}
        </div>
    </div>
</div>
@endsection