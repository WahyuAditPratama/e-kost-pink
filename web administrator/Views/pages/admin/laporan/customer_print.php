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
            /* auto is the initial value */
            margin: 0;
            /* this affects the margin in the printer settings */
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

        .print_area {
            margin: 1cm;
        }
    </style>

    <div class="print_area">
        <table class="table borderless">
            <thead>
                <tr>
                    <td class="text-center">
                        <h4 style="margin-bottom:5px;" class="text-center">
                            Laporan Data Customer
                        </h4>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Telepon</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Username</th>
                                    <th>Status</th>
                                </tr>
                            </thead>


                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($customers as $item) { ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $item->nama_customer ?></td>
                                        <td><?= $item->email ?></td>
                                        <td><?= $item->telepon ?></td>
                                        <td><?= $item->jenis_kelamin ?></td>
                                        <td><?= $item->username ?></td>
                                        <td><?= $item->status ?></td>

                                    </tr>
                                <?php } ?>
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
                                    <?php echo (date('Y-m-d')); ?></p>
                                </td>
                            </tr>
                        </table>
                        <div id="noprint">
                            <button type="button" onclick="window.close()" class="btn  btn-sm btn-default">Close</button>
                        </div>
    </div>
</body>

</html>