<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codes', function (Blueprint $table) {
            $table->primaryKey();
            $table->foreignKey('course_id')->constrained()->cascadeOnDelete();
            $table->string('type')->comment('Type of code. Eg. PRIORITY');
            $table->string('display')->comment('eg High, Low, etc');
            $table->string('description')->nullable()->comment('Internal descriptive text');
            $table->string('color')->nullable()->comment('Color to represent this code');
            $table->boolean('available_in_subtask')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->nullable()->index();
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
        Schema::dropIfExists('codes');
    }
};
