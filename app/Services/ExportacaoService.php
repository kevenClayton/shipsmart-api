<?php

namespace App\Services;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportarExcel;

class ExportacaoService
{
    public function modeloEhValido(string $modelo): bool
    {
        $permitidos = ['Contato'];
        return in_array($modelo, $permitidos) && class_exists("App\\Models\\{$modelo}");
    }

    public function gerarExcel($modelNome, $request, $nomeArquivo){
        return Excel::download(new ExportarExcel($modelNome, $request), $nomeArquivo);
    }

}
