<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nguonhang extends Model
{
    use HasFactory;    
    protected $table = "nguonhang";
    protected $fillable = [        
        'MaHang',
        'MaNCC',   
        'GiaNhap',          
    ];      
    public $timestamps = false;
}
