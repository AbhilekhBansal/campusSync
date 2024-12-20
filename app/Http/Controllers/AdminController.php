<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Classes;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    public function dashboard(Request $request)
    {
        return view('admin.dashboard.admin-dashboard');
    }
    // Admin
    public function manageAdmin(Request $request)
    {
        $admins = User::with('admin')->where('role', '=', 'admin')->get();
        // return $admins;

        return view('admin.manage-admin.admin-list', compact('admins'));
    }

    public function createAdmin(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $admin = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']), // Hash the password
            'role' => 'admin',
        ]);

        Admin::create([
            'user_id' => $admin->id,
            'status' => 1,
        ]);
        $admins = User::with('admin')->where('role', '=', 'admin')->get();

        return response()->json(['success' => 'Admin added successfully!', 'admins' => $admins], 201);
    }

    public function updateAdminStatus(Request $request, int $id)
    {
        $validatedData = Validator::make(['id' => (int)$id], [
            'id' => 'required|integer|exists:admins,user_id',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['error' => $validatedData->errors()], 400);
        }

        $admin = Admin::where('user_id', $id)->first();

        $admin->status = $admin->status == 1 ? 0 : 1;

        $admin->save();

        return response()->json([
            'success' => 'Admin status updated successfully!',
            'admin' => $admin,
        ], 200);
    }

    public function updateAdmin(Request $request, int $id)
    {
        $validatedData = Validator::make([$request->all(), "id" => $id], [
            'id' => 'required|integer|exists:admins,user_id',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $id . ',id',
            'password' => 'nullable|string|min:6',
        ])->after(function ($validator) use ($request) {
            if (!$request->filled('name') && !$request->filled('email') && !$request->filled('password')) {
                $validator->errors()->add('fields', 'At least one field (name, email, or password) must be provided.');
            }
        });

        // Check if validation fails
        if ($validatedData->fails()) {
            return response()->json(['error' => $validatedData->errors()], 400);
        }


        $admin = User::where('id', $id)->first();
        if (!$admin) {
            return response()->json(['error' => 'Admin not found'], 404);
        }


        $admin->name = $request->name;
        $admin->email = $request->email;


        if ($request->filled('password')) {
            $admin->password = bcrypt($request->password);
        }

        $admin->save();
        $admins = User::with('admin')->where('role', '=', 'admin')->get();

        return response()->json([
            'success' => 'Admin updated successfully!',
            'admins' => $admins,
        ], 200);
    }

    public function deleteAdmin(Request $request, int $id)
    {
        $validatedData = Validator::make(['id' => (int)$id], [
            'id' => 'required|integer|exists:admins,user_id',
        ]);
        if ($validatedData->fails()) {
            return response()->json(['error' => $validatedData->errors()], 400);
        }
        User::where('id', $id)->delete();
        return response()->json(['success' => 'Admin deleted successfully!'], 200);
    }
    public function getAdmin(Request $request, $id)
    {
        $validatedData = Validator::make(['id' => (int)$id], [
            'id' => 'required|integer|exists:admins,user_id',
        ]);
        if ($validatedData->fails()) {
            return response()->json(['error' => $validatedData->errors()], 400);
        }
        $admin = User::with('admin')->where('id', $id)->first();
        return response()->json(['success' => 'Admin fetched successfully!', 'admin' => $admin], 200);
    }
    // Student
    public function manageStudent(Request $request)
    {
        $students = User::with(['student.class'])
            ->where('role', '=', 'student')
            ->get();
        // return $students;
        $subjects = Subject::all();
        $classes = Classes::all();

        return view('admin.manage-students.student-list', compact('students', 'subjects', 'classes'));
    }

    public function createStudent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'studentClass' => 'required|integer|exists:classes,id',
            'roll' => 'required|integer|unique:students,roll_number|digits:10',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();


        $student = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']), // Hash the password
            'role' => 'student',
        ]);

        Student::create([
            'user_id' => $student->id,
            'class_id' => $validatedData['studentClass'],
            'roll_number' => $validatedData['roll'],
            'status' => 1,
        ]);

        $students = User::with(['student.class'])->where('role', '=', 'student')->get();

        return response()->json([
            'success' => true,
            'message' => 'Student added successfully!',
            'students' => $students,
        ], 201);
    }


    public function updateStudentStatus(Request $request)
    {
        $validatedData = Validator::make(['id' => (int)$request->id], [
            'id' => 'required|integer|exists:students,user_id',
        ]);
        if ($validatedData->fails()) {
            return response()->json(['error' => $validatedData->errors()], 400);
        }
        $student = Student::where('user_id', $request->id)->first();
        $student->status = $student->status == 1 ? 0 : 1;
        $student->save();
        return response()->json(['success' => 'Student status updated successfully!', 'student' => $student], 200);
    }

    public function deleteStudent(Request $request)
    {
        $validatedData = Validator::make(['id' => (int)$request->id], [
            'id' => 'required|integer|exists:students,user_id',
        ]);
        if ($validatedData->fails()) {
            return response()->json(['error' => $validatedData->errors()], 400);
        }
        User::where('id', $request->id)->delete();
        return response()->json(['success' => 'Student deleted successfully!'], 200);
    }

    public function getStudent(Request $request)
    {
        $validatedData = Validator::make(['id' => (int)$request->id], [
            'id' => 'required|integer|exists:students,user_id',
        ]);
        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()], 400);
        }
        $student = User::with(['student.class'])->where('id', $request->id)->first();
        // return $teacher;
        return response()->json(['success' => 'Student fetched successfully!', 'student' => $student], 200);
    }

    public function updateStudent(Request $request, $id)
    {
        $validatedData = Validator::make(array_merge($request->all(), ["id" => $id]), [
            'id' => 'required|integer|exists:students,user_id',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'class' => 'nullable|integer|exists:class,id',
            'roll' => 'nullable|integer|unique:students,roll_number,' . $id . ',user_id',
        ])->after(function ($validator) use ($request) {

            if (
                !$request->filled('name') && !$request->filled('email') &&
                !$request->filled('password') && !$request->filled('class') && !$request->filled('roll')
            ) {
                $validator->errors()->add('fields', 'At least one field (name, email, subject, roll, or password) must be provided.');
            }
        });

        if ($validatedData->fails()) {
            return response()->json(['error' => $validatedData->errors()], 400);
        }

        $student = User::where('id', $id)->first();
        if (!$student) {
            return response()->json(['error' => 'Teacher not found'], 404);
        }

        if ($request->filled('name')) {
            $student->name = $request->name;
        }

        if ($request->filled('email')) {
            $student->email = $request->email;
        }

        if ($request->filled('password')) {
            $student->password = bcrypt($request->password);
        }

        $student->save();

        if ($request->filled('class')) {
            $student->student->class_id = $request->class;
            $student->student->save();
        }

        $students = User::with(['student.class'])->where('role', 'student')->get();

        return response()->json([
            'success' => 'Student updated successfully!',
            'students' => $students,
        ], 200);
    }

    // Teachers
    public function manageTeachers(Request $request)
    {
        $teachs = User::with(['teacher.subject'])
            ->where('role', '=', 'teacher')
            ->get();
        // return $teachs;
        $subjects = Subject::all();

        return view('admin.manage-teacher.teacher-list', compact('teachs', 'subjects'));
    }

    public function createTeacher(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'subject' => 'required|integer|exists:subjects,id',
        ]);


        $admin = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']), // Hash the password
            'role' => 'teacher',
        ]);

        Teacher::create([
            'user_id' => $admin->id,
            'subject_id' => $validatedData['subject'],
            'status' => 1,
        ]);
        $teachs = User::with(['teacher.subject'])->where('role', '=', 'teacher')->get();

        return response()->json(['success' => 'Teacher added successfully!', 'teachs' => $teachs], 201);
    }

    public function updateTeacherStatus(Request $request)
    {
        $validatedData = Validator::make(['id' => (int)$request->id], [
            'id' => 'required|integer|exists:teachers,user_id',
        ]);
        if ($validatedData->fails()) {
            return response()->json(['error' => $validatedData->errors()], 400);
        }
        $teacher = Teacher::where('user_id', $request->id)->first();
        $teacher->status = $teacher->status == 1 ? 0 : 1;
        $teacher->save();
        return response()->json(['success' => 'Teacher status updated successfully!', 'teacher' => $teacher], 200);
    }

    public function deleteTeacher(Request $request)
    {
        $validatedData = Validator::make(['id' => (int)$request->id], [
            'id' => 'required|integer|exists:teachers,user_id',
        ]);
        if ($validatedData->fails()) {
            return response()->json(['error' => $validatedData->errors()], 400);
        }
        User::where('id', $request->id)->delete();
        return response()->json(['success' => 'Teacher deleted successfully!'], 200);
    }

    public function getTeacher(Request $request)
    {
        $validatedData = Validator::make(['id' => (int)$request->id], [
            'id' => 'required|integer|exists:teachers,user_id',
        ]);
        if ($validatedData->fails()) {
            return response()->json(['error' => $validatedData->errors()], 400);
        }
        $teacher = User::with(['teacher.subject'])->where('id', $request->id)->first();
        // return $teacher;
        return response()->json(['success' => 'Teacher fetched successfully!', 'teacher' => $teacher], 200);
    }

    public function updateTeacher(Request $request, $id)
    {
        $validatedData = Validator::make(array_merge($request->all(), ["id" => $id]), [
            'id' => 'required|integer|exists:teachers,user_id',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'subject' => 'nullable|integer|exists:subjects,id',
        ])->after(function ($validator) use ($request) {

            if (
                !$request->filled('name') && !$request->filled('email') &&
                !$request->filled('password') && !$request->filled('subject')
            ) {
                $validator->errors()->add('fields', 'At least one field (name, email, subject, or password) must be provided.');
            }
        });

        if ($validatedData->fails()) {
            return response()->json(['error' => $validatedData->errors()], 400);
        }

        $teacher = User::where('id', $id)->first();
        if (!$teacher) {
            return response()->json(['error' => 'Teacher not found'], 404);
        }

        if ($request->filled('name')) {
            $teacher->name = $request->name;
        }

        if ($request->filled('email')) {
            $teacher->email = $request->email;
        }

        if ($request->filled('password')) {
            $teacher->password = bcrypt($request->password);
        }

        $teacher->save();

        if ($request->filled('subject')) {
            $teacher->teacher->subject_id = $request->subject;
            $teacher->teacher->save();
        }

        $teachers = User::with(['teacher.subject'])->where('role', 'teacher')->get();

        return response()->json([
            'success' => 'Teacher updated successfully!',
            'teachers' => $teachers,
        ], 200);
    }
}
