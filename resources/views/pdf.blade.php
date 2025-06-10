<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Hasil Preferensi Karyawan</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #eee;
        }
    </style>
</head>

<body>
    <h2>Hasil Perhitungan SAW dan WP</h2>

    <!-- {{ var_dump($saw) }} -->
    @if(!isset($saw['ranking']))
        <p>Error: 'ranking' is not defined in $saw.</p>
    @endif

    <h2>SAW Ranking</h2>
    <table>
        <thead>
            <tr>
                <th>Alternative</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Tanggal Lahir</th>
                <th>Ranking</th>
                <th>SAW Score</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($saw['ranking'] as $row)
                <tr>
                    <td>{{ $row['alternative_name'] }}</td>
                    <td>{{ $row['name'] }}</td>
                    <td>{{ $karyawan->where('id', $row['id'])->first()->email ?? 'N/A' }}</td>
                    <td>{{ $karyawan->where('id', $row['id'])->first()->dob ?? 'N/A' }}</td>
                    <td>{{ $row['rank'] }}</td>
                    <td>{{ number_format($row['score'], 4) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <h2>WP Ranking</h2>
    <table>
        <thead>
            <tr>
                <th>Alternative</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Tanggal Lahir</th>
                <th>Ranking</th>
                <th>SAW Score</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($wp['ranking'] as $row)
                <tr>
                    <td>{{ $row['alternative_name'] }}</td>
                    <td>{{ $row['name'] }}</td>
                    <td>{{ $karyawan->where('id', $row['id'])->first()->email ?? 'N/A' }}</td>
                    <td>{{ $karyawan->where('id', $row['id'])->first()->dob ?? 'N/A' }}</td>
                    <td>{{ $row['rank'] }}</td>
                    <td>{{ number_format($row['score'], 4) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- <h2>Matrix</h2>
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>Alternative</th>
                @foreach ($saw['matrix'][array_key_first($saw['matrix'])] as $criteriaId => $val)
                    <th>Criteria {{ $criteriaId }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($saw['matrix'] as $altId => $criteriaVals)
                <tr>
                    <td>A{{ $altId }}</td>
                    @foreach ($criteriaVals as $value)
                        <td>{{ $value }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table> -->

</body>

</html>