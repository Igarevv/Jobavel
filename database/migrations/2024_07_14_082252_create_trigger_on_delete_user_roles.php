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
            "CREATE OR REPLACE FUNCTION delete_from_user_roles()
                   RETURNS TRIGGER AS $$
                   BEGIN
                       DELETE FROM model_has_roles WHERE model_id = OLD.id;
                       RETURN NULL;
                   END;
                   $$ LANGUAGE plpgsql;"
        );
        DB::statement('
                   CREATE TRIGGER delete_from_roles_when_user_deleted
                   AFTER DELETE ON users
                   FOR EACH ROW
                   EXECUTE FUNCTION delete_from_user_roles();'
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP TRIGGER delete_from_roles_when_user_deleted ON users');
        DB::statement('DROP FUNCTION delete_from_user_roles');
    }
};
