<?php

namespace App\Http\Controllers;

use App\estados;
use App\Role;
use App\unidad;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Routing\Redirector;
//use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Session;
use Validator;
use App\Http\Requests\Users\StoreUsersPostRequest;
use App\Http\Requests\Users\UpdateUsersPostRequest;

class UsersController extends Controller
{
    use recursoscontroller;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //dd($request->get('nombres'));
        $users = User::filterAndPaginate($request->get('nombres'));
        //dd($users);
        if($users->count()>0)
        {
            foreach ($users as $user)
            {
                $user->id = $this->encriptar($user->id);
            }
        }
        $c = 1;
        //dd($c);
        return view('users.index', compact('users', 'c'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $unidad = unidad::lists('unidad', 'id');
        $unidades = array('' => '--- Seleccione Una Unidad ---') + $unidad->all();
        $roles = Role::all();
        //dd($roles);
        return view('users.create', compact('unidades', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUsersPostRequest $request)
    {
        //return "ok";
       //
        $data = $request->all();
        //dd($data);
        $user = new User();
        $user->nombre = $data['nombre'];
        $user->apellidoP = $data['apellidoP'];
        $user->apellidoM = $data['apellidoM'];
        $user->ci = $data['ci'];
        $user->email = $data['email'];
        $user->password = \Hash::make($data['password']);
        $user->id_estado = 2; //Deshabilitado
        $user->id_unidad = $data['unidades'];
        $user->save();
        $id_user = $user->id;
        if($request->get('roles') != null)
        {
            $user->InsertarRoles($id_user, $data['roles']);
        }
        $message = 'El Usuario ' . $user->apellidoP . ' ' . $user->apellidoM . ' ' . $user->nombre . ' fue creado exitosamente';
        Session::flash('message', $message);
        //return $redirect->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = $this->desencriptar($id);
        //dd($id);
        $user = User::findOrFail($id);
        $user_roles = \DB::table('role_user')
            ->where('role_user.user_id', '=', $user->id)
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->lists('roles.name');
        $unidad = unidad::lists('unidad', 'id');
        $unidades = array('' => '--- Seleccione Una Unidad ---') + $unidad->all();
        $roles = Role::all();
        //dd($roles);
        $estados = estados::lists('nombre', 'id');
        $aux_users_id = $this->encriptar($user->id);
        //dd($aux_users_id);
        //dd($estados);
        return view('users.edit', compact('user', 'aux_users_id','unidades', 'roles', 'user_roles', 'estados'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUsersPostRequest $request, $id)
    {
        //dd($id);
        $id = $this->desencriptar($id);
        //dd($id);
        $data = $request->all();
        $user = User::findOrFail($id);
        $user->nombre    = $data['nombre'];
        $user->apellidoP = $data['apellidoP'];
        $user->apellidoM = $data['apellidoM'];
        $user->ci        = $data['ci'];
        $user->email     = $data['email'];
        $user->id_estado = $data['estados'];
        $user->id_unidad = $data['unidades'];
        $user->save();
        $id_user = $user->id;
        if($request->get('roles') != null)
        {
            $user->EditarRoles($id_user, $data['roles']);
        }
        $message = 'Los datos del usuario ' . $user->apellidoP . ' ' . $user->apellidoM . ' ' . $user->nombre . ' fueron modificados exitosamente';
        Session::flash('message', $message);
        //return $redirect->route('admin.users.index');*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function setDeshabilitar(Request $request, $id, Redirector $redirect)
    {
        //dd($id);
        $id = $this->desencriptar($id);
        //dd($id);
        $user = User::findOrFail($id);
        //dd($user);
        $user->id_estado = 2;
        $user->save();
        $message = 'El Usuario ' . $user->apellidoP . ' ' . $user->apellidoM . ' ' . $user->nombre . ' fue deshabilitado';
        Session::flash('message', $message);
        return $redirect->route('admin.users.index');
    }

    public function setHabilitar($id, Redirector $redirect)
    {
        $id = $this->desencriptar($id);
        $user = User::findOrFail($id);
        $user->id_estado = 1;
        $user->save();
        $message = 'El Usuario ' . $user->apellidoP . ' ' . $user->apellidoM . ' ' . $user->nombre . ' fue habilitado';
        Session::flash('message', $message);
        return $redirect->route('admin.users.index');
    }
}
