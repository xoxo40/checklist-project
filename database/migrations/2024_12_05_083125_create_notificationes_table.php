<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id(); // Identifiant unique de la notification
            $table->unsignedBigInteger('user_task_id'); // ID de la tâche liée
            $table->text('message'); // Message de la notification
            $table->boolean('is_read')->default(false); // Indique si la notification a été lue
            $table->boolean('is_processed')->default(false); // Indique si la notification a été traitée
            $table->timestamp('read_at')->nullable(); // Date et heure de lecture
            $table->timestamps(); // Création et mise à jour des timestamps automatiques

            // Clés étrangères
            $table->foreign('user_task_id')->references('id')->on('user_tasks')->onDelete('cascade');


    
        });

        $table->dropColumn('notifiable_type');
        $table->dropColumn('notifiable_id');
        $table->dropColumn('data');  // Si cette colonne existe aussi
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
