@if (! auth()->check())
    <p>Please, <a href="/login">sign in</a> to watch this lesson</p>
@elseif (! auth()->user()->isActive())
    <p>Please, <a href="/home">reactivate your account</a> to watch this lesson</p>
@else
    <p>ACCOUNT IS ACTIVE: EMBED THE VIDEO TAG</p>
@endif