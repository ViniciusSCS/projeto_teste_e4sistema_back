<?php

namespace App\Http\Controllers;

use App\Helpers\ExcelHelper;
use App\Models\Pessoa;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PessoaRequest;
use App\Models\Telefone;
use Illuminate\Support\Facades\Auth;

class PessoaController extends Controller
{

    public function create(PessoaRequest $request)
    {
        $data = $request->all();

        $pessoa = Pessoa::create([
            'nome' => $data['nome'],
            'email' => strtolower($data['email']),
            'endereco' => $data['endereco'],
            'user_id' => Auth::user()->id
        ]);

        $telefone = Telefone::create([
            'telefone' => $data['telefone'],
            'pessoa_id' => $pessoa->id
        ]);

        return ['status' => true, "messages" => 'Pessoa cadastrada com sucesso', "pessoa" => $pessoa, "telefone" => $telefone];
    }

    public function list()
    {
        $id = Auth::user()->id;

        $query = Pessoa::with('usuario')
            ->with('telefone')
            ->where('user_id', '=', DB::raw("'" . $id . "'"))
            ->get();

        return ['status' => true, "pessoas" => $query];
    }

    public function show($id)
    {
        $pessoa = Pessoa::find($id);

        $info = ($pessoa == NULL
            ? ['status' => false, 'message' => 'Pessoa não encotrada']
            : ['status' => true, 'message' => 'Pessoa encontrado', "pessoa" => $pessoa]
        );

        return $info;
    }

    public function update(PessoaRequest $request, $id)
    {
        $pessoa = Pessoa::find($id);
        $telefone = Telefone::where('pessoa_id', $id);

        $data = $request->all();

        $pessoa->update([
            'nome' => $data['nome'],
            'email' => strtolower($data['email']),
            'endereco' => $data['endereco'],
        ]);

        if (isset($data['telefone'])) {
            $telefone->update([
                'telefone' => $data['telefone']
            ]);
        } else {
            $telefone->create([
                'telefone' => $data['telefone'],
                'pessoa_id' => $id
            ]);
        }


        return ['status' => true, "messages" => 'Pessoa atualizada com sucesso', "pessoa" => $pessoa, "telefone" => $telefone];
    }

    public function delete($id)
    {
        $pessoa = Pessoa::find($id);

        $telefone = Telefone::where('pessoa_id', $id)->delete();

        $pessoa->delete($id);

        return ['status' => true, 'message' => 'Pessoa deletada com sucesso!', "pessoa" => $pessoa];
    }

    public function convertTitleToNumber($title)
    {
        $columnNumber = ExcelHelper::titleToNumber($title);

        return ['column_number' => $columnNumber];
    }
}
