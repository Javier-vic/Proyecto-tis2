<?php

namespace App\Http\Controllers;

use App\Models\map;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;


class MapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mapa = map::find(1);
        return view('Mantenedores.map.index', compact('mapa'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $values = request()->except('_token');
        try {
            DB::beginTransaction();

            $map = map::first();
            if ($values == []) {
                $map->delivery_zones = '';
            } else {
                $zonesToString = json_encode($values['polygons']);
                $map->delivery_zones = $zonesToString;
            }
            $map->save();
            DB::connection(session()->get('database'))->commit();

            return Response::json(array(
                'success' => true,
                'message' => 'Se guardaron los cambios correctamente',
                'mapData' => $map['delivery_zones'],

            ), 200);
        } catch (\Throwable $th) {
            dd($th);
            DB::connection(session()->get('database'))->rollBack();
            return Response::json(array(
                'success' => false,
                'message' => 'Ocurrió un error al crear las zonas de delivery'

            ), 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\map  $map
     * @return \Illuminate\Http\Response
     */
    public function show(map $map)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\map  $map
     * @return \Illuminate\Http\Response
     */
    public function edit(map $map)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\map  $map
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, map $map)
    {
        $values = request()->except('_token');
        $validator = Validator::make($request->all(), map::$rules, map::$messages);

        if ($validator->passes()) {
            DB::beginTransaction();
            try {

                $mapa = map::find($map->id);
                $mapa->direccion         = $request->direccion;
                $mapa->latitud         = $request->latitud;
                $mapa->longitud         = $request->longitud;
                $mapa->save();
                DB::connection(session()->get('database'))->commit();
                return response('Se editó la dirección con exito.', 200);
            } catch (\Throwable $th) {
                DB::connection(session()->get('database'))->rollBack();
                return response('No se pudo editar la dirección.', 400);
            }
        } else {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\map  $map
     * @return \Illuminate\Http\Response
     */
    public function destroy(map $map)
    {
        //
    }
}
