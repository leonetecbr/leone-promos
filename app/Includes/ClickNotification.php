<?php

use App\Models\SendedNotification;

$notification = SendedNotification::find(Request::input('tag'));

if (!empty($notification)) {
    $notification->cliques++;
    $notification->save();
}
