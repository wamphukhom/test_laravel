<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [ // ฟิลด์ใดบางที่เราจะเพิ่มข้อมูลได้ ลบข้อมูลได้
        'service_name',
        'service_image',
    ];

    // อัพโครงสร้างไปยังดาต้าเบสใช้ php artisan migrate
}
