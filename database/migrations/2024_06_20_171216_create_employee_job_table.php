<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employee_vacancy', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->generatedAs()->always();
            $table->foreignId('vacancy_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->boolean('has_cv')->default(false);
            $table->string('employee_contact_email');
            $table->timestamp('applied_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_job');
    }
};
