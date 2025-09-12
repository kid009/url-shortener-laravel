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
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->nullable() // อนุญาตให้ guest สร้างลิงก์ได้
                  ->constrained() // เชื่อมไปยังตาราง users
                  ->onDelete('cascade'); // ถ้า user ถูกลบ ให้ลบ link ของ user นั้นด้วย
            $table->text('original_url');
            $table->string('short_code', 10)->unique();
            $table->unsignedBigInteger('clicks')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};
