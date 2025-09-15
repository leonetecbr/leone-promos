<?php

use App\Models\SentNotification;

$notification = SentNotification::find(Request::input('tag'));

if (!empty($notification)) {
    $notification->cliques++;
    $notification->save();
}
