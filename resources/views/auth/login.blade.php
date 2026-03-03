<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  </head>

  <body>
    <div class="login-container">
      <form action="{{ route('login') }}" method="POST" class="login-form">
        @csrf
        <h2>Login</h2>

        @if ($errors->any())
        <div class="error-message">
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" name="loginEmail" id="email" required autofocus>
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" name="loginPassword" id="password" required>
        </div>

        <button type="submit" class="login-button">Login</button>
      </form>
    </div>
  </body>

</html>