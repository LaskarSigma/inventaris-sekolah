<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Data Barang</title>
    <style>
        html {
            margin: 60px 15px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th rowspan="2" style="width: 20px;">No</th>
                <th rowspan="2" style="width: 90px;">Tanggal Masuk</th>
                <th rowspan="2" style="width: 140px;">Nama dan Alamat Toko</th>
                <th colspan="2" style="width: 130px;">Tanda Bukti Pembelian</th>
                <th rowspan="2" style="width: 60px;">Merk</th>
                <th rowspan="2">Nama Barang</th>
                <th rowspan="2" style="width: 40px;">Kuantitas</th>
                <th rowspan="2" style="width: 65px;">Harga Satuan Rp.</th>
                <th rowspan="2" style="width: 70px;">Jumlah Rp.</th>
                <th rowspan="2" style="width: 55px;">Sumber Dana</th>
                <th rowspan="2" style="width: 40px;">Jenis Barang</th>
            </tr>
            <tr>
                <th style="width: 90px;">Tanggal</th>
                <th style="width: 40px;">Nomor</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->entry_date->format('d F Y') }}</td>
                    <td>{{ $item->name_address }}</td>
                    <td>{{ $item->receipt_date->format('d F Y') }}</td>
                    <td>{{ $item->receipt_no }}</td>
                    <td>{{ $item->brand ?: '-' }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                    <td>{{ $item->funding }}</td>
                    <td>{{ $item->inventoryCode->code ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="13">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
