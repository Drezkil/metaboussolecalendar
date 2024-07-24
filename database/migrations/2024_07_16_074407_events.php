<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        schema::create('events', function (Blueprint $table) {
            $table->id()->comment('Identifiant d\'un évènement');
            $table->string('title')->comment('title');
            $table->string('start')->comment('heure début');
            $table->string('end')->comment('heure fin');
            $table->unsignedBigInteger('id_user')->comment('Id utilisateur');
            $table->foreign('id_user')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
