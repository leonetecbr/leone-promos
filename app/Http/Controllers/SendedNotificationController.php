<?php

namespace App\Http\Controllers;

use App\Models\SendedNotification;
use Illuminate\Contracts\View\View;
use Symfony\Component\Routing\Annotation\Route;

class SendedNotificationController extends Controller
{

    /**
     * Lista as notificações enviadas
     * @paramint $page
     * @param int $page
     * @return View
     */
    #[Route('/notification/history/{page?}', name: 'notification.history')]
    public function get(int $page = 1): View
    {
        $sended_notifications = SendedNotification::orderBy('sended_at', 'DESC')->paginate(10, '*', 'page', $page);
        $notifications = $sended_notifications->items();
        return view('admin.sended_notifications', ['notifications' => $notifications, 'endPage' => $sended_notifications->lastPage(), 'page' => $page, 'groupName' => 1]);
    }
}
