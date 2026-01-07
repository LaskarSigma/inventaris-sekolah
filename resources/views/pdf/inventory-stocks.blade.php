<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Kartu Persediaan Barang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 20px;
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

        .info {
            margin-bottom: 20px;
        }

        .info table {
            border: none;
        }

        .info td {
            border: none;
            padding: 3px 10px;
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
        }

        .table th,
        .table td {
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .text-left {
            text-align: left;
        }

        .location {
            text-align: right;
            margin-top: 30px;
            margin-bottom: 10px;
        }

        .signatures {
            display: table;
            width: 100%;
            margin-top: 50px;
        }

        .signature {
            display: table-cell;
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 0 10px;
        }

        .signature-space {
            height: 80px;
        }

        .signature-name {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>KARTU PERSEDIAAN BARANG</h1>
    </div>

    <div class="info">
        <table>
            <tr>
                <td style="width: 150px;"><strong>Kelompok Barang</strong></td>
                <td style="width: 10px;">:</td>
                <td>{{ $category ?? 'Semua Kelompok' }}</td>
            </tr>
            <tr>
                <td><strong>Jenis Barang</strong></td>
                <td>:</td>
                <td>{{ $inventoryCode ?? 'Semua Jenis' }}</td>
            </tr>
            <tr>
                <td><strong>Merek</strong></td>
                <td>:</td>
                <td>{{ $brand ?? 'Semua Merek' }}</td>
            </tr>
            <tr>
                <td><strong>Periode</strong></td>
                <td>:</td>
                <td>{{ $dateRange ?? 'Semua Tanggal' }}</td>
            </tr>
            </thead>
        </table>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th rowspan="2" style="width: 20px;">No</th>
                <th rowspan="2" style="width: 10%;">Tanggal Pembelian</th>
                <th rowspan="2" style="width: 8%;">No. Pembelian</th>
                <th rowspan="2" style="width: 12%;">Merek</th>
                <th rowspan="2" style="width: 22%;">Nama Barang</th>
                <th rowspan="2" style="width: 13%;">Kode Barang</th>
                <th colspan="2" style="width: 12%;">Barang</th>
                <th rowspan="2" style="width: 15%;">Tempat</th>
            </tr>
            <tr>
                <th style="width: 6%;">Masuk</th>
                <th style="width: 6%;">Keluar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $index => $record)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $record->item?->receipt_date ? \Carbon\Carbon::parse($record->item->receipt_date)->format('d F Y') : '-' }}
                    </td>
                    <td class="text-left">{{ $record->item?->receipt_no ?? '-' }}</td>
                    <td>{{ $record->item?->brand }}</td>
                    <td>{{ $record->item?->name }}</td>
                    <td>{{ $record->inventory_code }}</td>
                    <td>{{ $record->incoming_stock ?? 0 }}</td>
                    <td>{{ $record->outgoing_stock ?? 0 }}</td>
                    <td class="text-left">{{ $record->location ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="location">
        Kencong, {{ now()->format('d F Y') }}
    </div>

    <div class="signatures">
        <div class="signature">
            <div>Mengetahui,</div>
            <div>Kepala SMK PGRI 5 Jember</div>
            <div class="signature-space"></div>
            <div class="signature-name">{{ $settings->headmaster_name }}</div>
        </div>
        <div class="signature">
            <div></div>
            <div>Waka Sarana Prasarana</div>
            <div class="signature-space"></div>
            <div class="signature-name">{{ $settings->infrastructure_head_name }}</div>
        </div>
    </div>
</body>

</html>
