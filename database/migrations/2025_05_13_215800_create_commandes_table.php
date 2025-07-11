<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Crée et retourne une nouvelle classe de migration
return new class extends Migration
{
    /**
     * Exécuter les migrations.
     */
    public function up(): void
    {
        // Créer la table "commandes"
        Schema::create('commandes', function (Blueprint $table) {
            $table->id(); // Identifiant
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // ID de l'utilisateur
            $table->foreignId('pharmacy_id')->constrained()->cascadeOnDelete(); // ID de la pharmacie
            $table->enum("status",["ENCOURS","VALIDÉE","REJETEE","LIVRÉ"])->default("ENCOURS"); // Statut
            $table->text("reject_reason")->nullable(); // Raison du rejet
            $table->integer('total_amount')->nullable(); // Prix total
            $table->decimal('longitude', 10, 7)->nullable(); // Longitude
            $table->decimal('latitude', 10, 7)->nullable(); // Latitude
            $table->enum('type', ["LIVRAISON", "SURE PLACE"])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Annuler les migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes'); // Supprimer la table "commandes"
    }
};
