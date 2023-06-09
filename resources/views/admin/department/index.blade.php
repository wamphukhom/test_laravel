<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            สวัสดีคุณ, {{ Auth::user()->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">ตารางตำแหน่งงาน</div>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">ลำดับ</th>
                                    <th scope="col">ชื่อแผนก</th>
                                    <th scope="col">ผู้บันทึก</th>
                                    <th scope="col">ระยะเวลา</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($departments as $row)
                                    <tr>
                                        <th scope="row">{{ $departments->firstItem() + $loop->index }}</th>
                                        <td>{{ $row->department_name }}</td>
                                        <td>{{ $row->user->name }}</td> <!-- ถ้าใช้ model ใส่แบบนี้ $row->user->name -->
                                        <td>
                                            @if ($row->created_at == null)
                                                ไม่มีข้อมูล
                                            @else
                                                {{ Carbon\Carbon::parse($row->created_at)->diffForHumans() }}
                                            @endif
                                            <!-- $row->created_at->diffForHumans() -->
                                        </td>
                                        <td>
                                            <a href="{{url('/department/edit/'.$row->id)}}" class="btn btn-warning">แก้ไข</a>
                                        </td>
                                        <td>
                                            <a href="{{url('/department/softdelete/'.$row->id)}}" class="btn btn-danger">ลบข้อมูล</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $departments->links() }}
                    </div>
                    @if (count($trashDepartments) > 0)
                    <div class="card my-2">
                        <div class="card-header">ถังขยะ</div>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">ลำดับ</th>
                                    <th scope="col">ชื่อแผนก</th>
                                    <th scope="col">ผู้บันทึก</th>
                                    <th scope="col">ระยะเวลา</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trashDepartments as $row)
                                    <tr>
                                        <th scope="row">{{ $trashDepartments->firstItem() + $loop->index }}</th>
                                        <td>{{ $row->department_name }}</td>
                                        <td>{{ $row->user->name }}</td> <!-- ถ้าใช้ model ใส่แบบนี้ $row->user->name -->
                                        <td>
                                            @if ($row->created_at == null)
                                                ไม่มีข้อมูล
                                            @else
                                                {{ Carbon\Carbon::parse($row->created_at)->diffForHumans() }}
                                            @endif
                                            <!-- $row->created_at->diffForHumans() -->
                                        </td>
                                        <td>
                                            <a href="{{url('/department/restore/'.$row->id)}}" class="btn btn-warning">กู้คืนข้อมูล</a>
                                        </td>
                                        <td>
                                            <a href="{{url('/department/delete/'.$row->id)}}" class="btn btn-danger">ลบถาวร</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $trashDepartments->links() }}
                    </div>
                    @endif
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">แบบฟอร์ม</div>
                        <div class="card-body">
                            <form action="{{ route('addDepartment') }}" method="POST">
                                @csrf
                                <!-- ป้องกันการแฮกข้อมูล -->
                                <div class="form-grop">
                                    <label for="department_name">ชื่อตำแหน่งงาน</label>
                                    <input type="text" class="form-control" name="department_name">
                                </div>
                                @error('department_name')
                                    <div class="my-2">
                                        <span class="text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                                @if (session('success'))
                                    <div class="my-2">
                                        <span class="text-success">{{ session('success') }}</span>
                                    </div>
                                @endif
                                <br>
                                <input type="submit" value="บันทึก" class="btn btn-primary">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
