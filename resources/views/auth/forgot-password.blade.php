@if (session('status'))
    {{ session('status') }}
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <input type="email" name="email" placeholder="E-Mail Address" required autofocus>
    <button type="submit">Send Reset Link</button>
</form>
