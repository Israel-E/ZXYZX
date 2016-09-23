<link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
<div class="row">
    <div class="col-lg-12 col-xs-12">
        <h2>Usuarios</h2>
        <div class="form-group col-lg-2">
            <a class="btn btn-info paginacion" href="{{ route('admin.users.create') }}" role="button">Nuevo Usuario</a>
        </div>
        <div class="form-group col-lg-2">
            <h5>Hay {{ $users->total() }} Usuarios</h5>
        </div>
        {!! Form::model(Request::only(['nombres']), ['id' => 'form', 'role' => 'search']) !!}
        <div class="form-group col-lg-6">
            {!! Form::text('nombres', null, ['class' => 'form-control', 'placeholder' => 'Introduzca el nombre o apellido del usuario a buscar']) !!}
        </div>
        <div class="form-group col-lg-2">
            {!! link_to('#', 'Buscar', ['id' => 'Buscar', 'class' => 'btn btn-default']) !!}
        </div>
        {!! Form::close() !!}
        <div class="form-group col-md-12 col-sm-12 col-xs-12">
            @if(Session::has('message'))
                <p class="alert alert-success">{{ Session::get('message') }}</p>
            @endif
        </div>
        <table class="table table-striped">
            <tr>
                <th>#</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Nombres</th>
                <th>CI</th>
                <th>Correo Electrónico</th>
                <th>Unidad</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            @foreach($users as $user)
                <tr>
                    <td>{{ $c }}</td>
                    <td>{{ $user->apellidoP }}</td>
                    <td>{{ $user->apellidoM }}</td>
                    <td>{{ $user->nombre }}</td>
                    <td>{{ $user->ci}}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->unidad }}</td>
                    <td>{{ $user->nombre_estado }}</td>
                    <td>
                        {!! Form::open(['route' => ['admin.users.edit', $user->id], 'id' => 'formulario', 'method' => 'GET']) !!}
                            <a class="btn btn-primary btn-xs paginacion" href="{{ route('admin.users.edit', $user->id) }}" role="button">Editar</a>
                        {!! Form::close() !!}
                        @if($user->id_estado == 1)
                            <a class="btn btn-danger btn-xs paginacion" href="{{ route('deshabilitar_usuario', $user->id) }}" role="button">Deshabilitar</a>
                        @elseif($user->id_estado == 2)
                            <a class="btn btn-danger btn-xs paginacion" href="{{ route('habilitar_usuario', $user->id) }}" role="button">Habilitar</a>
                        @endif
                    </td>
                </tr>
                <?php $c++ ?>
            @endforeach
        </table>
        {!! $users->appends(Request::only(['nombres']))->render() !!}
    </div>
</div>
<script>
    $(function(){
        $(".paginacion").click(function (){
            var ruta=$(this).attr("href");
            $( ".content" ).empty();
            $(".content").load(ruta);
            return false;
        });
    });
    $("#Buscar").click(function(event)
    {
        //alert('holaas');
        var token = $("input[name=_token]").val();
        var route = "{{route('admin.users.index')}}";
        var dataString = $("#form").serialize();
        //alert(dataString);
        $.ajax({
            url:route,
            headers:{'X-CSRF-TOKEN':token},
            type:'GET',
            datatype: 'json',
            data:dataString,
            success:function(data)
            {
                //alert(data);
                $( ".content" ).empty();
                $(".content").html(data);

            }
        })

    });

</script>

