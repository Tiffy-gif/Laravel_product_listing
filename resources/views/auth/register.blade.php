@extends('layouts.template')

@section('pageTitle')
Register
@endsection

@section('rightTitle')
Register
@endsection

@section('headerBlock')
<link rel="stylesheet" href="{{ URL::asset('css/register.css') }}">
@endsection

@section('content')

<!-- Success Popup -->
@if(session('success'))
<div id="successPopup" class="success-popup">
  <p>{{ session('success') }}</p>
</div>
@endif

<div class="register-form">

  @if ($errors->any())
  <div class="error-messages" style="color: #ff6b6b; margin-bottom: 15px;">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <form method="POST" action="{{ route('register') }}">
    @csrf

    <label for="name">Name</label>
    <input id="name" type="text" name="name" value="{{ old('name') }}" required>

    <label for="email">Email</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required>

    <label for="password">Password</label>
    <input id="password" type="password" name="password" required>

    <label for="password_confirmation">Confirm Password</label>
    <input id="password_confirmation" type="password" name="password_confirmation" required>

    <button type="submit">Register</button>
  </form>
</div>


<script>
// Show success popup and auto-hide after 3s
document.addEventListener('DOMContentLoaded', function() {
  const popup = document.getElementById('successPopup');
  if (popup) {
    setTimeout(() => {
      popup.classList.add('show');
    }, 100);

    setTimeout(() => {
      popup.classList.remove('show');
    }, 3000);
  }
});
</script>

@endsection