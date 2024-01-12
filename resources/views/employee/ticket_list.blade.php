@extends('employee.layouts.app')
@section('layout-wrapper')
@if(!empty(session('success')))
<div class="alert alert-success">{{session('success')}}</div>
@endif
<div class="card">
    <div class="card-title h4 m-4">Create Ticket</div>
    <hr>
    {{Form::open(['route'=>'add-ticket' , 'method'=>'post'])}}
    @csrf()
    <div class="row">
        <div class="col-md-5 m-4">
            <label for="">Category<span class="text-danger">*</span></label>
            @error('ticket_category')
            <span class="text-danger">{{$message}}</span>
            @enderror
            <select name="ticket_category" class="form-select ">
                <option value="">Choose Category</option>
                @foreach($ticket_category as $category)
                <option value="{{$category->id}}">{{$category->category}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-5 m-4">
            <label for="">Subject<span class="text-danger">*</span></label>
            @error('ticket_subject')
            <span class="text-danger">{{$message}}</span>
            @enderror
            <input type="text" class="form-control" name="ticket_subject">
        </div>
        <div class="col-md-5 m-4">
            <label for="">Details<span class="text-danger">*</span></label>
            @error('ticket_detail')
            <span class="text-danger">{{$message}}
        </div>
        @enderror
        <textarea name="ticket_detail" cols="115" rows="10"></textarea>
        <button class="btn btn-primary" type="submit">Submit <i class="fa fa-paper-plane"></i></button>
    </div>
</div>
{{Form::close()}}
<table class="table bg-white">
    <thead class="bg-dark">
        <th class="text-white">S#</th>
        <th class="text-white">Category</th>
        <th class="text-white">Ticket#</th>
        <th class="text-white">Submited On</th>
        <th class="text-white">Days Taken</th>
        <th class="text-white">Action</th>
    </thead>
    <tbody>
        <?php $serial = 1 ;?>
        @foreach($ticket_data as $ticket)
        <?php
            $date =new  DateTime($ticket->created_at);
            $currentDate = new DateTime();
            $interval = $date->diff($currentDate);
            $noOfDays = $interval->format('%a').' day(s)';
            ?>
        <tr>
            <td>{{$serial}}</td>
            <td>{{$ticket->category}}</td>
            <td>{{$ticket->ticket_number}}</td>
            <td>{{date('jS M Y',strtotime($ticket->created_at))}}</td>
            <td>
               <span class="badge bg-dark rounded-pill px-3">{{$noOfDays}}</span>
            </td>
            <td>
                <a href="{{route('ticket-details',$ticket->id)}}" class="btn btn-primary">Ticket Details</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
@endsection