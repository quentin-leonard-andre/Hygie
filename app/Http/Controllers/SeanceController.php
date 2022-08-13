<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Inertia\Inertia;
use Redirect;

use App\Models\Seance;

class SeanceController extends Controller
{
    public function index(){
        return Inertia::render('Seances/Layout', [
            'seances' => Auth::user()->seances()->orderByDesc('date_debut')->get(),
            'active_tab' => "Liste"
        ]);
    }

    public function create(){
        return Inertia::render('Seances/Layout', [
            'seances' => Auth::user()->seances()->orderByDesc('date_debut')->get(),
            'active_tab' => "Nouveau"
        ]);
    }

    public function store(Request $request){
        $datas = $this->validation($request);
        $datas['user_id'] = Auth::user()->id;

        Seance::create($datas);

        return Redirect::route('seances.create')->with('message', 'Séance créée avec succès.');
    }

    public function show(Seance $seance){
        return Inertia::render('Seances/Layout', [
            'seances' => Auth::user()->seances()->orderByDesc('date_debut')->get(),
            'seance' => Seance::with('exercices.machine')->find($seance->id),
            'active_tab' => "Voir"
        ]);
    }

    public function edit(Seance $seance){
        return Inertia::render('Seances/Layout', [
            'seances' => Auth::user()->seances()->orderByDesc('date_debut')->get(),
            'seance' => $seance,
            'active_tab' => "Edition"
        ]);
    }

    public function update(Request $request, Seance $seance){
        $datas = $this->validation($request);
        $seance->update($datas);
        return Redirect::route('seances.index')->with('message', 'Séance modifiée avec succès.');
    }

    public function destroy(Request $request, Seance $seance){
        //Suppression des exercices associés
        foreach($seance->exercices as $exercice){
            $exercice->delete();
        }
        $seance->delete();
        return Redirect::route('seances.index')->with('message', 'Séance supprimée avec succès.');
    }

    protected function validation(Request $request){
        return $request->validate([
            'date_debut' => 'required',
            'date_fin' => 'required|after:date_debut'
        ]);
    }
}