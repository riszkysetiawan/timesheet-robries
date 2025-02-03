<?php

namespace App\Http\Controllers\OperatorProduksi;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Production;
use App\Http\Requests\StoreProductionRequest;
use App\Http\Requests\UpdateProductionRequest;
use App\Models\Produk;
use App\Models\DetailProduction;
use Illuminate\Support\Facades\DB;
use App\Models\Warna;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PDF;
use Illuminate\Support\Facades\Validator;
use App\Exports\ProductionExport;
use App\Imports\ProductionImport;
use App\Models\Oven;
use App\Models\Proses;
use App\Models\Size;
use App\Models\Timer;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProductionOperatorProduksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Ambil data dari tabel production beserta timers dan proses
            $productions = Production::with(['timers.proses', 'timers.user', 'warna', 'size', 'produk'])
                ->orderBy('tgl_production', 'desc')
                ->select('production.*'); // Pastikan mengambil data dari production table

            // Filter berdasarkan tanggal jika ada
            if ($request->has('startDate') && $request->has('endDate')) {
                $startDate = Carbon::parse($request->input('startDate'))->startOfDay();
                $endDate = Carbon::parse($request->input('endDate'))->endOfDay();
                $productions = $productions->whereBetween('tgl_production', [$startDate, $endDate]);
            }

            return DataTables::of($productions)
                ->addIndexColumn() // Menambahkan index untuk DataTables
                ->filter(function ($query) use ($request) {
                    // Logika pencarian (searching)
                    if ($request->has('search') && $request->search['value']) {
                        $search = $request->search['value'];
                        $query->where(function ($q) use ($search) {
                            $q->where('so_number', 'like', "%{$search}%") // Pencarian berdasarkan SO Number
                                ->orWhere('barcode', 'like', "%{$search}%") // Pencarian berdasarkan Barcode
                                ->orWhereHas('warna', function ($q) use ($search) { // Pencarian berdasarkan Warna
                                    $q->where('warna', 'like', "%{$search}%");
                                })
                                ->orWhereHas('size', function ($q) use ($search) { // Pencarian berdasarkan Ukuran
                                    $q->where('size', 'like', "%{$search}%");
                                })
                                ->orWhereHas('timers.user', function ($q) use ($search) { // Pencarian berdasarkan Nama User
                                    $q->where('nama', 'like', "%{$search}%");
                                });
                        });
                    }
                })


                ->addColumn('action', function ($row) {
                    $tambahTimer = route('timer-start.production.operator-produksi', Crypt::encryptString($row->id));
                    return '
                        <a href="' . $tambahTimer . '" class="btn btn-outline-primary btn-rounded mb-2 me-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                            Mulai Timer
                        </a>
                        ';
                })
                ->addColumn('warna', function ($row) {
                    return $row->warna ? $row->warna->warna : '-'; // Access the 'warna' attribute from the related model
                })
                // ->addColumn('keterangan', function ($row) {
                //     return $row->finish_rework ? '-' : '';
                // })

                ->addColumn('size', function ($row) {
                    return $row->size ? $row->size->size : '-';
                })

                ->addColumn('oven_start', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 1); // Oven Start
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('oven_start_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 1); // Oven Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })

                ->addColumn('oven_finish', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 2); // Oven Finish
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('oven_finish_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 2); // Oven Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })

                ->addColumn('oven_duration', function ($row) {
                    $start = $row->timers->firstWhere('id_proses', 1); // Oven Start
                    $finish = $row->timers->firstWhere('id_proses', 2); // Oven Finish

                    if ($start && $finish) {
                        $startTime = \Carbon\Carbon::parse($start->waktu);
                        $finishTime = \Carbon\Carbon::parse($finish->waktu);
                        return $startTime->diffForHumans($finishTime, true); // Menghitung selisih waktu
                    }
                    return '-';
                })
                ->addColumn('press_start', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 3); // Press Start
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('press_start_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 3); // Press Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('press_finish', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 4); // Press Finish
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('press_finish_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 4); // Oven Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('press_duration', function ($row) {
                    $start = $row->timers->firstWhere('id_proses', 3); // Press Start
                    $finish = $row->timers->firstWhere('id_proses', 4); // Press Finish

                    if ($start && $finish) {
                        $startTime = \Carbon\Carbon::parse($start->waktu);
                        $finishTime = \Carbon\Carbon::parse($finish->waktu);
                        return $startTime->diffForHumans($finishTime, true); // Menghitung selisih waktu
                    }
                    return '-';
                })
                ->addColumn('wbs_start', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 5); // WBS Start
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('wbs_start_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 5); // Oven Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('wbs_finish', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 6); // WBS Finish
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('wbs_finish_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 6); // Oven Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('wbs_duration', function ($row) {
                    $start = $row->timers->firstWhere('id_proses', 5); // WBS Start
                    $finish = $row->timers->firstWhere('id_proses', 6); // WBS Finish

                    if ($start && $finish) {
                        $startTime = \Carbon\Carbon::parse($start->waktu);
                        $finishTime = \Carbon\Carbon::parse($finish->waktu);
                        return $startTime->diffForHumans($finishTime, true); // Menghitung selisih waktu
                    }
                    return '-';
                })
                ->addColumn('weld_start', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 7); // WELD Start
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('weld_start_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 7); // WELD Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('weld_finish', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 8); // WELD Finish
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('weld_finish_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 8); // Oven Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('weld_duration', function ($row) {
                    $start = $row->timers->firstWhere('id_proses', 7); // WBS Start
                    $finish = $row->timers->firstWhere('id_proses', 8); // WBS Finish

                    if ($start && $finish) {
                        $startTime = \Carbon\Carbon::parse($start->waktu);
                        $finishTime = \Carbon\Carbon::parse($finish->waktu);
                        return $startTime->diffForHumans($finishTime, true); // Menghitung selisih waktu
                    }
                    return '-';
                })
                ->addColumn('vbs_start', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 9); // VBS Start
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('vbs_start_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 9); // VBS Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('vbs_finish', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 10); // VBS Finish
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('vbs_finish_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 10); // Oven Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('vbs_duration', function ($row) {
                    $start = $row->timers->firstWhere('id_proses', 9); // WBS Start
                    $finish = $row->timers->firstWhere('id_proses', 10); // WBS Finish

                    if ($start && $finish) {
                        $startTime = \Carbon\Carbon::parse($start->waktu);
                        $finishTime = \Carbon\Carbon::parse($finish->waktu);
                        return $startTime->diffForHumans($finishTime, true); // Menghitung selisih waktu
                    }
                    return '-';
                })
                ->addColumn('hbs_start', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 11); // HBS Start
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('hbs_start_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 11); // HBS Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('hbs_finish', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 12); // HBS Finish
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('hbs_finish_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 12); // Oven Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('hbs_duration', function ($row) {
                    $start = $row->timers->firstWhere('id_proses', 10); // WBS Start
                    $finish = $row->timers->firstWhere('id_proses', 11); // WBS Finish

                    if ($start && $finish) {
                        $startTime = \Carbon\Carbon::parse($start->waktu);
                        $finishTime = \Carbon\Carbon::parse($finish->waktu);
                        return $startTime->diffForHumans($finishTime, true); // Menghitung selisih waktu
                    }
                    return '-';
                })
                ->addColumn('poles_start', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 13); // HBS Finish
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('poles_start_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 13); // Oven Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('poles_finish', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 14); // HBS Finish
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('poles_finish_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 14); // Oven Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('poles_duration', function ($row) {
                    $start = $row->timers->firstWhere('id_proses', 13); // WBS Start
                    $finish = $row->timers->firstWhere('id_proses', 14); // WBS Finish

                    if ($start && $finish) {
                        $startTime = \Carbon\Carbon::parse($start->waktu);
                        $finishTime = \Carbon\Carbon::parse($finish->waktu);
                        return $startTime->diffForHumans($finishTime, true); // Menghitung selisih waktu
                    }
                    return '-';
                })
                ->addColumn('assembly_start', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 15); // HBS Finish
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('assembly_start_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 15); // Oven Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('assembly_finish', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 16); // HBS Finish
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('assembly_finish_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 16); // Oven Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('assembly_duration', function ($row) {
                    $start = $row->timers->firstWhere('id_proses', 15); // WBS Start
                    $finish = $row->timers->firstWhere('id_proses', 16); // WBS Finish

                    if ($start && $finish) {
                        $startTime = \Carbon\Carbon::parse($start->waktu);
                        $finishTime = \Carbon\Carbon::parse($finish->waktu);
                        return $startTime->diffForHumans($finishTime, true); // Menghitung selisih waktu
                    }
                    return '-';
                })
                ->addColumn('finishing_start', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 17); // HBS Finish
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('finishing_start_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 17); // Oven Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('finishing_finish', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 18); // HBS Finish
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('finishing_finish_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 18); // Oven Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('finishing_duration', function ($row) {
                    $start = $row->timers->firstWhere('id_proses', 17); // WBS Start
                    $finish = $row->timers->firstWhere('id_proses', 18); // WBS Finish

                    if ($start && $finish) {
                        $startTime = \Carbon\Carbon::parse($start->waktu);
                        $finishTime = \Carbon\Carbon::parse($finish->waktu);
                        return $startTime->diffForHumans($finishTime, true); // Menghitung selisih waktu
                    }
                    return '-';
                })
                ->addColumn('rework_start', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 19); // Finish Rework
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('rework_start_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 19); // Oven Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('rework_finish', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 20); // Finish Rework
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('rework_finish_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 20); // Oven Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('rework_duration', function ($row) {
                    $start = $row->timers->firstWhere('id_proses', 19); // WBS Start
                    $finish = $row->timers->firstWhere('id_proses', 20); // WBS Finish

                    if ($start && $finish) {
                        $startTime = \Carbon\Carbon::parse($start->waktu);
                        $finishTime = \Carbon\Carbon::parse($finish->waktu);
                        return $startTime->diffForHumans($finishTime, true); // Menghitung selisih waktu
                    }
                    return '-';
                })
                ->addColumn('progress', function ($row) {
                    // Periksa apakah rework_finish memiliki nilai "Finish"
                    $reworkFinishTimer = $row->timers->firstWhere('id_proses', 20); // Rework Finish
                    if ($reworkFinishTimer && $reworkFinishTimer->status == 'Finish') {
                        return '100%'; // Jika rework_finish adalah "Finish", progress = 100%
                    }

                    // Jika tidak, gunakan nilai progress dari row atau default 0%
                    return $row->progress ? number_format($row->progress, 1) . ' %' : '0 %';
                })

                ->make(true);
        }

        return view('operator-produksi.production.index');
    }


    public function downloadExcel(Request $request)
    {
        \Log::info("Request Parameters: ", $request->all()); // Logging
        $startDate = $request->query('startDate'); // Pastikan ini konsisten dengan parameter di URL
        $endDate = $request->query('endDate');

        if ($startDate && $endDate) {
            try {
                $startDate = Carbon::parse($startDate)->startOfDay();
                $endDate = Carbon::parse($endDate)->endOfDay();
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Tanggal tidak valid.');
            }
        } else {
            // Jika tidak ada filter tanggal, set $startDate dan $endDate ke null
            $startDate = null;
            $endDate = null;
        }

        // Panggil export dengan parameter tanggal (bisa null)
        return Excel::download(new ProductionExport($startDate, $endDate), 'production.xlsx');
    }



    public function getBarangByBarcode($barcode)
    {
        // Cari barang berdasarkan barcode
        $produk = Produk::with('warna')->where('kode_barcode', $barcode)->first();

        if ($produk) {
            return response()->json([
                'kode_produk' => $produk->kode_produk,
                'harga' => $produk->harga,
                'warna' => $produk->warna->warna
            ]);
        }

        return response()->json(null);
    }


    public function getProduk($kode_produk)
    {
        $produk = Produk::with('warna')->where('kode_produk', $kode_produk)->first();

        if ($produk) {
            return response()->json([
                'produk' => $produk,
                'warna' => $produk->warna->warna // Kirim data satuan juga
            ]);
        } else {
            return response()->json(['message' => 'produk tidak ditemukan'], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produks = Produk::all();
        $warnas = Warna::all();
        $prosess = Proses::all();
        $sizes = Size::all();
        return view('operator-produksi.production.create', compact('produks', 'warnas', 'sizes', 'prosess'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'so_number.*' => 'required',
            'tgl_production' => 'required|date',
            // 'kode_produk.*' => 'required|exists:produk,kode_produk', // Pastikan kode produk ada di tabel produk
            'qty.*' => 'required|string',
            'nama_produk.*' => 'required|string',
            'warna.*' => 'required|string',
            'size.*' => 'required|string',
            'barcode.*' => 'required|string',
        ], [
            'so_number.*.required' => 'Nomor SO wajib diisi.',
            'tgl_production.required' => 'Tanggal produksi wajib diisi.',
            'tgl_production.date' => 'Tanggal produksi harus berupa tanggal yang valid.',
            // 'kode_produk.*.required' => 'Kode produk wajib diisi.',
            // 'kode_produk.*.exists' => 'Kode produk tidak ditemukan di dalam database.',
            'nama_produk.*.required' => 'Kode produk wajib diisi.',
            'qty.*.required' => 'Kuantitas wajib diisi.',
            'warna.*.required' => 'Warna wajib diisi.',
            'size.*.required' => 'Ukuran wajib diisi.',
            'barcode.*.required' => 'Barcode wajib diisi.',
        ]);


        try {
            DB::beginTransaction();

            // Ambil ID User dari sesi login
            $id_user = Auth::id();

            // Simpan data ke tabel production
            foreach ($request->so_number as $key => $so_number) {
                // Simpan setiap data sebagai satu row di tabel production
                $production = new Production();
                $production->so_number = $so_number;
                $production->tgl_production = $request->tgl_production;
                $production->id_size = $request->size[$key];
                $production->id_color = $request->warna[$key];
                $production->qty = $request->qty[$key];
                $production->barcode = $request->barcode[$key];
                $production->nama_produk = $request->nama_produk[$key]; // Setiap item dari array
                $production->finish_rework = null;
                $production->progress = null;
                $production->save();
            }

            // Commit Transaksi
            DB::commit();

            // Enkripsi SO Number
            $encryptedSoNumber = Crypt::encryptString($request->so_number[0]);

            // Kembalikan Response JSON
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan!',
                'encrypted_so_number' => $encryptedSoNumber,
            ]);
        } catch (\Exception $e) {
            // Rollback Transaksi jika Ada Error
            DB::rollBack();

            // Logging Error
            \Log::error('Error saat menyimpan data production: ' . $e->getMessage());

            // Kembalikan Response Error
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function uploadFile()
    {
        return view('operator-produksi.production.upload');
    }
    public function uploadExcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls|max:20480'
        ], [
            'file.required' => 'File Excel wajib diunggah.',
            'file.mimes' => 'Format file harus berupa .xlsx atau .xls.',
            'file.max' => 'Ukuran file tidak boleh lebih dari 20MB.'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        Excel::import(new ProductionImport, $request->file('file'));
        return response()->json([
            'status' => 'success',
            'message' => 'Data Produksi berhasil diupload!'
        ], 200);
    }
    /**
     * Display the specified resource.
     */
    public function show($encryptedId)
    {
        try {
            $id = Crypt::decryptString($encryptedId);
            $production = Production::with('detailProductions')->findOrFail($id);
            $produks = Produk::all();
            $warnas = Warna::all();
            return view('operator-produksi.production.detail', compact('produks', 'produks', 'warnas'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $decryptedId = Crypt::decryptString($id);
        $production = Production::findOrFail($decryptedId);
        $produks = Produk::all();
        $sizes = Size::all();
        $warnas = Warna::all();
        return view('operator-produksi.production.update', compact('production', 'produks', 'sizes', 'warnas'));
    }
    public function editTimer($id)
    {
        $decryptedId = Crypt::decryptString($id);
        $production = Production::findOrFail($decryptedId);
        $produks = Produk::all();
        $sizes = Size::all();
        $warnas = Warna::all();
        $prosess = Proses::all();
        // dd($prosess);
        return view('operator-produksi.production.updatetimer', compact('production', 'produks', 'sizes', 'warnas', 'prosess'));
    }
    public function updateTimer(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'timer_id' => 'required|exists:timer,id',
                'waktu' => 'required|date_format:Y-m-d H:i:s', // Format waktu harus sesuai
            ]);

            // Update timer
            $timer = Timer::findOrFail($validated['timer_id']);
            $timer->waktu = $validated['waktu'];
            $timer->updated_at = now();
            $timer->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Waktu timer berhasil diperbarui!',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal: ' . implode(', ', $e->errors()),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function deleteTimer(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'timer_id' => 'required|exists:timers,id', // Pastikan tabel dan kolom sesuai
            ]);

            // Cari timer berdasarkan ID
            $timer = Timer::findOrFail($validated['timer_id']);
            $timer->delete(); // Hapus timer

            return response()->json([
                'status' => 'success',
                'message' => 'Timer berhasil dihapus!',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal: ' . implode(', ', $e->errors()),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function updateFinishRework(Request $request, $id)
    {
        $decryptedId = Crypt::decryptString($id);

        // Find the production entry
        $production = Production::findOrFail($decryptedId);

        // Validate the incoming request
        $request->validate([
            'finish_rework' => 'required|in:Finish,Rework,Reject',
            'catatan' => 'nullable|string|max:255', // Ensure catatan is a string and has a max length
        ]);

        // Update progress based on finish_rework value
        switch ($request->finish_rework) {
            case 'Finish':
                $production->progress = 100;
                break;
            case 'Rework':
                $production->progress = max(0, $production->progress - 30);
                break;
            case 'Reject':
                $production->progress = max(0, $production->progress - 30);
                break;
        }

        // Update the finish_rework and catatan fields
        $production->finish_rework = $request->finish_rework;
        $production->catatan = $request->catatan;
        $production->save();

        // Return success response
        return response()->json(['status' => 'success', 'message' => 'Finish/Rework status updated successfully']);
    }



    public function timer($id)
    {
        $decryptedId = Crypt::decryptString($id);

        // Ambil data production
        $production = Production::findOrFail($decryptedId);

        // Hitung total proses
        $totalProses = 18;
        if ($production->finish_rework === 'Rework') {
            $totalProses += 2; // Tambahkan 2 untuk Rework Start dan Rework Finish
        }

        // Ambil semua proses yang sudah selesai
        $completedProses = Timer::where('id_production', $decryptedId)
            ->distinct('id_proses')
            ->count('id_proses');

        // Hitung progres awal
        $progress = ($completedProses / $totalProses) * 100;

        // Sesuaikan progres jika finish_rework adalah Rework atau Finishing Finish selesai
        if ($production->finish_rework === 'Rework') {
            $progress -= 30; // Kurangi 30% untuk Rework
        }

        // Cek apakah Finishing Finish selesai
        $isFinishingFinished = Timer::where('id_production', $decryptedId)
            ->where('id_proses', 18) // ID untuk Finishing Finish
            ->exists();

        if ($isFinishingFinished) {
            $progress += 30; // Tambahkan 30% jika Finishing selesai
        }

        // Pastikan progres tidak kurang dari 0% atau lebih dari 100%
        $progress = max(0, min(100, $progress));

        // Simpan progres ke dalam kolom production
        $production->progress = $progress;
        $production->save();
        $processTimers = Timer::where('id_production', $decryptedId)
            ->with('user') // Pastikan ada relasi dengan user
            ->get()
            ->keyBy('id_proses');
        // Ambil semua proses dengan status selesai atau belum
        $prosess = Proses::all()->map(function ($proses) use ($decryptedId) {
            $proses->is_done = Timer::where('id_production', $decryptedId)
                ->where('id_proses', $proses->id)
                ->exists();
            return $proses;
        });

        // Jika finish_rework adalah Rework, tambahkan proses Rework Start dan Rework Finish
        if ($production->finish_rework === 'Rework') {
            $reworkProcesses = Proses::whereIn('id', [19, 20])->get();
            $prosess = $prosess->concat($reworkProcesses);
        }

        // Ambil semua data lain
        $produks = Produk::all();
        $sizes = Size::all();
        $warnas = Warna::all();
        $users = User::whereHas('role', function ($query) {
            $query->whereIn('nama', ['Operator Produksi', 'Quality Control']);
        })->get();
        $ovens =  Oven::all();
        return view('operator-produksi.production.timer', compact(
            'production',
            'produks',
            'users',
            'sizes',
            'warnas',
            'prosess',
            'ovens',
            'processTimers'
        ));
    }

    public function timerbarcode($barcode)
    {
        // Decode the barcode to handle encoded characters
        $decodedBarcode = urldecode($barcode);

        \Log::info("Received Barcode: " . $decodedBarcode);

        try {
            // Query the database with the decoded barcode
            $production = Production::where('barcode', $decodedBarcode)->firstOrFail();
            \Log::info("Production Data Found: " . $production->id); // Debugging log

            // Hitung total proses
            $totalProses = 18;
            if ($production->finish_rework === 'Rework') {
                $totalProses += 2; // Tambahkan 2 untuk Rework Start dan Rework Finish
            }

            // Ambil semua proses yang sudah selesai
            $completedProses = Timer::where('id_production', $production->id)
                ->distinct('id_proses')
                ->count('id_proses');

            // Hitung progres
            $progress = ($completedProses / $totalProses) * 100;

            // Sesuaikan progres jika finish_rework adalah Rework atau Finishing Finish selesai
            if ($production->finish_rework === 'Rework') {
                $progress -= 30; // Kurangi 30% untuk Rework
            }

            // Cek apakah Finishing Finish selesai
            $isFinishingFinished = Timer::where('id_production', $production->id)
                ->where('id_proses', 18)
                ->exists();

            if ($isFinishingFinished) {
                $progress += 30;
            }

            // Pastikan progres tidak kurang dari 0% atau lebih dari 100%
            $progress = max(0, min(100, $progress));

            // Simpan progres
            $production->progress = $progress;
            $production->save();

            // Fetch processes and their status
            $prosess = Proses::all()->map(function ($proses) use ($production) {
                $proses->is_done = Timer::where('id_production', $production->id)
                    ->where('id_proses', $proses->id)
                    ->exists();
                return $proses;
            });

            // Jika finish_rework adalah Rework, tambahkan proses Rework
            if ($production->finish_rework === 'Rework') {
                $reworkProcesses = Proses::whereIn('id', [19, 20])->get();
                $prosess = $prosess->concat($reworkProcesses);
            }

            // Ambil data timer dengan relasi user
            $processTimers = Timer::where('id_production', $production->id)
                ->with('user')
                ->get()
                ->keyBy('id_proses');
            $users = User::whereHas('role', function ($query) {
                $query->whereIn('nama', ['Operator Produksi', 'Quality Control']);
            })->get();

            $produks = Produk::all();
            $sizes = Size::all();
            $warnas = Warna::all();
            $ovens =  Oven::all();

            // Return the desired view
            return view('operator-produksi.production.timer', compact(
                'production',
                'produks',
                'sizes',
                'warnas',
                'prosess',
                'users',
                'ovens',
                'processTimers'
            ));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error("Production data not found for barcode: " . $decodedBarcode);
            return response()->view('errors.404', [], 404);
        } catch (\Exception $e) {
            \Log::error("Error in timerbarcode: " . $e->getMessage());
            return response()->view('errors.500', [], 500);
        }
    }


    public function startTimer(Request $request)
    {
        try {
            $validated = $request->validate([
                'process_id' => 'required|exists:proses,id',
                'production_id' => 'required|exists:production,id',
                'id_user' => 'required|exists:users,id',
                'id_oven' => 'nullable|exists:oven,id',
                'manual_time' => 'nullable|date', // Validasi waktu manual jika ada
            ]);

            $productionId = $validated['production_id'];
            $processId = $validated['process_id'];
            $userId = $validated['id_user'];
            $ovenId = $validated['id_oven'] ?? null;

            // Gunakan waktu manual jika ada, jika tidak gunakan `now()`
            $time = $validated['manual_time']
                ? Carbon::parse($validated['manual_time'])->setTimezone('Asia/Jakarta')
                : now()->setTimezone('Asia/Jakarta');

            $existingTimer = Timer::where('id_production', $productionId)
                ->where('id_proses', $processId)
                ->exists();

            if ($existingTimer) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Timer untuk proses ini sudah dimulai sebelumnya.',
                ], 400);
            }

            // Simpan timer baru
            Timer::create([
                'id_proses' => $processId,
                'id_production' => $productionId,
                'id_users' => $userId,
                'id_oven' => $ovenId,
                'waktu' => $time,
                'created_at' => $time,
                'updated_at' => $time,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Timer berhasil dimulai!',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal: ' . implode(', ', $e->errors()),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $encryptedId)
    {
        try {
            // Dekripsi ID
            $id = Crypt::decryptString($encryptedId);

            // Validasi input
            $request->validate([
                'so_number' => 'required',
                // 'kode_produk' => 'required|exists:produk,kode_produk', // Pastikan kode produk ada di tabel produk
                'nama_produk' => 'required', // Pastikan kode produk ada di tabel produk
                'qty' => 'required|string',
                'warna' => 'required|string',
                'size' => 'required|string',
                'barcode' => 'required|string',
            ], [
                'so_number.required' => 'Nomor SO wajib diisi.',
                'tgl_production.required' => 'Tanggal produksi wajib diisi.',
                'tgl_production.date' => 'Tanggal produksi harus berupa tanggal yang valid.',
                'nama_produk.required' => 'Kode produk wajib diisi.',
                // 'kode_produk.exists' => 'Kode produk tidak ditemukan di dalam database.',
                'qty.required' => 'Kuantitas wajib diisi.',
                'warna.required' => 'Warna wajib diisi.',
                'size.required' => 'Ukuran wajib diisi.',
                'barcode.required' => 'Barcode wajib diisi.',
            ]);

            DB::beginTransaction();

            // Cari data production berdasarkan ID
            $production = Production::findOrFail($id);
            $production->so_number = $request->so_number;
            // $production->tgl_production = $request->tgl_production;
            $production->id_size = $request->size;
            $production->id_color = $request->warna;
            $production->qty = $request->qty;
            $production->barcode = $request->barcode;
            $production->nama_produk = $request->nama_produk;
            $production->save();

            DB::commit();

            // Kembalikan Response JSON
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil diperbarui!',
            ]);
        } catch (\Exception $e) {
            // Rollback Transaksi jika Ada Error
            DB::rollBack();

            // Logging Error
            \Log::error('Error saat memperbarui data production: ' . $e->getMessage());

            // Kembalikan Response Error
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function printSelected(Request $request)
    {
        // Fetch selected rows based on IDs
        $selectedIds = $request->input('selected_ids'); // This is an array of IDs passed from the front end
        $data = [];

        // Example: Fetch data from your production model with relationships
        $selectedProductions = Production::with(['produk', 'warna', 'size'])->whereIn('id', $selectedIds)->get();

        foreach ($selectedProductions as $item) {
            $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($item->barcode);

            $data[] = [
                'company_name' => 'ROBRIES',
                'tagline' => 'Providing Sustainable Living',
                'so_number' => $item->so_number,
                'size' => $item->size->size ?? 'N/A', // Access size name from the relationship
                'color' => $item->warna->warna ?? 'N/A', // Access color name from the relationship
                'barcode' => $item->barcode,
                'qty' => $item->qty,
                'nama_produk' => $item->nama_produk,
                'date' => now()->format('d/m/Y'),
                'batch_number' => '001',
                'qr_code_url' => $qrCodeUrl,
            ];
        }

        // Render the view for printing
        return view('operator-produksi.production.print', compact('data'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $production = Production::find($id);
        if (!$production) {
            return response()->json([
                'status' => 'error',
                'message' => 'produk tidak ditemukan!'
            ], 404);
        }
        $production->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'produk berhasil dihapus!'
        ]);
    }
}
