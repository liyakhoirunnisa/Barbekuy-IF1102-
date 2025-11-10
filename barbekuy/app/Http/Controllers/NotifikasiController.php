<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index(Request $request)
    {
        $admin  = Auth::user();
        $filter = $request->get('filter', 'all');

        $query = $admin->notifications()->latest();
        if ($filter === 'unread') $query = $admin->unreadNotifications()->latest();
        if ($filter === 'read')   $query = $admin->readNotifications()->latest();

        $notifications = $query->paginate(15);
        $unreadCount   = $admin->unreadNotifications()->count();

        return view('admin.notifikasi', compact('notifications', 'unreadCount', 'filter'));
    }

    public function markRead(string $id)
    {
        $n = Auth::user()->notifications()->where('id', $id)->firstOrFail();
        if (is_null($n->read_at)) $n->markAsRead();
        return back();
    }

    public function markAllRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back();
    }

    public function destroy(string $id)
    {
        Auth::user()->notifications()->where('id', $id)->delete();
        return back();
    }

    public function bulkDestroy(Request $request)
    {
        $ids = (array)$request->input('ids', []);
        if (!empty($ids)) {
            Auth::user()->notifications()->whereIn('id', $ids)->delete();
        }
        return back();
    }
}
