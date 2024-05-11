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
        .main>th{
            text-align: left;
            margin-bottom: 10px;
        }
        .main>td, .main>th{
            padding: 4px;
            font-size: 12px;
        }
        .logo{
            width: 12em;
        }
        .main>tr:nth-child(odd) td{
            background-color: #eee;
        }
        .main>td{
            padding-bottom: 25px;
            border: 1px #FFF solid;
            border-bottom: 1px #000 solid;
        }
        footer{
            position: absolute;
            bottom: 0;
        }
        .text-xs{
            font-size: 11px;
        }
        .chk{
            width: 12px;
            height: 12px;
            border: 1px #000 solid;
            border-radius: 2px;
            background-color: #FFF;
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
        <div>
            <h3 class="text-center text-secondary" style="margin: 0; margin-bottom: 5px;">{!! $params['pdf']['pdf-titulo-ordem-servico'] !!} - {{$orc->id}}</h3>
        </div>
        <br><br>

        <div>
            <h4 style="margin: 0; margin-bottom: 5px;">Cliente: {{ $orc->responsavel }}</h4>
            <h4 style="margin: 0;">Solicitante: {{ $orc->solicitante }}</h4>
        </div>

        <br>
        <div style="border: solid 3px #EEE">
            <table id="main-table" class="w-100" cellspacing="">
                <thead>
                    <tr class="main">
                        <th width="8%">Ítem</th>
                        <th width="72%">Descrição</th>
                        <th width="8%">Qtd.</th>
                        <th width="12%"></th>
                    </tr>
                </thead>
                <tbody class="main">
                    @foreach($orc->itens as $i => $item)
                    <tr class="main">
                        <td>{{ $i+1 }}</td>
                        <td>{{ $item->titulo }}</td>
                        <td>{{ $item->qtd }}</td>
                        <td>
                            <table cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td style="padding-right: 14px;"><div class="chk"/></td>
                                        <td><b> IMP.</b></td>
                                    </tr>
                                    <tr>
                                        <td><div class="chk"/></td>
                                        <td><b> ACAB.</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>
