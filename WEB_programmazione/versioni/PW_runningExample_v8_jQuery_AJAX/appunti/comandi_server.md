Ottimo! Capire i comandi **GET, POST, PUT, DELETE** è **fondamentale** quando si lavora con Laravel (e con il web in generale), perché fanno parte delle cosiddette **HTTP methods** (metodi HTTP) usati per comunicare tra browser e server.

---

## 🌐 I 4 principali metodi HTTP (REST)

Laravel usa questi metodi per distinguere **che tipo di operazione** vuoi fare su una risorsa (es. un autore, un libro ecc.)

### 🔹 1. `GET`

* **Usato per**: *richiedere dati* dal server (es. visualizzare una pagina, un elenco, un dettaglio).
* **Esempi:**

  ```php
  Route::get('/author', [AuthorController::class, 'index']); // Lista tutti gli autori
  Route::get('/author/5', [AuthorController::class, 'show']); // Mostra autore con ID 5
  ```

---

### 🔹 2. `POST`

* **Usato per**: *inviare nuovi dati* al server per **creare** qualcosa.

* **Esempi:**

  ```php
  Route::post('/author', [AuthorController::class, 'store']); // Salva un nuovo autore
  ```

* Nel form Blade:

  ```blade
  <form method="POST" action="{{ route('author.store') }}">
      @csrf
      ...
  </form>
  ```

---

### 🔹 3. `PUT` (o `PATCH`)

* **Usato per**: *modificare dati esistenti* (update).

* **Esempi:**

  ```php
  Route::put('/author/5', [AuthorController::class, 'update']); // Modifica autore ID 5
  ```

* Nei form HTML, si simula così:

  ```blade
  <form method="POST" action="{{ route('author.update', ['author' => $author->id]) }}">
      @csrf
      @method('PUT')  {{-- Laravel interpreta il metodo come PUT --}}
      ...
  </form>
  ```

---

### 🔹 4. `DELETE`

* **Usato per**: *cancellare dati* dal server.

* **Esempio:**

  ```php
  Route::delete('/author/5', [AuthorController::class, 'destroy']); // Elimina autore ID 5
  ```

* Nel form Blade:

  ```blade
  <form method="POST" action="{{ route('author.destroy', ['author' => $author->id]) }}">
      @csrf
      @method('DELETE')
      <button type="submit">Elimina</button>
  </form>
  ```

---

## 📦 Collegamento con `Route::resource()`

Quando usi:

```php
Route::resource('author', AuthorController::class);
```

Laravel crea **automaticamente** queste rotte con i metodi corretti:

| Metodo HTTP | URL                 | Azione           | Metodo Controller |
| ----------- | ------------------- | ---------------- | ----------------- |
| GET         | `/author`           | Elenco           | `index()`         |
| GET         | `/author/create`    | Form creazione   | `create()`        |
| POST        | `/author`           | Salvataggio      | `store()`         |
| GET         | `/author/{id}`      | Mostra dettaglio | `show($id)`       |
| GET         | `/author/{id}/edit` | Form modifica    | `edit($id)`       |
| PUT/PATCH   | `/author/{id}`      | Salvataggio mod. | `update($id)`     |
| DELETE      | `/author/{id}`      | Cancellazione    | `destroy($id)`    |

---

## 🧠 Riassunto facile

| Metodo | Significato | Uso principale               |
| ------ | ----------- | ---------------------------- |
| GET    | Leggi       | Vedere dati                  |
| POST   | Crea        | Inviare nuovi dati al server |
| PUT    | Aggiorna    | Modificare dati esistenti    |
| DELETE | Elimina     | Cancellare dati              |

---

Fammi sapere se vuoi che ti faccia uno **schema visivo** o un esempio pratico di tutte queste operazioni in una CRUD completa!
