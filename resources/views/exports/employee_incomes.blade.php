<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            text-align: left;
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>REPORTE DE INGRESOS</h2>
    <p>FECHA DE INICIO: {{ $startDate }}</p>
    <p>FECHA DE FIN: {{ $endDate }}</p>
    <br>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>TIPO INGRESO</th>
                <th>FECHA INGRESO</th>
                <th>VISITANTE</th>
                <th>TIPO USUARIO</th>
                <th>NÚMERO DOCUMENTO</th>
                <th>CONJUNTO</th>
                <th>AGLOMERACIÓN</th>
                <th>UNIDAD</th>
                <th>NOTA INGRESO</th>
                <th>PORTERÍA ENTRADA</th>
                <th>PORTERO ENTRADA</th>
                <th>ELEMENTOS ENTRADA</th>
                <th>FECHA SALIDA</th>
                <th>NOTA SALIDA</th>
                <th>PORTERÍA SALIDA</th>
                <th>PORTERO SALIDA</th>
                <th>ELEMENTOS SALIDA</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employeeIncomes as $income)
                <tr>
                    <td>{{ $income->id }}</td>
                    <td>
                        @if($income->type_income == 1)
                            PEATONAL
                        @else
                            VEHICULAR
                        @endif
                    </td>
                    <td>{{ $income->admission_date }}</td>
                    <td>{{ mb_strtoupper($income->visitors()->first()->name ?? 'SIN VISITANTE')  }}</td>
                    <td>{{ mb_strtoupper($income->visitors()->first()->typeuser->name ?? 'SIN TIPO DE USUARIO')  }}</td>
                    <td>{{ mb_strtoupper($income->visitors()->first()->document_number ?? 'SIN NÚMERO DE DOCUMENTO')  }}</td>
                    <td>{{ mb_strtoupper($income->setresidencial->name ?? 'SIN CONJUNTO') }}</td>
                    <td>{{ mb_strtoupper($income->agglomeration->name ?? 'SIN AGLOMEREACIÓN') }}</td>
                    <td>{{ mb_strtoupper($income->unit->name ?? 'SIN UNIDAD') }}</td>
                    <td>{{ $income->nota ? mb_strtoupper(strip_tags($income->nota)) : 'SIN NOTA' }}</td>
                    <td>
                        {{ $income->goal ? mb_strtoupper($income->goal->name) . ' - ( ' . mb_strtoupper($income->goal->state->name) . ' )' : 'SIN PORTERÍA' }}
                    </td>
                    <td>
                        {{ $income->user ? mb_strtoupper($income->user->name) . ' ' . mb_strtoupper($income->user->lastname) . ' - ( ' . mb_strtoupper($income->user->state->name) . ' )' : 'SIN PORTERO' }}
                    </td>
                    <td>
                        @if($income->elements->isEmpty())
                            SIN ELEMENTOS
                        @else
                            <ul>
                                @foreach($income->elements as $element)
                                    <li>
                                        {{ mb_strtoupper($element->name) }} - Nota: {{ mb_strtoupper(strip_tags($element->pivot->nota)) }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </td>

                    @if($income->exitentries->isEmpty()) 
                        <td>
                            SIN FECHA 
                        </td>
                        <td>
                            SIN NOTA 
                        </td>
                        <td>
                            SIN PORTERÍA
                        </td>
                        <td>
                            SIN PORTERO
                        </td>
                        <td>
                            SIN ELEMENTOS
                        </td>
                   @else 
                        @php
                            $exit = $income->exitentries->first(); // en caso de múltiples salidas, puedes ajustarlo
                        @endphp
                        <td>{{ $exit->departure_date }}</td>
                        <td>
                            {{ $exit->nota ? mb_strtoupper(strip_tags($exit->nota)) : 'SIN NOTA' }}
                        </td>

                        <td>{{ mb_strtoupper($exit->goal->name ?? 'SIN PORTERÍA') }}</td>
                        <td>{{ mb_strtoupper($exit->user->name ?? 'SIN PORTERO') }}</td>
                        <td>
                            @if ($exit->elements->isNotEmpty())
                                <ul>
                                    @foreach($exit->elements as $element)
                                        <li>
                                            {{ mb_strtoupper($element->name) }} - Nota: {{ mb_strtoupper(strip_tags($element->pivot->nota)) }}
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                SIN ELEMENTOS
                            @endif
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
