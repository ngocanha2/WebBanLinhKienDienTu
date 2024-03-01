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
        // Schema::create('binhluan', function (Blueprint $table) {            
        //     $table->id("MaBinhLuan");
        //     $table->integer('MaHang',11);
        //     $table->foreign('MaHang')->references('MaHang')->on('HangHoa');
        //     $table->string("NoiDung");
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('binhluans');
    }
};
