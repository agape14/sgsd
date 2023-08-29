<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\TbDirectorioDetResp;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DataTables;

class TbDirectorioDetRespController extends Controller
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

    public function gettblresponsables(Request $request){
        $codisesion = $request->input('CODI_SESION');
        $codiperiod = $request->input('CODI_PERIODO');
        $numersecu = $request->input('NUME_SECUEN');

        $query = DB::table('tb_directorio_det_resps as a')
            ->select(
            'a.CODI_DOCU_SUSTENTO', 
            'a.NUME_SECUEN', 
            'a.DESC_DOCUMENTO', 
            'a.CODI_AREA',
            'd.AR_NOMB', 
            'c.CODI_ESTADO', 
            'c.DESC_ESTADO', 
            )
            ->join('estado as c','c.CODI_ESTADO','=','a.CODI_ESTADO')
            ->join('AREA as d','d.AR_CODI','=','a.CODI_AREA');
            if ($codisesion) {
                $query->where('a.CODI_SESION', $codisesion);
            }

            if ($codiperiod) {
                $query->where('a.CODI_PERIODO', $codiperiod);
            }

            if ($numersecu) {
                $query->where('a.NUME_SECUEN', $numersecu);
            }

            $tbDirectorioDetResp = $query->orderByDesc('a.CODI_DOCU_SUSTENTO')->get();
            
            return Datatables::of($tbDirectorioDetResp)->addIndexColumn()
            ->addColumn('action', function($row){
                $buttons = '<button class="btn btn-primary btn-sm m-1" id="btnMostrarSustento" data-nro-sec="'.$row->NUME_SECUEN.'" data-nro-docu="'.$row->CODI_DOCU_SUSTENTO.'" data-cod-area="'.$row->CODI_AREA.'" data-name-area="'.$row->AR_NOMB.'"><i class="bi bi-file-earmark-plus-fill" data-bs-toggle="tooltip" data-bs-placement="Top" title="Sustento"></i></button>';
                $buttons .= '<button type="button" class="btn btn-danger btn-sm" id="btnDelAreaResp" data-nro-sec="'.$row->NUME_SECUEN.'" data-cod-area="'.$row->CODI_AREA.'" data-cod-sust="'.$row->CODI_DOCU_SUSTENTO.'"><i class="bi bi-trash-fill" data-bs-toggle="tooltip" data-bs-placement="Top" title="Eliminar"></i></button>';
                return $buttons;
            })
            ->addColumn('CODI_ESTADO', function ($row) {
                if($row->CODI_ESTADO==1){
                    return '<span class="badge bg-info">'.$row->DESC_ESTADO.'</span>';
                } else if($row->CODI_ESTADO==2){
                    return '<span class="badge bg-warning">'.$row->DESC_ESTADO.'</span>';
                }else if($row->CODI_ESTADO==3){
                    return '<span class="badge bg-success">'.$row->DESC_ESTADO.'</span>';
                }
                
            })
            ->rawColumns(['action','CODI_ESTADO'])
            ->make(true);
        //}
        return view('tbdirectoriocab.index');
    }

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
        $fechaAct=Carbon::now();
        $sgteNroDocuSust= DB::table('tb_directorio_det_resps')
        ->where('CODI_SESION','=',$request->CODI_SESION)
        ->where('CODI_PERIODO', '=', $request->CODI_PERIODO)
        ->where('NUME_SECUEN', '=', $request->NUME_SECUEN)
        ->max('CODI_DOCU_SUSTENTO') + 1;

        $validaAreaExiste= DB::table('tb_directorio_det_resps')
        ->where('CODI_SESION','=',$request->CODI_SESION)
        ->where('CODI_PERIODO', '=', $request->CODI_PERIODO)
        ->where('NUME_SECUEN', '=', $request->NUME_SECUEN)
        ->where('CODI_AREA', '=', $request->CODI_AREA);
        if ($validaAreaExiste->exists()) {
            return response()->json(['success' => false,'message'=>'El area seleccionado ya existe dentro de los responsables, verifique.']);
        } else {
            DB::table('tb_directorio_det_resps')->insert([
                'CODI_SESION' => $request->CODI_SESION,
                'CODI_PERIODO' => $request->CODI_PERIODO,
                'NUME_SECUEN' => $request->NUME_SECUEN,
                'CODI_AREA' => $request->CODI_AREA,
                'CODI_DOCU_SUSTENTO' => $sgteNroDocuSust,
                'CODI_ESTADO' => 2,
                'created_at' => DB::raw("CONVERT(datetime, '$fechaAct', 120)"),
            ]);
            return response()->json(['success' => true,'message'=>'Se registro correctamente el area responsable. ']);
        }
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TbDirectorioDetResp  $tbDirectorioDetResp
     * @return \Illuminate\Http\Response
     */
    public function show(TbDirectorioDetResp $tbDirectorioDetResp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TbDirectorioDetResp  $tbDirectorioDetResp
     * @return \Illuminate\Http\Response
     */
    public function edit(TbDirectorioDetResp $tbDirectorioDetResp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TbDirectorioDetResp  $tbDirectorioDetResp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TbDirectorioDetResp $tbDirectorioDetResp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TbDirectorioDetResp  $tbDirectorioDetResp
     * @return \Illuminate\Http\Response
     */
    public function destroy($codi_sesion,$periodo,$nrosecu,$codarea,$codsust)
    {
        DB::table('tb_directorio_det_resp_dets')
        ->where('CODI_SESION',$codi_sesion)
        ->where('CODI_PERIODO',$periodo)
        ->where('NUME_SECUEN',$nrosecu)
        ->where('CODI_AREA',$codarea)
        ->delete();

        DB::table('tb_directorio_det_resps')
        ->where('CODI_SESION',$codi_sesion)
        ->where('CODI_PERIODO',$periodo)
        ->where('NUME_SECUEN',$nrosecu)
        ->where('CODI_AREA',$codarea)
        ->where('CODI_DOCU_SUSTENTO',$codsust)
        ->delete();
        return response()->json(['success' => true,'NUME_SECUEN'=>$codsust,'message'=>'Se elimino correctamente el responsable nro. '.strval($codsust)]);
    }

    public function getAreas()
    {
        //$listAreas = DB::table('AREA')->where('AR_TIPO', '=', 'A')->where('AR_ESTADO', '=', '1')->pluck('AR_NOMB', 'AR_CODI', 'AR_SIGL');
        $listAreas = DB::table('AREA')->where('AR_TIPO', '=', 'A')->where('AR_ESTADO', '=', '1')->pluck(DB::raw("CONCAT(AR_SIGL, ' - ', AR_NOMB) AS NOMB_AREA"), 'AR_CODI');
        return response()->json($listAreas);
    }
}
