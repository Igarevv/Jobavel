<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banned_users', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->generatedAs()->always();
            $table->uuid('user_id');
            $table->string('reason_type');
            $table->string('comment')->nullable();
            $table->tinyInteger('duration');
            $table->timestamp('banned_at')->useCurrent();
            $table->primary('id');
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banned_users');
    }
};
