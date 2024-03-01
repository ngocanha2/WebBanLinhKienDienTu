<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('yeucaubaohanh', function (Blueprint $table) {
            $table->id();            
            $table->integer('MaDonhang',11)->unsigned();
            $table->foreign('MaDonhang')->references('MaDonhang')->on('donhang');
            $table->integer('MaHang',11)->unsigned();
            $table->foreign('MaHang')->references('MaHang')->on('hanghoa');
            $table->dateTime("NgayYeuCau");
            $table->string("NguyenNhanBaoHanh");
            $table->boolean("DaXuLy")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yeucaubaohanh');
    }
};
