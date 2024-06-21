<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Http\Requests\StorePersonaRequest;
use App\Http\Requests\UpdatePersonaRequest;
use App\Models\Role;
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
     * Mostrar listado de los recursos registrados.
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

            $this->data[$key]->urls = [
                'edit' => route('personas.edit', $value->id),
                'destroy' => route('personas.destroy', $value->id),
                'show' => route('personas.show', $value->id),
            ];
        }

        return Inertia::render("Recursos/Personas/Table", [
            'data' => $this->data,
        ]);
    }

    /**
     * Mostrar formulario para registrar un nuevo recurso.
     */
    public function create()
    {
        //
        return Inertia::render("Recursos/Personas/Create");
    }

    /**
     * Almacenar nuevo recurso.
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

        if (Persona::where('email', $data['email'])->exists()) {
            $email = $data['email'];
            return Redirect::back()
                ->withErrors([
                    'email' => "[$email] ya existe está registrado."
                ]);
        } else if (Persona::where('id_nac', $data['id_nac'])->exists()) {
            $id_nac = $data['id_nac'];
            $tipo_id_nac = $data['tipo_id_nac'];
            return Redirect::back()
                ->withErrors([
                    'id_nac' => "[$tipo_id_nac: $id_nac] ya está registrado."
                ]);
        }

        $this->instance = Persona::create($data);
        $this->instance->save();

        if ($ropo) {
            $ropo_nro = $ropo['nro'];

            if (DB::table('ropo')->where('nro', $ropo_nro)->exists()) {
                return Redirect::back()
                    ->withErrors([
                        'ropo.nro' => "[Nro Ropo:$ropo_nro] ya existe está registrado."
                    ]);
            }

            DB::table('ropo')->insert([
                'persona' => $this->instance->id,
                ...$ropo
            ]);
        }

        $tipo_id_nac = $this->instance->tipo_id_nac;
        $id_nac = $this->instance->id_nac;

        $this->message = "Persona con $tipo_id_nac $id_nac creada con éxito";

        return Redirect::intended(route('personas.index'))->with([
            'from' => 'store.persona',
            'message' => ['content' => $this->message]
        ]);
    }

    /**
     * Mostrar un recurso en especifico.
     *
     * @param string $id
     */
    public function show(string $id)
    {
        //
        $this->data = Persona::findOrFail($id);

        $this->data->ropo = DB::table('ropo')->where('persona', $this->data->id)->first() ?: null;

        $this->relations['empresas'] = $this->data->empresas()->get();
        $this->data->empresas = $this->relations['empresas'];

        return Inertia::render("Recursos/Personas/Show", [
            'data' => $this->data,
        ]);
    }

    /**
     * Mostrar el formulario para editar el recurso.
     *
     * @param string $id
     */
    public function edit(string $id)
    {
        //
        $this->data = Persona::findOrFail($id);

        return Inertia::render("Recursos/Personas/Edit", [
            'data' => $this->data,
        ]);
    }

    /**
     * Actualizar los datos del recurso.
     */
    public function update(UpdatePersonaRequest $request, Persona $persona)
    {
        //
    }

    /**
     * Eliminar uno recurso en especifico o muchos.
     *
     * @param string $id
     */
    public function destroy(string $id)
    {
        //

        $this->data = Persona::findOrFail($id);
        $this->data->delete();

        return Redirect::intended(route('personas.index'))
            ->with([
                'from' => 'destroy.persona',
                'message' => [
                    'action' => [
                        'type' => 'destroy',
                        'data' => $this->data
                    ],
                    'toast' => [
                        'variant' => 'default',
                        'title' => 'Recurso: Persona',
                        'description' => $this->data->nombres.' '.$this->data->apellidos.' ('.$this->data->id_nac.') se ha eliminado de los registros.'
                    ]
                ]
            ]);
    }
}
