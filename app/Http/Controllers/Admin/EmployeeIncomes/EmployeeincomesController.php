<?php

namespace App\Http\Controllers\Admin\EmployeeIncomes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmployeeIncomes\EmployeeincomesCreateRequest;
use App\Http\Requests\Admin\EmployeeIncomes\EmployeeincomesUpdateRequest;
use App\Models\Agglomeration\Agglomeration;
use App\Models\Element\Element;
use App\Models\EmployeeIncome\Employeeincome;
use App\Models\ExitEntry\ExitEntry;
use App\Models\Goal\Goal;
use App\Models\SetResidencial\Setresidencial;
use App\Models\Unit\Unit;
use App\Models\User;
use App\Models\Vehicle\Vehicle;
use App\Models\Visitor\Visitor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Str;

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

        if(auth()->user()->id !== 1 && auth()->user()->id !== 2){
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

        if(auth()->user()->id !== 1 && auth()->user()->id !== 2){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        if (auth()->user()->can('admin.permission.administrator')) {
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
            $vehicles = Vehicle::where('state_id',1)->get();
            return view('admin.employeeincomes.create',compact('visitors','elements','setresidencials','goals','users','units','agglomerations','vehicles'));
        }elseif (auth()->user()->can('admin.permission.subadministrator') || auth()->user()->can('admin.permission.goalie')) {
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
            $vehicles = Vehicle::where('setresidencial_id', $setresidencial->id)->where('state_id',1)->get();

            
            return view('admin.employeeincomes.create',compact('visitors','elements','setresidencial','goals','users','agglomerations','vehicles'));
        }
    }

    public function store(Request $request)
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }

        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1 && auth()->user()->id !== 2){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        $validated = $request->validate([
            'type_income' => 'required',
            'admission_date' => 'required|date',
            'nota' => 'nullable|string',
            'visitor_id' => 'nullable|array',
            'visitor_id.*' => 'integer|exists:visitors,id',
            'setresidencial_id' => 'required|integer|exists:setresidencials,id',
            'agglomeration_id' => 'required|integer|exists:agglomerations,id',
            'unit_id' => 'required|integer|exists:units,id',
            'goal_id' => 'nullable|integer|exists:goals,id',
            'user_id' => 'nullable|integer|exists:users,id',
            'vehicle_id' => 'nullable|integer|exists:vehicles,id',
            'elements' => 'nullable|array',
            'elements.*' => 'integer|exists:elements,id',
            'photos' => 'nullable|array',
            'photos.*' => 'nullable|string',
            'notaElement' => 'nullable|array',
            'notaElement.*' => 'nullable|string',
        ], [
            'visitor_id.*.exists' => 'ALGUNO DE LOS VISITANTES SELECCIONADOS NO EXISTE.',
            'type_income.required' => 'EL CAMPO TIPO INGRESO ES OBLIGATORIO.',
            'agglomeration_id.required' => 'EL CAMPO AGLOMERACIÓN ES OBLIGATORIO.',
            'unit_id.required' => 'EL CAMPO UNIDAD ES OBLIGATORIO.',
            'setresidencial_id.required' => 'EL CAMPO CONJUNTO RESIDENCIAL ES OBLIGATORIO.',
            'admission_date.required' => 'EL CAMPO FECHA DE INGRESO ES OBLIGATORIO.',
            'agglomeration_id.exists' => 'LA AGLOMERACIÓN SELECCIONADA NO EXISTE.',
            'unit_id.exists' => 'LA UNIDAD SELECCIONADA NO EXISTE.',
            'setresidencial_id.exists' => 'EL CONJUNTO RESIDENCIAL SELECCIONADO NO EXISTE.',
            'admission_date.date' => 'LA FECHA DE INGRESO NO ES UNA FECHA VÁLIDA.',
        ]);



        if (auth()->user()->can('admin.permission.administrator') && auth()->user()->can('admin.permission.subadministrator')) {
            $employeeIncome = Employeeincome::create([
                'type_income' => $validated['type_income'],
                'admission_date' => $validated['admission_date'],
                'nota' => $validated['nota'] ?? null,
                'setresidencial_id' => $validated['setresidencial_id'],
                'agglomeration_id' => $validated['agglomeration_id'],
                'unit_id' => $validated['unit_id'],
                'user_id' => $validated['user_id'] ?? null,
                'goal_id' => $validated['goal_id'] ?? null,
            ]);

            if (!empty($validated['visitor_id'])) {
                foreach ($validated['visitor_id'] as $visitorId) {
                    $employeeIncome->vehicles()->attach(
                        ['vehicle_id' => $validated['vehicle_id'] ?? null],
                        ['visitor_id' => $visitorId]
                    );
                }
            }


        } elseif (auth()->user()->can('admin.permission.goalie')) {
            $employeeIncome = Employeeincome::create([
                'type_income' => $validated['type_income'],
                'admission_date' => $validated['admission_date'],
                'nota' => $validated['nota'] ?? null,
                'setresidencial_id' => $validated['setresidencial_id'],
                'agglomeration_id' => $validated['agglomeration_id'],
                'unit_id' => $validated['unit_id'],
                'user_id' => Auth::user()->id,
                'goal_id' => session('current_goal'),
            ]);

            if (!empty($validated['visitor_id'])) {
                foreach ($validated['visitor_id'] as $visitorId) {
                    $employeeIncome->vehicles()->attach(
                        ['vehicle_id' => $validated['vehicle_id'] ?? null],
                        ['visitor_id' => $visitorId]
                    );
                }
            }
        }


        if (!empty($validated['elements'])) {
            foreach ($validated['elements'] as $index => $elementId) {
                $photoPath = null;

                if (!empty($validated['photos'][$index])) {
                    $base64Image = $validated['photos'][$index];
                    $image = str_replace('data:image/png;base64,', '', $base64Image);
                    $image = str_replace(' ', '+', $image);
                    $imageName = 'Employeeincomes/' . Str::random(20) . '_' . $index . '.png';
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

        if(auth()->user()->id !== 1 && auth()->user()->id !== 2){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }
        $employeeElements = $employeeincome->elements()->get();
        $elements = Element::all();

                
        $exitEntry = ExitEntry::where('employeeincome_id',$employeeincome->id)->latest()->first();

        return view('admin.employeeincomes.show',compact('employeeincome','employeeElements','elements','exitEntry'));
    }

    public function edit(Employeeincome $employeeincome)
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1 && auth()->user()->id !== 2){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }
        if (auth()->user()->can('admin.permission.administrator')) {

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

            $vehicles = Vehicle::where('state_id',1)
                ->orWhere(function ($query) use ($employeeincome) {
                    $query->where('state_id', 2)
                        ->whereHas('employeeincomes', function ($q) use ($employeeincome) {
                            $q->where('vehicle_id', $employeeincome->vehicle_id);
                        });
                })
            ->get();

            $units = Unit::where('agglomeration_id', $employeeincome->agglomeration_id)->get();


            $elements = Element::all();
            $employeeElements = $employeeincome->elements()->get();
            return view('admin.employeeincomes.edit',compact('employeeincome','visitors','elements','employeeElements','setresidencials','goals','users','agglomerations','units','vehicles'));
        }elseif (auth()->user()->can('admin.permission.subadministrator') || auth()->user()->can('admin.permission.goalie')) {
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

        if (auth()->user()->id !== 1 && auth()->user()->id !== 2) {
            if (empty($authSetresidencials)) {
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }
        if (auth()->user()->can('admin.permission.administrator') || auth()->user()->can('admin.permission.subadministrator')) {
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

        }elseif(auth()->user()->can('admin.permission.goalie')){
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
                        $imageName = 'Employeeincomes/' . Str::random(20) . '_' . $index . '.' . $extension;

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




    public function createExit(Employeeincome $employeeincome, Request $request)
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1 && auth()->user()->id !== 2){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

            $idVisitor = $request->ingVi ? explode(',', $request->ingVi) : [];
            $identi = $request->iden;
            $idVehicle = $request->vehicle;

        if (auth()->user()->can('admin.permission.administrator')) {
            $goals = Goal::where('state_id',1)->get();
            $users = User::where('state_id', 1)
                ->whereHas('roles', function ($query) {
                    $query->where('id', 3);
                })
            ->get();

            $elements = Element::all();

            $exitEntry = ExitEntry::whereHas('vehicles', function ($query) use ($idVehicle) {
                    $query->where('vehicles.id', $idVehicle);
                })
                ->with(['vehicles', 'visitors'])
                ->latest()
            ->first();


            if ($exitEntry && $employeeincome->id === $exitEntry->employeeincome_id) {
                // Se queda con la salida encontrada
            } else {
                $exitEntry = null;
            }


            return view('admin.employeeincomes.createExit',compact('employeeincome','goals','users','elements','exitEntry'));
        } elseif (auth()->user()->can('admin.permission.subadministrator') || auth()->user()->can('admin.permission.goalie')) {

            $setresidencial = auth()->user()->setresidencials()->where('state_id', 1)->first();
            $goals = Goal::where('setresidencial_id', $setresidencial->id)->where('state_id',1)->get();

            $users = User::where('state_id', 1)
                ->whereHas('roles', function ($query) {
                    $query->where('id', 3);
                })
                ->whereHas('setresidencials', function ($query) use ($setresidencial) {
                    $query->where('setresidencials.id', $setresidencial->id);
                })
            ->get();

            $elements = Element::all();




            if($identi == 'p'){
                $exitEntry = ExitEntry::whereHas('visitors', function ($query) use ($idVisitor) {
                        $query->where('visitors.id', $idVisitor);
                    })
                    ->with(['vehicles', 'visitors'])
                    ->latest()
                ->first();


                if ($exitEntry && $employeeincome->id === $exitEntry->employeeincome_id) {
                    // Se queda con la salida encontrada
                }
            }else{
                 $exitEntry = ExitEntry::whereHas('vehicles', function ($query) use ($idVehicle) {
                        $query->where('vehicles.id', $idVehicle);
                    })
                    ->with(['vehicles', 'visitors'])
                    ->latest()
                ->first();

                if ($exitEntry && $employeeincome->id === $exitEntry->employeeincome_id) {
                    // Se queda con la salida encontrada
                }
            }
           



            return view('admin.employeeincomes.createExit',compact('employeeincome','goals','users','elements','exitEntry','idVisitor','identi','idVehicle'));

        }


    }

    public function storeExit(Request $request)
    {

        if (auth()->user()->state_id == 2) {
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }

        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if (auth()->user()->id !== 1 && auth()->user()->id !== 2) {
            if (empty($authSetresidencials)) {
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }


        $validated = $request->validate([
            'visitor_id' => 'nullable|array',
            'visitor_id.*' => 'integer|exists:visitors,id',
            'vehicle_id' => 'nullable',
            'type_income' => 'nullable',
            'departure_date' => 'required|date',
            'nota' => 'nullable|string',
            'goal_id' => 'nullable|integer|exists:goals,id',
            'user_id' => 'nullable|integer|exists:users,id',
            'employeeincome_id' => 'nullable|integer|exists:employeeincomes,id',
            'elements' => 'nullable|array',
            'elements.*' => 'integer|exists:elements,id',
            'photos' => 'nullable|array',
            'photos.*' => 'nullable|string',
            'notaElement' => 'nullable|array',
            'notaElement.*' => 'nullable|string',
        ], [
            'departure_date.required' => 'EL CAMPO FECHA DE INGRESO ES OBLIGATORIO.',
            'departure_date.date' => 'LA FECHA DE INGRESO NO ES UNA FECHA VÁLIDA.',
        ]);



        if (auth()->user()->can('admin.permission.administrator') || auth()->user()->can('admin.permission.subadministrator')) {

            // $vehicleIngreso = Employeeincome::where('vehicle_id', $request->vehicle_id)
            //     ->latest()
            // ->first();

            // if ($vehicleIngreso) {
            //     $vehicleSalida = ExitEntry::where('employeeincomevehicle_id', $vehicleIngreso->id)
            //         ->where('vehicle_id', $request->vehicle_id)
            //         ->latest()
            //     ->first();
                    
            //     if ($vehicleSalida) {
            //         return back()->with('info', 'ESTE VEHÍCULO YA TIENE UN SALIDA REGISTRADO Y NO HA INGRESADO AÚN.');
            //     }else{
                    if($request->vehicle_id){
                        $exitEntry = ExitEntry::create([
                            'type_income' => 2,
                            'departure_date' => Carbon::now()->format('Y-m-d H:i'),
                            'nota' => $validated['nota'] ?? null,
                            'goal_id' => session('current_goal'),
                            'user_id' => Auth::user()->id,
                            'employeeincome_id' => $validated['employeeincome_id'] ?? null,
                        ]);

                        if (!empty($validated['visitor_id'])) {
                            foreach ($validated['visitor_id'] as $visitorId) {
                                $exitEntry->vehicles()->attach(
                                    ['vehicle_id' => $validated['vehicle_id'] ?? null],
                                    ['visitor_id' => $visitorId]
                                );
                            }
                        }

                    }else{
                        $exitEntry = ExitEntry::create([
                            'type_income' => 1,
                            'departure_date' => Carbon::now()->format('Y-m-d H:i'),
                            'nota' => $validated['nota'] ?? null,
                            'goal_id' => session('current_goal'),
                            'user_id' => Auth::user()->id,
                            'employeeincome_id' => $validated['employeeincome_id'] ?? null,
                        ]);

                        if (!empty($validated['visitor_id'])) {
                            foreach ($validated['visitor_id'] as $visitorId) {
                                $exitEntry->vehicles()->attach(
                                    ['vehicle_id' => null],
                                    ['visitor_id' => $visitorId]
                                );
                            }
                        }
                    }
            //     }
            // }else{

            //     $vehicleSalidaTwo = ExitEntry::where('vehicle_id', $request->vehicle_id)
            //         ->latest()
            //     ->first();
                    

            //     if ($vehicleSalidaTwo) {
            //         return back()->with('info', 'ESTE VEHÍCULO YA TIENE UN SALIDA REGISTRADO Y NO HA INGRESADO AÚN.');
            //     }else{
            //         if($request->vehicle_id){
            //             ExitEntry::create([
            //                 'type_income' => 2,
            //                 'departure_date' => Carbon::now()->format('Y-m-d H:i'),
            //                 'nota' => $validated['nota'] ?? null,
            //                 'goal_id' => session('current_goal'),
            //                 'user_id' => Auth::user()->id,
            //                 'employeeincome_id' => $validated['employeeincome_id'] ?? null,
            //                 'employeeincomevehicle_id' => $validated['employeeincome_id'] ?? null,
            //                 'visitor_id' =>  $validated['visitor_id'],
            //                 'vehicle_id' => $validated['vehicle_id'] ?? null,//id del vehiculo
            //             ]);
            //         }else{
            //             ExitEntry::create([
            //                 'type_income' => 1,
            //                 'departure_date' => Carbon::now()->format('Y-m-d H:i'),
            //                 'nota' => $validated['nota'] ?? null,
            //                 'goal_id' => session('current_goal'),
            //                 'user_id' => Auth::user()->id,
            //                 'employeeincome_id' => $validated['employeeincome_id'] ?? null,
            //                 'visitor_id' =>  $validated['visitor_id'],
            //             ]);
            //         }
            //     }
            // }

           
        } elseif (auth()->user()->can('admin.permission.goalie')) {
            
            // $vehicleIngreso = Employeeincome::where('vehicle_id', $request->vehicle_id)
            //     ->latest()
            // ->first();


            
            // if ($vehicleIngreso) {
            //     $vehicleSalida = ExitEntry::where('employeeincomevehicle_id', $vehicleIngreso->id)
            //         ->where('vehicle_id', $request->vehicle_id)
            //         ->latest()
            //     ->first();
                    

            //     if ($vehicleSalida) {
            //         return back()->with('info', 'ESTE VEHÍCULO YA TIENE UN SALIDA REGISTRADO Y NO HA INGRESADO AÚN.');
            //     }else{

                    if($request->vehicle_id){
                        $exitEntry = ExitEntry::create([
                            'type_income' => 2,
                            'departure_date' => Carbon::now()->format('Y-m-d H:i'),
                            'nota' => $validated['nota'] ?? null,
                            'goal_id' => session('current_goal'),
                            'user_id' => Auth::user()->id,
                            'employeeincome_id' => $validated['employeeincome_id'],
                        ]);
                        if (!empty($validated['visitor_id'])) {
                            foreach ($validated['visitor_id'] as $visitorId) {
                                $exitEntry->vehicles()->attach(
                                    ['vehicle_id' => $validated['vehicle_id'] ?? null],
                                    ['visitor_id' => $visitorId]
                                );
                            }
                        }
                    }else{
                        $exitEntry = ExitEntry::create([
                            'type_income' => 1,
                            'departure_date' => Carbon::now()->format('Y-m-d H:i'),
                            'nota' => $validated['nota'] ?? null,
                            'goal_id' => session('current_goal'),
                            'user_id' => Auth::user()->id,
                            'employeeincome_id' => $validated['employeeincome_id'],
                        ]);

                        if (!empty($validated['visitor_id'])) {
                            foreach ($validated['visitor_id'] as $visitorId) {
                                $exitEntry->vehicles()->attach(
                                    ['vehicle_id' => null],
                                    ['visitor_id' => $visitorId]
                                );
                            }
                        }
                    }
            //     }
            // }else{

            //      $vehicleSalidaTwo = ExitEntry::where('vehicle_id', $request->vehicle_id)
            //         ->latest()
            //     ->first();
                    

            //     if ($vehicleSalidaTwo) {
            //         return back()->with('info', 'ESTE VEHÍCULO YA TIENE UN SALIDA REGISTRADO Y NO HA INGRESADO AÚN.');
            //     }else{
            //         if($request->vehicle_id){
            //             ExitEntry::create([
            //                 'type_income' => 2,
            //                 'departure_date' => Carbon::now()->format('Y-m-d H:i'),
            //                 'nota' => $validated['nota'] ?? null,
            //                 'goal_id' => session('current_goal'),
            //                 'user_id' => Auth::user()->id,
            //                 'employeeincome_id' => $validated['employeeincome_id'],
            //                 'employeeincomevehicle_id' => $validated['employeeincome_id'],
            //                 'visitor_id' => $validated['visitor_id'],
            //                 'vehicle_id' => $validated['vehicle_id'] ?? null,//id del vehiculo
            //             ]);
            //         }else{
            //             ExitEntry::create([
            //                 'type_income' => 1,
            //                 'departure_date' => Carbon::now()->format('Y-m-d H:i'),
            //                 'nota' => $validated['nota'] ?? null,
            //                 'goal_id' => session('current_goal'),
            //                 'user_id' => Auth::user()->id,
            //                 'employeeincome_id' => $validated['employeeincome_id'],
            //                 'visitor_id' => $validated['visitor_id'],
            //             ]);
            //         }
            //     }
            // }
        }

        if (!empty($validated['elements'])) {
            foreach ($validated['elements'] as $index => $elementId) {
                $photoPath = null;

                if (!empty($validated['photos'][$index])) {
                    $base64Image = $validated['photos'][$index];
                    $image = str_replace('data:image/png;base64,', '', $base64Image);
                    $image = str_replace(' ', '+', $image);
                    $imageName = 'Employeeincomes/' . Str::random(20) . '_' . $index . '.png';
                    \File::put(public_path('storage/' . $imageName), base64_decode($image));
                    $photoPath = $imageName;
                }

                $exitEntry->elements()->attach($elementId, [
                    'imagen' => $photoPath,
                    'nota' => $validated['notaElement'][$index] ?? null,
                ]);
            }
        }
        
        //return redirect()->route('admin.employeeincomes.index')->with('success','LA CREACIÓN DE LA SALIDA FUE CORRECTA.');
        return back()->with('success', 'LA CREACIÓN DE LA SALIDA FUE CORRECTA.');
    }

    public function createIncomGoal(Request $request)
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1 && auth()->user()->id !== 2){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        if (auth()->user()->can('admin.permission.administrator')) {
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
            $vehicles = Vehicle::where('state_id',1)->get();
            return view('admin.employeeincomes.createincomgoal',compact('visitors','elements','setresidencials','goals','users','units','agglomerations','vehicles'));
        }elseif (auth()->user()->can('admin.permission.subadministrator') || auth()->user()->can('admin.permission.goalie')) {
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
            $vehicles = Vehicle::where('setresidencial_id', $setresidencial->id)->where('state_id',1)->get();

            $visitor_id = $request->ingVi;

            
            return view('admin.employeeincomes.createincomgoal',compact('visitors','elements','setresidencial','goals','users','agglomerations','vehicles','visitor_id'));
        }
    }




     public function createIncomGoalVehicle(Request $request)
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1 && auth()->user()->id !== 2){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        if (auth()->user()->can('admin.permission.administrator')) {
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
            $vehicles = Vehicle::where('state_id',1)->get();
            return view('admin.employeeincomes.createincomvehicle',compact('visitors','elements','setresidencials','goals','users','units','agglomerations','vehicles'));
        }elseif (auth()->user()->can('admin.permission.subadministrator') || auth()->user()->can('admin.permission.goalie')) {
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
            $vehicles = Vehicle::where('setresidencial_id', $setresidencial->id)->where('state_id',1)->get();

            $vehicle_id  = $request->vehicle;
           $visitor_ids = explode(',', $request->ingVi);

            
            return view('admin.employeeincomes.createincomvehicle',compact('visitors','elements','setresidencial','goals','users','agglomerations','vehicles','vehicle_id','visitor_ids'));
        }
    }





   public function destroy(Employeeincome $employeeincome)
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1 && auth()->user()->id !== 2){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        try {
            // Intentar eliminar el ingreso
            $employeeincome->delete();

            // Si se eliminó correctamente, eliminar imágenes asociadas y relaciones en la tabla pivot
            $currentElements = $employeeincome->elements()->get();

            foreach ($currentElements as $currentElement) {
                if ($currentElement->pivot->imagen && file_exists(public_path('storage/' . $currentElement->pivot->imagen))) {
                    unlink(public_path('storage/' . $currentElement->pivot->imagen));
                }
            }

            $employeeincome->elements()->detach();

            return redirect()->route('admin.employeeincomes.index')->with('delete','LA ELIMINACIÓN DEL INGRESO FUE ÉXITOSA.');

        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->route('admin.employeeincomes.index')->with('info', 'NO SE PUEDE ELIMINAR ESTE INGRESO PORQUE YA TIENE UNA SALIDA REGISTRADA.');
            }

            return redirect()->route('admin.employeeincomes.index')->with('info', 'OCURRIÓ UN ERROR AL INTENTAR ELIMINAR EL INGRESO.');
        }
    }



    public function dateFinisConfir($id)
    {
        if (auth()->user()->can('admin.permission.administrator') || auth()->user()->can('admin.permission.subadministrator')) {

            $exitEntry = ExitEntry::create([
                'departure_date' => Carbon::now()->format('Y-m-d H:i'),
                'employeeincome_id' => $id
            ]);
            return response()->json(['success' => true, 'message' => 'SE ACTUALIZO CORRECTAMENTE LA FECHA DE SALIDA.']);

        }elseif(auth()->user()->can('admin.permission.goalie')){
             $exitEntry = ExitEntry::create([
                'departure_date' => Carbon::now()->format('Y-m-d H:i'),
                'employeeincome_id' => $id,
                'goal_id' => session('current_goal'),
                'user_id' => Auth::user()->id
            ]);
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
