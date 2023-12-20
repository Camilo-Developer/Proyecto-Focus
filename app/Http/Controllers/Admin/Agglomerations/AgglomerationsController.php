<?php

namespace App\Http\Controllers\Admin\Agglomerations;

use App\Http\Controllers\Controller;
use App\Models\Agglomeration\Agglomeration;
use App\Models\SetResidencial\Setresidencial;
use App\Models\State\State;
use Illuminate\Http\Request;

class AgglomerationsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $agglomerations = Agglomeration::query()
            ->where('name', 'LIKE', "%$search%")
            ->paginate(5);
        $states = State::all();
        $setresidencials = Setresidencial::all();
        return view('admin.agglomerations.index',compact('agglomerations','states','search','setresidencials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type_agglomeration' => 'required',
            'state_id' => 'required',
            'setresidencial_id' => 'required',
        ]);
        $agglomerations = $request->all();
        Agglomeration::create($agglomerations);
        return redirect()->route('admin.agglomerations.index')->with('success','La aglomeración del conjunto fue creada correctamente.');

    }

    public function show(Agglomeration $agglomeration)
    {
        //
    }

    public function edit(Agglomeration $agglomeration)
    {
        return view('admin.agglomerations.index',compact('agglomeration'));

    }

    public function update(Request $request, Agglomeration $agglomeration)
    {
        $request->validate([
            'name' => 'required',
            'type_agglomeration' => 'required',
            'state_id' => 'required',
            'setresidencial_id' => 'required',
        ]);
        $data = $request->all();
        $agglomeration->update($data);
        return redirect()->route('admin.agglomerations.index')->with('edit','La aglomeración del conjunto fue editada correctamente.');

    }

    public function destroy(Agglomeration $agglomeration)
    {
        $agglomeration->delete();
        return redirect()->route('admin.agglomerations.index')->with('delete','La aglomeración del conjunto fue eliminada correctamente.');
    }
}
