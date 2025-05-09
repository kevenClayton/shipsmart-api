<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportarExcel;
use Carbon\Carbon;

class ExportacaoExcelController extends Controller
{
    public function exportar(Request $request)
    {
        $modelName = $request->get('tipoExportacao'); // Obtenha o nome da classe do modelo
        $model = "App\\Models\\{$modelName}"; // Crie o nome completo da classe do model
        if (!class_exists($model)) {
            return response()->json(['error' => 'Não encontrado'], 404);
        }
        $horarioAtualExportal = Carbon::now()->format('d-m-y h_m');
        $nomeArquivo = $modelName.'-'.$horarioAtualExportal.'-.xlsx';
        return Excel::download(new ExportarExcel($modelName, $request), $nomeArquivo);
    }
}
