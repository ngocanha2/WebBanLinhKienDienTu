<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class danhmuc extends Model
{
    use HasFactory;
    protected $table = "danhmuc";
    public $timestamps = false;
    protected $primaryKey = "MaDanhMuc";
    protected $fillable = [   
        "TenDanhMuc"
    ];
}
