<?php

namespace App\Http\Controllers\Admin\Visitors;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Visitors\VisitorsCreateRequest;
use App\Http\Requests\Admin\Visitors\VisitorsUpdateRequest;
use App\Models\Company\Company;
use App\Models\SetResidencial\Setresidencial;
use App\Models\State\State;
use App\Models\Typeuser\Typeuser;
use App\Models\Unit\Unit;
use App\Models\Vehicle\Vehicle;
use App\Models\Visitor\Visitor;
use App\Models\VisitorEntry\Visitorentry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class VisitorsController extends Controller
{
    
    public function __construct(){
        $this->middleware('can:admin.visitors.index')->only('index');
        $this->middleware('can:admin.visitors.edit')->only('edit', 'update');
        $this->middleware('can:admin.visitors.show')->only('show');
        $this->middleware('can:admin.visitors.create')->only('create', 'store');
        $this->middleware('can:admin.visitors.destroy')->only('destroy');
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

        $visitors = Visitor::all();
        return view('admin.visitors.index',compact('visitors'));
    }

    public function create(Request $request)
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

        $doc = $request->query('Doc'); 

        if (auth()->user()->can('admin.permission.administrator')) {
            $states = State::all();
            $typeusers = Typeuser::all();
            $companies = Company::all();
            $units = Unit::where('state_id',1)->get();
            $vehicles = Vehicle::where('state_id',1)->get();
            $setresidencials = Setresidencial::where('state_id',1)->get();

            return view('admin.visitors.create',compact('doc','states','typeusers','companies','units','vehicles','setresidencials'));
        }elseif (auth()->user()->can('admin.permission.subadministrator') || auth()->user()->can('admin.permission.goalie')) {
            $setresidencial = auth()->user()->setresidencials()->where('state_id', 1)->first();


            $states = State::all();
            $typeusers = Typeuser::all();
            $companies = Company::all();

            $units = Unit::where('state_id',1)->whereHas('agglomeration', function ($query) use ($setresidencial) {
                $query->where('setresidencial_id', $setresidencial->id);
            })->get();
            
            $vehicles = Vehicle::where('setresidencial_id',$setresidencial->id)->where('state_id',1)->get();

            return view('admin.visitors.create',compact('doc','states','typeusers','companies','units','vehicles','setresidencial'));
        }
    }
 
        public function store(VisitorsCreateRequest $request)
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

            $visitors = $request->all();


    if ($request->filled('imagen')) {
        $base64Image = $request->input('imagen');
        $image = str_replace('data:image/png;base64,', '', $base64Image);
        $image = str_replace(' ', '+', $image);
        $imageName = 'visitors/' . Str::random(20) . '.png';
        \File::put(public_path('storage/' . $imageName), base64_decode($image));
        $visitors['imagen'] = $imageName;
    }

    elseif ($request->hasFile('imagen_file')) {
        $file = $request->file('imagen_file');
        $imageName = 'visitors/' . Str::random(20) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('storage/visitors'), basename($imageName));
        $visitors['imagen'] = $imageName;
    }

            $visitor = Visitor::create($visitors);

            $visitor->units()->sync($request->units);
            $visitor->vehicles()->sync($request->vehicles);

           return redirect()->route('admin.employeeincomes.createIncom.goal', [
    'ingVi' => $visitor->id
])->with('success', 'EL VISITANTE SE CREO CORRECTAMENTE.');
        }

    public function show(Visitor $visitor)
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
        $employeeincomes = $visitor->employeeincomes()->paginate(10);

        return view('admin.visitors.show',compact('visitor','employeeincomes'));
    }

    public function edit(Visitor $visitor)
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

            $states = State::all();
            $typeusers = Typeuser::all();
            $companies = Company::all();
            $units = Unit::where('state_id', 1)
                ->orWhere(function ($query) use ($visitor) {
                    $query->where('state_id', 2)
                        ->whereHas('visitors', function ($q) use ($visitor) {
                            $q->where('visitor_id', $visitor->id);
                        });
                })
            ->get();
                $vehicles = Vehicle::where('state_id', 1)
                ->orWhere(function ($query) use ($visitor) {
                    $query->where('state_id', 2)
                        ->whereHas('visitors', function ($q) use ($visitor) {
                            $q->where('visitor_id', $visitor->id);
                        });
                })
            ->get();

            $setresidencials = Setresidencial::where('state_id', 1)
            ->orWhere(function ($query) use ($visitor) {
                $query->where('state_id', 2)
                      ->whereHas('visitors', function ($q) use ($visitor) {
                          $q->where('setresidencial_id', $visitor->setresidencial_id);
                      });
            })->get();

            $units_user = $visitor->units->pluck('id')->toArray();
            $vehicles_user = $visitor->vehicles->pluck('id')->toArray();

            return view('admin.visitors.edit',compact('visitor','states','typeusers','companies','units','vehicles','setresidencials','units_user','vehicles_user'));
        }elseif (auth()->user()->can('admin.permission.subadministrator') || auth()->user()->can('admin.permission.goalie')) {

            $setresidencial = auth()->user()->setresidencials()->where('state_id', 1)->first();

            $states = State::all();
            $typeusers = Typeuser::all();
            $companies = Company::all();

            $units = Unit::where('state_id', 1)->whereHas('agglomeration', function ($query) use ($setresidencial) {
                $query->where('setresidencial_id', $setresidencial->id);
                 })
                ->orWhere(function ($query) use ($visitor) {
                    $query->where('state_id', 2)
                        ->whereHas('visitors', function ($q) use ($visitor) {
                            $q->where('visitor_id', $visitor->id);
                        });
                })
                ->get();

            $vehicles = Vehicle::where('setresidencial_id',$setresidencial->id)->where('state_id', 1)
                ->orWhere(function ($query) use ($visitor) {
                    $query->where('state_id', 2)
                        ->whereHas('visitors', function ($q) use ($visitor) {
                            $q->where('visitor_id', $visitor->id);
                        });
                })
            ->get();

            $units_user = $visitor->units->pluck('id')->toArray();
            $vehicles_user = $visitor->vehicles->pluck('id')->toArray();

            return view('admin.visitors.edit',compact('visitor','states','typeusers','companies','units','setresidencial','vehicles','units_user','vehicles_user'));
        }
    }
    
    public function update(VisitorsUpdateRequest $request, Visitor $visitor)
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

        $data = $request->all();

        if ($request->has('imagen') && $request->input('imagen')) {
            $base64Image = $request->input('imagen');

            if (strpos($base64Image, 'data:image/') === 0) {
                [$type, $image] = explode(';', $base64Image);
                [, $image] = explode(',', $image);

                $extension = str_contains($type, 'image/png') ? 'png' : 'jpeg';

                $imageName = 'visitors/' . Str::random(20) . '.' . $extension;

                \File::put(public_path('storage/' . $imageName), base64_decode($image));
                $data['imagen'] = $imageName;

                if ($visitor->imagen && file_exists(public_path('storage/' . $visitor->imagen))) {
                    unlink(public_path('storage/' . $visitor->imagen));
                }
            } elseif (strpos($base64Image, 'visitors/') === 0) {
                $data['imagen'] = $base64Image;
            } else {
                return back()->withErrors(['imagen' => 'El formato de la imagen no es válido.']);
            }
        } else {
            $data['imagen'] = $visitor->imagen; 
        }


        if ($request->hasFile('imagen_file')) {
            $file = $request->file('imagen_file');
            $imageName = 'visitors/' . Str::random(20) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/visitors'), $imageName);

            // Eliminar imagen anterior si existe
            if ($visitor->imagen && file_exists(public_path('storage/' . $visitor->imagen))) {
                unlink(public_path('storage/' . $visitor->imagen));
            }

            $data['imagen'] = $imageName;
        }

        
    

        $visitor->update($data);

        $visitor->units()->sync($request->units);
        $visitor->vehicles()->sync($request->vehicles);

        return redirect()->route('admin.visitors.index')->with('edit','EL VISITANTE SE EDITO CORRECTAMENTE.');

    }

    
    public function destroy(Visitor $visitor)
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
            // Eliminar la imagen si existe
            if ($visitor->imagen) {
                $imagenPath = public_path('storage/' . $visitor->imagen);
                if (file_exists($imagenPath)) {
                    unlink($imagenPath);
                }
            }

            $visitor->delete();
            $visitor->units()->detach();
            $visitor->vehicles()->detach();
            return redirect()->route('admin.visitors.index')->with('delete', 'EL VISITANTE SE ELIMINÓ CORRECTAMENTE.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == "23000") {
                return redirect()->route('admin.visitors.index')->with('info', 'NO SE PUDO ELIMINAR EL REGISTRO YA QUE ESTÁ ASOCIADO A OTROS REGISTROS.');
            }
            return redirect()->route('admin.visitors.index')->with('info', 'OCURRIÓ UN ERROR AL INTENTAR ELIMINAR EL VISITANTE.');
        }
    }

    public function confirmVisitor($id)
    {
        $visitor = Visitor::findOrFail($id);
        $visitor->confirmation = 1;
        $visitor->save();
        return response()->json(['success' => true, 'message' => 'Confirmación actualizada correctamente.']);
    }


}
