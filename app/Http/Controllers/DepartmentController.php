<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function index()
    {
        // $departments = Department::all();
        // $departments = DB::table('departments')->get();
        // $departments = Department::paginate(3); // อีกรูปแบบ DB::table('departments')->paginate(3); ต้องไปทำค่าใน model

        // --- เขียน joy ตารางได้เลยโดยที่ไม่ต้องไปทำใน model แบบ ด้านบน ---
        // $departments = DB::table('departments')
        //     ->join('users', 'departments.user_id', 'users.id')
        //     ->select('departments.*', 'users.name')->paginate(3);
        // --- จบ ---

        // หัวข้อ delete
        $departments = Department::paginate(3); //แบบ elowpaen
        $trashDepartments = Department::onlyTrashed()->paginate(3);
        return view('admin.department.index', compact('departments', 'trashDepartments'));
    }

    public function store(Request $request)
    {
        // dd($request->department_name); // dd คือ debug
        $request->validate( // ตรวจสอบข้อมูล
            [
                'department_name' => 'required|unique:departments|max:20' // ต้องมีข้อมูลไม่ว่าง|ไม่ซ้า|ยาวไม่เกิน 10
            ],
            [
                'department_name.required' => 'กรุณาป้อนชื่อตำแหน่งด้วยจ้า',
                'department_name.max' => 'ห้ามป้อนเกิน 20 ตัวอักษร',
                'department_name.unique' => 'คุณใส่ชื่อตำแหน่งซ้ำจ้า'
            ]
        );
        // บันทึกข้อมูล
        // $department = new Department;
        // $department->department_name = $request->department_name;
        // $department->user_id = Auth::user()->id;
        // $department->save();

        $data = array();
        $data["department_name"] = $request->department_name;
        $data["user_id"] = Auth::user()->id;
        DB::table('departments')->insert($data); //query builder
        return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อย');
    }

    public function edit($id)
    {
        // dd($id); // dd คือ debug
        // dd($Department->department_name);
        $department = Department::find($id);

        return view('admin.department.edit', compact('department'));
    }

    public function update(Request $request, $id)
    {
        // dd($id, $request->department_name);
        $request->validate( // ตรวจสอบข้อมูล
            [
                'department_name' => 'required|unique:departments|max:20' // ต้องมีข้อมูลไม่ว่าง|ไม่ซ้า|ยาวไม่เกิน 10
            ],
            [
                'department_name.required' => 'กรุณาป้อนชื่อตำแหน่งด้วยจ้า',
                'department_name.max' => 'ห้ามป้อนเกิน 20 ตัวอักษร',
                'department_name.unique' => 'คุณใส่ชื่อตำแหน่งซ้ำจ้า'
            ]
        );
        $update = Department::find($id)->update([
            'department_name' => $request->department_name,
            'user_id' => Auth::user()->id
        ]);
        return redirect()->route('department')->with('success', 'อัพเดทข้อมูลเรียบร้อย');
    }

    public function softdelete($id)
    {
        // dd($id);
        $delete = Department::find($id)->delete();
        return redirect()->back()->with('department')->with('success', 'ลบข้อมูลเรียบร้อย');
    }

    public function restore($id){
        $restore = Department::withTrashed()->find($id)->restore();
        return redirect()->back()->with('department')->with('success', 'กู้คืนข้อมูลเรียบร้อย');
    }

    public function delete($id){
        $delete = Department::onlyTrashed()->find($id)->forcedelete();
        return redirect()->back()->with('department')->with('success', 'ลบในถังขยะเรียบร้อย');
    }
}
