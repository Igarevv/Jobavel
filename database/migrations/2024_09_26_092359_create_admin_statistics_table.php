<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_statistics', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->generatedAs()->always();
            $table->integer('vacancies_count')->default(0);
            $table->integer('employers_count')->default(0);
            $table->integer('employees_count')->default(0);
            $table->timestamp('record_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_statistics');
    }
};
