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
            $table->enum("status",["ENCOURS","VALIDEE","REJETEE"])->default("ENCOURS"); // Statut
            $table->text("reject_reason")->nullable(); // Raison du rejet
            $table->timestamps(); // Horodatage créé et mis à jour
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
