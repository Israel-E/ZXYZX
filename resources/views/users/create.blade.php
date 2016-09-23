<link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Nuevo Usuario</h3>
    </div>
    <div id="message-error">
    </div>
    <!-- /.box-header -->
    <!-- form start -->

    {!! Form::open(['id' => 'form']) !!}
        <div class="box-body">
            <div class="form-group">
                {!! Form::label('apellidoP', 'Apellido Paterno') !!}
                {!! Form::text('apellidoP', null, ['class' => 'form-control', 'placeholder' => 'Por favor introduzca el Apellido Paterno']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('apellidoM', 'Apellido Materno') !!}
                {!! Form::text('apellidoM', null, ['class' => 'form-control', 'placeholder' => 'Por favor introduzca el Apellido Materno']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('nombre', 'Nombres') !!}
                {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Por favor introduzca los Nombres']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('ci', 'Cédula de Identidad') !!}
                {!! Form::text('ci', null, ['class' => 'form-control', 'placeholder' => 'Por favor introduzca la Cédula de Identidad']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('email', 'Correo Electrónico') !!}
                {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Por favor introduzca el Correo Electrónico']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('password', 'Contraseña') !!}
                {!! Form::password('password', ['class' => 'form-control' , 'placeholder' => 'Por favor introduzca su Contraseña']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('unidades', 'Unidades') !!}
                {!! Form::select('unidades', $unidades, null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('roles', 'Roles Del Usuario') !!}<br/>
                @foreach($roles as $rol)
                    <label class="checkbox-inline">{!! Form::checkbox('roles[]', $rol->name) !!} {{$rol->name}}</label>
                @endforeach
            </div>

        </div>
        <!-- /.box-body -->

        <div class="box-footer">
            {!! link_to('#', 'Guardar Usuario', ['id' => 'Grabar', 'class' => 'btn btn-primary']) !!}
            {!! link_to('#', 'Cancelar Usuario', ['id' => 'Cancelar', 'class' => 'btn btn-danger']) !!}
        </div>
    {!! Form::close() !!}
</div>
<script>
    $("#Grabar").click(function(event)
    {
        var apellidoP = $("#apellidoP").val();
        var apellidoM = $("#apellidoM").val();
        var token = $("input[name=_token]").val();
        var route = "{{route('admin.users.store')}}";

        var dataApellidoP = "apellidoP="+apellidoP;
        var dataApellidoM = "apellidoM="+apellidoM;
        var dataString = $("#form").serialize();
        //alert(dataString);
        $.ajax({
            url:route,
            headers:{'X-CSRF-TOKEN':token},
            type:'post',
            datatype: 'json',
            data:dataString,
            success:function(data)
            {
                $("#errores").remove();
                var ruta = '{{ route('admin.users.index') }}';
                $(".content").load(ruta);
            },
            error:function(xhr, data)
            {
                var errors = xhr.responseJSON;
                errorsHtml = '<div id="errores" class="alert alert-danger" role="alert"><p>Por favor corriga los siguientes errores:</p><ul>';
                $.each( errors , function( key, value ) {
                    errorsHtml = errorsHtml + '<li>' + value[0] + '</li>'; //showing only the first error.
                    //alert(value[0]);
                });
                errorsHtml = errorsHtml + '</ul></div>';
                //alert(errorsHtml);
                //console.log(data.responseJSON[0]);
                //alert(data.responseJSON);
                //$("#error").html(data.responseJSON.apellidoM);
                //alert(data.error.length);
                //console.log(data.responseJSON);
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