<!DOCTYPE html PUBLIC"-//OPENHTMLTOPDF//DOC XHTML Character Entities Only 1.0//EN" "">
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        img {
            /* display: inherit;
            position: absolute; */
            left: 20px;
            /* top: 5px; */
        }

        table {
            border: 1px solid;
            width: 100%;
            border-collapse: collapse;
            font-size: 6pt;
        }

        .container {
            font-size: 10pt;
        }

        th,
        td {
            padding: 0px;
            padding-left: 15px;
            text-align: left;
            white-space: nowrap;
        }

        #tick-mark {
            position: relative;
            display: inline-block;
            width: 8px;
            height: 8px;
        }

        #tick-mark::before {
            position: absolute;
            left: 0;
            top: 50%;
            height: 50%;
            width: 2px;
            background-color: #000000;
            content: "";
            transform: translateX(10px) rotate(-45deg);
            transform-origin: left bottom;
        }

        #tick-mark::after {
            position: absolute;
            left: 0;
            bottom: 0;
            height: 2px;
            width: 100%;
            background-color: #000000;
            content: "";
            transform: translateX(10px) rotate(-45deg);
            transform-origin: left bottom;
        }
    </style>
</head>

<body>
    <div class="container">
        FORMULIR PERMINTAAN DAN PEMBERIAN CUTI
        <table class="tb-main">

            <td style="padding: 10px; border: 3px solid;">

                <table style="border: none;">
                    <tr>
                        <td style="width: 50%; padding: 60px;">

                        </td>
                        <td>
                            <div style="font-family: Arial;">
                                ANAK LAMPIRAN 1.b
                                <br>
                                PERATURAN BADAN KEPEGAWAIAN NEGARA REPUBLIK
                                <br>
                                INDONESIA
                                <br>
                                NOMOR 24 TAHUN 2017
                                <br>
                            </div>
                            <div style="padding-top: 15px;">
                                Yogyakarta, {{ $data->tanggal }}
                                <br>
                                Kepada
                                <br>
                                Yth. Ketua Pengadilan TUN Yogyakarta <br>
                                di. <br> Yogyakarta
                            </div>

                        </td>
                    </tr>
                </table>
                <br>
                <div style="text-align: center; font-size: 8pt; font-weight: 700;">
                    FORMULIR PERMINTAAN DAN PEMBERIAN CUTI <br>
                    {{ $data->letter_head }}
                </div>
                <table>
                    <tr>
                        <th colspan="4">
                            I. Data Pegawai
                        </th>
                    </tr>
                    <tr>
                        <td style="border: 1px solid; width: 15%;">
                            Nama
                        </td>
                        <td style="border: 1px solid; width: 30%;">
                            {{ $data->name }}
                        </td>
                        <td style="border: 1px solid; width: 15%;">
                            NIP
                        </td>
                        <td style="border: 1px solid; width: 30%;">
                            {{ $data->nip }}
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid; width: 15%;">
                            Jabatan
                        </td>
                        <td style="border: 1px solid; width: 30%;">
                            {{ $data->title }}
                        </td>
                        <td style="border: 1px solid; width: 15%;">
                            Masa Kerja
                        </td>
                        <td style="border: 1px solid; width: 30%;">
                            {{ $data->working_time }}
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid; width: 15%;">
                            Unit Kerja
                        </td>
                        <td style="border: 1px solid;" colspan="3">
                            Pengadilan Tata Usaha Negara Yogyakarta
                        </td>
                    </tr>
                </table>

                <br>

                <table>
                    <tr>
                        <th colspan="4">
                            II. JENIS CUTI YANG DIAMBIL. **
                        </th>
                    </tr>
                    <tr>
                        <td style="border: 1px solid; width: 40%;">
                            1. Cuti Tahunan
                        </td>
                        <td style="border: 1px solid; width: 10%;">
                            @if ($data->permit_type == 'Tahunan')
                                <div id="tick-mark"></div>
                            @endif
                        </td>
                        <td style="border: 1px solid; width: 40%;">
                            1. Cuti Besar
                        </td>
                        <td style="border: 1px solid; width: 10%;">
                            @if ($data->permit_type == 'Besar')
                                <div id="tick-mark"></div>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid; width: 40%;">
                            2. Cuti Sakit
                        </td>
                        <td style="border: 1px solid; width: 10%;">
                            @if ($data->permit_type == 'Sakit')
                                <div id="tick-mark"></div>
                            @endif
                        </td>
                        <td style="border: 1px solid; width: 40%;">
                            2. Cuti Melahirkan
                        </td>
                        <td style="border: 1px solid; width: 10%;">
                            @if ($data->permit_type == 'Melahirkan')
                                <div id="tick-mark"></div>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid; width: 40%;">
                            3. Cuti Karena Alasan Penting
                        </td>
                        <td style="border: 1px solid; width: 10%;">
                            @if ($data->permit_type == 'Karena Alasan Penting')
                                <div id="tick-mark"></div>
                            @endif
                        </td>
                        <td style="border: 1px solid; width: 40%;">
                            3. Cuti di Luar Tanggungan Negara
                        </td>
                        <td style="border: 1px solid; width: 10%;">
                            @if ($data->permit_type == 'Luar Tanggungan Negara')
                                <div id="tick-mark"></div>
                            @endif
                        </td>
                    </tr>
                </table>

                <br>

                <table>
                    <tr>
                        <th>
                            III. ALASAN CUTI
                        </th>
                    </tr>
                    <tr>
                        <td style="border: 1px solid; height: 40px;">
                            {{ $data->reason }}
                        </td>
                    </tr>
                </table>

                <br>

                <table>
                    <tr>
                        <th colspan="6">
                            IV. LAMANYA CUTI
                        </th>
                    </tr>
                    <tr>
                        <td style="border: 1px solid; height: 30px; width: 10%;">
                            Selama
                        </td>
                        <td style="border: 1px solid; height: 30px; width: 28%;">
                            {{ $data->leave_long }}
                        </td>
                        <td style="border: 1px solid; height: 30px; width: 15%;">
                            Mulai Tanggal
                        </td>
                        <td style="border: 1px solid; height: 30px; width: 20%;">
                            {{ date('d-m-Y', strtotime($data->start_time)) }}
                        </td>
                        <td style="border: 1px solid; height: 30px; width: 7%;">
                            s/d
                        </td>
                        <td style="border: 1px solid; height: 30px; width: 20%;">
                            {{ date('d-m-Y', strtotime($data->end_time)) }}
                        </td>
                    </tr>
                </table>
                <br>
                <table>
                    <tr>
                        <th colspan="5">
                            V. CATATAN CUTI ***
                        </th>
                    </tr>
                    <tr>
                        <td style="border: 1px solid; width: 20%;" colspan="3">
                            1. CUTI TAHUNAN
                        </td>
                        <td style="border: 1px solid; width: 20%;">
                            CUTI BESAR
                        </td>
                        <td style="border: 1px solid; width: 10%;">
                            @foreach ($data->leave_notes as $notes)
                                @if ($notes->type == 'Besar')
                                    <b>{{ $notes->amount }}</b>
                                @endif
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid; width: 3%;">
                            Tahun
                        </td>
                        <td style="border: 1px solid; width: 1%; padding-right:15px;">
                            Sisa
                        </td>
                        <td style="border: 1px solid; width: 1%;  padding-right:15px;">
                            Keterangan
                        </td>
                        <td style="border: 1px solid; width: 10%;">
                            CUTI SAKIT
                        </td>
                        <td style="border: 1px solid; width: 10%;">
                            @foreach ($data->leave_notes as $notes)
                                @if ($notes->type == 'Sakit')
                                    <b>{{ $notes->amount }}</b>
                                @endif
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid; height: 15px;">

                        </td>
                        <td style="border: 1px solid; height: 15px; ">
                        </td>
                        <td style="border: 1px solid; height: 15px;">
                        </td>
                        <td style="border: 1px solid; width: 10%;">
                            CUTI MELAHIRKAN
                        </td>
                        <td style="border: 1px solid; width: 10%;">
                            @foreach ($data->leave_notes as $notes)
                                @if ($notes->type == 'Melahirkan')
                                    <b>{{ $notes->amount }}</b>
                                @endif
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid; height: 15px;">
                            <b>N-1</b>
                        </td>
                        <td style="border: 1px solid; height: 15px; ">
                            @if ($data->leave_notes != [])
                                @foreach ($data->leave_notes as $i => $notes)
                                    @if ($data->leave_notes[$i]->type == 'Tahunan-0')
                                        <b>{{ $data->leave_notes[$i]->remain }} hari </b>
                                    @endif
                                @endforeach
                            @else
                                <b>Masih...hari</b>
                            @endif
                        </td>
                        <td style="border: 1px solid; height: 15px;">
                            @if ($data->leave_notes != [])
                                @foreach ($data->leave_notes as $i => $notes)
                                    @if ($data->leave_notes[$i]->type == 'Tahunan-0')
                                        <b>Masih {{ $data->leave_notes[$i]->amount }} hari </b>
                                    @endif
                                @endforeach
                            @else
                                <b>Masih...hari</b>
                            @endif
                        </td>
                        <td style="border: 1px solid; width: 10%;">
                            CUTI KARENA ALASAN PENTING
                        </td>
                        <td style="border: 1px solid; width: 10%;">
                            @foreach ($data->leave_notes as $notes)
                                @if ($notes->type == 'Karena Alasan Penting')
                                    <b>{{ $notes->amount }}</b>
                                @endif
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid; height: 15px;">
                            <b>N</b>
                        </td>
                        <td style="border: 1px solid; height: 15px; ">
                            @if ($data->leave_notes != [])
                                @foreach ($data->leave_notes as $i => $notes)
                                    @if ($data->leave_notes[$i]->type == 'Tahunan-1')
                                        <b>{{ $data->leave_notes[$i]->remain }} hari </b>
                                    @endif
                                @endforeach
                            @else
                                <b>Masih...hari</b>
                            @endif
                        </td>
                        <td style="border: 1px solid; height: 15px;">
                            @if ($data->leave_notes != [])
                                @foreach ($data->leave_notes as $i => $notes)
                                    @if ($data->leave_notes[$i]->type == 'Tahunan-1')
                                        <b>Masih {{ $data->leave_notes[$i]->amount }} hari </b>
                                    @endif
                                @endforeach
                            @else
                                <b>Masih...hari</b>
                            @endif
                        </td>
                        <td style="border: 1px solid; width: 10%;">
                            CUTI DI LUAR TANGGUNGAN NEGARA
                        </td>
                        <td style="border: 1px solid; width: 10%;">
                            @foreach ($data->leave_notes as $notes)
                                @if ($notes->type == 'Luar Tanggungan Negara')
                                    <b>{{ $notes->amount }}</b>
                                @endif
                            @endforeach
                        </td>
                    </tr>
                </table>

                <br>

                <table>
                    <tr>
                        <th colspan="3">
                            ALAMAT SELAMA MENJALANKAN CUTI
                        </th>
                    </tr>
                    <tr>
                        <td style="border: 1px solid; width: 45%; text-align:center;">
                            Alamat Lengkap
                        </td>
                        <td style="border: 1px solid; width: 25%; text-align:center;">
                            Telpon
                        </td>
                        <td style="border-top: 1px solid; width: 40%; text-align:center;">
                            <b>Hormat Saya,</b>
                        </td>
                    </tr>
                    <tr>
                        <td style="border-right: 1px solid;">
                            {{ $data->address }}
                        </td>
                        <td style="border-right: 1px solid; text-align: center;">
                            {{ $data->phone }}
                        </td>
                        <td style="height: 15px; text-align: center;">
                            {{ $data->name }}
                        </td>
                    </tr>
                    <tr>
                        <td style="border-right: 1px solid;">
                        </td>
                        <td style="border-right: 1px solid;">
                        </td>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td style="border-right: 1px solid;">

                        </td>
                        <td style=" border-right: 1px solid; height: 15px;">
                        </td>
                        <td style="text-align:center; ">
                            @if ($sign_pemohon)
                                <img src="data:image/png;base64,{{ $sign_pemohon ?? null }}" alt=""
                                    style="min-height: 50px; max-height: 50px;" width="auto">
                            @else
                                <div style="padding: 35px;"></div>
                            @endif
                            <p><b
                                    style="text-decoration: underline; white-space: nowrap; margin:0;">({{ $data->name }})</b>
                                <br>{{ $data->nip }} <b></b>
                            </p>
                        </td>
                    </tr>
                </table>

                <br>

                <table>
                    <tr>
                        <th colspan="4">
                            PERTIMBANGAN ATASAN LANGSUNG **
                        </th>
                    </tr>
                    <tr>
                        <td style="border: 1px solid; width: 15%; text-align:center;">
                            DISETUJUI
                        </td>
                        <td style="border: 1px solid; width: 25%; text-align:center;">
                            PERUBAHAN ****
                        </td>
                        <td style="border: 1px solid; width: 30%; text-align:center;">
                            DITANGGUHKAN ****
                        </td>
                        <td style="border: 1px solid; width: 30%; text-align:center;">
                            TIDAK DISETUJUI ****
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid; text-align:center; height: 15px;">
                            @foreach ($data->approval as $approve)
                                @if ($approve->approval_status == 'Disetujui' && $approve->approval_type == 'ATASAN')
                                    <span id="tick-mark"></span>
                                @endif
                            @endforeach
                        </td>
                        <td style="border: 1px solid; text-align:center; height: 15px;">
                            @foreach ($data->approval as $approve)
                                @if ($approve->approval_status == 'Perubahan' && $approve->approval_type == 'ATASAN')
                                    <span id="tick-mark"></span>
                                @endif
                            @endforeach
                        </td>
                        <td style="border: 1px solid; text-align:center; height: 15px;">
                            @foreach ($data->approval as $approve)
                                @if ($approve->approval_status == 'Ditangguhkan' && $approve->approval_type == 'ATASAN')
                                    <span id="tick-mark"></span>
                                @endif
                            @endforeach
                        </td>
                        <td style="border: 1px solid; text-align:center; height: 15px;">
                            @foreach ($data->approval as $approve)
                                @if ($approve->approval_status == 'Tidak Disetujui' && $approve->approval_type == 'ATASAN')
                                    <span id="tick-mark"></span>
                                @endif
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td style="border-right: 1px solid;" colspan="3">
                            @foreach ($data->approval as $approve)
                                @if ($approve->approval_type == 'ATASAN')
                                    {{ $approve->note }}
                                @endif
                            @endforeach
                        </td>
                        <td style="border-right: 1px solid; text-align:center;">
                            <b>
                                @foreach ($data->approval as $approve)
                                    @if ($approve->approval_type == 'ATASAN')
                                        {{ $approve->title }}
                                    @endif
                                @endforeach <br> PTUN YOGYAKARTA
                            </b>

                        </td>
                    </tr>
                    <tr>
                        <td style="border-right: 1px solid;" colspan="3">
                        </td>
                        <td style="border-right: 1px solid; text-align:center;">
                            @foreach ($data->approval as $approve)
                                @if ($approve->approval_type == 'ATASAN')
                                    @if ($sign_atasan)
                                        <img src="data:image/png;base64,{{ $sign_atasan ?? null }}" alt=""
                                            style="min-height: 50px; max-height: 50px;" width="auto">
                                    @else
                                        <div style="padding: 35px;"></div>
                                    @endif
                                @endif
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td style="border-right: 1px solid; height: 15px;" colspan="3">

                        </td>
                        <td style="border-right: 1px solid; text-align:center;">
                            @foreach ($data->approval as $approve)
                                @if ($approve->approval_type == 'ATASAN')
                                    <p><b style="text-decoration: underline;">({{ strtoupper($approve->chief) }})</b>
                                        <br>{{ $approve->nip }} <b></b>
                                    </p>
                                @endif
                            @endforeach
                        </td>
                    </tr>
                </table>

                <br>

                <table>
                    <tr>
                        <th colspan="4">
                            KEPUTUSAN PEJABAT YANG BERWENANG MEMBERIKAN CUTI **
                        </th>
                    </tr>
                    <tr>
                        <td style="border: 1px solid; width: 15%; text-align:center;">
                            DISETUJUI
                        </td>
                        <td style="border: 1px solid; width: 25%; text-align:center;">
                            PERUBAHAN ****
                        </td>
                        <td style="border: 1px solid; width: 30%; text-align:center;">
                            DITANGGUHKAN ****
                        </td>
                        <td style="border: 1px solid; width: 30%; text-align:center;">
                            TIDAK DISETUJUI ****
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid; text-align:center; height: 15px;">
                            @foreach ($data->approval as $approve)
                                @if ($approve->approval_status == 'Disetujui' && $approve->approval_type == 'PEJABAT')
                                    <span id="tick-mark"></span>
                                @endif
                            @endforeach
                        </td>
                        <td style="border: 1px solid; text-align:center; height: 15px;">
                            @foreach ($data->approval as $approve)
                                @if ($approve->approval_status == 'Perubahan' && $approve->approval_type == 'PEJABAT')
                                    <span id="tick-mark"></span>
                                @endif
                            @endforeach
                        </td>
                        <td style="border: 1px solid; text-align:center; height: 15px;">
                            @foreach ($data->approval as $approve)
                                @if ($approve->approval_status == 'Ditangguhkan' && $approve->approval_type == 'PEJABAT')
                                    <span id="tick-mark"></span>
                                @endif
                            @endforeach
                        </td>
                        <td style="border: 1px solid; text-align:center; height: 15px;">
                            @foreach ($data->approval as $approve)
                                @if ($approve->approval_status == 'Tidak Disetujui' && $approve->approval_type == 'PEJABAT')
                                    <span id="tick-mark"></span>
                                @endif
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td style="border-right: 1px solid;" colspan="3">

                        </td>
                        <td style="border-right: 1px solid; text-align:center;">
                            <b>KETUA PTUN YOGYAKARTA </b>

                        </td>
                    </tr>
                    <tr>
                        <td style="border-right: 1px solid;" colspan="3">
                            @foreach ($data->approval as $approve)
                                @if ($approve->approval_type == 'PEJABAT')
                                    {{ $approve->note }}
                                @endif
                            @endforeach
                        </td>
                        <td style="border-right: 1px solid; text-align:center;">
                            @foreach ($data->approval as $approve)
                                @if ($approve->approval_type == 'PEJABAT')
                                    @if ($sign_pejabat)
                                        <img src="data:image/png;base64,{{ $sign_pejabat ?? null }}" alt=""
                                            style="min-height: 50px; max-height: 50px;" width="auto">
                                    @else
                                        <div style="padding: 35px;"></div>
                                    @endif
                                @endif
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td style="border-right: 1px solid; height: 15px;" colspan="3">

                        </td>
                        <td style="border-right: 1px solid; text-align:center;">
                            @foreach ($data->approval as $approve)
                                @if ($approve->approval_type == 'PEJABAT')
                                    <p><b style="text-decoration: underline;">({{ $approve->chief }})</b>
                                        <br>{{ $approve->nip }} <b></b>
                                    </p>
                                @endif
                            @endforeach
                        </td>
                    </tr>
            </td>
            </tr>
        </table>
        <b>Catatan: </b>
        <br>
        * Coret yang tidak perlu
        <br>
        ** Pilih salah satu dengan centang (<span id="tick-mark"></span> &nbsp; &nbsp;)
        <br>
        *** diisi oleh pejabat yang menangani bidang kepegawaian sebelum PNS mengajukan Cuti
        <br>
        **** diberi tanda centang dan alasannya,.


        </td>
        </table>
</body>

</html>
