<?php

namespace App\Http\Controllers;

use App\Models\TicketMessaging;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;
use App\Events\TicketChat;

class AdminController extends Controller
{

    //view main dashboard
    public function index($page = null)
    {
        if (!empty(Session::get('id'))) {
            $page = 'Admin Dashboard';
            return view('admin.dashboard')->with('page', $page);
        }
        return redirect()->route('admin-login-page');
    }
    public function login(Request $request)
    {
        $user = DB::table('users')->where('email', $request->email)->first();
        if (!empty($user)) {
            if (Hash::check($request->password, $user->password)) {
                Auth::loginUsingId($user->id);
                Session::put('id', $user->id);
                Session::put('admin_name', $user->name);
                return redirect()->route('admin-dashboard');
            }
        }
        return redirect()->back()->with('error', 'Invalid credentials or user does not exists');
    }
    public function logout()
    {
        Auth::logout();
        Session::forget('id');
        return redirect()->route('admin-login-page');
    }
    //view users
    public function ShowUserList()
    {
        if (!empty(Session::get('id'))) {
            $data['page'] = 'Manage User';
            $data['userData'] = Admin::GetUserList()->paginate(5);
            return view('admin.manage_user', $data);
        }
        return redirect('/admin');
    }
    //view form to add user
    public function ShowAddUserForm()
    {
        if (!empty(Session::get('id'))) {
            $data['page'] = 'Add User';
            $data['department'] = Admin::GetDeparments();
            return view('admin.add_user_form', $data);
        }
        return redirect('/admin');
    }
    //store user details
    public function AddUser(Request $request)
    {
        if (!empty(Session::get('id'))) {
            $validator = Validator::make($request->all(), [
                'username' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'department' => 'required',
                'emp_code' => 'required|numeric|unique:users',
                'address' => 'required',
                'gender' => 'required',
                'city' => 'required',
                'contact' => 'required|numeric',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $password = Hash::make($request->password);
            $data = [
                'name' => $request->username,
                'email' => $request->email,
                'password' => $password,
                'depart_id' => $request->department,
                'emp_code' => $request->emp_code,
                'address' => $request->address,
                'gender' => $request->gender,
                'city' => $request->city,
                'contact' => $request->contact,
                'created_by' => Session::get('id'),
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 1
            ];
            Admin::AddUser($data);
            return redirect()->route('user-list')->with('success', 'User added successfully!');
        }
        return redirect('/admin');
    }
    //desc : view for  to edit user details,
    //param : user_id
    public function ShowEditForm($id)
    {
        if (!empty(Session::get('id'))) {
            $data['userData'] = Admin::GetUserData($id);
            $data['page'] = 'Edit User';
            $data['department'] = Admin::GetDeparments();
            return view('admin.edit_form', $data);
        }
        return redirect('/');
    }
    //desc: update user details
    //param : user_id
    public function UpdateUserData(Request $request, $id)
    {
        if (!empty(Session::get('id'))) {
            $request->validate([
                'username' => 'required',
                'email' => 'required|email|unique:users,email,' . $request->id,
                'department' => 'required',
                'address' => 'required',
                'role' => 'required',
                'gender' => 'required',
                'city' => 'required',
                'contact' => 'required|numeric',
            ]);
            $data['roleData'] = [
                'role_id' => $request->role,
                'user_id' => $id,
            ];
            $data['userData'] = [
                'name' => $request->username,
                'email' => $request->email,
                'depart_id' => $request->department,
                'address' => $request->address,
                'gender' => $request->gender,
                'city' => $request->city,
                'contact' => $request->contact,
            ];
            if (!empty($request->password)) {
                $data['password'] = $request->password;
            }
            Admin::UpdateUserData($data, $id);
            return redirect()->route('user-list')->with('success', 'User updated successfully!');
        }
        return redirect('/admin');
    }
    //desc : update status on delete request
    //param : user_id
    public function DeleteUser($id)
    {
        if (!empty(Session::get('id'))) {
            Admin::DeleteUser($id);
            return redirect()->route('user-list')->with('success', 'User deleted successfully!');
        }
        return redirect('/admin');
    }

    //desc: show leaves applied
    public function ShowEmployeeLeaveList()
    {
        if (!empty(Session::get('id'))) {
            $data['page'] = 'Manage Leave';
            $data['leaveData'] = Admin::GetEmployeeLeaveList();
            return view('admin.manage_leave', $data);
        }
        return redirect('/admin');
    }

    //save leave status
    public function SaveLeaveStatus(Request $request)
    {
        if (!empty(Session::get('id'))) {
            $leave_id = $request->leave_id;
            $leave_status = $request->leave_status;
            Admin::SaveLeaveStatus($leave_status, $leave_id);
            return redirect()->route('manage-leave')->with('success', 'Leave ' . $leave_status);
        }
        return redirect('/admin');
    }
    //desc: show tickets
    public function ShowTicketList()
    {
        $data['page'] = 'Manage Ticket';
        $data['ticket_data'] = Admin::GetEmployeesTicketData();
        return view('admin.manage_ticket', $data);
    }
    //desc:show individual ticket details to admin
    //param: ticket_id
    public function ShowTicketDetails($ticket_id)
    {
        $data['page'] = 'Ticket Detials';
        $data['ticket_details'] = Admin::GetIndividualTicketDetails($ticket_id);
        $data['messages'] = DB::table('tbl_ticket_reply')
        ->where('ticket_id',$ticket_id)
        ->join('users','users.id','tbl_ticket_reply.user_id')
        ->get();
        // dd($data['messages']);
        return view('admin.ticket_data', $data);

    }
    public function SendTicketMessage(Request $request)
    {
        $username = $request->username;
        $message = $request->message;
        $login_user_id = $request->login_user_id;
        $ticket_id = $request->ticket_id;
        event(new TicketChat($username, $message, $login_user_id,$ticket_id));
        $data = [
            'ticket_id' => $request->ticket_id,
            'reply' => $request->message,
            'user_id' =>$login_user_id,
        ];
        TicketMessaging::insert($data);
        return response()->json(['messages' => $message]);
    }
}