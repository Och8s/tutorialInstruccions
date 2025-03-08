<!DOCTYPE html>
<html>
<head>
    <title>Tutorials de reparació</title>
</head>
<body>
    <h1>Tutorials</h1>
    <ul>
        @if (count($guides) > 0)
            @foreach ($guides as $guide)
                <li>
                    {{ $guide->title }} - {{ $guide->category }}
                    <a href="{{ route('guides.show', $guide->id) }}">Mostrar instrucciones</a>
                </li>
            @endforeach
        @else
            <li>No hay guías disponibles.</li>
        @endif
    </ul>
</body>
</html>
