<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class yeucaubaohanh extends Model
{
    use HasFactory;
    protected $table = "yeucaubaohanh";
    public $timestamps = false;
    protected $fillable = [        
        'id',
        'MaDonHang',   
        'MaHang',
        'NgayYeuCau',        
        'NguyenNhanBaoHanh',
        'DaXuLy',
        'SoLuong',        
    ];   
    // protected $casts = [
    //     'DaXuLy' => 'boolean',
    // ];    
}
