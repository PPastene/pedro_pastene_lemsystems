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
        if($request->artist['name'] == '' || $request->artist['name'] == null)
        {
            return "Error al guardar el registro";
        }

        $reporte = new Reporte;
        $reporte->artist_name = $request->artist['name'];
        $reporte->search_date = $request->search_date;
        $reporte->songs = json_encode($request->songs);

        $reporte->save();

        if($reporte)
        {
            return response()->json([
                'id' => $reporte->id,
                'message' => "La busqueda ha sido guardada satisfactoriamente"
            ]);
        }
    }

    public function generateExcel($id){

        $data = Reporte::find($id);

        $artist = $data->artist_name;
        $songs = json_decode($data->songs);
        $search_date = date('m-d-Y_H-i-s', strtotime($data->search_date));

        $array = [];

        foreach($songs as $song){
            array_push($array, [$song->artist->name, $song->title, $song->album->title]);
        }

        $excel = new SongsExport($array);

        /*$excel = new SongsExport([
            //[1, 2, 3],[4, 5, 6]
        ]);*/

        return Excel::download($excel, "{$artist}_{$search_date}.xlsx");
    }
}
