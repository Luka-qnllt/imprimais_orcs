<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orcamento {{ $orc->id }}</title>

    <style>
        body{
            padding: 1.7em;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            padding-bottom: 1em;
        }
        .text-center{
            display: flex;
            text-align: center;
        }
        .text-secondary{
            color: #444;
        }
        .w-100{
            width: 100%;
        }
        th{
            text-align: left;
            margin-bottom: 10px;
        }
        td, th{
            padding: 4px;
            font-size: 12px;
        }
        .logo{
            width: 12em;
        }
        tr.stripped td{
            background-color: #eee;
        }
        footer{
            position: absolute;
            bottom: 0;
        }
        .text-xs{
            font-size: 11px;
        }
    </style>
</head>
<body>

    <head>
        <div>
            <img class="logo" src="{{ asset('/assets/imprimais-logo-nome.png') }}">
        </div>
    </head>
    <section>
        <br><br>
        <h3 class="text-center text-secondary">{!! $params['pdf']['pdf-titulo'] !!}</h3><br>

        <p class="text-secondary">{!! $params['pdf']['pdf-sub-titulo'] !!}</p><br>

        <div style="border: solid 3px #EEE; width: 100%; padding: 7px;">
            <label>Cliente: {{ $orc->solicitante }}</label>
        </div>
        <br>
        <div style="border: solid 3px #EEE">
            <table class="w-100">
                <thead>
                    <tr>
                        <th>Ítem</th>
                        <th>Descrição</th>
                        <th>Qtd.</th>
                        <th>Valor Un.</th>
                        <th>Total R$</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i=1
                    @endphp
                    @foreach($orc->itens as $item)
    
                    <tr class="{{ ($i % 2) == 0 ? 'stripped' : '' }}">
                        <td>{{ $i }}</td>
                        <td>{{ $item->titulo }}</td>
                        <td>{{ $item->qtd }}</td>
                        <td>{{ number_format( $item->valor_un, 2, ',', '.') }}</td>
                        <td>{{ number_format($item->qtd * $item->valor_un, 2, ',', '.') }}</td>
                    </tr>
                    
                    @php
                        $i++
                    @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
        <br><br>
        <div class="text-secondary text">
            <p>
                <small>
                    Valor Total: R$ {{number_format( $orc->valor_total, 2, ',', '.')}} <br><br>
                    Prazo de Entrega: {{$orc->previsao}} <br><br>
                    Itabatã, {{ strftime('%A, %d de %B de %Y', strtotime('today')) }}
                </small>
            </p>
        </div>
    </section>
    <footer>
        <div class="text-secondary text-center">
            <p>
                <small class="text-xs">
                    {!! $params['pdf']['pdf-footer'] !!}
                </small>
            </p>
        </div>
    </footer>
</body>
</html>