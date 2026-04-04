<?php

namespace App\Http\Controllers;

use App\Models\AdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminNotificationController extends Controller
{
    public function read(Request $request, AdminNotification $notification)
    {
        $actor = Auth::user();

        if (!$actor || !in_array($actor->role, ['admin', 'apex'], true)) {
            abort(403);
        }

        if (
            $notification->recipient_role !== $actor->role ||
            (int) $notification->recipient_id !== (int) $actor->id
        ) {
            abort(403);
        }

        if (!$notification->is_read) {
            $notification->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
        ]);
    }
}
