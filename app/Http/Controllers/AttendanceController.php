<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolClass;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\Branch;
use App\Models\Date;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{

    public function index(request $req){
        $requestedMonth = $req->input('Month');  //2024-10-24
        $class_id = $req->input( 'classes');
        $section_id = $req->input('sections');

        // if ($requestedMonth) {
        //     // Assuming month values are 1-12 (January = 1, February = 2, etc.)
        //     $startDate = Carbon::createFromDate(date('Y'), $requestedMonth)->startOfMonth();
        // } else {
        //     // Default to the current month
        //     $startDate = Carbon::now()->startOfMonth();
        // }

        // dd($startDate);

        if($requestedMonth) {
            // Parse the input to get the month
            $month = Carbon::parse($requestedMonth)->month; // Get the month number (1-12)
            $year = Carbon::parse($requestedMonth)->year; // Get the year

            // Create the start date for the requested month
            $startDate = Carbon::createFromDate($year, $month)->startOfMonth();
        } else {
            // Default to the current month
            $startDate = Carbon::now()->startOfMonth();
        }


        $endDate = $startDate->copy()->endOfMonth();
        $daysName = [];
        $attendances = [];

        if($section_id){
            $students = Student::with('attendances')->where('class_id', $class_id)->where('section_id', $section_id)->get();
        }
        else{
            $students = Student::with('attendances')->where('class_id', $class_id)->get();
        }

        // Loop through the days of the month
        while ($startDate <= $endDate) {
            $daysName[] = $startDate->formatLocalized('%A');

            // Get attendance records for each student on that day
            foreach ($students as $student) {
                $attendanceRecord = $student->attendances()
                    ->where('date_id', Date::where('date', $startDate->format('Y-m-d'))->first()->id)
                    ->first();

                $attendances[$student->full_name][$startDate->format('Y-m-d')] = [
                    'dayName' => $startDate->formatLocalized('%A'),
                    'status' => $attendanceRecord->status ?? null,
                ];
            }

            $startDate->addDay(); // Increment the date
        }



        $classes = SchoolClass::all();
        $branches = Branch::all();
        $data = [
            'daysName' => $daysName,
            'classes' => $classes,
            'branches' => $branches,
            'attendances' => $attendances,
            'daysName' => $daysName

        ];
        return view("dashboard.attendances.index",$data);
    }
    public function create(){
        $classes = SchoolClass::all();
        $branches = Branch::all();
        $data = [
            'classes' => $classes,
            'branches' => $branches
        ];
        return view("dashboard.attendances.create",$data);
    }


    public function store(request $request)
    {
    $validator = Validator::make($request->all(), [
        'date' => 'required|date|exists:dates,date',
        'class_id' => 'required|integer',
        'branch_id' => 'required|integer',
        'section_id' => 'required|integer',
        'student_id' => 'required|array',
        'status' => 'required|array',
        'status.*' => 'required', // Example statuses
    ]);
    if ($validator->fails()) {
        return ['errors' => $validator->errors()];
    }

    $date_id = Date::where('date', $request->date)->first();

    $insert_data = [];
    foreach ($request->student_id as $index => $student_id) {
        $insert_data[] = [
            'class_id' => (int)$request->class_id,
            'branch_id' => (int)$request->branch_id,
            'section_id' => (int)$request->section_id,
            'student_id' => (int)$student_id,
            'status' => $request->status[$index],
            'lock' => 1,
            'date_id' => $date_id->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    // Perform a batch insert
    Attendance::insert($insert_data);
    $msg = [
        'success' => 'Attendance Submitted Successfully',
        'redirect' => route('attendances')
    ];
    return response()->json($msg);

    }
    public function fetch(request $request){

        $validator = Validator::make($request->all(), [
            'branch_id' => 'required',
            'class_id' => 'required',
            'section_id' => 'required',
            'date' => 'required',
        ]);
        if ($validator->fails()) {
            return ['errors' => $validator->errors()];
        }



        $date = $request->date;
        $attendanceExists = Attendance::where('class_id',$request->class_id)->where('section_id',$request->section_id)->whereHas('date', function($query) use ($date) {
            $query->where('date', $date);
        })->exists();

        if ($attendanceExists) {
            return response()->json(['error'=>'Attendance is locked today.']);
        } else {
            $students = Student::select('id','full_name','father_name','gr_no')->where('class_id',$request->class_id)->where('section_id',$request->section_id)->get();

            $data = [
                'status' => 200,
                'students' => $students,
                'attendance_date' => $request->date,
                'class_id' => $request->class_id,
                'section_id' => $request->section_id,
                'branch_id' => $request->branch_id,
            ];
            return response()->json($data);
        }

    }
}
