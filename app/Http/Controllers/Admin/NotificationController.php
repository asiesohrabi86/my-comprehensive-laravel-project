<?php

namespace App\Http\Controllers\Admin;
use App\Models\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function readAll(Request $request){

        $notifications = Notification::all();
        foreach($notifications as $notification){
            $notification->update(['read_at' => now()]);
        }
    }
}
