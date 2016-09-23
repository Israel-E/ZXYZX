<?php

namespace App\Http\Requests\Users;

use App\Http\Controllers\recursoscontroller;
use App\Http\Requests\Request;
use Illuminate\Routing\Route;

class UpdateUsersPostRequest extends Request
{
    use recursoscontroller;
    private $route;
    private $id;
    public function __construct(Route $route)
    {
        $this->route = $route;
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = ($this->desencriptar($this->route->getParameter('users')));
        return [
            'apellidoM' => 'required',
            'nombre'    => 'required',
            'ci'        => 'required|unique:users,ci,'. $id,
            'email'     => 'required|email|unique:users,email,' . $id,
            'unidades'  => 'required',
            'roles'     => 'required',
            'estados'   => 'required',
        ];
    }

    public function messages()
    {
        return [
            'apellidoM.required' => 'El campo Apellido Materno es obligatorio',
            'nombre.required'    => 'El campo Nombres es obligatorio',
            'ci.required'        => 'El campo Cédula de Indetidad es obligatorio',
            'ci.unique'          => 'El campo Cédula de Indetidad ya se encuentra registrado por otro Usuairo',
            'email.required'     => 'El campo Correo Electrónico es obligatorio',
            'email.email'        => 'El Correo Electrónico introducido no es valido',
            'email.unique'       => 'El campo Correo Correo Electrónico ya se encuentra registrado por otro Usuairo',
            'unidades.required'  => 'Usted debe selecconar una Unidad',
            'roles.required'     => 'El campo Roles es obligatorio',
            'estados.required'   => 'Usted debe seleccionar un Estado',
        ];
    }
}
