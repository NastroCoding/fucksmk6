<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order = Order::all();
        return OrderResource::collection($order);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bus_id' => 'required',
            'driver_id' => 'required',
            'contact_name' => 'required',
            'contact_phone' => 'required',
            'start_rent_date' => 'required',
            'total_rent_days' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->messages()
            ], 422);
        }

        // Calculate end rent date based on start date and total rent days
    $startRentDate = Carbon::parse($request->start_rent_date);
    $endRentDate = $startRentDate->copy()->addDays($request->total_rent_days - 1);

    // Check for conflicting orders for the bus
    $busConflict = Order::where('bus_id', $request->bus_id)
                        ->where(function ($query) use ($startRentDate, $endRentDate) {
                            $query->where('start_rent_date', '<=', $endRentDate)
                                  ->whereRaw('DATE_ADD(start_rent_date, INTERVAL total_rent_days DAY) >= ?', [$startRentDate->toDateString()]);
                        })
                        ->exists();

    // Check for conflicting orders for the driver
    $driverConflict = Order::where('driver_id', $request->driver_id)
                           ->where(function ($query) use ($startRentDate, $endRentDate) {
                               $query->where('start_rent_date', '<=', $endRentDate)
                                     ->whereRaw('DATE_ADD(start_rent_date, INTERVAL total_rent_days DAY) >= ?', [$startRentDate->toDateString()]);
                           })
                           ->exists();

    // If there are conflicts, return an error response
    if ($busConflict) {
        return response()->json([
            'message' => 'The requested bus is already booked during the requested rental period.'
        ], 409);
    }

    if ($driverConflict) {
        return response()->json([
            'message' => 'The requested driver is already booked during the requested rental period.'
        ], 409);
    }

    // Create a new order
    $order = Order::create([
        'bus_id' => $request->bus_id,
        'driver_id' => $request->driver_id,
        'contact_name' => $request->contact_name,
        'contact_phone' => $request->contact_phone,
        'start_rent_date' => $request->start_rent_date,
        'total_rent_days' => $request->total_rent_days,
    ]);

        return new OrderResource($order);

    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json([
            'message' => 'delete order success'
        ]);
    }
}
