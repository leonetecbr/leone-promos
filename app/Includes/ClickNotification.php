<?php

use App\Models\SendedNotification;

$notification = SendedNotification::where('id', Request::input('tag'))->first();

if (!empty($notification)) {
    $notification->cliques++;
    $notification->save();
}
