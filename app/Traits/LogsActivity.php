<?php

namespace App\Traits;

use App\Models\ActivityLog;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    /**
     * Log aktivitas user ke database
     */
    public function logActivity(string $activity): void
    {
        if (Auth::check()) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'activity' => $activity,
                'ip_address' => request()->ip(),
            ]);
        }
    }

    /**
     * Buat notifikasi untuk user
     */
    public function createNotification(string $title, string $message, ?int $userId = null): void
    {
        $userId = $userId ?? Auth::id();
        if ($userId) {
            Notification::create([
                'user_id' => $userId,
                'title' => $title,
                'message' => $message,
            ]);
        }
    }

    /**
     * Log aktivitas + Buat notifikasi (gabungan)
     */
    public function logWithNotification(string $activity, string $notifTitle, string $notifMessage, ?int $userId = null): void
    {
        $this->logActivity($activity);
        $this->createNotification($notifTitle, $notifMessage, $userId);
    }
}
