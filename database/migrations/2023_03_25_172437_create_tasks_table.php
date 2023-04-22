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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->enum('status',['new ','inprogress','completed','rejected','success']);
            $table->enum('priority',['low ','medium','high']);
            $table->foreignId('employee_id')->nullable()->default(null)->references('id')->on('users')->onDelete('set null');
            $table->foreignId('project_id')->nullable()->default(null)->references('id')->on('projects')->onDelete('set null');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
