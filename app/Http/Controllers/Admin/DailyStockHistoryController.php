<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\DailyStockHistory;
use App\Http\Requests\StoreDailyStockHistoryRequest;
use App\Http\Requests\UpdateDailyStockHistoryRequest;
use Illuminate\Http\Request;

class DailyStockHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        $histories = DailyStockHistory::where('date', $date)->with('product')->get();

        return view('daily-stock-history.index', compact('histories', 'date'));
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
    public function store(StoreDailyStockHistoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DailyStockHistory $dailyStockHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DailyStockHistory $dailyStockHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDailyStockHistoryRequest $request, DailyStockHistory $dailyStockHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DailyStockHistory $dailyStockHistory)
    {
        //
    }
}
