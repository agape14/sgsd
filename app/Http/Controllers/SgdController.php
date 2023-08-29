<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Arr;
class SgdController extends Controller
{
    
    public function getdocumentoporexp(Request $request){
        $nroExp=$request->input('DO_EXPE_CODI');
        $doPeri=$request->input('DO_PERI');
        
        $query = DB::table('DOCUMENTO')
        ->join('TIPO_DOCUMENTO', 'DOCUMENTO.TD_CODI', '=', 'TIPO_DOCUMENTO.TD_CODI')
        ->join('ESTADO_DOCUMENTO', 'DOCUMENTO.ED_CODI', '=', 'ESTADO_DOCUMENTO.ED_CODI')
        ->join('AREA', 'DOCUMENTO.DO_AREA', '=', 'AREA.AR_CODI')
        ->select(
            'DOCUMENTO.DO_CODI',
            'TIPO_DOCUMENTO.TD_CODI',
            'DOCUMENTO.DO_ASUN',
            DB::raw("TIPO_DOCUMENTO.TD_NOMB+' '+CAST(CAST(RIGHT('000000' + Ltrim(Rtrim(DOCUMENTO.DO_TD_CODI)),6) AS VARCHAR(8)) + ' - ' + CAST(DOCUMENTO.DO_PERI AS VARCHAR(4)) + ' - ' + 'EMILIMA' AS VARCHAR(50)) + ' - ' + AREA.AR_SIGL AS DO_DESC_STR"),
            DB::raw("CAST(CAST(RIGHT('000000' + Ltrim(Rtrim(DOCUMENTO.DO_TD_CODI)),6) AS VARCHAR(8)) + ' - ' + CAST(DOCUMENTO.DO_PERI AS VARCHAR(4)) + ' - ' + 'EMILIMA' AS VARCHAR(50)) + ' - ' + AREA.AR_SIGL AS DO_NUME_STR"),
            DB::raw('CONVERT(VARCHAR(10), CAST(DOCUMENTO.DO_FECH AS DATE), 103)  FECHA_DOC'),
            'DOCUMENTO.DO_TD_CODI',
            'DOCUMENTO.DO_FOLI',
            'TIPO_DOCUMENTO.TD_NOMB',
            'ESTADO_DOCUMENTO.ED_DESC',
            'AREA.AR_SIGL',
        )
        ->whereIn('DOCUMENTO.DO_EXPE_ORIG', ['I','E']);
        if ($nroExp) {
            $query->where('DOCUMENTO.DO_EXPE_CODI', $nroExp);
        }else{
            $query->where('DOCUMENTO.DO_EXPE_CODI', '0');
        }
        if ($doPeri) {
            $query->where('DOCUMENTO.DO_PERI', $doPeri);
        }else{
            $query->where('DOCUMENTO.DO_PERI', '2010');
        }
        
        $tbDocumentosSGD = $query->orderByDesc('DOCUMENTO.DO_CODI')->get();
        
        return Datatables::of($tbDocumentosSGD)->addIndexColumn()
            ->addColumn('action', function($row){
                $buttons = '<button class="btn btn-primary btn-sm m-1" id="btnAddDocSgd" data-do-codi="'.$row->DO_CODI.'" data-docu-desc="'.$row->DO_DESC_STR.'" ><i class="bi bi-save-fill" data-bs-toggle="tooltip" data-bs-placement="Top" title="Sustento"></i></button>';
                return $buttons;
            })
            ->rawColumns(['action'])
            ->make(true);
        return view('tbdirectoriocab.index');
    }

    public function getAnios(){
        $currentYear = Carbon::now()->year;
        $years = range(2021, $currentYear);
        $yearList = array_combine($years, $years);
        $yearList = Arr::sortDesc($yearList);
        return response()->json($yearList);
    }
}
