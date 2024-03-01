<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class giohang extends Model
{
    use HasFactory;    
    protected $table = "giohang";
    public $timestamps = false;

    protected $fillable = [        
        'MaKH',
        'MaHang',   
        'SoLuongTrongGio',        
    ];      
}
