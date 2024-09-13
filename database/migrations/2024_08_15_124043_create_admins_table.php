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
        Schema::create('admins', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->generatedAs()->always();
            $table->uuid('admin_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password', 255);
            $table->boolean('is_super_admin')->default(false);
            $table->smallInteger('account_status')->default(\App\Enums\Admin\AdminAccountStatusEnum::PENDING_TO_AUTHORIZE->value);
            $table->char('api_token', 60)->unique()->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('password_reset_at')->nullable();
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
