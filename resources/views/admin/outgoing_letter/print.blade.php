<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <title>Document</title>

    <style>
        .no-space{
            white-space: 0;
            margin: 0;
            padding: 0;
        }
        .bold{
            font-weight: 700;
        }
        .table{
            border-collapse: collapse;
            width: 100%;
        }
        .text-underlined{
            text-decoration: underline;
        }
        .text-center{
            text-align: center;
        }
        table th,
        table td {
          border: solid 3px;
          padding: 8px;
        }
        .one-space{
            white-space: 0;
            margin: 0;
            padding: 5px;
        }
    </style>
</head>
<body>
    <table class="table">
        <tr>
            <td colspan="3">
                <H3 class="no-space">
                    PENGADILAN TATA USAHA NEGARA YOGYAKARTA
                </H3>
                <p class="no-space bold">Jalan : Janti No.66 Banguntapan, Bantul</p>
                <p class="no-space bold">Telp. : 0274-520502 Fax : 0274581675</p>

            </td>
        </tr>
        <tr>
            <td colspan="3">
                <h2 class="text-underlined text-center no-space">
                    LEMBAR DISPOSISI
                </h2>
            </td>
        </tr>
        <tr>
            <td width="50%">
                <div class="d-flex">
                    Indeks : {{$data->index}}
                </div>
            </td>
            <td colspan="2">
                <div class="d-flex">
                    <p class="no-space">
                        Rahasia : @if ($data->letter_type == 'Rahasia') Ya @endif
                    </p>
                    <p class="no-space code" style="float: left;"></p>
                </div>
                <div class="d-flex">
                    <p class="no-space">
                        Penting : @if ($data->letter_type == 'Penting') Ya @endif
                    </p>
                    <p class="no-space code" style="float: left;"></p>
                </div>
                <div class="d-flex">
                    <p class="no-space">
                        Biasa : @if ($data->letter_type == 'Biasa') Ya @endif
                    </p>
                    <p class="no-space code" style="float: left;"></p>
                </div>
            </td>
        </tr>
        <tr>
            <td width="50%">
                <div class="d-flex">
                    <p class="no-space">
                        Kode : {{$data->code}}
                    </p>
                    <p class="no-space code" style="float: left;"></p>
                </div>
            </td>
            <td colspan="2">
                <div class="d-flex">
                    <p class="no-space">
                        Tanggal Penyelesaian : {{$data->date_finish}}
                    </p>
                    <p class="no-space date_finish" style="float: left;"></p>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <div style="display: flex; margin-bottom: 3px;">
                    <p class="one-space">Tanggal Nomor : {{$data->date_number}}</p>
                </div>
                <div style="display: flex; margin-bottom: 3px;">
                    <p class="one-space">Asal Surat : {{$data->from}}</p>
                </div>
                <div style="display: flex; margin-bottom: 3px;">
                    <p class="one-space">Isi Ringkas : {{$data->resume_content}}</p>
                </div>
                <div style="display: flex; margin-bottom: 3px;">
                    <p class="one-space">No/Tgl Agenda : {{$data->agenda_number."/".$data->agenda_date}} </p>
                </div>
            </td>
        </tr>
        <tr>
            <td valign="top">
                <h5 class="no-space">INSTRUKSI INFORMASI :</h5>
                <div class="ketua-instruction">
                    @foreach ($data->disposition as $d)
                        @if ($d->role == 'Ketua' || $d->role == 'Wakil Ketua')
                        <p>- {{$d->instruction}}</p>
                        @endif
                    @endforeach
                </div>
            </td>
            <td style="border-right: none;">
                <h5 class="no-space" style="margin-bottom: 5px;">DITERUSKAN KEPADA :</h5>
                <div class="no-space" style="display: flex; margin-bottom: 3px;">
                    <p class="no-space"> 1. Ketua </p>
                </div>
                <div class="no-space" style="display: flex; margin-bottom: 3px;">
                    <p class="no-space">2. Wakil Ketua</p>
                </div>
                <div class="no-space"style="display: flex; margin-bottom: 3px;">
                    <p class="no-space">3. Panitera</p>
                </div>
                <div style="display: flex; margin-bottom: 3px;">
                    <p class="no-space">4. Sekretaris</p>
                </div>
                <div style="display: flex; margin-bottom: 3px;">
                    <span>
                        <p class="no-space">5. Pan. Mud. Hukum</p>
                    </span>
                    <p class="no-space forward-5" style="float: left;"></p>
                </div>
                <div style="display: flex; margin-bottom: 3px;">
                    <span>
                        <p class="no-space">6. Pan. Mud.Perkara</p>
                    </span>
                    <p class="no-space forward-6" style="float: left;"></p>
                </div>
                <div style="display: flex; margin-bottom: 3px;">
                    <span>
                        <p class="no-space">7. Sub. Bagian Perencanaan, Teknologi Informasi dan Pelaporan</p>
                    </span>
                    <p class="no-space forward-7" style="float: left;"></p>
                </div>
                <div style="display: flex; margin-bottom: 3px;">
                <span>
                    <p class="no-space">8. Sub. Bagian Kepegawaian, Organisasi dan Tata Laksana</p>
                </span>
                    <p class="no-space forward-8" style="float: left;"></p>
                </div>
                <div style="display: flex; margin-bottom: 3px;">
                <span>
                    <p class="no-space">9. Sub. Bagian Umum dan Keuangan</p>
                </span>
                    <p class="no-space forward-9" style="float: left;"></p>
                </div>
            </td>
            <td valign="top" style="border-left: none;" width="20px">
                <input type="checkbox" style="padding-top: 15px;" @foreach ($data->disposition as $d) @if ($d->role == 'Ketua') checked  @endif @endforeach>
                <input class="no-space" type="checkbox"  @foreach ($data->disposition as $d) @if ($d->role == 'Wakil Ketua') checked  @endif @endforeach>
                <input class="no-space" type="checkbox"  @foreach ($data->disposition as $d) @if ($d->role == 'Panitera')  checked @endif @endforeach>
                <input class="no-space"  type="checkbox"  @foreach ($data->disposition as $d) @if ($d->role == 'Sekretaris')checked @endif @endforeach>
                <input class="no-space" type="checkbox"  @foreach ($data->disposition as $d) @if ($d->role == 'Pan. Mud. Hukum') style="background-color: red; border-radius: 5px; color: white; " @endif @endforeach>
                <input class="no-space"  type="checkbox"  @foreach ($data->disposition as $d) @if ($d->role == 'Pan. Mud.Perkara') style="background-color: red; border-radius: 5px; color: white; " @endif @endforeach>
                <input class="no-space" type="checkbox"  @foreach ($data->disposition as $d) @if ($d->role == 'Sub. Bagian Perencanaan, Teknologi Informasi dan Pelaporan') style="background-color: red; border-radius: 5px; color: white; " @endif @endforeach>
                <input  type="checkbox" style="padding-top: 18px;"  @foreach ($data->disposition as $d) @if ($d->role == 'Sub. Bagian Kepegawaian, Organisasi dan Tata Laksana') style="background-color: red; border-radius: 5px; color: white; " @endif @endforeach>
                <input type="checkbox" style="padding-top: 20px;" @foreach ($data->disposition as $d) @if ($d->role == 'Sub. Bagian Umum dan Keuangan') style="background-color: red; border-radius: 5px; color: white; " @endif @endforeach>
            </td>
        </tr>
        <tr>
            <td valign="top" colspan="3" height="100px">
                <h5 class="no-space">DISPOSISI PANITERA :</h5>
                <div class="panitera-instruction">
                @foreach ($data->disposition as $d)
                    @if ($d->role == 'Panitera')
                    <p>- {{$d->instruction}}</p>
                    @endif
                @endforeach
                </div>
            </td>
        </tr>
        <tr>
            <td valign="top" colspan="3" height="100px" style="border-bottom-style: dashed;">
                <h5 class="no-space">DISPOSISI SEKRETARIS :</h5>
                <div class="sekretaris-instruction">
                @foreach ($data->disposition as $d)
                    @if ($d->role == 'Sekretaris')
                    <p>- {{$d->instruction}}</p>
                    @endif
                @endforeach
                </div>
            </td>
        </tr>
        <tr>
            <td valign="top" colspan="3" height="100px" style="border-top-style: dashed;">
                <div style="display: flex; margin-bottom: 3px;">
                    <h5 class="no-space" style="width: 170px;">DISPOSISI PANMUD : </h5>
                    <div class="panmud-instruction" height="100px">
                    @foreach ($data->disposition as $d)
                        @if ($d->role == 'Pan. Mud. Hukum' || $d->role == 'Pan. Mud.Perkara')
                        <p>- {{$d->instruction}}</p>
                        @endif
                    @endforeach
                    </div>
                </div>
                <br>
                <div style="display: flex; margin-bottom: 3px;">
                    <h5 class="no-space" style="width: 170px;">DISPOSISI KASUBAG : </h5>
                    @foreach ($data->disposition as $d)
                        @if ($d->role == 'Sub. Bagian Perencanaan, Teknologi Informasi dan Pelaporan' || $d->role == 'Sub. Bagian Kepegawaian, Organisasi dan Tata Laksana' || $d->role == 'Sub. Bagian Umum dan Keuangan')
                        <p>- {{$d->instruction}}</p>
                        @endif
                    @endforeach
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
