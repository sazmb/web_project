@extends('layouts.master')

@section('title','User authentication')

@section('body')
<script>
    $(document).ready(function(){
        $("#login-form").submit(function(event) {
            // Ottenere i valori dei campi email e password
            var email = $("#login-form input[name='email']").val();
            var password = $("#login-form input[name='password']").val();
            var error = false;
            // Verifica se il campo "password" è vuoto
            if (password.trim() === "") {
                error = true;
                $("#invalid-password").text("La password è obbligatoria.");
                event.preventDefault(); // Impedisce l'invio del modulo
                $("#login-form input[name='password']").focus();
            } else {
                $("#invalid-password").text("");
            }

            // Verifica se il campo "email" è vuoto
            if (email.trim() === "") {
                error = true;
                $("#invalid-email").text("L'indirizzo email è obbligatorio.");
                event.preventDefault(); // Impedisce l'invio del modulo
                $("#login-form input[name='email']").focus();
            } else {
                $("#invalid-email").text("");
            } 
        });

        $("#register-form").submit(function(event) {
            // Ottenere i valori dei campi per la registrazione
            var name = $("input[name='name']").val();
            var email = $("#register-form input[name='email']").val();
            var password = $("#register-form input[name='password']").val();
            // Espressione regolare per la password (almeno 8 caratteri, almeno una cifra, almeno
            // un carattere speciale tra ! - * [ ] $ & /)
            var passwordRegex = /^(?=.*[0-9])(?=.*[!-\*\[\]\$&\/]).{8,}$/;
            var confirmPassword = $("input[name='password_confirmation']").val();
            var error = false;

            // Verifica se il campo "confirm-password" è vuoto
            if (confirmPassword.trim() === "") {
                error = true;
                $("#invalid-confirmPassword").text("La re-immissione della password è obbligatoria.");
                event.preventDefault(); // Impedisce l'invio del modulo
                $("input[name='password_confirmatio']").focus();
            } else {
                $("#invalid-confirmPassword").text("");
            } 

            // Verifica se il campo "password" è vuoto
            if (password.trim() === "") {
                error = true;
                $("#invalid-registrationPassword").text("La password è obbligatoria.");
                event.preventDefault(); // Impedisce l'invio del modulo
                $("#register-form input[name='password']").focus();
            } else if(!passwordRegex.test(password)) {
                error = true;
                $("#invalid-registrationPassword").text("Il formato della password è sbagliato (almeno 8 caratteri, di cui almeno una cifra e un carattere tra ! - * [ ] $ & /).");
                event.preventDefault(); // Impedisce l'invio del modulo
                $("#register-form input[name='password']").focus();
            } else {
                $("#invalid-registrationPassword").text("");
            } 

            // Verifica se il campo "email" è vuoto
            if (email.trim() === "") {
                error = true;
                $("#invalid-registrationEmail").text("L'indirizzo email è obbligatorio.");
                event.preventDefault(); // Impedisce l'invio del modulo
                $("#register-form input[name='email']").focus();
            } else {
                $("#invalid-registrationEmail").text("");
            }

            // Verifica se il campo "name" è vuoto
            if (name.trim() === "") {
                error = true;
                $("#invalid-name").text("Il nome è obbligatorio.");
                event.preventDefault(); // Impedisce l'invio del modulo
                $("input[name='name']").focus();
            } else {
                $("#invalid-name").text("");
            } 

            if(!error) {
                // Verifica che la password sia state editata due volte correttamente
                if(confirmPassword.trim() !== password.trim())
                {
                    $("#invalid-confirmPassword").text("Immettere la stessa password due volte.");
                    event.preventDefault(); // Impedisce l'invio del modulo
                    $("input[name='password_confirmation']").focus();
                } else {
                    $("#invalid-confirmPassword").text("");
                } 

                // effettua chiamata AJAX per verificare che l'email dell'utente non sia già presente nel DB
                event.preventDefault(); // Impedisce preventivamente l'invio del modulo prima del controllo
                $.ajax({

                    type: 'GET',

                    url: '/ajaxUser',

                    data: {email: email.trim()},

                    success: function (data) {

                        if (data.found)
                        {
                            error = true;
                            $("#invalid-registrationEmail").text("L'email esiste già nel database.");
                        } else {
                            $("#register-form")[0].submit();
                        }
                    }
                });
            }
        });
    });
</script>

<div class="container-fluid">
    <div class="row">
        <div>
            <ul class="nav nav-tabs mb-3 justify-content-end">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#login-tab">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#register-tab">Register</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="tab-content">
            <div class="tab-pane active" id="login-tab">
                <form id="login-form" action="{{ route('login') }}" method="post">
                @csrf
                    <div class="form-group mb-3">
                        <input type="text" name="email" class="form-control" placeholder="Email..."/>
                    </div>
                    <span class="invalid-input" id="invalid-email"></span>

                    <div class="form-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password..."/>
                    </div>
                    <span class="invalid-input" id="invalid-password"></span>

                    <div class="form-group text-center mb-3">
                        <label for="login-submit" class="btn btn-primary w-100"><i class="bi bi-door-open"></i> Login</label>
                        <input id="login-submit" class="d-none" type="submit" value="Login">
                    </div>
                </form>
            </div>

            <div class="tab-pane" id="register-tab">
                <form id="register-form" action="{{ route('register') }}" method="post">
                @csrf
                    <div class="form-group mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Your name..."/>
                    </div>
                    <span class="invalid-input" id="invalid-name"></span>

                    <div class="form-group mb-3">
                        <input type="text" name="email" class="form-control" placeholder="Your email..."/>
                    </div>
                    <span class="invalid-input" id="invalid-registrationEmail"></span>

                    <div class="form-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Type password..."/>
                    </div>
                    <span class="invalid-input" id="invalid-registrationPassword"></span>

                    <div class="form-group mb-3">
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Re-type password..."/>
                    </div>
                    <span class="invalid-input" id="invalid-confirmPassword"></span>

                    <div class="form-group text-center mb-3">
                        <label for="register-submit" class="btn btn-primary w-100"><i class="bi bi-person-plus"></i> Register</label>
                        <input id="register-submit" class="d-none" type="submit" value="Register">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection