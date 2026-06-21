<!DOCTYPE html>
<html>

    <head>
        <title>Laporan Kargo</title>
        <style>
            body {
                font-family: sans-serif;
                font-size: 12px;
                color: #333;
            }

            .header {
                text-align: center;
                margin-bottom: 20px;
            }

            .header h2 {
                margin: 0;
                padding: 0;
                color: #162E93;
            }

            .header p {
                margin: 5px 0 0 0;
                color: #666;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 15px;
            }

            th,
            td {
                border: 1px solid #ddd;
                padding: 8px 10px;
                text-align: left;
            }

            th {
                background-color: #f8fafc;
                color: #0f172a;
                font-weight: bold;
            }

            tr:nth-child(even) {
                background-color: #f8fafc;
            }
        </style>
    </head>

    <body>

        <div class="header">
            <h2>Laporan {{ $jenis_laporan }} Kargo MEX</h2>
            <p>Periode Waktu: {{ $periode }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No. Resi</th>
                    <th>Tgl Terima</th>
                    <th>Pengirim</th>
                    <th>Tujuan</th>
                    <th>Berat</th>
                    <th>Status Akhir</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $k)
                    <tr>
                        <td style="font-weight: bold;">{{ $k->no_resi }}</td>
                        <td>{{ \Carbon\Carbon::parse($k->created_at)->format('d/m/Y') }}</td>
                        <td>{{ $k->pengirim->nama ?? '-' }}</td>
                        <td>{{ $k->kotaTujuan->nama_kota ?? '-' }}</td>
                        <td>{{ $k->berat }} kg</td>
                        <td>{{ $k->status_terakhir }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 20px;">Tidak ada data kargo pada periode ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </body>

</html>