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
        Schema::create('employers', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->generatedAs()->always();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->uuid('employer_id')->unique();
            $table->string('company_name')->unique();
            $table->text('company_description')->nullable();
            $table->string('contact_email')->unique();
            $table->string('company_logo')->default('default_logo.png');
            $table->timestamp('created_at')->useCurrent();
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employers');
    }

};
