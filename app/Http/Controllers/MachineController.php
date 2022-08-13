<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Auth;
use Redirect;

use App\Models\Machine;

class MachineController extends Controller
{
    public function index(){
        return Inertia::render('Machines/Layout', [
            'machines' => Auth::user()->machines,
            'active_tab' => "Liste"
        ]);
    }

    public function create(){
        return Inertia::render('Machines/Layout', [
            'machines' => Auth::user()->machines,
            'active_tab' => "Nouveau"
        ]);
    }

    public function store(Request $request){
        $datas = $this->validation($request);
        $datas['user_id'] = Auth::user()->id;

        Machine::create($datas);

        return Redirect::route('machines.create')->with('message', 'Machine créée avec succès.');
    }

    public function show(Machine $machine){
        return view('machines.show', compact('machine'));
    }

    public function edit(Machine $machine){
        return Inertia::render('Machines/Layout', [
            'machine' => $machine,
            'machines' => Auth::user()->machines,
            'active_tab' => "Edition"
        ]);
    }

    public function update(Request $request, Machine $machine){
        $datas = $this->validation($request);
        $machine->update($datas);
        return Redirect::route('machines.index')->with('message', 'Machine modifiée avec succès.');
    }

    public function destroy(Request $request, Machine $machine){
        $machine->delete();
        return Redirect::route('machines.index')->with('message','Machine supprimée avec succès.');
    }

    protected function validation(Request $request){
        return $request->validate([
            'nom' => 'required',
        ]);
    }
}
