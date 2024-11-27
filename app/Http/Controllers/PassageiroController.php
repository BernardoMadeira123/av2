<?php

namespace App\Http\Controllers;

use App\Models\Passageiro;
use Illuminate\Http\Request;

class PassageiroController extends Controller
{

    public function index()
    {
        $passageiros = Passageiro::all();
        return response()->json($passageiros);
    }

    public function show($id)
    {
        $passageiro = Passageiro::find($id);

        if (!$passageiro) {
            return response()->json(['message' => 'Passageiro não encontrado'], 404);
        }

        return response()->json($passageiro);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'documento' => 'required|string|unique:passageiros',
            'data_nascimento' => 'required|date',
            'sexo' => 'required|in:M,F',
            'endereco' => 'required|string|max:255',
            'telefone' => 'required|string|max:15',
            'email' => 'required|email|unique:passageiros',
            'nacionalidade' => 'required|string|max:255',
        ]);

        $passageiro = Passageiro::create($validatedData);

        return response()->json($passageiro, 201);
    }

    public function update(Request $request, $id)
    {
        $passageiro = Passageiro::find($id);

        if (!$passageiro) {
            return response()->json(['message' => 'Passageiro não encontrado'], 404);
        }

        $validatedData = $request->validate([
            'nome' => 'nullable|string|max:255',
            'documento' => 'nullable|string|unique:passageiros,documento,' . $id,
            'data_nascimento' => 'nullable|date',
            'sexo' => 'nullable|in:M,F',
            'endereco' => 'nullable|string|max:255',
            'telefone' => 'nullable|string|max:15',
            'email' => 'nullable|email|unique:passageiros,email,' . $id,
            'nacionalidade' => 'nullable|string|max:255',
        ]);

        $passageiro->update($validatedData);

        return response()->json($passageiro);
    }

    public function destroy($id)
    {
        $passageiro = Passageiro::find($id);

        if (!$passageiro) {
            return response()->json(['message' => 'Passageiro não encontrado'], 404);
        }

        $passageiro->delete();

        return response()->json(['message' => 'Passageiro removido com sucesso']);
    }
}
