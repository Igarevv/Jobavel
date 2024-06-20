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
        Schema::create('employees', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->generatedAs()->always();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('first_name')->unique();
            $table->string('last_name')->unique();
            $table->string('email');
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
