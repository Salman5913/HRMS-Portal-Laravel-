<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Admin extends Model
{
    use HasFactory;
    //desc:get all department
    public static function GetDeparments(){
        $data = DB::table('tbl_department')
        ->get();
        return $data;
    }
    //desc: insert user data
    //param : user data
    public static function AddUser($data)
    {
        DB::table('users')->insert($data);
    }
    //desc: get all users data
    public static function GetUserList()
    {
        $data = DB::table('users as u')
            ->leftJoin('tbl_user_role as ur', 'u.id', 'ur.user_id')
            ->leftJoin('tbl_role as r', 'r.role_id', 'ur.role_id')
            ->leftJoin('tbl_department as d','d.id','u.depart_id')
            ->where('u.status', 1)
            ->select('u.*', 'r.role', 'd.department_name');
        return $data;
    }
    //desc: get single user data
    //param : user_id
    public static function GetUserData($id)
    {
        $data = DB::table('users as u')
            ->leftJoin('tbl_user_role as ur', 'u.id', 'ur.user_id')
            ->leftJoin('tbl_role as r', 'r.role_id', 'ur.role_id')
            ->where('u.id', $id)
            ->select('u.*', 'r.role')
            ->first();
        return $data;
    }
    //desc: update user data
    //param : user_id, user_data
    public static function UpdateUserData($data,$id){
        //update users table
        DB::table('users')
        ->where('id',$id)
        ->update($data['userData']);

        //update or assign role
        $role = DB::table('tbl_user_role')
        ->where('user_id',$id)
        ->first();
        if(empty($role)){
            DB::table('tbl_user_role')
            ->insert($data['roleData']);
        }else{
            DB::table('tbl_user_role')
            ->where('user_id',$id)
            ->update($data['roleData']);
        }
    }
    //desc: update status on delete request
    //param : user_id
    public static function DeleteUser($id){
        DB::table('users')
        ->where('id',$id)
        ->update(['status' => 0]);
    }
    //desc: get leaves applied
    public static function GetEmployeeLeaveList(){
        $data = DB::table('tbl_leave')
        ->get();
        return $data;
    }
    //desc: save leave status
    //param : leave_data,leave_id
    public static function SaveLeaveStatus($leave_status , $leave_id){
        $data= DB::table('tbl_leave')
        ->where('id',$leave_id)
        ->update(['leave_status'=>$leave_status]);
    }
    //desc: get alll employees ticket data
    public static function GetEmployeesTicketData(){
        $data = DB::table('tbl_tickets')
        ->leftJoin('users','users.id','tbl_tickets.employee_id')
        ->leftJoin('tbl_department', 'tbl_department.id','users.depart_id')
        ->leftJoin('tbl_ticket_category','tbl_ticket_category.id','tbl_tickets.category_id')
        ->select('tbl_tickets.*','users.name','users.emp_code','tbl_ticket_category.category','tbl_department.department_name')
        ->get();
        return $data;
    }
    //desc: get individual ticket details
    //param: ticket_id
    public static function GetIndividualTicketDetails($ticket_id){
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

