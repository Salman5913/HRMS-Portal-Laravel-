<?php

namespace App\Http\Controllers;

use App\Events\TicketChat;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;
use App\Models\TicketMessaging;

class EmployeeController extends Controller
{
    //desc: view employee dashboard
    public function index()
    {
        if (!empty(Session::get('emp_id'))) {
            $page = "Employee Dashboard";
            return view('employee.dashboard')->with('page', $page);
        }
        return redirect()->route('employee-login-page');
    }
    public function login(Request $request)
    {
        $user = DB::table('users')->where('email', $request->email)->first();
        if (!empty($user)) {
            if (Hash::check($request->password, $user->password)) {
                Auth::loginUsingId($user->id);
                Session::put('emp_id', $user->id);
                return redirect()->route('employee-dashboard');
            }
        }
        return redirect()->back()->with('error', 'Invalid credentials or user does not exists');
    }
    public function logout()
    {
        Auth::logout();
        Session::forget('emp_id');
        return redirect()->route('employee-login-page');
    }
    //desc: view leave dashboard
    public function ShowLeaveList()
    {
        if (!empty(Session::get('emp_id'))) {
            $data['page'] = 'Manage Leave';
            $data['leaveData'] = Employee::GetSingleEmployeeLeaveList();
            return view('employee.leave_dashboard', $data);
        }
        return redirect('/');
    }

    //desc: view to select leave type
    public function ShowAddLeaveForm()
    {
        if (!empty(Session::get('emp_id'))) {
            $data['page'] = 'Apply Leave';
            return view('employee.add_leave', $data);
        }
        return redirect('/');
    }
    //desc: add leave data
    public function AddLeave(Request $request)
    {
        if (!empty(Session::get('emp_id'))) {
            if ($request->leave_type == 'Half Day') {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'leave_type' => 'required',
                        'from_time' => 'required|after:now',
                        'to_time' => 'required|after:from_time',
                        'half_day_reason' => 'required',
                    ],
                    [
                        'half_day_reason.required' => 'The reason is required',
                        'from_time.after' => 'The from time field must be a time after now',
                        'to_time.after' => 'The to time field must be a time after from time field'
                    ]
                );
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator);
                }
                $fromtime = date('H:i:s', strtotime($request->from_time));
                $totime = date('H:i:s', strtotime($request->to_time));
                $data = [
                    'leave_type' => $request->leave_type,
                    'from_time' => $fromtime,
                    'to_time' => $totime,
                    'from_date' => date('Y-m-d H:i:s'),
                    'to_date' => date('Y-m-d H:i:s'),
                    'number_of_leaves' => 0,
                    'reason' => $request->half_day_reason,
                    'status' => 1,
                    'created_on' => date('Y-m-d H:i:s')
                ];
                Employee::AddLeave($data);
            } else {
                $current_time = strtotime(date('H:i:s'));
                $today = date('Y-m-d');
                if ($request->from_date == $today && $current_time > strtotime('9:00:00')) {
                    return redirect()->back()->with('application_error', 'You cannot apply leave after 9 am for the same day');
                }
                if ($request->from_date < $today) {
                    return redirect()->back()->with('application_error', 'Leave application date could not be in past');
                }
                if ($request->no_of_leave > 2) {
                    return redirect()->back()->with('application_error', 'You cannot apply leave for more than two days');
                }
                $validator = Validator::make(
                    $request->all(),
                    [
                        'leave_type' => 'required',
                        'from_date' => 'required',
                        'to_date' => 'required|after_or_equal:from_date',
                        'full_day_reason' => 'required',
                        'no_of_leave' => 'required'
                    ],
                    [
                        'full_day_reason.required' => 'The reason is required',
                    ]
                );
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator);
                }
                $data = [
                    'leave_type' => $request->leave_type,
                    'from_date' => date('Y-m-d H:i:s', strtotime($request->from_date)),
                    'to_date' => date('Y-m-d H:i:s', strtotime($request->to_date)),
                    'number_of_leaves' => $request->no_of_leave,
                    'reason' => $request->full_day_reason,
                    'status' => 1,
                    'created_on' => date('Y-m-d H:i:s')
                ];
                Employee::AddLeave($data);
            }
            return redirect()->route('leave-list')->with('success', 'Leave applied');
        }
        return redirect('/');
    }

    //desc: desc: show attendance list
    public function ShowAttendanceList()
    {
        if (!empty(Session::get('emp_id'))) {
            $data['page'] = 'Attendance';
            $data['attendanceData'] = Employee::GetAttendanceList();
            return view('employee.attendance_list', $data);
        }
        return redirect('/');
    }
    //desc:show view to mark attendance
    public function ShowAttendanceMarkPage()
    {
        if (!empty(Session::get('emp_id'))) {
            $data['page'] = 'Mark Attendance';

            return view('employee.mark_attendance', $data);
        }
        return redirect('/');
    }
    //add employee attendance
    public function AddAttendance(Request $request)
    {
        if (!empty(Session::get('emp_id'))) {
            $request->validate([
                'emp_code' => 'required|numeric'
            ]);
            $shift_data = Employee::GetShiftData($request->emp_code);
            $current_time = date('H:i:s');
            if (!empty($shift_data)) {
                $shift_in_time = strtotime($shift_data->shift_in_time);
                $shift_out_time = strtotime($shift_data->shift_out_time);
                $check_time_in_out = Employee::CheckTimeIn($request->emp_code);
                //if time in not marked
                if (empty($check_time_in_out->time_in)) {
                    $status = 'On Time';
                    if (strtotime($current_time) > $shift_in_time) {
                        $status = 'Late In';
                    }
                    $data = [
                        'user_id' => Session::get('emp_id'),
                        'shift_id' => $shift_data->id,
                        'time_in' => $current_time,
                        'in_status' => $status,
                        'created_on' => date('Y-m-d')
                    ];
                }
                //if time in is marked
                if (!empty($check_time_in_out->time_in) && empty($check_time_in_out->time_out)) {
                    $status = 'System Time Out';
                    if (strtotime($current_time) < $shift_out_time) {
                        $status = 'Early Going';
                    }
                    $data = [
                        'time_out' => $current_time,
                        'out_status' => $status,
                        'updated_on' => date('Y-m-d H:i:s')
                    ];
                }
                if (!empty($check_time_in_out->time_in) && !empty($check_time_in_out->time_out)) {
                    return redirect()->route('attendance-list')->with('success', 'Attendance is already marked.');
                }
                Employee::AddAttendance($data);
                return redirect()->route('attendance-list')->with('success', 'Attendance marked.');
            }
            return redirect()->back()->withErrors(['emp_code' => 'Some errors occured or employee code does not exists.']);
        }
        return redirect('/');
    }
    //desc: Show employee ticket list
    public function ShowTicketList()
    {
        if (!empty(Session::get('emp_id'))) {
            $data['page'] = 'Ticket';
            $data['ticket_category'] = Employee::GetTicketCategoryList();
            $data['ticket_data'] = Employee::GetSingleEmployeeTicketList();
            return view('employee.ticket_list', $data);
        }
        return redirect('/');
    }
    //desc: Add employee ticket
    public function AddTicket(Request $request)
    {
        if (!empty(Session::get('emp_id'))) {
            $request->validate(
                [
                    'ticket_category' => 'required',
                    'ticket_subject' => 'required|max:100',
                    'ticket_detail' => 'required|max:350',
                ],
                [
                    'ticket_category.required' => 'Required',
                    'ticket_subject.required' => 'Required',
                    'ticket_detail.required' => 'Required',
                    'ticket_subject.max' > 'Ticket subject should not more than 150 characters long',
                    'ticket_category.max' > 'Ticket detail should not more than 150 characters long'
                ]
            );
            $last_compliant_no = DB::table('tbl_tickets')->max('complain_number');
            $complain_number = $last_compliant_no + 1;
            $ticket_number = 'ticket#00' . $complain_number;
            $data = [
                'complain_number' => $complain_number,
                'ticket_number' => $ticket_number,
                'category_id' => $request->ticket_category,
                'employee_id' => Session::get('emp_id'),
                'subject' => $request->ticket_subject,
                'detail' => $request->ticket_detail,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => Session::get('emp_id'),
                'status' => 1
            ];
            Employee::AddTicket($data);
            return redirect()->route('ticket-list')->with('success', 'Ticker successfully added!');
        }
        return redirect('/');
    }
    //desc: view single ticket details
    //param: ticket_id
    public function ShowTicketDetails($ticket_id){
        $data['page'] = 'Ticket Details';
        $data['ticket_details'] = Employee::GetSingleEmployeeTicketDetails($ticket_id);
        $data['messages'] = DB::table('tbl_ticket_reply')
        ->where('ticket_id',$ticket_id)
        ->join('users','users.id','tbl_ticket_reply.user_id')
        ->get();
        return view('employee.ticket_details',$data);
    }
    //send messages for ticket
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
            'user_id' => $login_user_id,
        ];
        TicketMessaging::insert($data);
        return response()->json(['messages' => $message]);
    }
}