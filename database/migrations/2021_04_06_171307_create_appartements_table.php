<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppartementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appartements', function (Blueprint $table) {
            $table->id();
            $table->string('appartement_code'); //  APP00001
            $table->string('appartement_type')->nullable(); //  appartement/duplexe
            $table->string('appartement_etat')->nullable(); //  neuf/occupe
            $table->string('appartement_situation')->nullable(); // titre/milikia/contrat/miftah/contrat adlia
            $table->string('appartement_etage')->nullable(); // RDC/1/2/3/4
            $table->integer('appartements_en_etage')->default(0); // 0/1/2/3
            $table->string('appartement_facade')->nullable();   // Rue, Patio, Place, Piscine, Sur Mer
            $table->string('surface')->nullable();
            $table->integer('ascenseur')->default(0);
            $table->integer('parking')->default(0);
            $table->integer('nbr_chambre')->default(0);
            $table->integer('nbr_salon')->default(0);
            $table->integer('nbr_facade')->default(0);
            $table->integer('nbr_patio')->default(0);
            $table->integer('nbr_toilette')->default(0);
            $table->integer('nbr_cuisine')->default(0);
            $table->integer('prix_metre')->default(0);
            $table->integer('prix_total')->default(0);
            $table->integer('prix_declaration')->default(0);
            $table->integer('client_id');
            $table->integer('intermediaire_id');
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
        Schema::dropIfExists('appartements');
    }
}