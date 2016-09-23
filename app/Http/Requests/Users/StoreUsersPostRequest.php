<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\Request;

class StoreUsersPostRequest extends Request
{
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
        return [
            'apellidoM' => 'required',
            'nombre'    => 'required',
            'ci'        => 'required|unique:users,ci',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required',
            'unidades'  => 'required',
            'roles'     => 'required',
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
            'password.required'  => 'El campo Contraseña es obligatorio',
            'unidades.required'  => 'Usted debe selecconar una Unidad',
            'roles.required'     => 'El campo Roles es obligatorio',
        ];
    }
}
