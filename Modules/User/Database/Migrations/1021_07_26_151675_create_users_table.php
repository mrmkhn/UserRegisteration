<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firstName')->nullable();
            $table->string('lastName')->nullable();
            $table->string('username')->nullable();
            $table->text('password')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('bornDate')->nullable();
            $table->string('nationalCode')->nullable();
            $table->unsignedBigInteger('image_id')->nullable();
            $table->boolean('accept_rules')->default(0);
            $table->string('nickname')->nullable();
            $table->string('referral_code')->unique();
            $table->string('api_token')->nullable();
            $table->enum('status',\Modules\User\Models\User::$enumStatuses)->default('active');
            $table->boolean('special_teachers')->default(0);
            $table->string('prefix')->nullable();
            $table->string('english_name')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('degree_of_education')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('activity_id')->nullable();
            $table->string('city_id')->nullable();
            $table->boolean('iran1450')->default(0);
            $table->string('iran1450_options')->nullable();
            $table->string('iran1450_register_date')->nullable();



            $table->text('company_description')->nullable();
            $table->text('secret_description')->nullable();
            $table->longText('teachers_executive_records')->nullable();
            $table->longText('teachers_scientific_records')->nullable();
            $table->text('teacher_teaser')->nullable();
            $table->text('teacher_banner')->nullable();

            $table->boolean('updated')->default(0);
            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();
            $table->bigInteger('delete_user')->nullable();
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
        Schema::dropIfExists('users');
    }
}
