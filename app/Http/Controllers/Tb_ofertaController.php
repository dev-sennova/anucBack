<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tb_oferta;              


class tb_ofertaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        try {
         $tb_oferta = new Tb_oferta;
         $tb_oferta->product_id = $request->request('product_id');
         $tb_oferta->asociados_finca_id = $request->request('asociados_finca_id');
         $tb_oferta->start_date = $request->request('start_date');
         // Suponiendo que la duración es de 30 días
         $tb_oferta->end_date = \Carbon\Carbon::parse($tb_oferta->start_date)->addDays(30);
         $tb_oferta->save();

        if ($tb_oferta->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Oferta creado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Oferta no pudo ser creado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
