<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Http\Requests\StorePersonaRequest;
use App\Http\Requests\UpdatePersonaRequest;
use App\Models\Role;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PersonaController extends Controller
{

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->adm_role = Role::where('name', 'Admin')->first()->id;
        $this->user = Auth::user();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $this->data = Persona::all();

        foreach ($this->data as $key => $value) {
            $ropo = DB::table('ropo')->where('persona', $value->id)->first();

            if ($ropo) {
                $info = [
                    'nro' => $ropo->nro,
                    'tipo' => $ropo->tipo,
                    'tipo_aplicador' => $ropo->tipo_aplicador,
                    'caducidad' => $ropo->caducidad
                ];

                $this->data[$key]->ropo = $info;
            }
        }

        return Inertia::render("Recursos/Personas/Table", [
            'data' => $this->data,
            'isAdmin' => $this->user->role_id == $this->adm_role
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return Inertia::render("Recursos/Personas/Create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonaRequest $request)
    {
        //
        $data = $request->all();
        $ropo = [];

        foreach ($data as $key => $value) {
            if (str_contains($key, 'ropo')) {
                foreach ($value as $k => $v) {
                    $ropo[$k] = $v;
                }
                unset($data[$key]);
            }
        }

        $ropo = count($ropo) > 0 ? $ropo : null;

        if ($data['email']) {
            return Redirect::intended(route('personas.index'))
                ->withErrors([
                    'email' => 'La persona ya existe.'
                ]);
        }

        $this->instance->save();
        $this->instance = Persona::create($data);

        if ($ropo) {
            DB::table('ropo')->insert([
                'persona' => $this->instance->id,
                'nro' => $ropo['nro'],
                'tipo' => $ropo['tipo'],
                'caducidad' => date('Y-m-d H:i:s', $ropo['caducidad']),
                'tipo_aplicador' => $ropo['tipo_aplicador'],
            ]);
        }

        $this->message = "Persona [$this->instance] creada con éxito";

        return Redirect::intended(route('personas.index'))->with([
            'from' => 'store.persona',
            'message' => $this->message
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $this->data = Persona::findOrFail($id);

        $this->relations['empresas'] = $this->data->empresas()->get();
        $this->data->empresas = $this->relations['empresas'];

        return Inertia::render("Recursos/Personas/Show", [
            'data' => $this->data,
            'isAdmin' => $this->user->role_id == $this->adm_role
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Persona $persona)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePersonaRequest $request, Persona $persona)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Persona $persona)
    {
        //
    }
}
