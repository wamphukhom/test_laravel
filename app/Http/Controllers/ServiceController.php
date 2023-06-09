<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ServiceController extends Controller
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
        $services = Service::paginate(3); //แบบ elowpaen
        return view('admin.service.index', compact('services'));
    }

    public function store(Request $request)
    {
        // dd($request->department_name); // dd คือ debug
        $request->validate( // ตรวจสอบข้อมูล
            [
                'service_name' => 'required|unique:services|max:20', // ต้องมีข้อมูลไม่ว่าง|ไม่ซ้า|ยาวไม่เกิน 10
                'service_image' => 'required|mimes:jpg,jpeg,png',
            ],
            [
                'service_name.required' => 'กรุณาป้อนชื่อตำแหน่งด้วยจ้า',
                'service_name.max' => 'ห้ามป้อนเกิน 20 ตัวอักษร',
                'service_name.unique' => 'คุณใส่บริการซ้ำจ้า',
                'service_image.required' => 'กรุณาใส่ภาพประกอบบริการ',
            ]
        );

        // การเข้ารหัสรูปภาพ
        // dd($request->service_name, $request->service_image);
        $service_image = $request->file('service_image');
        //เข้ารหัสรูปภาพได้ชื่อภาพ
        $name_gen = hexdec(uniqid());
        //ดึงนามสกุลภาพ
        $img_ext = strtolower($service_image->getClientOriginalExtension());
        $img_name = $name_gen . '.' . $img_ext;
        //อัพโหลด
        $upload_location = 'image/services/';
        $full_path = $upload_location . $img_name;
        Service::insert([
            'service_name' => $request->service_name,
            'service_image' => $full_path,
            'created_at' => Carbon::now()
        ]);
        $service_image->move($upload_location, $img_name);
        return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อย');
    }

    public function edit($id)
    {
        $service = Service::find($id);
        return view('admin.service.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        // dd($id, $request->department_name);
        $request->validate( // ตรวจสอบข้อมูล
            [
                'service_name' => 'required|max:20', // ต้องมีข้อมูลไม่ว่าง|ไม่ซ้า|ยาวไม่เกิน 10
            ],
            [
                'service_name.required' => 'กรุณาป้อนชื่อตำแหน่งด้วยจ้า',
                'service_name.max' => 'ห้ามป้อนเกิน 20 ตัวอักษร',
            ]
        );
        $service_image = $request->file('service_image');

        if ($service_image) {
            //อัพเดทภาพและชื่อ
            $name_gen = hexdec(uniqid());
            //ดึงนามสกุลภาพ
            $img_ext = strtolower($service_image->getClientOriginalExtension());
            $img_name = $name_gen . '.' . $img_ext;
            //อัพโหลด
            $upload_location = 'image/services/';
            $full_path = $upload_location . $img_name;

            Service::find($id)->update([
                'service_name' => $request->service_name,
                'service_image' => $full_path,
            ]);

            //ลบภาพเก่าและอัพภาพใหม่แทนที่
            $old_image = $request->old_image;
            \unlink($old_image);

            $service_image->move($upload_location, $img_name);
            return redirect()->route('services')->with('success', 'อัพเดทภาพเรียบร้อย');
        } else {
            //อัพเดทภาพอย่างเดียว
            Service::find($id)->update([
                'service_name' => $request->service_name,
            ]);
            return redirect()->route('services')->with('success', 'อัพเดทชื่อเรียบร้อย');

        }

        $update = Service::find($id)->update([
            'service_name' => $request->service_name,
            'user_id' => Auth::user()->id
        ]);
        return redirect()->route('service')->with('success', 'อัพเดทข้อมูลเรียบร้อย');
    }

    public function delete($id){
        //ลบภาพ
        $img = Service::find($id)->service_image;
        \unlink($img);

        //ลบข้อมูลจากฐานข้อมูล
        $delete = Service::find($id)->delete();
        return redirect()->back()->with('success', 'ลบข้อมูลเรียบร้อย');
    }
}
