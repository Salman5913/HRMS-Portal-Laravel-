<aside id="layout-menu" class="layout-menu menu-vertical menu bg-primary shadow">
  <img src="{{url('assets\img\icons\brands\logoits3.png')}}" alt="ITS" class="bg-white" height="90px" width="280px" >

    <div class="app-brand demo text-white">
     <a href="{{route('employee-dashboard')}}"> Attendance Management</a >
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
      <!-- Dashboard -->
      <li class="menu-item ">
        <a href="{{route('employee-dashboard')}}" class="menu-link text-white">
          <i class="menu-icon tf-icons bx bx-home-circle"></i>
          <div>Dashboard</div>
        </a>
      </li>
      <!-- Leave -->
      <li class="menu-item ">
        <a href="{{route('leave-list')}}" class="menu-link menu-toggle text-white">
          <i class="bx bx-book me-3"></i>
          <div >My Leave</div>
        </a>
      </li>
      <!-- Mark Attendance -->
      <li class="menu-item ">
        <a href="{{route('attendance-list')}}" class="menu-link menu-toggle text-white">
          <i class="bx bx-calendar me-3"></i>
          <div >Mark Attendance</div>
        </a>
      </li>
      <!-- Mark Attendance -->
      <li class="menu-item ">
        <a href="{{route('ticket-list')}}" class="menu-link menu-toggle text-white">
          <i class="fa fa-ticket me-3"></i>
          <div >Ticket</div>
        </a>
      </li>
    </ul>
  </aside>