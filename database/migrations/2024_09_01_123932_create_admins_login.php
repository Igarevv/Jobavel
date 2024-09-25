<?php

use App\Persistence\Models\Admin;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admins_login', function (Blueprint $table) {
            $table->integer('id')->generatedAs()->always();
            $table->foreignIdFor(Admin::class, 'admin_id');
            $table->timestamp('first_login_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_admins_login');
    }
};
