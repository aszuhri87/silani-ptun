<?php

namespace App\Libraries;

use Carbon;

class MonthNameApplicant
{
    public static function chart_data($data)
    {
        try {

            // dd($data);
            $collect = collect(
                Carbon\CarbonPeriod::create(
                    now()->startOfYear(),
                    now()->endOfYear()
                ))
                ->map(function ($data) {
                    $month = $data->format('F');

                    return [
                        'jumlah' => 0,
                        'bulan' => $month,
                    ];
                })
                ->keyBy('bulan')
                ->values()
                ->toArray();

            for ($x = 0; $x < count($collect); ++$x) {
                for ($i = 0; $i < count($data); ++$i) {
                    if ($data[$i]['month_name'] == $collect[$x]['bulan'] && $data[$i]['count']) {
                        $collect[$x]['jumlah'] = $data[$i]['count'];
                    }
                    elseif ($data[$i]['month_name'] == $collect[$x]['bulan']) {
                        $collect[$x]['jumlah'] = 0;
                    }
                }
                $collect[$x]['bulan'] = Carbon\Carbon::parse($collect[$x]['bulan'])->translatedFormat('F');

            }

            return $collect;
        } catch (Exception $e) {
            throw new Exception($e);

            return response([
                'message' => $e->getMessage(),
            ]);
        }
    }
}
