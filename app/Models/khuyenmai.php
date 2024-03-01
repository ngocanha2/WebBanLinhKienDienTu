<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class khuyenmai extends Model
{
    use HasFactory;
    protected $table = "khuyenmai";
    protected $primaryKey = "MaKM";
    public $timestamps = false;
    protected $fillable = [        
        'MaKM',
        'TenKhuyenMai',
        'TyLeGiamGia',   
        'NgayBatDau',
        'NgayKetThuc',        
    ];   
    protected $casts = [
        'NgayBatDau' => 'datetime',
        'NgayKetThuc'=>'datetime'
    ];
    
}
