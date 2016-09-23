<link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Modificar Usuario</h3>
    </div>
    <div id="message-error">
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    {!! Form::model($user, ['id' => 'form']) !!}

    <div class="box-body">
        @include('users.partials.fields_usuario')
        <div class="form-group">
            {!! Form::label('unidades', 'Unidades') !!}
            {!! Form::select('unidades', $unidades, $user->id_unidad, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('roles', 'Roles Del Usuario') !!}<br/>
            @foreach($roles as $rol)
                @if (count($user_roles)>0 && in_array($rol->name, $user_roles))
                    <label class="checkbox-inline">{!! Form::checkbox('roles[]', $rol->name, true) !!} {{$rol->name}}</label>
                @else
                    <label class="checkbox-inline">{!! Form::checkbox('roles[]', $rol->name, false) !!} {{$rol->name}}</label>
                @endif
            @endforeach
        </div>
        <div class="form-group">
            {!! Form::label('estados', 'Estados') !!}
            {!! Form::select('estados', $estados, $user->id_estado, ['class' => 'form-control']) !!}
        </div>
    </div>
    <!-- /.box-body -->

    <div class="box-footer">
        {!! link_to('#','Modificar Usuario', ['id' => 'Modificar','class' => 'btn btn-primary']) !!}
        {!! link_to('#', 'Cancelar Usuario', ['id' => 'Cancelar', 'class' => 'btn btn-danger']) !!}
    </div>
    {!! Form::close() !!}
</div>
<script>
    $("#Modificar").click(function(event)
    {
        //alert('holaas');

        var apellidoP = $("#apellidoP").val();
        var apellidoM = $("#apellidoM").val();
        var token = $("input[name=_token]").val();
        var route = "{{route('admin.users.update', $aux_users_id)}}";

        var dataApellidoP = "apellidoP="+apellidoP;
        var dataApellidoM = "apellidoM="+apellidoM;
        var dataString = $("#form").serialize();
        //alert(dataString);
        $.ajax({
            url:route,
            headers:{'X-CSRF-TOKEN':token},
            type:'put',
            datatype: 'json',
            data:dataString,
            success:function(data)
            {
                //alert('jijiji');
                $("#errores").remove();
                var ruta = '{{ route('admin.users.index') }}';
                $(".content").load(ruta);
            },
            error:function(xhr, data)
            {
                //alert('jojojojo');
                var errors = xhr.responseJSON;
                errorsHtml = '<div id="errores" class="alert alert-danger" role="alert"><p>Por favor corriga los siguientes errores:</p><ul>';
                $.each( errors , function( key, value ) {
                    errorsHtml = errorsHtml + '<li>' + value[0] + '</li>'; //showing only the first error.
                    //alert(value[0]);
                });
                errorsHtml = errorsHtml + '</ul></div>';
                $("#message-error").html(errorsHtml);

            }
        })

    });
    $("#Cancelar").click(function(event)
    {
        var ruta = '{{ route('admin.users.index') }}';
        $(".content").load(ruta);
    });
</script>