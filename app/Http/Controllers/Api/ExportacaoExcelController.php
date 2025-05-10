<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\ExportacaoService;

class ExportacaoExcelController extends Controller
{
    protected $contato;
    protected $exportacaoServico;
    public function __construct(ExportacaoService $exportacaoServico)
    {
        $this->exportacaoServico = $exportacaoServico;
    }
    public function exportar(Request $request)
    {
        $modelNome = $request->get('tipoExportacao');
        if (!$this->exportacaoServico->modeloEhValido($modelNome)) {
            return response()->json(['error' => 'Tipo de exportação inválido.'], 400);
        }

        $horarioAtualExportal = Carbon::now()->format('d-m-y h_m');
        $nomeArquivo = $modelNome . '-' . $horarioAtualExportal . '-.xlsx';
        return $this->exportacaoServico->gerarExcel($modelNome, $request, $nomeArquivo);
    }
}
