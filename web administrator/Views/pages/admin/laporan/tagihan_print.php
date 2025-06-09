<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title></title>

    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/public/assets/css/bootstrap.css">
</head>

<body style="font-size: 12px;" onload="window.print()">
    <style>
        @page {
            size: auto;
            margin: 0;
        }

        @media print {
            #noprint {
                display: none;
            }
        }
    </style>
    <style>
        @media print {
            #noprint {
                display: none;
            }
        }

        @media all {
            #footer {
                position: absolute;
                /* bottom: 0; */
            }
        }

        .table-borderless>tbody>tr>td,
        .table-borderless>tbody>tr>th,
        .table-borderless>tfoot>tr>td,
        .table-borderless>tfoot>tr>th,
        .table-borderless>thead>tr>td,
        .table-borderless>thead>tr>th {
            border: none;
        }
    </style>

    <div class="print_area">
        <table class="table borderless">
            <thead>
                <tr>
                    <td class="text-center">
                        <h4 style="margin-bottom:5px;" class="text-center">
                            Laporan Data Booking
                        </h4>
                        <p>Periode <?= tgl_indo($periode_awal); ?> s/d <?= tgl_indo($periode_akhir); ?></p>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No Invoice</th>
                                    <th>Nama Customer</th>
                                    <th>Nama Room</th>
                                    <th>Periode (Bulan/Tahun)</th>
                                    <th>Tanggal Bayar</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tagihans as $tagihan) : ?>
                                    <tr>
                                        <td><?= $tagihan->no_invoice; ?></td>
                                        <td><?= $tagihan->nama_customer; ?></td>
                                        <td><?= $tagihan->nama_room; ?></td>
                                        <td><?= bulan($tagihan->bulan) . ' ' . $tagihan->tahun; ?></td>
                                        <td><?= date('d-m-Y', strtotime($tagihan->payment_date)); ?></td>
                                        <td><?= number_format($tagihan->nominal); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td colspan="5" class="text-end"><strong>Subtotal:</strong></td>
                                    <td><strong><?= number_format($subtotal); ?></strong></td>
                                </tr>
                            </tbody>

                        </table>
                        <table class="table-borderless">
                            <tr>
                                <td width="200%" class="text-left">
                                    Dicetak Oleh</br>
                                    E-Kost Pink
                                    <br />
                                    <br />
                                    <br />
                                    <?php echo tgl_indo(date('Y-m-d')); ?></p>
                                </td>
                            </tr>
                        </table>
                        <div id="noprint">
                            <button hidden type="button" onclick="window.close()" class="btn  btn-sm btn-default">Close</button>
                        </div>
    </div>
</body>

</html>