<!DOCTYPE html>
<html>

<head>
    <title>Smartusers PDF</title>
    <style>
        body {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #eee;
        }
    </style>
</head>

<body>
    <h2>Report Karyawan</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>E-Mail</th>
                <th>Tanggal Lahir</th>
                <th>Jabatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($karyawan as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name}}</td>
                    <td>{{ $user->email}}</td>
                    <td>{{ $user->dob}}</td>
                    <td>{{ $user->role}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <h2>Report Karyawan</h2>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Kerap</th>
                <th>Tanggal Lahir</th>
                <th>Jabatan</th>
            </tr>
        </thead>
        <tbody>
            {{ $wp }}
           
        </tbody>
    </table>
</body>

</html>