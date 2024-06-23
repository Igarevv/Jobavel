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
        Schema::table('employees', function (Blueprint $table) {
            $table->uuid('employee_id')->unique();
        });

        Schema::table('employers', function (Blueprint $table) {
            $table->uuid('employer_id')->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->removeColumn('employee_id');
        });

        Schema::table('employers', function (Blueprint $table) {
            $table->removeColumn('employer_id');
        });
    }
};
