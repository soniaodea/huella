<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeContactUsuarioMessageFieldType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("contactoUsuarios", function (Blueprint $table) {
            $table->dropColumn("message");
        });

        Schema::table("contactoUsuarios", function (Blueprint $table) {
            $table->text("message");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("contactoUsuarios", function (Blueprint $table) {
            $table->dropColumn("message");
        });

        Schema::table("contactoUsuarios", function (Blueprint $table) {
            $table->string("message");
        });
    }
}
