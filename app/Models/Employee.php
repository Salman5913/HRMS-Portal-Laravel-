<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DB;

class Employee extends Model
{
    use HasFactory;

    //desc: add leave data
    //param : leave_data
    public static function AddLeave($data)
    {
        DB::table('tbl_leave')
            ->insert($data);
    }
    //desc: get leave list of current employee
    public static function GetSingleEmployeeLeaveList()
    {
        $data = DB::table('tbl_leave')
            ->where('user_id', Session::get('emp_id'))
            ->get();
        return $data;
    }
    //desc: check if time in is marked
    //param: employee_code
    public static function CheckTimeIn($emp_code)
    {
        $data = DB::table('users')
            ->where('emp_code', $emp_code)
            ->whereDate('created_on', date('Y-m-d'))
            ->join('tbl_emp_attendance', 'tbl_emp_attendance.user_id', 'users.id')
            ->select('tbl_emp_attendance.*')
            ->first();
        return $data;
    }
    //desc: get employee shift data
    public static function GetShiftData($emp_code)
    {
        $data = DB::table('users')
            ->join('tbl_emp_shift', 'tbl_emp_shift.user_id', 'users.id')
            ->where('users.emp_code', $emp_code)
            ->first();
        return $data;
    }
    //desc: add employee attendance
    //param: attendance data to insert or update
    public static function AddAttendance($data)
    {
        if (empty($data['out_status'])) {
            DB::table('tbl_emp_attendance')
                ->insert($data);
        } else {
            DB::table('tbl_emp_attendance')
                ->update($data);
        }
    }
    //desc: get current month attendance list
    public static function GetAttendanceList()
    {
        // Get the first and last day of the current month
        $firstDayOfMonth = Carbon::now()->startOfMonth();
        $lastDayOfMonth = Carbon::now()->endOfMonth();
        $data = DB::table('tbl_emp_attendance')
            ->whereBetween('created_on', [$firstDayOfMonth, $lastDayOfMonth])
            ->where('user_id', Session::get('emp_id'))
            ->orderBy('created_on','desc')
            ->get();
        return $data;
    }
    //desc: get ticket categories
    public static function GetTicketCategoryList(){
        $data = DB::table('tbl_ticket_category')
        ->get();
        return $data;
    }
    //desc: add employee ticket data
    public static function AddTicket($data){
        DB::table('tbl_tickets')
        ->insert($data);
    }
    //desc: get current employee tickets
    public static function GetSingleEmployeeTicketList(){
        $emp_id = Session::get('emp_id');
        $data = DB::table('tbl_tickets')
        ->where('employee_id',$emp_id)
        ->join('users','users.id','tbl_tickets.employee_id')
        ->join('tbl_ticket_category','tbl_ticket_category.id','tbl_tickets.category_id')
        ->select('tbl_tickets.*','users.name','tbl_ticket_category.category')
        ->get();
        return $data;
    }
    //desc: Get each ticket details for current employee
    //param: ticket_id
    public static function GetSingleEmployeeTicketDetails($ticket_id){
        $data = DB::table('tbl_tickets')
        ->where('tbl_tickets.id',$ticket_id)
        ->join('users','users.id','tbl_tickets.employee_id')
        ->join('tbl_department', 'tbl_department.id','users.depart_id')
        ->join('tbl_ticket_category','tbl_ticket_category.id','tbl_tickets.category_id')
        ->select('tbl_tickets.*','users.name','users.emp_code','tbl_ticket_category.category','tbl_department.department_name')
        ->first();
        return $data;
    }
}