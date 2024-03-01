<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nhacungcap extends Model
{
    use HasFactory;
    protected $table = "nhacungcap";
    protected $primaryKey = "MaNCC";
    protected $fillable = [        
        'MaNCC',
        'TenNCC',   
        'DiaChi',
        'SDT',        
    ];   
       
    public $timestamps = false;
}
