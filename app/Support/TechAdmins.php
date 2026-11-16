<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification;
use Throwable;

/** Utilisateurs Dash3 qui gèrent les techniciens (permission « erp »). */
class TechAdmins
{
    public static function all(): Collection
    {
        try {
            return User::permission('erp')->get();
        } catch (Throwable) {
            // Permission absente (installation neuve) : on se rabat sur le rôle admin
            try {
                return User::role('admin')->get();
            } catch (Throwable) {
                return collect();
            }
        }
    }

    public static function notify($notification): void
    {
        $admins = self::all();
        if ($admins->isNotEmpty()) {
            Notification::send($admins, $notification);
        }
    }
}
