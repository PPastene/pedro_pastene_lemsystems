<nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{ url('/') }}">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/best') }}">Artist Best Songs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/ranking') }}">Ranking</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/excel') }}">Generate Excel</a>
            </li>
        </ul>
    </div>
</nav>
