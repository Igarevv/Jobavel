<?php

use App\Persistence\Models\Employer;
use App\Persistence\Models\Vacancy;
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
            $table->foreignIdFor(Employer::class, 'employer_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('title');
            $table->integer('salary')->default(0);
            $table->text('description');
            $table->json('requirements');
            $table->json('responsibilities');
            $table->json('offers')->nullable();
            $table->integer('response_number')->default(0);
            $table->boolean('is_published')->default(false);
            $table->primary('id');
        });

        Schema::create('tech_skill_vacancy', function (Blueprint $table) {
            $table->foreignIdFor(Vacancy::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->integer('tech_skill_id')->unsigned();
            $table->foreign('tech_skill_id')->references('id')->on(
                'tech_skills'
            );
            $table->timestamps();
            $table->softDeletes();
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
