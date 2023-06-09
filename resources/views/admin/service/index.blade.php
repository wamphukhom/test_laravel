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
                        <div class="card-header">บริการ</div>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">ลำดับ</th>
                                    <th scope="col">ภาพประกอบ</th>
                                    <th scope="col">ชื่อบริการ</th>
                                    <th scope="col">ระยะเวลา</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($services as $row)
                                    <tr>
                                        <th scope="row">{{ $services->firstItem() + $loop->index }}</th>
                                        <td>
                                            <img src="{{asset($row->service_image)}}" alt="" width="90"></td>
                                        <td>{{ $row->service_name }}</td>
                                        <!-- ถ้าใช้ model ใส่แบบนี้ $row->user->name -->
                                        <td>
                                            @if ($row->created_at == null)
                                                ไม่มีข้อมูล
                                            @else
                                                {{ Carbon\Carbon::parse($row->created_at)->diffForHumans() }}
                                            @endif
                                            <!-- $row->created_at->diffForHumans() -->
                                        </td>
                                        <td>
                                            <a href="{{ url('/service/edit/' . $row->id) }}"
                                                class="btn btn-warning">แก้ไข</a>
                                        </td>
                                        <td>
                                            <a href="{{ url('/service/delete/' . $row->id) }}"
                                                class="btn btn-danger" onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่')">ลบ</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $services->links() }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">แบบฟอร์มบริการ</div>
                        <div class="card-body">
                            <form action="{{route('addService')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!-- ป้องกันการแฮกข้อมูล -->
                                <div class="form-group">
                                    <label for="service_name">ชื่อบริการ</label>
                                    <input type="text" class="form-control" name="service_name">
                                </div>
                                @error('service_name')
                                    <div class="my-2">
                                        <span class="text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                                <div class="form-group">
                                    <label for="service_image">ภาพประกอบ</label>
                                    <input type="file" class="form-control" name="service_image">
                                </div>
                                @error('service_image')
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
