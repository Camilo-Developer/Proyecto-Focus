<?php

namespace App\Http\Controllers\Admin\EmployeeIncomes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmployeeIncomes\EmployeeincomesCreateRequest;
use App\Http\Requests\Admin\EmployeeIncomes\EmployeeincomesUpdateRequest;
use App\Models\Agglomeration\Agglomeration;
use App\Models\Element\Element;
use App\Models\EmployeeIncome\Employeeincome;
use App\Models\Goal\Goal;
use App\Models\SetResidencial\Setresidencial;
use App\Models\Unit\Unit;
use App\Models\User;
use App\Models\Visitor\Visitor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class EmployeeincomesController extends Controller
{
    public function __construct(){
        $this->middleware('can:admin.employeeincomes.index')->only('index');
        $this->middleware('can:admin.employeeincomes.edit')->only('edit', 'update');
        $this->middleware('can:admin.employeeincomes.create')->only('create', 'store');
        $this->middleware('can:admin.employeeincomes.show')->only('show');
        $this->middleware('can:admin.employeeincomes.destroy')->only('destroy');
    }

    public function index()
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        $employeeincomes = Employeeincome::all();
        return view('admin.employeeincomes.index',compact('employeeincomes'));
    }

    public function create()
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        if (auth()->user()->hasRole('ADMINISTRADOR')) {
            $visitors = Visitor::where('state_id',1)->get();
            $elements = Element::all();
            $setresidencials = Setresidencial::where('state_id',1)->get();
            $goals = Goal::where('state_id',1)->get();
            $users = User::where('state_id', 1)
                ->whereHas('roles', function ($query) {
                    $query->where('id', 3);
                })
            ->get();

            $units = Unit::where('state_id',1)->get();
            $agglomerations = Agglomeration::where('state_id',1)->get();
            return view('admin.employeeincomes.create',compact('visitors','elements','setresidencials','goals','users','units','agglomerations'));
        }elseif (auth()->user()->hasRole('SUB_ADMINISTRADOR') || auth()->user()->hasRole('PORTERO')) {
            $setresidencial = auth()->user()->setresidencials()->where('state_id', 1)->first();

            $visitors = Visitor::where('setresidencial_id', $setresidencial->id)->where('state_id',1)->get();
            $elements = Element::all();

            $goals = Goal::where('setresidencial_id', $setresidencial->id)->where('state_id',1)->get();

            $users = User::where('state_id', 1)
                ->whereHas('roles', function ($query) {
                    $query->where('id', 3);
                })
                ->whereHas('setresidencials', function ($query) use ($setresidencial) {
                    $query->where('setresidencials.id', $setresidencial->id);
                })
            ->get();

            $agglomerations = Agglomeration::where('setresidencial_id', $setresidencial->id)->where('state_id',1)->get();

            
            return view('admin.employeeincomes.create',compact('visitors','elements','setresidencial','goals','users','agglomerations'));
        }
    }

    public function store(Request $request)
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }

        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        $validated = $request->validate([
            'visitor_id' => 'required|integer|exists:visitors,id',
            'agglomeration_id' => 'required|integer|exists:agglomerations,id',
            'unit_id' => 'required|integer|exists:units,id',
            'setresidencial_id' => 'required|integer|exists:setresidencials,id',
            'admission_date' => 'required|date',
            'user_id' => 'nullable|integer|exists:users,id',
            'goal_id' => 'nullable|integer|exists:goals,id',
            'goal2_id' => 'nullable|integer|exists:goals,id',
            'nota' => 'nullable|string',
            'elements' => 'nullable|array',
            'elements.*' => 'integer|exists:elements,id',
            'photos' => 'nullable|array',
            'photos.*' => 'nullable|string',
            'notaElement' => 'nullable|array',
            'notaElement.*' => 'nullable|string',
        ], [
            'visitor_id.required' => 'EL CAMPO VISITANTE ES OBLIGATORIO.',
            'agglomeration_id.required' => 'EL CAMPO AGLOMERACIÓN ES OBLIGATORIO.',
            'unit_id.required' => 'EL CAMPO UNIDAD ES OBLIGATORIO.',
            'setresidencial_id.required' => 'EL CAMPO CONJUNTO RESIDENCIAL ES OBLIGATORIO.',
            'admission_date.required' => 'EL CAMPO FECHA DE INGRESO ES OBLIGATORIO.',
            'visitor_id.exists' => 'EL VISITANTE SELECCIONADO NO EXISTE.',
            'agglomeration_id.exists' => 'LA AGLOMERACIÓN SELECCIONADA NO EXISTE.',
            'unit_id.exists' => 'LA UNIDAD SELECCIONADA NO EXISTE.',
            'setresidencial_id.exists' => 'EL CONJUNTO RESIDENCIAL SELECCIONADO NO EXISTE.',
            'admission_date.date' => 'LA FECHA DE INGRESO NO ES UNA FECHA VÁLIDA.',
        ]);


        if (auth()->user()->hasRole('ADMINISTRADOR') || auth()->user()->hasRole('SUB_ADMINISTRADOR')) {
            $employeeIncome = Employeeincome::create([
                'visitor_id' => $validated['visitor_id'],
                'agglomeration_id' => $validated['agglomeration_id'],
                'unit_id' => $validated['unit_id'],
                'setresidencial_id' => $validated['setresidencial_id'],
                'admission_date' => $validated['admission_date'],
                'user_id' => $validated['user_id'] ?? null,
                'goal_id' => $validated['goal_id'] ?? null,
                'goal2_id' => $validated['goal2_id'] ?? null,
                'nota' => $validated['nota'] ?? null,
            ]);
        } elseif (auth()->user()->hasRole('PORTERO')) {
            $employeeIncome = Employeeincome::create([
                'visitor_id' => $validated['visitor_id'],
                'setresidencial_id' => $validated['setresidencial_id'],
                'admission_date' => $validated['admission_date'],
                'user_id' => Auth::user()->id,
                'goal_id' => session('current_goal'),
                'nota' => $validated['nota'] ?? null,
                'agglomeration_id' => $validated['agglomeration_id'],
                'unit_id' => $validated['unit_id'],
            ]);
        }

        if (!empty($validated['elements'])) {
            foreach ($validated['elements'] as $index => $elementId) {
                $photoPath = null;

                if (!empty($validated['photos'][$index])) {
                    $base64Image = $validated['photos'][$index];
                    $image = str_replace('data:image/png;base64,', '', $base64Image);
                    $image = str_replace(' ', '+', $image);
                    $imageName = 'Employeeincomes/' . date('YmdHis') . '_' . $index . '.png';
                    \File::put(public_path('storage/' . $imageName), base64_decode($image));
                    $photoPath = $imageName;
                }

                $employeeIncome->elements()->attach($elementId, [
                    'imagen' => $photoPath,
                    'nota' => $validated['notaElement'][$index] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.employeeincomes.index')->with('success','LA CREACIÓN DEL INGRESO FUE ÉXITOSA.');
    }


    public function show(Employeeincome $employeeincome)
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }
        $employeeElements = $employeeincome->elements()->get();
        $elements = Element::all();

        return view('admin.employeeincomes.show',compact('employeeincome','employeeElements','elements'));
    }

    public function edit(Employeeincome $employeeincome)
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }
        if (auth()->user()->hasRole('ADMINISTRADOR')) {

            $visitors = Visitor::where('state_id', 1)
            ->orWhere(function ($query) use ($employeeincome) {
                $query->where('state_id', 2)
                      ->whereHas('employeeincomes', function ($q) use ($employeeincome) {
                          $q->where('visitor_id', $employeeincome->visitor_id);
                      });
            })
            ->get();
            $setresidencials = Setresidencial::where('state_id', 1)
            ->orWhere(function ($query) use ($employeeincome) {
                $query->where('state_id', 2)
                      ->whereHas('employeeincomes', function ($q) use ($employeeincome) {
                          $q->where('setresidencial_id', $employeeincome->setresidencial_id);
                      });
            })->get();



            $goals = Goal::where('state_id',1)
                ->orWhere(function ($query) use ($employeeincome) {
                    $query->where('state_id', 2)
                        ->whereHas('employeeincomes', function ($q) use ($employeeincome) {
                            $q->where('goal_id', $employeeincome->goal_id);
                        });
                })
            ->get();
            $goals2 = Goal::where('state_id',1)
                ->orWhere(function ($query) use ($employeeincome) {
                    $query->where('state_id', 2)
                        ->whereHas('employeeincomes2', function ($q) use ($employeeincome) {
                            $q->where('goal2_id', $employeeincome->goal2_id);
                        });
                })
            ->get();

            $users = User::where('state_id', 1)
                ->whereHas('roles', function ($query) {
                    $query->where('id', 3);
                })
                ->orWhere(function ($query) use ($employeeincome) {
                    $query->where('state_id', 2)
                        ->whereHas('employeeincomes', function ($q) use ($employeeincome) {
                            $q->where('user_id', $employeeincome->user_id);
                        });
                })
              
            ->get();

            $agglomerations = Agglomeration::where('state_id', 1)
                ->orWhere(function ($query) use ($employeeincome) {
                    $query->where('state_id', 2)
                        ->whereHas('employeeincomes', function ($q) use ($employeeincome) {
                            $q->where('agglomeration_id', $employeeincome->agglomeration_id);
                        });
                })
            ->get();

            $units = Unit::where('agglomeration_id', $employeeincome->agglomeration_id)->get();


            $elements = Element::all();
            $employeeElements = $employeeincome->elements()->get();
            return view('admin.employeeincomes.edit',compact('employeeincome','visitors','elements','employeeElements','setresidencials','goals','goals2','users','agglomerations','units'));
        }elseif (auth()->user()->hasRole('SUB_ADMINISTRADOR') || auth()->user()->hasRole('PORTERO')) {
            $setresidencial = auth()->user()->setresidencials()->where('state_id', 1)->first();

            $visitors = Visitor::where('setresidencial_id', $setresidencial->id)
            ->where('state_id', 1)
            ->orWhere(function ($query) use ($employeeincome) {
                $query->where('state_id', 2)
                      ->whereHas('employeeincomes', function ($q) use ($employeeincome) {
                          $q->where('visitor_id', $employeeincome->visitor_id);
                      });
            })->get();
            $elements = Element::all();
            $employeeElements = $employeeincome->elements()->get();

            $goals = Goal::where('setresidencial_id', $setresidencial->id)
            ->where('state_id',1)
                ->orWhere(function ($query) use ($employeeincome) {
                    $query->where('state_id', 2)
                        ->whereHas('employeeincomes', function ($q) use ($employeeincome) {
                            $q->where('goal_id', $employeeincome->goal_id);
                        });
                })
            ->get();

            $goals2 = Goal::where('setresidencial_id', $setresidencial->id)
            ->where('state_id',1)
                ->orWhere(function ($query) use ($employeeincome) {
                    $query->where('state_id', 2)
                        ->whereHas('employeeincomes', function ($q) use ($employeeincome) {
                            $q->where('goal2_id', $employeeincome->goal2_id);
                        });
                })
            ->get();

            $users = User::where('state_id', 1)
                ->whereHas('roles', function ($query) {
                    $query->where('id', 3);
                })
                ->whereHas('setresidencials', function ($query) use ($setresidencial) {
                    $query->where('setresidencials.id', $setresidencial->id);
                })
                ->orWhere(function ($query) use ($employeeincome) {
                    $query->where('state_id', 2)
                        ->whereHas('employeeincomes', function ($q) use ($employeeincome) {
                            $q->where('user_id', $employeeincome->user_id);
                        });
                })
            
            ->get();

            $agglomerations = Agglomeration::where('setresidencial_id', $setresidencial->id)
                ->where('state_id', 1)
                ->orWhere(function ($query) use ($employeeincome) {
                    $query->where('state_id', 2)
                        ->whereHas('employeeincomes', function ($q) use ($employeeincome) {
                            $q->where('agglomeration_id', $employeeincome->agglomeration_id);
                        });
                })
            ->get();

            $units = Unit::where('agglomeration_id', $employeeincome->agglomeration_id)->get();

            return view('admin.employeeincomes.edit',compact('employeeincome','visitors','elements','employeeElements','setresidencial','goals','goals2','users','agglomerations','units'));
        }

    }

    public function update(Request $request, Employeeincome $employeeincome)
{
    if (auth()->user()->state_id == 2) {
        Auth::logout();
        return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
    }

    $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

    if (auth()->user()->id !== 1) {
        if (empty($authSetresidencials)) {
            Auth::logout();
            return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
    }
    if (auth()->user()->hasRole('ADMINISTRADOR') || auth()->user()->hasRole('SUB_ADMINISTRADOR')) {
        $employeeincome->update([
            'visitor_id' =>  $request->input('visitor_id'),
            'admission_date' => $employeeincome->admission_date,
            'departure_date' => $employeeincome->departure_date,
            'nota' => $request->input('nota'),
            'user_id' => $request->input('user_id') ?? null,
            'goal_id' => $request->input('goal_id') ?? null,
            'goal2_id' => $request->input('goal2_id') ?? null,
            'agglomeration_id' => $request->input('agglomeration_id') ?? null,
            'unit_id' => $request->input('unit_id') ?? null,
        ]);

    }elseif(auth()->user()->hasRole('PORTERO')){
        $employeeincome->update([
            'visitor_id' =>  $request->input('visitor_id'),
            'admission_date' => $employeeincome->admission_date,
            'departure_date' => $employeeincome->departure_date,
            'nota' => $request->input('nota'),
            'user_id' => Auth::user()->id,
            'agglomeration_id' => $request->input('agglomeration_id') ?? null,
            'unit_id' => $request->input('unit_id') ?? null,
            'goal_id' => $employeeincome->goal_id,
            'goal2_id' => $employeeincome->goal2_id,
        ]);
    }

    $currentElements = $employeeincome->elements()->get();

    if ($request->has('elements') && is_array($request->elements)) {
        $elements = $request->elements;
        $photos = $request->photos;
        $notas = $request->notaElement;
        $id = $request->emploElements;

        foreach ($currentElements as $currentElement) {
            if (!in_array($currentElement->pivot->id, $id)) {
                if ($currentElement->pivot->imagen && file_exists(public_path('storage/' . $currentElement->pivot->imagen))) {
                    unlink(public_path('storage/' . $currentElement->pivot->imagen));
                }
                $employeeincome->elements()->detach($currentElement->pivot->element_id);
            }
        }

        foreach ($elements as $index => $elementId) {
            $photo = $photos[$index] ?? null;
            $nota = $notas[$index] ?? null;
            $elementPivotId = $id[$index] ?? null;

            $data = ['nota' => $nota];

            if ($photo) {
                if (strpos($photo, 'data:image/') === 0) {
                    [$type, $image] = explode(';', $photo);
                    [, $image] = explode(',', $image);

                    $extension = str_contains($type, 'image/png') ? 'png' : 'jpeg';
                    $imageName = 'Employeeincomes/' . date('YmdHis') . '_' . $index . '.' . $extension;

                    \File::put(public_path('storage/' . $imageName), base64_decode($image));
                    $data['imagen'] = $imageName;

                    if ($elementPivotId) {
                        $currentPivot = $currentElements->firstWhere('pivot.id', $elementPivotId);
                        if ($currentPivot && $currentPivot->pivot->imagen && file_exists(public_path('storage/' . $currentPivot->pivot->imagen))) {
                            unlink(public_path('storage/' . $currentPivot->pivot->imagen));
                        }
                    }
                } elseif (strpos($photo, 'Employeeincomes/') === 0) {
                    $data['imagen'] = $photo;
                }
            }

            if ($elementPivotId) {
                $existingPivot = $currentElements->firstWhere('pivot.id', $elementPivotId);
                if ($existingPivot) {
                    DB::table('element_has_employeeincome')
                        ->where('id', $elementPivotId)
                        ->update(array_merge(['element_id' => $elementId], $data));
                }
            } else {
                $employeeincome->elements()->attach($elementId, $data);
            }
        }
    } else {
        // Si no se envían elementos, eliminar todos los elementos asociados
        foreach ($currentElements as $currentElement) {
            if ($currentElement->pivot->imagen && file_exists(public_path('storage/' . $currentElement->pivot->imagen))) {
                unlink(public_path('storage/' . $currentElement->pivot->imagen));
            }
        }
        $employeeincome->elements()->detach();
    }

    return redirect()->route('admin.employeeincomes.index')->with('edit', 'LA EDICIÓN DEL INGRESO FUE ÉXITOSA.');
}




    public function destroy(Employeeincome $employeeincome)
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }
        
        // Obtener los elementos asociados al ingreso
        $currentElements = $employeeincome->elements()->get();

        // Eliminar imágenes asociadas y relaciones en la tabla pivot
        foreach ($currentElements as $currentElement) {
            if ($currentElement->pivot->imagen && file_exists(public_path('storage/' . $currentElement->pivot->imagen))) {
                unlink(public_path('storage/' . $currentElement->pivot->imagen));
            }
        }

        // Desvincular todos los elementos
        $employeeincome->elements()->detach();

        // Eliminar el ingreso
        $employeeincome->delete();
        
        return redirect()->route('admin.employeeincomes.index')->with('delete','LA ELIMINACIÓN DEL INGRESO FUE ÉXITOSA.');
    }

    public function dateFinisConfir($id)
    {
        if (auth()->user()->hasRole('ADMINISTRADOR') || auth()->user()->hasRole('SUB_ADMINISTRADOR')) {
            $employeeincome = Employeeincome::findOrFail($id);
            $employeeincome->departure_date = Carbon::now()->format('Y-m-d H:i');
            $employeeincome->save();
            return response()->json(['success' => true, 'message' => 'SE ACTUALIZO CORRECTAMENTE LA FECHA DE SALIDA.']);

        }elseif(auth()->user()->hasRole('PORTERO')){

        $employeeincome = Employeeincome::findOrFail($id);
        $employeeincome->departure_date = Carbon::now()->format('Y-m-d H:i');
        $employeeincome->goal2_id = session('current_goal');
        $employeeincome->save();
        return response()->json(['success' => true, 'message' => 'SE ACTUALIZO CORRECTAMENTE LA FECHA DE SALIDA.']);
       }
    }


    public function getUnitsByAgglomeration($agglomeration_id)
    {
        $units = Unit::where('agglomeration_id', $agglomeration_id)
                    ->where(function ($query) {
                        $query->where('state_id', 1)
                            ->orWhere(function ($query) {
                                $query->where('state_id', 2)
                                        ->whereHas('employeeincomes', function ($q) {
                                            $q->where('agglomeration_id', request()->agglomeration_id);
                                        });
                            });
                    })
                    ->with('agglomeration')
                    ->get();

        return response()->json($units);
    }
    
}
