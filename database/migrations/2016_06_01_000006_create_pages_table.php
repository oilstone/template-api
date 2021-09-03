<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->char('language', 2)->default('en')->index();
            $table->foreignId('translates_id')->nullable()->constrained('pages')->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('is_published')->default(0);
            $table->string('slug', 100)->index();
            $table->string('title', 100);
            $table->timestamp('publish_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
