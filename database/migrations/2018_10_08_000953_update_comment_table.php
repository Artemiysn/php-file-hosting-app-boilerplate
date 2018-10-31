<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('userCommentaries', function (Blueprint $table) {
            $table->integer('uploaded_files_id')->unsigned();
            $table->string('content');
            $table->string('name');
            $table->foreign('uploaded_files_id')
                ->references('id')
                ->on('uploadedFiles')
                ->onDelete('cascade');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
