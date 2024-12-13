<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
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
    //teachers
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
