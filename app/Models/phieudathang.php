<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class phieudathang extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "phieudathang";
    protected $primaryKey = "SoPhieuDatHang";
    protected $fillable = [        
        'SoPhieuDatHang',
        'MaNCC',
        'MaNV',   
        'NgatDat',
        'TongSL',        
        'TongSL', 
        'ThanhTien',       
    ];   
       
}
