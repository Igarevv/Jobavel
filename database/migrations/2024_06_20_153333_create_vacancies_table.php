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
        Schema::create('vacancies', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->generatedAs()->always()->from(
                1001
            );
            $table->foreignId('employer_id')->constrained()->cascadeOnDelete();
            $table->string('job_title');
            $table->integer('salary')->default(0);
            $table->text('job_description');
            $table->json('job_requirements');
            $table->integer('response_number')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->primary('id');

            $table->softDeletes();
        });

        Schema::create('vacancy_tech_skills', function (Blueprint $table) {
            $table->foreignId('vacancy_id')->constrained()->cascadeOnDelete();
            $table->integer('tech_skill_id')->unsigned();
            $table->foreign('tech_skill_id')->references('id')->on(
                'tech_skills'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacancies');
        Schema::dropIfExists('vacancy_tech_skills');
    }

};
