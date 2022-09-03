<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Redirect;

use Auth;
use App\Models\Seance;
use App\Models\Exercice;
use App\Models\Machine;

class ExerciceController extends Controller
{
    public function create(Seance $seance){
        return Inertia::render('Seances/Layout', [
            'seance' => $seance,
            'active_tab' => "Exercice/Create",
            'machines' => Auth::user()->machines()->orderBy('nom')->get()
        ]);
    }

    public function store(Request $request, Seance $seance){
        $datas = $this->validation($request);
        $datas['user_id'] = Auth::user()->id;
        $datas['seance_id'] = $seance->id;
        
        Exercice::create($datas);

        return Redirect::route('seances.show', ['seance' => $seance->id])->with('message', 'Exercice créé avec succès.');
    }

    public function edit(Seance $seance, Exercice $exercice){
        return Inertia::render('Seances/Layout', [
            'seance' => $seance,
            'exercice' => $exercice,
            'active_tab' => "Exercice/Create",
            'machines' => Auth::user()->machines()->orderBy('nom')->get()
        ]);
    }

    public function update(Request $request, Seance $seance, Exercice $exercice){
        $datas = $this->validation($request);
        $exercice->update($datas);
        return redirect(route('seances.show', ['seance' => $seance->id]))->with('success','Exercice mis à jour avec succès.');
    }

    public function destroy(Request $request, Seance $seance, Exercice $exercice){
        $exercice->delete();
        return redirect(route('seances.show', ['seance' => $seance]))->with('success','Exercice supprimé avec succès.');
    }

    protected function validation(Request $request){
        return $request->validate([
            'distance' => 'nullable',
            'niveau' => 'nullable',
            'temps' => 'nullable',
            'numero_serie' => 'required',
            'repetitions' => 'nullable',
            'poids' => 'nullable',
            'machine_id' => 'nullable'
        ]);
    }

    public function getLastInput(Machine $machine){
        $res = Seance::orderByDesc('date_debut')->first()->exercices()->where('machine_id', '=', $machine->id)->orderByDesc('repetitions')->first();
        return json_encode($res);
    }
}
