<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseSuggestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('course_suggestion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedbigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('CASCADE')->onUpdate('NO ACTION');
            $table->unsignedbigInteger('term_id')->unsigned();
            $table->foreign('term_id')->references('id')
                ->on('terms')->onDelete('CASCADE')->onUpdate('NO ACTION');
            $table->unsignedbigInteger('course_id')->unsigned();
            $table->foreign('course_id')->references('id')
                ->on('courses')->onDelete('CASCADE')->onUpdate('NO ACTION');
            $table->unsignedbigInteger('consultant_id')->unsigned(); //مشاور
            $table->foreign('consultant_id')->references('id')
                ->on('users')->onDelete('CASCADE')->onUpdate('NO ACTION');
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
        Schema::dropIfExists('course_suggestion');
    }
}
