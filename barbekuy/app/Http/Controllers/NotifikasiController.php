<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    /**
     * Tampilkan daftar notifikasi admin + filter.
     */
    public function index(Request $request)
    {
        $admin  = Auth::user();
        $filter = $request->get('filter', 'all');

        // default: semua notifikasi, terbaru di atas
        $query = $admin->notifications()->latest();

        if ($filter === 'unread') {
            $query = $admin->unreadNotifications()->latest();
        } elseif ($filter === 'read') {
            $query = $admin->readNotifications()->latest();
        }

        $notifications = $query->paginate(15);
        $unreadCount   = $admin->unreadNotifications()->count();

        return view('admin.notifikasi', compact('notifications', 'unreadCount', 'filter'));
    }

    /**
     * Tandai 1 notifikasi sebagai sudah dibaca.
     */
    public function markRead(string $id)
    {
        $n = Auth::user()
            ->notifications()
            ->where('id', $id)
            ->firstOrFail();

        if (is_null($n->read_at)) {
            $n->markAsRead();
        }

        return back();
    }

    /**
     * Tandai semua notifikasi yang belum dibaca => sudah dibaca.
     * Dipakai dropdown "Tandai semua dibaca".
     */
    public function markAllRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return back();
    }

    /**
     * Tandai semua notifikasi sebagai BELUM dibaca.
     * Dipakai dropdown "Tandai semua belum dibaca".
     */
    public function markAllUnread()
    {
        $user = Auth::user();

        // Set kolom read_at = null untuk semua notifikasi yang sudah pernah dibaca
        $user->notifications()
            ->whereNotNull('read_at')
            ->update(['read_at' => null]);

        return back();
    }

    /**
     * Hapus satu notifikasi.
     */
    public function destroy(string $id)
    {
        Auth::user()
            ->notifications()
            ->where('id', $id)
            ->delete();

        return back();
    }

    /**
     * Hapus banyak notifikasi (checkbox + popup).
     */
    public function bulkDestroy(Request $request)
    {
        $ids = (array) $request->input('ids', []);

        if (!empty($ids)) {
            Auth::user()
                ->notifications()
                ->whereIn('id', $ids)
                ->delete();
        }

        return back();
    }
}
