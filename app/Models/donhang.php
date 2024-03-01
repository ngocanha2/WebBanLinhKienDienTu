<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class donhang extends Model
{
    use HasFactory;
    protected $table = "donhang";
    public $timestamps = false;

    protected $primaryKey = "MaDonhang";
    protected $fillable = [        
        'MaDonhang',
        'MaKH',   
        'NgayMua',
        'ThanhTien',
        'TenNguoiNhan',
        'SDT',
        'Email',
        'GhiChu',        
        'token',
        'DiaChiGiaoHang',
        'TrangThai',
        'PhuongThucVanChuyen',
        'PhuongThucThanhToan'
    ];   
}
