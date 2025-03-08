<!DOCTYPE html>
<html>
<head>
    <title>{{ $guide->title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .guide-info {
            margin-bottom: 50px; /* Espai més gran abans dels passos */
            background: grey;
            padding: 10px;
        }
        .steps-title {
            text-align: left;
            margin-left: 10%;
            font-size: 1.5em;
            font-weight: bold;
            margin-top: 30px; /* Espai entre el text i la secció de passos */
        }
        .step-container {
            display: flex;
            align-items: flex-start;
            margin-bottom: 30px;
            text-align: left;
        }
        .step-image {
            flex: 1;
            padding-right: 30px;
            max-width: 400px;
        }
        .step-text {
            flex: 2;
            font-size: 1.1em;
        }
        .step-image img {
            max-width: 100%;
            height: auto;
            display: block;
        }
        ol {
            list-style-type: decimal; /* Manté la numeració */
            padding-left: 10%;
            text-align: left;
        }
        ol li {
            margin-bottom: 20px;
        }
        .intro-text {
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 30px; /* Espai entre el text i la secció de passos */
        }
    </style>
</head>
<body>
    <div class="guide-info">
        <h1>{{ $guide->title }}</h1>
        <p><strong>Categoría:</strong> {{ $guide->category }}</p>
        <p><strong>Dificultad:</strong> {{ $guide->difficulty }}</p>
        <p><strong>URL:</strong> <a href="{{ $guide->url }}" target="_blank">Ver en iFixit</a></p>
        <p><strong>Tipo:</strong> {{ $guide->type }}</p>
        <p><strong>Usuario:</strong> {{ $guide->author_username }}</p>
    </div>

    <!-- Text centrat abans dels passos -->
    <div class="intro-text">
        <p><strong>{{ $guide->summary }}</strong></p>
    </div>

    <!-- Títol de passos alineat a l'esquerra -->
    <div class="steps-title">Pasos:</div>

    @if(isset($guide->steps))
        @php
            $steps = json_decode($guide->steps, true);
        @endphp
        @if(is_array($steps))
            <ol>
                @foreach($steps as $step)
                    <li>
                        <div class="step-container">
                            <div class="step-image">
                                @if(isset($step['media']['data']) && is_array($step['media']['data']) && count($step['media']['data']) > 0)
                                    @foreach($step['media']['data'] as $image)
                                        <img src="{{ $image['standard'] }}" alt="Imagen del paso">
                                    @endforeach
                                @endif
                            </div>
                            <div class="step-text">
                                @if(isset($step['lines']) && is_array($step['lines']))
                                    <ul>
                                        @foreach($step['lines'] as $line)
                                            @if(isset($line['text_rendered']))
                                                <li>{!! $line['text_rendered'] !!}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach
            </ol>
        @endif
    @endif

    <a href="{{ route('home') }}">Volver a la lista</a>
</body>
</html>
