<style>
    .head {
        background-color: rgb(39, 39, 255) !important
    }
</style>
<div class="content-wrapper overflow-hidden">
    <div class="d-flex justify-content-between align-items-center head">
        <div class="m-4 h4 text-white fw-bold">
            XOLVA
        </div>

        <div class="dropdown mt-3 me-5 d-flex justify-content-center align-items-center ">
            <a href="dropdown-toggle" data-bs-toggle="dropdown">
                <i class="bx text-white bx-user h4"></i>
                <span class="ms-2 mb-2 text-white">Admin</span>
                <i class="ms-2 mb-2 text-white fa fa-sm fa-chevron-down"></i>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <form action="/admin-logout" method="get">
                        @csrf
                        <button type="submit" class="dropdown-item m-1"><i class="fa fa-power-off "></i> Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
    <!-- Page header -->
    <div class="bg-white">
        <div class="d-flex justify-content-between alig-items-center ">

            <div class="p-4">
                <h4>
                    <span class="font-weight-semibold">
                        <span class="h5">
                            <i class="fa fa-home "></i>
                            <span>@if(!empty($page)){{ $page }}@endif</span>
                        </span>
                    </span>
                </h4>
            </div>
            <span style="margin-left: 40%; font-size: 20px; font-family: Calibri, Courier, monospace;" class=" p-3">
                <?php echo date('l d M, Y', strtotime(date('D M, Y')) ); ?>
            </span>
        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline bg-dark text-white">
            <marquee scrollamount="5" onmouseout="this.start();" onmouseover="this.stop();">
                <i class="fa fa-bell"></i>
                Official working hours are from 8:45 AM to 5:00 PM (Monday to Friday). Attendance will not be accepted
                without marking through card / e-card.
            </marquee>
        </div>
    </div>