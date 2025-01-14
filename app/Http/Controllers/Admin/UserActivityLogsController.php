<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\user_activity_logs;
use App\Http\Requests\Storeuser_activity_logsRequest;
use App\Http\Requests\Updateuser_activity_logsRequest;
use App\Models\Kategori;
use App\Http\Requests\StoreKategoriRequest;
use App\Http\Requests\UpdateKategoriRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\KategoriExport;
use App\Models\UserActivityLog;
use Maatwebsite\Excel\Facades\Excel;


class UserActivityLogsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Ambil parameter start_date dan end_date jika ada
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            $activities = UserActivityLog::with('user') // Mengambil data relasi user
                ->select('user_activity_logs.*');

            // Filter berdasarkan rentang tanggal jika ada
            if ($startDate && $endDate) {
                $activities->whereBetween('created_at', [$startDate, $endDate]);
            }

            return DataTables::of($activities)
                ->addIndexColumn() // Tambahkan kolom nomor urut
                ->addColumn('user', function ($activity) {
                    // Tampilkan nama user
                    return $activity->user ? $activity->user->nama : 'Guest';
                })
                ->addColumn('model', function ($activity) {
                    // Nama model yang terlibat
                    return $activity->model ?? '-';
                })
                ->addColumn('details', function ($activity) {
                    if ($activity->details) {
                        // Escape HTML dan tambahkan line break (untuk teks multi-line)
                        return nl2br(e($activity->details));
                    }
                    return '-'; // Jika tidak ada detail
                })
                ->addColumn('action', function ($activity) {
                    $deleteUrl = route('history.admin.destroy', Crypt::encryptString($activity->id));
                    return '
                        <a class="btn btn-outline-danger btn-rounded mb-2 me-4" href="javascript:void(0)" onclick="confirmDelete(' . $activity->id . ')" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6l-2 14H7L5 6"></path>
                                <path d="M10 11v6"></path>
                                <path d="M14 11v6"></path>
                            </svg>
                            Delete
                        </a>';
                })
                ->rawColumns(['details', 'action']) // Render kolom details dan action sebagai HTML
                ->make(true);
        }

        return view('superadmin.history.index');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Storeuser_activity_logsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($user_activity_logs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($user_activity_logs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($request,  $user_activity_logs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $id = Crypt::decryptString($id);
            $log = UserActivityLog::findOrFail($id);
            $log->delete();

            return response()->json(['status' => 'success', 'message' => 'Log berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan saat menghapus log'], 500);
        }
    }
}
