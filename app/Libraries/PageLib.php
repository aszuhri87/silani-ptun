<?php

namespace App\Libraries;

use DB;
use Illuminate\Support\Facades\Auth;

class PageLib
{
    public static function config($additional = [])
    {
        $notify1 = DB::table('notifications')->where('notifiable_id', Auth::user()->id)->whereNull('read_at')->get();

        $counter1 = [];
        $counter2 = [];
        $counter3 = [];
        $counter4 = [];
        $counter5 = [];
        $counter6 = [];
        $counter7 = [];

        foreach ($notify1 as $item1) {
            // DB::table('notifications')->where('id', $item1->id)
            // ->update(['read_at' => date('Y-m-d H:i:s')]);

            $dat = json_decode($item1->data);
            if ($dat->type == null) {
                $counter1[] = null;
            } else {
                if ($dat->type == 'disposition') {
                    $counter1[] = $item1;
                }

                if ($dat->type == 'exit') {
                    $counter2[] = $item1;
                }

                if ($dat->type == 'leave') {
                    $counter3[] = $item1;
                }

                if ($dat->type == 'outgoing') {
                    $counter4[] = $item1;
                }

                if ($dat->type == 'inbox') {
                    $counter5[] = $item1;
                }

                if ($dat->type == 'done') {
                    $counter6[] = $item1;
                }

                if ($dat->type == 'proceed') {
                    $counter7[] = $item1;
                }
            }
        }

        $disposition_count = count($counter1);
        $exit_count = count($counter2);
        $leave_count = count($counter3);
        $outgoing_count = count($counter4);
        $inbox = count($counter5);
        $done = count($counter6);
        $proceed = count($counter7);

        return collect([
            'disposition_count' => $disposition_count,
            'exit_count' => $exit_count,
            'leave_count' => $leave_count,
            'outgoing_count' => $outgoing_count,
            'inbox' => $inbox,
            'done' => $done,
            'proceed' => $proceed,
        ])->merge($additional)->all();
    }
}
