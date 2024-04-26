<?php

namespace App\Http\Controllers;

use App\Http\Resources\DriverResource;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $driver = Driver::all();
        return DriverResource::collection($driver);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'age' => 'required',
            'id_number' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->messages()
            ], 422);
        }

        $driver = Driver::create([
            'name' => $request->name,
            'age' => $request->age,
            'id_number' => $request->id_number,
        ]);

        return response()->json([
            'message' => 'create driver success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'age' => 'required',
            'id_number' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->messages()
            ], 422);
        }

        $driver = Driver::findOrFail($id);
        $driver->update([
            'name' => $request->name,
            'age' => $request->age,
            'id_number' => $request->id_number,
        ]);

        return response()->json([
            'message' => 'update driver success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $driver = Driver::findOrFail($id);
        $driver->delete();

        return response()->json([
            'message' => 'delete driver success'
        ]);
    }
}
