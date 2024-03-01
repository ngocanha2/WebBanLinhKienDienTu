<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chitietdathang extends Model
{
    use HasFactory;
    protected $table = "chitietdathang";
    public $timestamps = false;
    protected $fillable = [
        'SoPhieuDatHang',
        'MaHang',
        'SoLuong',
        'DonGia'
    ];    
}
