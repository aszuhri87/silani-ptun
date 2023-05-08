<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        img{
            display: inherit;
            position: absolute;
            left: 20px;
            width: 80px;
            top: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row mt-2">
        <div class="col-2">
            <img src="data:image/png;base64,{{ $logo ?? null }}" alt="Logo">
       </div>
       <div class="col-10" style="text-align: center; margin-left: 10%;">
           <div>
               <h3 style="font-family: 'Times New Roman', Times, serif; font-weight: 700; "><b>PENGADILAN TATA USAHA NEGARA YOGYAKARTA </b></h3>
               <p style="font-size:11px; font-family: 'Arial'; font-weight: 700;">Jl. Janti No.66 Banguntapan Telp. (0274) 520502 Faks. (0274)581675 <br>
               Yogyakarta 5518</p>

               <p style="font-size:11px; font-family: 'Arial';">Website: www.ptun-yogyakarta.go.id Email: info@ptun-yogyakarta.go.id</p>
           </div>
       </div>
   </div>
   <hr id="garis" style="border: solid black; ">
   <div class="text-center">
       <h3 style="font-family: 'Times New Roman', Times, serif; font-weight: 700; text-align:center;"> SURAT IJIN KELUAR KANTOR
       </h3>
   </div>

   <div style="font-family: 'Times New Roman', Times, serif; margin-left: 3%; margin-top: 5%;">
       Pejabat  : <br>
       {{$data->name}}
       <hr style="border: dotted black; border-top:none;">
       <hr style="border: dotted black; border-top:none;">

       <p> Memberikan izin keluar kantor kepada:</p>
       <table style="margin-bottom: 10%;">
           <tr>
               <td>
                   <p style="padding: 1; margin: 1;  white-space:0;"> Nama </p>
               </td>
               <td>
                : {{$data->name}}
               </td>
           </tr>
           <tr>
               <td>
                   <p style="padding: 1; margin: 1;  white-space:0;"> NIP/Gol.</p>
               </td>
               <td>
                : {{$data->nip.' / '.$data->gol}}
               </td>
           </tr>
           <tr>
               <td>
                   <p style="padding: 1; margin: 1;  white-space:0;"> Unit Kerja</p>
               </td>
               <td>
                : {{$data->unit}}
               </td>
           </tr>
           <tr>
               <td>
                   <p style="padding: 1; margin: 1;  white-space:0;"> Pada</p>
               </td>
               <td>
               </td>
           </tr>
           <tr>
               <td>
                   <p style="padding: 1; margin: 1;  white-space:0;"> Hari/tanggal</p>
               </td>
               <td>
                : {{$data->date}}
               </td>
           </tr>
           <tr>
               <td>
                   <p style="padding: 1; margin: 1;  white-space:0;"> Jam</p>
               </td>
               <td>
                : {{$data->time}}
               </td>
           </tr>
           <tr>
               <td>
                   <p style="padding: 1; margin: 1;  white-space:0;"> Untuk Keperluan</p>
               </td>
               <td>
                : {{$data->reason}} <br>
               </td>
           </tr>
       </table>
       <table style="margin-left: 55%; padding: 10px;">
           <tr>
               <td></td>
               <!-- <td></td> -->
               <td class="">
                   <div class="d-flex" style="white-space: nowrap;">
                      <p style="margin-bottom: 1; white-space:0;"> Yogyakarta, {{$data->date}} </p>
                   </div>
               </td>
           </tr>
           <tr>
               <td></td>
               <!-- <td></td> -->
               <!-- <td></td> -->
               <td style="white-space: nowrap;">
                    Pejabat yang memberikan izin: <br>
                    {{$data->approver}}
               </td>
           </tr>
           <tr>
               <td></td>
               <td></td>
               <!-- <td></td> -->
               <td>
                <div style="display:inline-block;">
                    @if ($signature)
                    <img src="data:image/png;base64,{{ $signature ?? null }}"
                    style="margin-left: 60%; margin-top: 95%; width: auto; height: 60px;">
                    @else
                    <div style="margin-left: 60%; margin-top: 95%; width: auto; height: 60px;"></div>
                    @endif
                </div>
               </td>
           </tr>
           <tr>
               <td></td>
               <!-- <td></td> -->
               <!-- <td></td> -->
               <td style="white-space: nowrap;">
                   <p style="margin-top: 100px; text-align:center;"> ( {{$data->name}} )</p>
               </td>
           </tr>
       </table>
   </div>
</div>

</body>
</html>
