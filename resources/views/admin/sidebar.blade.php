<aside id="layout-menu" class="layout-menu menu-vertical menu bg-primary shadow">
  <img src="{{url('assets\img\icons\brands\logoits3.png')}}" alt="ITS" class="bg-white" height="90px" width="280px" >

    <div class="app-brand demo text-white">
     <a href="{{route('admin-dashboard')}}"> Attendance Management</a >
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
      <!-- Dashboard -->
      <li class="menu-item ">
        <a href="{{route('admin-dashboard')}}" class="menu-link text-white">
          <i class="menu-icon tf-icons bx bx-home-circle"></i>
          <div data-i18n="Analytics">Dashboard</div>
        </a>
      </li>

      <!-- User -->
      <li class="menu-item">
        <a href="{{route('user-list')}}" class="menu-link menu-toggle text-white">
          <i class="bx bx-user me-3"></i>
          <div data-i18n="Layouts">Manage User</div>
        </a>
      </li>
      <!-- Leave Management -->
      <li class="menu-item">
        <a href="{{route('manage-leave')}}" class="menu-link menu-toggle text-white">
          <i class="bx bx-book me-3"></i>
          <div data-i18n="Layouts">Manage Leave</div>
        </a>
      </li>
      <!-- Ticket Management -->
      <li class="menu-item">
        <a href="{{route('manage-ticket')}}" class="menu-link menu-toggle text-white">
          <i class="fa fa-ticket me-3"></i>
          <div data-i18n="Layouts">Manage Ticket</div>
        </a>
      </li>
    </ul>
  </aside>