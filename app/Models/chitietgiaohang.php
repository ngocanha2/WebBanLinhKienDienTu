<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chitietgiaohang extends Model
{
    use HasFactory;
    protected $table = "chitietgiaohang";
    public $timestamps = false;
    protected $fillable = [        
        'SoPhieuGiaoHang',
        'MaHang',   
        'SoLuong',
    ];   
}
