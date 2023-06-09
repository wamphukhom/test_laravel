<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            สวัสดีคุณ, {{Auth::user()->name}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ลำดับ</th>
                            <th scope="col">ชื่อ</th>
                            <th scope="col">อีเมล์</th>
                            <th scope="col">วันที่</th>
                            <th scope="col">เริ่มใช้งานระบบ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($i=1)
                        @foreach ($users as $row)
                        <tr>
                            <th scope="row">{{ $users->firstItem()+$loop->index }}</th>
                            <td>{{$row->name}}</td>
                            <td>{{$row->email}}</td>
                            <td>{{$row->created_at}}</td>
                            <td>{{Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</td> <!-- $row->created_at->diffForHumans() -->
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$users->links()}}
            </div>
        </div>
    </div>
</x-app-layout>
