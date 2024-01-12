@extends('admin.layouts.app')
@section('layout-wrapper')
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
         $date = new DateTime($ticket->created_at);
         $current_date = new DateTime();
         $interval = $date->diff($current_date);
         $no_of_days = $interval->format('%a'). ' day(s)';
            ?>
        <tr>
            <td>{{$serial}}</td>
            <td>{{$ticket->category}}</td>
            <td>{{$ticket->ticket_number}}</td>
            <td>{{date('jS M Y',strtotime($ticket->created_at))}}</td>
            <td>
               <span class="badge bg-dark rounded-pill px-3">{{$no_of_days}}</span>
            </td>
            <td>
                <a href="{{route('admin-ticket-details',$ticket->id)}}" class="btn btn-primary">Ticket Details</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection