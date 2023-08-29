<?php

namespace App\Http\Controllers;

use App\Http\Requests\TbDirectorioCabRequest;

use Illuminate\Support\Facades\DB;
use App\Models\TbDirectorioCab;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DataTables;

use Illuminate\Pagination\LengthAwarePaginator;
/**
 * Class TbDirectorioCabController
 * @package App\Http\Controllers
 */
class TbDirectorioCabController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function inicio(Request $request)
    {
        $listestadosesion = DB::table('estado')->where('ACTIVO', '=', 1)->orderBy('CODI_ESTADO', 'asc')->get();
        return view('tbdirectoriocab.index',['listestadosesion'=>$listestadosesion]);
    }
    public function index(Request $request)
    {
        //if ($request->ajax()) {
            $codisesion = $request->input('CODI_SESION');
            $fechaprogramada = $request->input('FECH_PROGRAMADA');
            $estado = $request->input('CODI_ESTADO');

            $query = DB::table('tb_directorio_cabs as a')
            ->select(
            'a.CODI_SESION', 
            'a.CODI_PERIODO', 
            DB::raw('CONVERT(VARCHAR(10), CAST(a.FECH_PROGRAMADA AS DATE), 103)  FECH_PROGRAMADA'),
            'a.CODI_ESTADO', 
            'e.DESC_ESTADO', 
            DB::raw('(SELECT COUNT(*) FROM tb_directorio_dets d_det WHERE d_det.CODI_SESION=a.CODI_SESION AND d_det.CODI_PERIODO=a.CODI_PERIODO) AS TOTAL_TEMAS'), 
            DB::raw('(SELECT COUNT(*) FROM tb_acuerdo_cabs d_acu WHERE d_acu.CODI_SESION=a.CODI_SESION AND d_acu.CODI_PERIODO=a.CODI_PERIODO) AS TOTAL_ACUERDOS'),
            )
            ->selectRaw('(0) AS TOTAL_AVANCE')
            ->join('estado as e','e.CODI_ESTADO','=','a.CODI_ESTADO');
            if ($codisesion) {
                $query->where('a.CODI_SESION', $codisesion);
            }
    
            if ($fechaprogramada) {
                $fechProgramada = Carbon::createFromFormat('Y-m-d', $fechaprogramada)->toDateTimeString();
                $query->whereDate('a.FECH_PROGRAMADA', $fechProgramada);
            }
    
            if ($estado) {
                $query->where('a.CODI_ESTADO', $estado);
            }
    
            $tbDirectorioCabs = $query->orderByDesc('a.CODI_SESION')->get();
            
            return Datatables::of($tbDirectorioCabs)->addIndexColumn()
            ->addColumn('action', function($row){
                $buttons = '<button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" data-bs-id="'.$row->CODI_SESION.'"><i class="bi bi-pencil-fill" data-bs-toggle="tooltip" data-bs-placement="Top" title="Editar"></i></button>';
                $buttons .= '<a href="/temas/'.$row->CODI_SESION.'/'.$row->CODI_PERIODO.'">
                    <button type="button" class="btn btn-primary btn-sm">
                        <i class="bi bi-journal-text" data-bs-toggle="tooltip" data-bs-placement="Top" title="Agenda"></i>
                    </button>
                </a>';
                $buttons .= '<button type="button" class="btn btn-success btn-sm"><i class="bi bi-hand-thumbs-up" data-bs-toggle="tooltip" data-bs-placement="Top" title="Acuerdos"></i></button>';
                //$buttons .= '<button type="button" class="btn btn-danger btn-sm m-1 d-none" id="btnDeleteSesion" data-delete-id="'.$row->CODI_SESION.'"><i class="bi bi-trash-fill" data-bs-toggle="tooltip" data-bs-placement="Top" title="Eliminar"></i></button>';
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
        $fechaAct=Carbon::now();
        /*$query = DB::table('tb_directorio_cabs');
        $query->where('CODI_PERIODO', '=', $fechaAct->year);
        $maxCodiSesion = $query->max('CODI_SESION');
        $lastCodiSesion = $maxCodiSesion + 1;
        dd($lastCodiSesion);*/

        $lastCodiSesion = DB::table('tb_directorio_cabs')->where('CODI_PERIODO', '=', 2023)->max('CODI_SESION') + 1;
        //dd($lastCodiSesion);
        return view('tbdirectoriocab.index', ['lastCodiSesion' => $lastCodiSesion]);
        //$tbDirectorioCab = new TbDirectorioCab();
        //return view('tb-directorio-cab.create', compact('lastCodiSesion'));
    }

    public function getData()
    {
        // Your controller logic here
        $fechaAct=Carbon::now();
        $lastCodiSesion = DB::table('tb_directorio_cabs')->where('CODI_PERIODO', '=', $fechaAct->year)->max('CODI_SESION') + 1;
        //return view('tbdirectoriocab.create', ['lastCodiSesion' => $lastCodiSesion]);
        return response()->json(['success' => true,'lastCodiSesion'=>$lastCodiSesion]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'CODI_SESION' => 'required',
            'CODI_PERIODO' => 'required',
            'FECH_PROGRAMADA' => 'required',
        ]);
        
        $fechProgramada = Carbon::createFromFormat('Y-m-d', $request->FECH_PROGRAMADA)->toDateTimeString();
        $fechaActual=Carbon::now();
        
        DB::table('tb_directorio_cabs')->insert([
            'CODI_SESION' => $request->CODI_SESION,
            'CODI_PERIODO' => $request->CODI_PERIODO,
            'FECH_PROGRAMADA' => DB::raw("CONVERT(datetime, '$fechProgramada', 120)"),
            'CODI_ESTADO' => 1,
            'created_at' => DB::raw("CONVERT(datetime, '$fechaActual', 120)"),
        ]);
        return response()->json(['success' => true,'CODI_SESION'=>$request->CODI_SESION,'message'=>'Se registro correctamente la nueva sesion de directorio con el nro. '.strval($request->CODI_SESION)]);
        //return redirect()->route('tbdirectoriocab.inicio')->with('success','Se registro correctamente la nueva sesion de directorio.');
    }

   
    public function show($id)
    {
        $tbDirectorioCab = DB::table('tb_directorio_cabs')->where('CODI_SESION', $id)->first();
        $formattedDate = date('Y-m-d', strtotime($tbDirectorioCab->FECH_PROGRAMADA));
        //return view('tbdirectoriocab.show', ['tbDirectorioCab' => $tbDirectorioCab,'formattedDate' => $formattedDate]);
        return response()->json(['success' => true,'tbDirectorioCab'=>$tbDirectorioCab,'formattedDate'=>$formattedDate]);
    }

    public function edit($id)
    {
        $tbDirectorioCab = TbDirectorioCab::find($id);

        return view('tb-directorio-cab.edit', compact('tbDirectorioCab'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  TbDirectorioCab $tbDirectorioCab
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //dd($request->all());
        /*$request->validate([
            'CODI_SESION' => 'required',
            'CODI_PERIODO' => 'required',
            'FECH_PROGRAMADA' => 'required',
        ]);*/
        
        $fechProgramada = Carbon::createFromFormat('Y-m-d', $request->FECH_PROGRAMADA)->toDateTimeString();
        $fechaActEdit=Carbon::now();
        DB::table('tb_directorio_cabs')
        ->where('CODI_SESION',$request->CODI_SESION)
        ->where('CODI_PERIODO',$request->CODI_PERIODO)
        ->update([
            'FECH_PROGRAMADA' => DB::raw("CONVERT(datetime, '$fechProgramada', 120)"),
            'updated_at' => DB::raw("CONVERT(datetime, '$fechaActEdit', 120)"),
        ]);
        return response()->json(['success' => true,'CODI_SESION'=>$request->CODI_SESION,'message'=>'Se actualizo correctamente la sesion de directorio nro. '.strval($request->CODI_SESION)]);
    }

  
    public function destroy($id)
    {
        DB::table('tb_directorio_cabs')->where('CODI_SESION', $id)->delete();
        return response()->json(['success' => true,'CODI_SESION'=>$id,'message'=>'Se elimino correctamente la sesion de directorio nro. '.strval($id)]);
        //$tbDirectorioCab = TbDirectorioCab::find($id)->delete();
        //return redirect()->route('tbdirectoriocab.index')->with('success', 'Se elimino correctamente la sesion de directorio nro. '.strval($id));
    }

    public function search(Request $request)
    {
        //dd($request->input('CODI_SESION'),$request->input('FECH_PROGRAMADA'),$request->input('CODI_ESTADO'));
        $codisesion = $request->input('CODI_SESION');
        $fechaprogramada = $request->input('FECH_PROGRAMADA');
        $estado = $request->input('CODI_ESTADO');

        $query = TbDirectorioCab::query()
            ->select(
                'CODI_SESION',
                'CODI_PERIODO',
                DB::raw('CAST(FECH_PROGRAMADA AS DATE) AS FECH_PROGRAMADA'),
                'CODI_ESTADO',
                DB::raw('(0) AS NUME_AVANCE'),
                DB::raw('(0) AS TOTAL_TEMAS'),
                DB::raw('(0) AS TOTAL_ACUERDOS')
            );
   
        /*
        ->selectRaw('(SELECT COUNT(*) FROM tb_directorio_dets b2 WHERE  b2.CODI_SESION=a.CODI_SESION AND b2.CODI_PERIODO=a.CODI_PERIODO) AS TOTAL_TEMAS')
        ->selectRaw('(SELECT COUNT(*) FROM tb_directorio_dets b3 
        INNER JOIN tb_acuerdo_cabs c3 ON b3.CODI_SESION=c3.CODI_SESION AND b3.CODI_PERIODO=c3.CODI_PERIODO AND b3.NUME_SECUEN=c3.NUME_SECUEN
        WHERE  b3.CODI_SESION=a.CODI_SESION AND b3.CODI_PERIODO=a.CODI_PERIODO) AS TOTAL_ACUERDOS')
        */
        /*
        ->join('tb_directorio_dets as b', function ($join) {
            $join->on('a.CODI_SESION', '=', 'b.CODI_SESION')
                 ->on('a.CODI_PERIODO', '=', 'b.CODI_PERIODO');
        })
        
        ->join('tb_acuerdo_cabs as c', function ($join2) {
            $join2->on('b.CODI_SESION', '=', 'c.CODI_SESION')
                 ->on('b.CODI_PERIODO', '=', 'c.CODI_PERIODO')
                 ->on('b.NUME_SECUEN', '=', 'c.NUME_SECUEN');
        })*/
        //->groupBy(['a.CODI_SESION','a.CODI_PERIODO','a.FECH_PROGRAMADA','b.NUME_AVANCE','b.CODI_ESTADO']);
        

        if ($codisesion) {
            $query->where('CODI_SESION', $codisesion);
        }

        if ($fechaprogramada) {
            $fechProgramada = Carbon::createFromFormat('Y-m-d', $fechaprogramada)->toDateTimeString();
            $query->whereDate('FECH_PROGRAMADA', $fechProgramada);
        }

        if ($estado) {
            $query->where('CODI_ESTADO', $estado);
        }

        $tbDirectorioCabs = $query->paginate();
        return response()->json([
            'data' => $tbDirectorioCabs->items(),
            'draw' => $request->input('draw'),
            'recordsTotal' => $tbDirectorioCabs->total(),
            'recordsFiltered' => $tbDirectorioCabs->total(),
        ]);
        /*
        return view('tbdirectoriocab.index', compact('tbDirectorioCabs'))
            ->with('i', (request()->input('page', 1) - 1) * $tbDirectorioCabs->perPage());
        */
        //return view('index', ['results' => $results]);
    }
}
