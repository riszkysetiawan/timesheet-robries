<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserActivityLog;
use Illuminate\Support\Facades\Auth;

class GlobalActivityObserver
{
    /**
     * Handle the "created" event.
     */
    public function created(Model $model)
    {
        $this->logActivity('created', $model, 'Menambahkan data baru.');
    }

    /**
     * Handle the "updated" event.
     */
    public function updated(Model $model)
    {
        // Ambil perubahan data
        $changes = $model->getChanges();
        $original = $model->getOriginal();

        $details = [];
        foreach ($changes as $key => $value) {
            // Tambahkan perubahan ke dalam detail
            $details[] = "Mengubah {$key} dari '{$original[$key]}' menjadi '{$value}'";
        }

        $this->logActivity('updated', $model, implode(', ', $details));
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(Model $model)
    {
        $this->logActivity('deleted', $model, 'Menghapus data.');
    }

    /**
     * Log activity to the database.
     */
    protected function logActivity($action, Model $model, $details)
    {
        // Jangan log jika model adalah UserActivityLog (untuk menghindari loop)
        if ($model instanceof UserActivityLog) {
            return;
        }

        UserActivityLog::create([
            'user_id' => Auth::check() ? Auth::id() : null, // ID user (jika ada user login)
            'action' => $action, // Action (created, updated, deleted)
            'model' => get_class($model), // Nama model
            'model_id' => $model->getKey(), // ID dari model
            'details' => $details, // Detail perubahan
            'ip_address' => request()->ip(), // IP Address
        ]);
    }
}
