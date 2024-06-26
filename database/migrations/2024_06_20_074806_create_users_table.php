<?php

use App\Enums\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->generatedAs()->always();
            $table->primary('id');
            $table->uuid('user_id')->unique();
            $table->string('email')->unique();
            $table->enum(
                'role',
                [Role::EMPLOYEE->value, Role::EMPLOYER->value]
            );
            $table->boolean('is_confirmed')->default(false);
            $table->timestamp('email_confirmed_at')->nullable();
            $table->string('password');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }

};
