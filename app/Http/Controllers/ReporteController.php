<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reporte;
use App\Exports\SongsExport;
use Excel;
use Storage;

class ReporteController extends Controller
{
    public function __construct(){}

    public function index()
    {
        return view('excel');
    }

    public function saveReport(Request $request){
        if($request->artista['nombre'] == '' || $request->artista['nombre'] == null)
        {
            return "Error al guardar el registro";
        }

        $reporte = new Reporte;
        $reporte->nombre_artista = $request->artista['nombre'];
        $reporte->fecha_busqueda = $request->fecha_busqueda;
        $reporte->canciones = json_encode($request->canciones);

        $reporte->save();

        if($reporte)
        {
            return $reporte->id;
        }
    }

    public function generateExcel($id){

        $datos = Reporte::find($id);

        $artista = $datos->nombre_artista;
        $canciones = json_decode($datos->canciones);
        $fecha_busqueda = date('m-d-Y_h-i-s', strtotime($datos->fecha_busqueda));

        $array = [];

        foreach($canciones as $cancion){
            array_push($array, [$cancion->artist->name, $cancion->title, $cancion->album->title]);
        }

        $excel = new SongsExport($array);

        /*$excel = new SongsExport([
            //[1, 2, 3],[4, 5, 6]
        ]);*/

        return Excel::download($excel, "{$artista}_{$fecha_busqueda}.xlsx");
    }
}
