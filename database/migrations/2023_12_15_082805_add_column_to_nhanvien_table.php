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
        Schema::table('nhanvien', function (Blueprint $table) {
            $table->string("password")->default('$2y$10$bsr.l72cucLlteucqkYKKewIKEPf1YmdocSAsDCaIA3uQoOX4werm');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nhanvien', function (Blueprint $table) {
            //
        });
    }
};
