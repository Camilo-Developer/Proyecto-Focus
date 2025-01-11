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
                <th>FECHA INGRESO</th>
                <th>FECHA SALIDA</th>
                <th>NOTA</th>
                <th>VISITANTE</th>
                <th>ELEMENTOS RELACIONADOS</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employeeIncomes as $income)
                <tr>
                    <td>{{ $income->id }}</td>
                    <td>{{ $income->admission_date }}</td>
                    <td>{{ $income->departure_date ?? 'SIN SALIDA' }}</td>
                    <td>{{ mb_strtoupper(strip_tags($income->nota)) }}</td>
                    <td>{{ mb_strtoupper($income->visitor->name) ?? 'SIN VISITANTE' }}</td>
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
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
