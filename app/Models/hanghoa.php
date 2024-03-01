<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hanghoa extends Model
{
    use HasFactory;
    protected $table = "hanghoa";
    public $timestamps = false;

    protected $primaryKey = "MaHang";
    protected $fillable = [        
        'MaHang',
        'TenHang',   
        'GiaBan',
        'SoLuongTon',
        'ThoiGianBaoHanh',
        'HinhAnh',
        'FlagXoa',
        'MaDanhMuc',        
        'MaKhuyenMai',
    ];   
    protected $casts = [
        'FlagXoa' => 'boolean',
    ];
}
