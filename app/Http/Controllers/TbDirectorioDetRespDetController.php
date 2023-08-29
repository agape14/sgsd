<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\TbDirectorioDetRespDet;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DataTables;

class TbDirectorioDetRespDetController extends Controller
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

    public function gettblsustentos(Request $request){
        $codisesion = $request->input('CODI_SESION');
        $codiperiod = $request->input('CODI_PERIODO');
        $numersecu = $request->input('NUME_SECUEN');
        $codarea = $request->input('CODI_AREA');
        $codsust = $request->input('CODI_DOCU_SUSTENTO');

        $query = DB::table('tb_directorio_det_resp_dets as a')
            ->select(
            'a.CODI_SESION', 
            'a.CODI_PERIODO', 
            'a.NUME_SECUEN', 
            'a.CODI_AREA',
            'a.CODI_DOCU_SUSTENTO', 
            'a.CODI_DO_SGD', 
            'a.DESC_DOCUMENTO', 
            'a.DESC_COMENTARIO', 
            );
            if ($codisesion) {
                $query->where('a.CODI_SESION', $codisesion);
            }

            if ($codiperiod) {
                $query->where('a.CODI_PERIODO', $codiperiod);
            }

            if ($numersecu) {
                $query->where('a.NUME_SECUEN', $numersecu);
            }

            if ($codarea) {
                $query->where('a.CODI_AREA', $codarea);
            }
            /*
            if ($codsust) {
                $query->where('a.CODI_DOCU_SUSTENTO', $codsust);
            }
            */
            $tbDirectorioDetRespDets = $query->orderByDesc('a.CODI_DOCU_SUSTENTO')->get();
            
            return Datatables::of($tbDirectorioDetRespDets)->addIndexColumn()
            ->addColumn('action', function($row){
                $buttons = '<button type="button" disabled class="btn btn-danger btn-sm" id="btnDelAreaRespDet " data-nro-sec="'.$row->NUME_SECUEN.'" data-cod-area="'.$row->CODI_AREA.'" data-cod-sust="'.$row->CODI_DOCU_SUSTENTO.'"><i class="bi bi-trash-fill" data-bs-toggle="tooltip" data-bs-placement="Top" title="Eliminar"></i></button>';
                return $buttons;
            })
            ->make(true);
        //}
        return view('tbdirectoriocab.index');
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
        $codsesi=$request->CODI_SESION;
        $codperi=$request->CODI_PERIODO;
        $codsecu=$request->NUME_SECUEN;
        $codarea=$request->CODI_AREA;
        $descdoc=$request->DESC_DOCUMENTO;
        $coddocu=$request->CODI_DOCU_SUSTENTO;

        $fechaAct=Carbon::now();
        $sgteNroDocuSustDet= DB::table('tb_directorio_det_resp_dets')
        ->where('CODI_SESION','=',$codsesi)
        ->where('CODI_PERIODO', '=', $codperi)
        ->where('NUME_SECUEN', '=', $codsecu)
        ->where('CODI_AREA', '=', $codarea)
        ->max('CODI_DOCU_SUSTENTO') + 1;

        DB::table('tb_directorio_det_resp_dets')->insert([
            'CODI_SESION' => $codsesi,
            'CODI_PERIODO' => $codperi,
            'NUME_SECUEN' => $codsecu,
            'CODI_AREA' => $codarea,
            'CODI_DOCU_SUSTENTO' => $sgteNroDocuSustDet,
            'DESC_DOCUMENTO' => $descdoc,
            'created_at' => DB::raw("CONVERT(datetime, '$fechaAct', 120)"),
        ]);
        DB::statement('UPDATE tb_directorio_det_resps SET DESC_DOCUMENTO = CONCAT(DESC_DOCUMENTO, ?, CHAR(13) + CHAR(10)) WHERE CODI_SESION = ? AND CODI_PERIODO = ? AND NUME_SECUEN = ? AND CODI_AREA = ? AND CODI_DOCU_SUSTENTO = ?', [$descdoc, $codsesi, $codperi, $codsecu, $codarea, $coddocu]);
        return response()->json(['success' => true,'message'=>'Se registro correctamente el documento para el sustento. ']);
    }

    public function store_sgd(Request $request)
    {
        $codsesi=$request->CODI_SESION;
        $codperi=$request->CODI_PERIODO;
        $codsecu=$request->NUME_SECUEN;
        $codarea=$request->CODI_AREA;
        $descdoc=$request->DESC_DOCUMENTO;
        $coddocu=$request->CODI_DOCU_SUSTENTO;
        $coddocu_sgd=$request->CODI_DO_SGD;

        $fechaAct=Carbon::now();
        $sgteNroDocuSustDet= DB::table('tb_directorio_det_resp_dets')
        ->where('CODI_SESION','=',$codsesi)
        ->where('CODI_PERIODO', '=', $codperi)
        ->where('NUME_SECUEN', '=', $codsecu)
        ->where('CODI_AREA', '=', $codarea)
        ->max('CODI_DOCU_SUSTENTO') + 1;

        DB::table('tb_directorio_det_resp_dets')->insert([
            'CODI_SESION' => $codsesi,
            'CODI_PERIODO' => $codperi,
            'NUME_SECUEN' => $codsecu,
            'CODI_AREA' => $codarea,
            'CODI_DOCU_SUSTENTO' => $sgteNroDocuSustDet,
            'CODI_DO_SGD' => $coddocu_sgd,
            'DESC_DOCUMENTO' => $descdoc,
            'created_at' => DB::raw("CONVERT(datetime, '$fechaAct', 120)"),
        ]);
        DB::statement('UPDATE tb_directorio_det_resps SET DESC_DOCUMENTO = CONCAT(DESC_DOCUMENTO, ?, CHAR(13) + CHAR(10)) WHERE CODI_SESION = ? AND CODI_PERIODO = ? AND NUME_SECUEN = ? AND CODI_AREA = ? AND CODI_DOCU_SUSTENTO = ?', [$descdoc, $codsesi, $codperi, $codsecu, $codarea, $coddocu]);
        return response()->json(['success' => true,'message'=>'Se registro correctamente el documento para el sustento. ']);
    }

    public function show(TbDirectorioDetRespDet $tbDirectorioDetRespDet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TbDirectorioDetRespDet  $tbDirectorioDetRespDet
     * @return \Illuminate\Http\Response
     */
    public function edit(TbDirectorioDetRespDet $tbDirectorioDetRespDet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TbDirectorioDetRespDet  $tbDirectorioDetRespDet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TbDirectorioDetRespDet $tbDirectorioDetRespDet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TbDirectorioDetRespDet  $tbDirectorioDetRespDet
     * @return \Illuminate\Http\Response
     */
    public function destroy($codi_sesion,$periodo,$nrosecu,$codarea,$codsust)
    {   
        
        DB::table('tb_directorio_det_resp_dets')
        ->where('CODI_SESION',$codi_sesion)
        ->where('CODI_PERIODO',$periodo)
        ->where('NUME_SECUEN',$nrosecu)
        ->where('CODI_AREA',$codarea)
        ->where('CODI_DOCU_SUSTENTO',$codsust)
        ->delete();

        $contadorDetExiste=DB::table('tb_directorio_det_resp_dets')
        ->where('CODI_SESION',$codi_sesion)
        ->where('CODI_PERIODO',$periodo)
        ->where('NUME_SECUEN',$nrosecu)
        ->where('CODI_AREA',$codarea)
        ->count();

        if ($contadorDetExiste>=1) {
            DB::table('tb_directorio_det_resps')
            ->join('tb_directorio_det_resp_dets', 'tb_directorio_det_resps.CODI_DOCU_SUSTENTO', '=', 'tb_directorio_det_resp_dets.CODI_DOCU_SUSTENTO')
            ->join('tb_directorio_det_resp_dets', function ($join) {
                $join->on('tb_directorio_det_resps.CODI_SESION', '=', 'tb_directorio_det_resp_dets.CODI_SESION')
                    ->on('tb_directorio_det_resps.CODI_PERIODO', '=', 'tb_directorio_det_resp_dets.CODI_PERIODO')
                    ->on('tb_directorio_det_resps.NUME_SECUEN', '=', 'tb_directorio_det_resp_dets.NUME_SECUEN')
                    ->on('tb_directorio_det_resps.CODI_AREA', '=', 'tb_directorio_det_resp_dets.CODI_AREA');
            })
            ->where('tb_directorio_det_resp_dets.CODI_SESION', $codi_sesion)
            ->where('tb_directorio_det_resp_dets.CODI_PERIODO', $periodo)
            ->where('tb_directorio_det_resp_dets.NUME_SECUEN', $nrosecu)
            ->where('tb_directorio_det_resp_dets.CODI_AREA', $codarea)
            ->where('tb_directorio_det_resp_dets.CODI_DOCU_SUSTENTO', $codsust)
            ->update(['tb_directorio_det_resps.DESC_DOCUMENTO' => DB::raw('CONCAT(tb_directorio_det_resps.DESC_DOCUMENTO, tb_directorio_det_resp_dets.DESC_DOCUMENTO)')]);
        } else {
            DB::table('tb_directorio_det_resps')
            ->where('CODI_SESION',$codi_sesion)
            ->where('CODI_PERIODO',$periodo)
            ->where('NUME_SECUEN',$nrosecu)
            ->where('CODI_AREA',$codarea)
            ->update(['DESC_DOCUMENTO' => null]);
        }
        return response()->json(['success' => true,'NUME_SECUEN'=>$codsust,'message'=>'Se elimino correctamente el sustento nro. '.strval($codsust)]);
        
    }
}
