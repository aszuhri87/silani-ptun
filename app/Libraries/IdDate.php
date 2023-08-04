<?php

namespace App\Libraries;

use Carbon\Carbon;
class IdDate{
    public static function translate($date){

        $translating = Carbon::parse($date)->locale('id');

        $translating->settings(['formatFunction' => 'translatedFormat']);

        return $translating;
    }
}
