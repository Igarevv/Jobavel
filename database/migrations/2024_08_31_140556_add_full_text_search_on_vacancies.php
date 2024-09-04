<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('vacancies', function (Blueprint $table) {
            DB::statement("ALTER TABLE vacancies ADD COLUMN document_search tsvector");

            DB::statement(
                "CREATE OR REPLACE FUNCTION update_full_test_search_on_vacancy_creation()
                      RETURNS TRIGGER AS $$
                      DECLARE
                          company_name TEXT;
                          skills_text TEXT;
                      BEGIN
                       SELECT e.company_name INTO company_name
                       FROM employers e
                          WHERE e.id = NEW.employer_id;

                          SELECT string_agg(s.skill_name, ' ') INTO skills_text
                          FROM tech_skills s
                          INNER JOIN tech_skill_vacancy vs ON vs.tech_skill_id = s.id
                          WHERE vs.vacancy_id = NEW.id;

                       NEW.document_search :=
                              setweight(to_tsvector(coalesce(NEW.title, '')), 'A') ||
                              setweight(to_tsvector(coalesce(skills_text, '')), 'B') ||
                              setweight(to_tsvector(coalesce(company_name, '')), 'C') ||
                              setweight(to_tsvector(coalesce(NEW.employment_type, '')), 'D');

                          RETURN NEW;
                      END
                      $$ LANGUAGE plpgsql;"
            );

            DB::statement(
                "
                CREATE OR REPLACE TRIGGER trigger_update_full_text_search_when_vacancy_create_or_update
                BEFORE INSERT OR UPDATE ON vacancies
                FOR EACH ROW
                EXECUTE FUNCTION update_full_test_search_on_vacancy_creation();"
            );

            DB::statement('CREATE INDEX full_text_search_vacancies_idx ON vacancies USING gin(document_search);');
        });
    }

    public function down(): void
    {
        DB::statement("DROP TRIGGER IF EXISTS trigger_update_full_text_search_when_vacancy_create_or_update ON vacancies");
        DB::statement("DROP FUNCTION IF EXISTS update_full_test_search_on_vacancy_creation");
        DB::statement("DROP INDEX full_text_search_vacancies_idx");
    }
};
