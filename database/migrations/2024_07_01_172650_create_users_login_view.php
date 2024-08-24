<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement(
            "SELECT u.user_id              AS account_id,
                    e.employee_id                          AS user_id,
                    concat(e.first_name, ' ', e.last_name) AS name,
                    u.email                                AS email
                    FROM users u
                        JOIN employees e ON e.user_id = u.id
                    UNION ALL
                    SELECT u.user_id      AS account_id,
                           e.employer_id  AS user_id,
                           e.company_name AS name,
                           u.email        AS email
                    FROM users u
                             JOIN employers e ON e.user_id = u.id"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW user_login_data');
    }

};
