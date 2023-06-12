<?php

namespace App\Observers;

use App\Models\DispositionDocument;
use App\Models\DispositionUser;
use App\Models\User;
use App\Notifications\NewLetter;

class DispositionObserver
{
    public function created(DispositionDocument $item)
    {
        // $author = $item->user;
        // dd();
        // $disUser = DispositionUser::first();
        // // dd($disUser->id);
        // $users = User::where('id', $disUser->user_id)->get();
        // dd($users);
        // foreach ($users as $user) {
        //     $user->notify(new NewLetter($item, $user, $disUser->id));
        // }
    }
}
