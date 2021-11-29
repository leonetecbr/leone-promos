<?php

namespace App\Http\Controllers;

use App\Models\SendedNotification;

class SendedNotificationController extends Controller
{
  public function get($page = 1)
  {
    $sended_notifications = SendedNotification::paginate(10, '*', 'page', $page);
    $notifications = $sended_notifications->items();
    return view('admin.sended_notifications', ['notifications' => $notifications, 'final' => $sended_notifications->lastPage(), 'page' => $page, 'group_name' => 1]);
  }
}
