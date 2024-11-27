<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use Illuminate\Http\Request;

class FuncionarioController extends Controller
{

    public function index()
    {
        $funcionarios = Funcionario::all();
        return response()->json($funcionarios);
    }

    public function show($id)
    {
        $funcionario = Funcionario::find($id);

        if (!$funcionario) {
            return response()->json(['message' => 'Funcionário não encontrado'], 404);
        }

        return response()->json($funcionario);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'documento' => 'required|string|unique:funcionarios',
            'sexo' => 'required|in:M,F,Outro',
            'data_nascimento' => 'required|date',
            'telefone' => 'required|string|max:15',
            'email' => 'required|email|unique:funcionarios',
            'endereco' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'salario' => 'required|numeric',
            'status' => 'required|in:ativo,inativo',
        ]);

        $funcionario = Funcionario::create($validatedData);

        return response()->json($funcionario, 201);
    }

    public function update(Request $request, $id)
    {
        $funcionario = Funcionario::find($id);

        if (!$funcionario) {
            return response()->json(['message' => 'Funcionário não encontrado'], 404);
        }

        $validatedData = $request->validate([
            'nome' => 'nullable|string|max:255',
            'documento' => 'nullable|string|unique:funcionarios,documento,' . $id,
            'sexo' => 'nullable|in:M,F,Outro',
            'data_nascimento' => 'nullable|date',
            'telefone' => 'nullable|string|max:15',
            'email' => 'nullable|email|unique:funcionarios,email,' . $id,
            'endereco' => 'nullable|string|max:255',
            'cargo' => 'nullable|string|max:255',
            'salario' => 'nullable|numeric',
            'status' => 'nullable|in:ativo,inativo',
        ]);

        $funcionario->update($validatedData);

        return response()->json($funcionario);
    }

    public function destroy($id)
    {
        $funcionario = Funcionario::find($id);

        if (!$funcionario) {
            return response()->json(['message' => 'Funcionário não encontrado'], 404);
        }

        $funcionario->delete();

        return response()->json(['message' => 'Funcionário removido com sucesso']);
    }
}
