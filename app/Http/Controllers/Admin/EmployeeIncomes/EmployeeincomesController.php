<?php

namespace App\Http\Controllers\Admin\EmployeeIncomes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmployeeIncomes\EmployeeincomesCreateRequest;
use App\Http\Requests\Admin\EmployeeIncomes\EmployeeincomesUpdateRequest;
use App\Models\Element\Element;
use App\Models\EmployeeIncome\Employeeincome;
use App\Models\Goal\Goal;
use App\Models\SetResidencial\Setresidencial;
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
            return view('admin.employeeincomes.create',compact('visitors','elements','setresidencials','goals','users'));
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
            
            return view('admin.employeeincomes.create',compact('visitors','elements','setresidencial','goals','users'));
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
        
        if (auth()->user()->hasRole('ADMINISTRADOR') || auth()->user()->hasRole('SUB_ADMINISTRADOR')) {

            $employeeIncome = Employeeincome::create([
                'visitor_id' => $request->input('visitor_id'),
                'setresidencial_id' => $request->input('setresidencial_id'),
                'admission_date' => $request->input('admission_date'),
                'user_id' => $request->input('user_id') ?? null,
                'goal_id' => $request->input('goal_id') ?? null,
                'nota' => $request->input('nota'),
            ]);
        }elseif(auth()->user()->hasRole('PORTERO')){
            $employeeIncome = Employeeincome::create([
                'visitor_id' => $request->input('visitor_id'),
                'setresidencial_id' => $request->input('setresidencial_id'),
                'admission_date' => $request->input('admission_date'),
                'user_id' => Auth::user()->id,
                'goal_id' => session('current_goal'),
                'nota' => $request->input('nota'),
            ]);
        }

        if ($request->has('elements') && is_array($request->elements)) {
            $elements = $request->elements;
            $photos = $request->photos;
            $notas = $request->notaElement;

            foreach ($elements as $index => $elementId) {
                $photoPath = null;
                if (isset($photos[$index])) {
                    $base64Image = $photos[$index];
                    $image = str_replace('data:image/png;base64,', '', $base64Image);
                    $image = str_replace(' ', '+', $image);
                    $imageName = 'Employeeincomes/' . date('YmdHis') . '_' . $index . '.png';
                    \File::put(public_path('storage/' . $imageName), base64_decode($image));
                    $photoPath = $imageName;
                }
                $employeeIncome->elements()->attach($elementId, [
                    'imagen' => $photoPath,
                    'nota' => $notas[$index] ?? null,
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


            $elements = Element::all();
            $employeeElements = $employeeincome->elements()->get();
            return view('admin.employeeincomes.edit',compact('employeeincome','visitors','elements','employeeElements','setresidencials','goals','users'));
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

            return view('admin.employeeincomes.edit',compact('employeeincome','visitors','elements','employeeElements','setresidencial','goals','users'));
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
        ]);

    }elseif(auth()->user()->hasRole('PORTERO')){
        $employeeincome->update([
            'visitor_id' =>  $request->input('visitor_id'),
            'admission_date' => $employeeincome->admission_date,
            'departure_date' => $employeeincome->departure_date,
            'nota' => $request->input('nota'),
            'user_id' => Auth::user()->id,
            'goal_id' => session('current_goal'),
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
        $employeeincome = Employeeincome::findOrFail($id);
        $employeeincome->departure_date = Carbon::now()->format('Y-m-d H:i');
        $employeeincome->save();
        return response()->json(['success' => true, 'message' => 'SE ACTUALIZO CORRECTAMENTE LA FECHA DE SALIDA.']);
    }

}
