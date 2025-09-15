<?php

namespace App\Http\Controllers;

use App\Models\SentNotification;
use Illuminate\Contracts\View\View;
use Symfony\Component\Routing\Annotation\Route;

class SentNotificationController extends Controller
{

    /**
     * Lista as notificações enviadas
     */
    #[Route('/notification/history', name: 'notification.history')]
    public function get(): View
    {
        $sent_notifications = SentNotification::orderBy('sent_at', 'DESC')->paginate(10);
        $notifications = $sent_notifications->items();

        return view('admin.sent_notifications', ['notifications' => $notifications, 'endPage' => $sent_notifications->lastPage(), 'groupName' => 1]);
    }
}
