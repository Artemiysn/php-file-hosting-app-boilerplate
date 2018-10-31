<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploadedFiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nameUser', 500);
            $table->string('type', 300);
            $table->integer('size');
            $table->string('path', 300);
            $table->string('preview', 300);
            $table->integer('downloads');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE Public.\"uploadedFiles\" ADD COLUMN searchtext TSVECTOR;");
        DB::statement("CREATE INDEX searchtext_index ON \"uploadedFiles\" USING GIN(searchtext);");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP INDEX IF EXISTS searchtext_gin");
        Schema::dropIfExists('uploadedFiles');
    }
}
