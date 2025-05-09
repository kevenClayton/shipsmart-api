<?php

namespace App\Exports;


use App\Models\Contato;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;

class ExportarExcel implements FromCollection,WithHeadings,ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $model;
    protected $filtro;
    public function headings(): array
    {

        switch ($this->model) {
            case 'Contato':
                return $this->cabecalhoContatos();
            default:
                return response()->json(['error' => 'Não encontrado'], 404);
        }
    }

    public function __construct($model, $filtro = null)
    {
        $this->model = $model;
        $this->filtro = $filtro;
    }


    public function collection()
    {
        switch ($this->model) {
            case 'Contato':
                return $this->exportarContatos();
            default:
                return response()->json(['error' => 'Não encontrado'], 404);
        }
    }

    protected function cabecalhoContatos(){
        return [
            'Nome',
            'E-mail',
            'Telefone',
            'Endereço'
        ];
    }

    protected function exportarContatos()
    {
        $contatos = Contato::with('enderecos')->get();

        return $contatos->map(function ($contato) {
            $endereco = $contato->enderecos->first();
            $enderecoCompleto = $endereco
                ? "{$endereco->endereco}, {$endereco->numero} - {$endereco->bairro}, {$endereco->cidade}/{$endereco->estado}"
                : '';

            return [
                'nome' => $contato->nome,
                'email' => $contato->email,
                'telefone' => $contato->telefone,
                'endereco' =>" $enderecoCompleto",
            ];
        });
    }


    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:N1')->getFont()->setBold(true);

    }

}
