<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulePageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_page', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->nullable()->constrained('modules')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('page_id')->nullable()->constrained('pages')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('module_page');
    }
}
