<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hotels = Hotel::all();
        return response()->json([
            'status' => 'success',
            'message' => 'Lista de todos los hoteles',
            'data' => $hotels
        ], 200);
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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'direccion' => 'required',
            'pais' => 'required',
            'despartamento' => 'required',
            'ciudad' => 'required',
            'nit' => 'required',
        ], [
            'required' => 'El :attribute es requerido.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Devuelve el hotel',
                'data' => $validator->messages()
            ], 400);
        } else {
            $hotelExiste = Hotel::where('nit', $request->all()['nit'])->first();
            if ($hotelExiste == NULL) {
                $hotel = Hotel::create($request->all());
                return response()->json([
                    'status' => 'success',
                    'message' => 'Devuelve el hotel',
                    'data' => $hotel
                ], 201);
            } else {
                return response()->json([
                    'status' => 'success',
                    'message' => 'El hotel ya existe',
                    'data' => $hotelExiste
                ], 200);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($hotel)
    {
        $hotel = Hotel::where('id', $hotel)->first();
        $status = '';
        if (!isNull($hotel)) {
            $status = 'error';
        } else {
            $status = 'success';
        }
        return response()->json([
            'status' => $status,
            'message' => 'Devuelve el hotel',
            'data' => $hotel
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hotel $hotel)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hotel $hotel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotel $hotel)
    {
        //
    }
}
