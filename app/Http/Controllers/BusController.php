<?php

namespace App\Http\Controllers;

use App\Http\Resources\BusResource;
use App\Models\Bus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class BusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $bus = Bus::all();
        return BusResource::collection($bus);    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plate_number' => 'required',
            'brand' => 'required',
            'seat' => 'required',
            'price_per_day' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'messages' => $validator->messages()
            ], 422);
        }

        $bus = Bus::create([
            'plate_number' => $request->plate_number,
            'brand' => $request->brand,
            'seat' => $request->seat,
            'price_per_day' => $request->price_per_day,
        ]);

        return response()->json([
            'message' => 'create bus success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Bus $bus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'plate_number' => 'required',
            'brand' => 'required',
            'seat' => 'required',
            'price_per_day' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'messages' => $validator->messages()
            ], 422);
        }

        $bus = Bus::findOrFail($id);
        $bus->update([
            'plate_number' => $request->plate_number,
            'brand' => $request->brand,
            'seat' => $request->seat,
            'price_per_day' => $request->price_per_day,
        ]);

        return response()->json([
            'message' => 'update bus success'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $bus = Bus::findOrFail($id);
        $bus->delete();

        return response()->json([
            'message' => 'delete bus success'
        ]);
    }
}
