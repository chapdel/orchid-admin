<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLicensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->string('key')->nullable()->unique();
            $table->foreignId('license_type_id')->constrained();
            $table->dateTime('expired_at')->nullable();
            $table->dateTime('started_at')->nullable();
            $table->enum('status', ['pending', 'payed', 'expired', 'canceled'])->default('pending');
            $table->bigInteger('company_id')->nullable();
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
        Schema::dropIfExists('licenses');
    }
}
