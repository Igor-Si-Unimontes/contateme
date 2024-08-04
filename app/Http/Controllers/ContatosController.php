<?php

namespace App\Http\Controllers;

use App\Models\Contatos;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContatosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contatos = Contatos::all();
        return Inertia::render('Contatos/index',['contatos' => $contatos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Contatos/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'telefone' => 'required|min:14',
            'nome' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'imagem' => 'required|file|mimes:jpeg,png,jpg|max:2048', 
        ]);

        $imagem = null;
        if ($request->hasFile('imagem')) {
            $imagem = $request->file('imagem')->store('contatos', 'public');
        }

        $contato = new Contatos($request->except('imagem'));
        $contato->imagem = $imagem;
        $contato->save();

        return redirect()->route('contato.index')->with('success', 'Contato atualizado com sucesso!');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contatos  $contatos
     * @return \Illuminate\Http\Response
     */
    public function show(Contatos $contatos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contatos  $contatos
     * @return \Illuminate\Http\Response
     */
    public function edit(Contatos $contatos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contatos  $contatos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contatos $contato)
{
    if ($request->hasFile('imagem')) {
        if ($contato->imagem) {
            Storage::disk('public')->delete($contato->imagem);
        }
        $imagem = $request->file('imagem')->store('contatos', 'public');
    } else {
        $imagem = $contato->imagem;
    }

    $contato->update($request->except('imagem') + ['imagem' => $imagem]);

    return redirect()->route('contato.index')->with('success', 'Contato atualizado com sucesso!');
}
    
    
    
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contatos  $contatos
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contatos = Contatos::find($id);
        $contatos->delete();
        return redirect('contato');
    }
}
