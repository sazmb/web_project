Per creare un **Model** e un **Controller** per la classe `Partita` in Laravel, puoi utilizzare la **CLI di Artisan**, che è il tool a riga di comando di Laravel.

---

## ✅ Comando per creare **Model + Controller + Migration**

```bash
php artisan make:model Partita -mc
```

### Spiegazione del comando:

| Parte        | Significato                                                        |
| ------------ | ------------------------------------------------------------------ |
| `make:model` | Crea un nuovo modello                                              |
| `Partita`    | Nome del modello (verrà creato come `Partita.php` in `app/Models`) |
| `-m`         | Crea automaticamente anche la migration                            |
| `-c`         | Crea automaticamente anche il controller                           |

---

### Risultati di questo comando:

1. **Model** → `app/Models/Partita.php`
2. **Migration** → in `database/migrations/xxxx_xx_xx_create_partitas_table.php`
3. **Controller** → `app/Http/Controllers/PartitaController.php`

---

## 🔧 Vuoi anche le route resource automatiche?

Se vuoi aggiungere anche tutte le rotte per la gestione CRUD:

Nel file `routes/web.php`:

```php
Route::resource('partita', App\Http\Controllers\PartitaController::class);
```

Laravel genererà automaticamente tutte le rotte RESTful (GET, POST, PUT, DELETE) come per `author` o `book`.

---

## 📌 Esempio: aggiunta di una colonna nella migration

Apri il file di migration che è stato creato (`xxxx_xx_xx_create_partitas_table.php`) e aggiungi, ad esempio:

```php
public function up()
{
    Schema::create('partitas', function (Blueprint $table) {
        $table->id();
        $table->string('squadra_casa');
        $table->string('squadra_trasferta');
        $table->integer('gol_casa');
        $table->integer('gol_trasferta');
        $table->date('data_partita');
        $table->timestamps();
    });
}
```

Poi esegui:

```bash
php artisan migrate
```

Per creare fisicamente la tabella `partitas` nel database.

---

Se vuoi, ti posso aiutare anche a scrivere il codice nel controller o nella view per gestire le partite. Fammi sapere! ⚽
