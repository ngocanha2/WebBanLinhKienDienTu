<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hinhanh extends Model
{
    use HasFactory;    
    protected $table = "hinhanh";
    public $timestamps = false;

    protected $fillable = [        
        'MaHinh',
        'MaHang',   
        'TenHinh',        
    ];   
    protected $casts = [
        'FlagXoa' => 'boolean',
    ];
}
