<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Auth;

use App\Models\User;
use App\Models\DetailUser;
use App\Models\ExperienceUser;
use App\Models\Order;
use App\Models\Service;
use App\Models\OrderStatus;


class MemberController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $orders = Order::where('freelancer_id', Auth::user()->id))->get();

        $progress = Order::where('freelancer_id', Auth::user()->id)
            ->where('order_status_id', 2) // Assuming 2 is the status for progress
            ->count();

        $completed = Order::where('freelancer_id', Auth::user()->id)
            ->where('order_status_id', 1) // Assuming 1 is the status for completed
            ->count();

        $freelancer = Order::where('buyer_id', Auth::user()->id)
            ->where('order_status_id', 2) // Assuming 5 is the status for canceled
            ->distinct('freelancer_id') // unique freelancers
            ->count();

        return view('pages.dashboard.index', compact('orders', 'progress', 'completed', 'freelancer'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return abort(404);
    }
}
