<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\Squadra;
use Illuminate\Support\Facades\File;

class SquadreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tenta di importare da file (ma non si blocca se fallisce)
        $importOk = $this->importaSquadreDaFile(database_path('squadra.txt'));

        // Se il file era vuoto o non valido, o comunque non ha popolato nulla, allora fallback
        if (Squadra::count() === 0) {
            $this->command->warn("Nessuna squadra trovata. Popolamento di fallback tramite factory...");
            $this->populateDB();
        }
    }

    private function populateDB(): void
    {
        Squadra::factory()->count(4)->create();
    }

    /**
     * Importa le squadre da un file .txt.
     * Ritorna true se almeno una squadra è stata creata, false altrimenti.
     */
    private function importaSquadreDaFile(string $percorsoFile): bool
    {
        if (!File::exists($percorsoFile)) {
            $this->command->warn("File non trovato: $percorsoFile. Il seeder continuerà comunque.");
            return false;
        }

        $righe = File::lines($percorsoFile);
        $importate = 0;

        foreach ($righe as $riga) {
            $nome = trim($riga);

            if ($nome === '') {
                continue;
            }

            Squadra::create([
                'nome' => $nome,
                'partite_giocate' => 0,
                'punteggio' => 0,
                'vittorie' => 0,
                'sconfitte' => 0,
                'pareggi' => 0,
            ]);

            $importate++;
        }

        if ($importate > 0) {
            $this->command->info("$importate squadre importate da file.");
            return true;
        } else {
            $this->command->warn("Nessuna squadra valida trovata nel file.");
            return false;
        }
    }
}
