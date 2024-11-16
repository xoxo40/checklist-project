<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id(); // Champ id auto-incrémenté
            $table->morphs('notifiable'); // Champs notifiable_id et notifiable_type
            $table->string('type'); // Type de notification
            $table->text('data'); // Données de la notification (sous forme JSON)
            $table->timestamp('read_at')->nullable(); // Horodatage de lecture
            $table->timestamps(); // Champs created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
