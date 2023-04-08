<?php

use App\Enums\Roles;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->primaryKey();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->integer('role')->default((Roles::MEMBER)->value);
            $table->boolean('is_active')->default(true);
            $table->string('email')->unique();
            $table->string('job_title')->nullable();
            $table->text('about')->nullable();
            $table->string('avatar_url')->nullable();
            $table->string('avatar_disk')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->text('settings')->nullable();
            $table->boolean('should_be_logged_out')->default(false);
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
