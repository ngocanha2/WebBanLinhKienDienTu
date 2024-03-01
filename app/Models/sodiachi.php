<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sodiachi extends Model
{
    use HasFactory;
    protected $table = "sodiachi";
    protected $primaryKey = "MaDiaChi";
    public $timestamps = false;
    protected $fillable = [        
        'MaDiaChi',
        'MaKH',   
        'DiaChi',
        'DiaChiCuThe',        
        'TenNguoiNhan',
        'SDT',
        'MacDinh',
        'flagXoa'
    ];   
    protected $casts = [
        'MacDinh' => 'boolean',
    ];    
}
