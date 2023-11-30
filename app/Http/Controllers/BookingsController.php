<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Http\Controllers\Controller;
use App\Models\Clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($hotel, Request $request)
    {
        
        $filtro = array(['bookings.hotels_id', $hotel]);
        $filtroOr = array();
        if ($request->get('id')) {
            array_push($filtro, ['bookings.id', $request->get('id')]);
        }

        if ($request->get('fecha')) {
            array_push($filtro, ['bookings.fecha_llegada', $request->get('fecha')]);
        }

        if ($request->get('nombre')) {
            $nombre = $request->get('nombre');
            array_push($filtroOr, ['clients.nombre', 'like', "%$nombre%"]);
            array_push($filtroOr, ['clients.documento', 'like', "%$nombre%"]);
        }
        $reservas = Bookings::join('clients', 'clients.id', '=', 'bookings.clients_id')
                    ->select('bookings.*', 'clients.nombre', "clients.documento")
                    ->selectRaw('DATE_ADD(bookings.fecha_llegada, INTERVAL bookings.cantidad_noche DAY) as fecha_salida')
                    ->where($filtro)
                    ->orWhere($filtroOr)
                    ->orderBy('bookings.id', 'desc')
                    ->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Lista de todas las reservas',
            'data' => $reservas
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
        $req = $request->all();
        $validator = Validator::make($req, [
            'nombre' => 'required',
            'documento' => 'required',
            'numero_personas' => 'required|numeric',
            'fecha_llegada' => 'required',
            'cantidad_noche' => 'required|numeric',
            'valor_reserva' => 'required|numeric',
            'hotels_id' => 'required|numeric',
        ], [
            'required' => 'El :attribute es requerido.',
            'numeric' => 'El :attribute debe ser numérico.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Devuelve la reserva',
                'data' => $validator->messages()
            ], 400);
        }
        $dataClient = array('nombre' => $req['nombre'], 'documento' => $req['documento']);
        $client = Clients::where('documento', $dataClient['documento'])->first();
        if ($client == NULL) {
            $client = Clients::create($dataClient);
        }
        $dataReserva = array(
            'numero_personas' => $req['numero_personas'],
            'fecha_llegada' => $req['fecha_llegada'],
            'cantidad_noche' => $req['cantidad_noche'],
            'valor_reserva' => $req['valor_reserva'],
            'hotels_id' => $req['hotels_id'],
            'clients_id' => $client->id
        );
        $reservas = Bookings::create($dataReserva);
        return response()->json([
            'status' => 'success',
            'message' => 'La reserva se creo',
            'data' => $reservas
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Bookings $bookings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Bookings $bookings)
    {
        $req = $request->all();
        $validator = Validator::make($req, [
            'numero_personas' => 'required|numeric',
            'fecha_llegada' => 'required',
            'cantidad_noche' => 'required|numeric',
            'valor_reserva' => 'required|numeric',
        ], [
            'required' => 'El :attribute es requerido.',
            'numeric' => 'El :attribute debe ser numérico.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Devuelve la reserva',
                'data' => $validator->messages()
            ], 400);
        }
        $bookings->update($req);
        return response()->json([
            'status' => 'success',
            'message' => 'La reserva se creo',
            'data' => $bookings
        ], 200);
    }

    public function editEstadoReserva(Request $request, Bookings $bookings)
    {
        $req = $request->all();
        $validator = Validator::make($req, [
            'estado_reserva' => 'required'
        ], [
            'required' => 'El :attribute es requerido.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Devuelve la reserva',
                'data' => $validator->messages()
            ], 400);
        }
        $bookings->update($req);
        return response()->json([
            'status' => 'success',
            'message' => 'La reserva se creo',
            'data' => $bookings
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bookings $bookings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bookings $bookings)
    {
        //
    }
}
