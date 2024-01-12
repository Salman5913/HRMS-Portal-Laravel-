@extends('admin.layouts.app')
@section('layout-wrapper')
@if(session('success'))
<div class="alert alert-success">{{session('success')}}</div>
@endif
<div class="m-3 d-flex justify-content-end">
    <a href="/add-user-form" class="btn btn-info  float-right">Add
        <i class="fa fa-user-plus ms-1"></i>
    </a>
</div>
<table class="table bg-white">
    <thead class="bg-dark ">
        <tr>
            <th class="text-white" scope="col">Username</th>
            <th class="text-white" scope="col">S no.</th>
            <th class="text-white" scope="col">Email</th>
            <th class="text-white" scope="col">Department</th>
            <th class="text-white" scope="col">Contact</th>
            <th class="text-white" scope="col">Role</th>
            <th class="text-white" scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $serialNumber = 1;
        ?>
        @foreach($userData as $users)
        <tr>
            <td>{{$serialNumber}}</td>
            <td>{{$users->name}}</td>
            <td>{{$users->email}}</td>
            <td>{{$users->department_name}}</td>
            <td>{{$users->contact}}</td>
            <td>
                @if(!empty($users->role))
                {{$users->role}}
                @else
                {{'---'}}
                @endif
            </td>
            <td>
                <div class="dropdown">
                    <button class="dropdown-toggle btn btn-primary" data-bs-toggle="dropdown">Action</button>
                    <div class="dropdown-menu">
                        <div>
                            <a href="{{route('edit-form',['id'=> $users->id])}}" class="dropdown-item">
                                Edit
                            </a>
                        </div>
                        <div>
                            <a class="dropdown-item"  href="{{route('delete-user',['id'=>$users->id])}}">
                                Delete
                            </a>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <?php $serialNumber++; ?>
        @endforeach
    </tbody>
</table>
{!! $userData->links('pagination::bootstrap-5') !!}
@endsection