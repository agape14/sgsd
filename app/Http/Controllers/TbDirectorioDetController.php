<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\TbDirectorioDet;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DataTables;
class TbDirectorioDetController extends Controller
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
    public function indextemas(Request $request, $id, $anio)
    {
        $id = $id;
        $anio = $anio;
        $listestados = DB::table('estado')->where('ACTIVO', '=', 1)->orderBy('CODI_ESTADO', 'asc')->get();
        $listfinalidad = DB::table('finalidad')->where('ACTIVO', '=', 1)->orderBy('CODI_FINALIDAD', 'asc')->get();
        //$listestados->prepend(['CODI_ESTADO' => '', 'DESC_ESTADO' => 'TODOS']);
        return view('admin.sesiondirectorio.temas',['codigo_sesion' => $id,'periodo'=>$anio,'listestados'=>$listestados,'listfinalidad'=>$listfinalidad]);
    }
    public function gettbltemas(Request $request){
        $codisesion = $request->input('CODI_SESION');
        $codiperiod = $request->input('CODI_PERIODO');
        $numersecu = $request->input('NUME_SECUEN');
        $descripcion = $request->input('DESC_TEMA');
        $fechalimite = $request->input('FECH_LIMITE');
        $estado = $request->input('CODI_ESTADO');
        $query = DB::table('tb_directorio_dets as a')
            ->select(
            'a.NUME_SECUEN', 
            'a.DESC_TEMA', 
            'b.DESC_FINALIDAD', 
            DB::raw('CONVERT(VARCHAR(10), CAST(a.FECH_LIMITE AS DATE), 103)  FECH_LIMITE'),
            'c.CODI_ESTADO', 
            'c.DESC_ESTADO', 
            )
            ->selectRaw('(0) AS RESPONSABLES')
            ->selectRaw('(0) AS EN_PROCESO')
            ->selectRaw('(0) AS CULMINADOS')
            ->selectRaw('(0) AS AVANCE')
            ->join('finalidad as b','b.CODI_FINALIDAD','=','a.CODI_FINALIDAD')
            ->join('estado as c','c.CODI_ESTADO','=','a.CODI_ESTADO');

            if ($codisesion) {
                $query->where('a.CODI_SESION', $codisesion);
            }

            if ($codiperiod) {
                $query->where('a.CODI_PERIODO', $codiperiod);
            }

            if ($numersecu) {
                $query->where('a.NUME_SECUEN', $numersecu);
            }
    
            if ($descripcion) {
                $query->where('a.DESC_TEMA','LIKE', '%'.$descripcion.'%');
            }

            if ($fechalimite) {
                $fechProgramada = Carbon::createFromFormat('Y-m-d', $fechalimite)->toDateTimeString();
                $query->whereDate('a.FECH_LIMITE', $fechProgramada);
            }

            if ($estado) {
                $query->where('c.CODI_ESTADO', $estado);
            }
    
            $tbDirectorioDet = $query->orderByDesc('a.NUME_SECUEN')->get();
            
            return Datatables::of($tbDirectorioDet)->addIndexColumn()
            ->addColumn('action', function($row){
                $buttons = '<button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#mdlEditaTema" data-edt-id="'.$row->NUME_SECUEN.'"><i class="bi bi-pencil-fill" data-bs-toggle="tooltip" data-bs-placement="Top" title="Editar"></i></button>';
                $buttons .= '<button class="btn btn-primary btn-sm m-1" data-bs-toggle="modal" data-bs-target="#mdlResponsables" data-nro-sec="'.$row->NUME_SECUEN.'"><i class="bi bi-bar-chart-fill" data-bs-toggle="tooltip" data-bs-placement="Top" title="Seguimiento"></i></button>';
                $buttons .= '<button type="button" class="btn btn-danger btn-sm" id="btnDeleteTema" data-delete-id="'.$row->NUME_SECUEN.'"><i class="bi bi-trash-fill" data-bs-toggle="tooltip" data-bs-placement="Top" title="Eliminar"></i></button>';
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
        /*
        $request->validate([
            'CODI_SESION' => 'required',
            'CODI_PERIODO' => 'required',
            'DESC_TEMA' => 'required',
            'FECH_LIMITE' => 'required',
            'CODI_FINALIDAD' => 'required',
        ]);
        */
        $fechFinalidad = Carbon::createFromFormat('Y-m-d', $request->FECH_LIMITE)->toDateTimeString();
        $fechaAct=Carbon::now();
        $sgteNroSecuen = DB::table('tb_directorio_dets')->where('CODI_SESION','=',$request->CODI_SESION)->where('CODI_PERIODO', '=', $request->CODI_PERIODO)->max('NUME_SECUEN') + 1;

        DB::table('tb_directorio_dets')->insert([
            'CODI_SESION' => $request->CODI_SESION,
            'CODI_PERIODO' => $request->CODI_PERIODO,
            'NUME_SECUEN' => $sgteNroSecuen,
            'DESC_TEMA' => $request->DESC_TEMA,
            'CODI_FINALIDAD' => $request->CODI_FINALIDAD,
            'CODI_ESTADO' => 1,
            'FECH_LIMITE' => DB::raw("CONVERT(datetime, '$fechFinalidad', 120)"),
            'NUME_AVANCE' => 0,
            'created_at' => DB::raw("CONVERT(datetime, '$fechaAct', 120)"),
        ]);
        return response()->json(['success' => true,'NUME_SECUEN'=>$sgteNroSecuen,'message'=>'Se registro correctamente el tema con el nro. '.strval($sgteNroSecuen)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TbDirectorioDet  $tbDirectorioDet
     * @return \Illuminate\Http\Response
     */
    public function show($codi_sesion,$periodo,$numero)
    {
        $tbDirectorioDet = DB::table('tb_directorio_dets')->where('CODI_SESION', $codi_sesion)->where('CODI_PERIODO', $periodo)->where('NUME_SECUEN', $numero)->first();
        $fechaLimiteFormat = date('Y-m-d', strtotime($tbDirectorioDet->FECH_LIMITE));
        return response()->json(['success' => true,'tbDirectorioDet'=>$tbDirectorioDet,'fechaLimiteFormat'=>$fechaLimiteFormat]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TbDirectorioDet  $tbDirectorioDet
     * @return \Illuminate\Http\Response
     */
    public function edit(TbDirectorioDet $tbDirectorioDet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TbDirectorioDet  $tbDirectorioDet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $fechLimite = Carbon::createFromFormat('Y-m-d', $request->FECH_LIMITE)->toDateTimeString();
        $fechaActEdit=Carbon::now();
        DB::table('tb_directorio_dets')
        ->where('CODI_SESION',$request->CODI_SESION)
        ->where('CODI_PERIODO',$request->CODI_PERIODO)
        ->where('NUME_SECUEN',$request->NUME_SECUEN)
        ->update([
            'DESC_TEMA' =>$request->DESC_TEMA,
            'FECH_LIMITE' => DB::raw("CONVERT(datetime, '$fechLimite', 120)"),
            'CODI_FINALIDAD' =>$request->CODI_FINALIDAD,
            'updated_at' => DB::raw("CONVERT(datetime, '$fechaActEdit', 120)"),
        ]);
        return response()->json(['success' => true,'CODI_SESION'=>$id,'message'=>'Se actualizo correctamente el tema nro. '.strval($id)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TbDirectorioDet  $tbDirectorioDet
     * @return \Illuminate\Http\Response
     */
    public function destroy($codi_sesion,$periodo,$numero)
    {
        DB::table('tb_directorio_dets')
        ->where('CODI_SESION',$codi_sesion)
        ->where('CODI_PERIODO',$periodo)
        ->where('NUME_SECUEN',$numero)->delete();
        return response()->json(['success' => true,'NUME_SECUEN'=>$numero,'message'=>'Se elimino correctamente el tema nro. '.strval($numero)]);
    }
}
