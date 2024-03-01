<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hoadonbaohanhsuachua extends Model
{
    use HasFactory;
    protected $table = "hoadonbaohanhsuachua";
    public $timestamps = false;
    protected $primaryKey = "YeuCauBaoHanhId";
    protected $fillable = [        
        'YeuCauBaoHanhId',
        'NgayTao',   
        'SoLuongThayMoi',
        'SoLuongSuaChua',        
        'ThanhTien',
        'MoTa',          
    ];   
}
