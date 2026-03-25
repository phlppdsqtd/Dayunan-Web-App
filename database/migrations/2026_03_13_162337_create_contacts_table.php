<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('contacts', function (Blueprint $table) {
        $table->id();
        $table->string('name');           // James, Jan
        $table->string('role');           // Front Desk, Admin
        $table->string('staff_type');     // Staff
        $table->string('contact_number'); // 0963...
        $table->string('email');          // james@dayunan.com
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};