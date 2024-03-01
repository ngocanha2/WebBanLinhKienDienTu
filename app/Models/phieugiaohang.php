<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class phieugiaohang extends Model
{
    use HasFactory;
    public $timestamps = false;    
    protected $table = "phieugiaohang";
    protected $primaryKey = "SoPhieuGiaoHang";
    protected $fillable = [        
        'SoPhieuGiaoHang',
        'SoPhieuDatHang',
        'NgayGiao',
        'TongSoLuong',
        'GhiChu',   
        'TrangThai',
        'ThanhTien',
    ];   
}
