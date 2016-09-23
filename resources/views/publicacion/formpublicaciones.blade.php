
<div class="row">
  <div class="col-lg-12 col-xs-12">
  <div id="form-errors"></div >
 <form method="post" id="formulario" enctype="multipart/form-data" action="{{ url('/postimgs') }}" >
 {{ csrf_field() }}
  <div class="form-group">
    <label >Titulo Publicacion</label>
    <input type="text" class="form-control" name = "titulo" placeholder="Titulo Publicacion">
    <small id="ayudaPublicacion" class="form-text text-muted">Inserte Aqui el nombre que tendra su publicacion</small>
  </div>
  <div class="form-group">
    <label>Contenido</label>
    <textarea class="form-control" id="editor" name="contenido"cols="30" rows="15" placeholder="Contenido" ></textarea>
  </div>
  <div class="form-group">
    <label>fecha publicacion</label>
     <input type="date"name="fecha_inicio"  min="{{$fecha_inicio}}" max="{{$fecha_fin}}" class="form-control"  value="{{ old('fecha_inicio') }}">
  </div>
  <div class="form-group">
    <label>fecha finalizacion</label>
    <input type="date" id='fecha_fin' name="fecha_fin" min="{{$fecha_inicio}}" max="{{$fecha_fin}}" class="form-control"  value="{{ old('fecha_fin') }}">
  </div>
  <div class="form-group">
    <label>Categoria</label>
    <select class="form-control" name="categoria">
    @foreach($categorias as $c)
      <option value="{{$c['id']}}">{{$c['categoria']}}</option>
    @endforeach
    </select>
  </div>
  <div class="form-group">
    @foreach($sitios as $s)
      <input tabindex="1" type="checkbox" name="sitios[]" id="{{$s['id']}}" value="{{$s['id']}}"> {{$s['nombre_sitio']}}
    @endforeach
    </select>
  </div>
  <div class="form-group">
    <label for="exampleInputFile">File input</label>
    Subir imagen: 
    <input type="file" id="file" name="file[]" multiple>
    <small id="fileHelp" class="form-text text-muted">This is some placeholder block-level help text for the above input. It's a bit lighter and easily wraps to a new line.</small>
  </div>
  


  <!-- Subir videos -->
  <input type="checkbox" name="videos" value="Yes"> Agregar Videos<br>
  <div class="form-group">
    <div class="col-lg-12">
      <label>Subir Videos</label>
    </div>
      <div id="contenedor">
          <div>
              <input type="text" id="video" class="form-control previsualizar" name = "video_upload[]" placeholder="Url del video">
              <div id="vista-previa-video0" class="eliminar-imagen"></div>
          </div>
      </div>
  </div>
  <a id="agregarCampo" class="btn btn-success">Agregar URL del Video</a>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<div id="vista-previa"></div>
  <div id="respuesta"></div>

</div>
</div>

<script>
    $('#editor').trumbowyg();
</script>
<script>

    var z=1;
     $(function(){   
       $("#file").on("change", function(){
           /* Limpiar vista previa */
           $("#vista-previa").html('');
           var archivos = document.getElementById('file').files;
           var navegador = window.URL || window.webkitURL;
           /* Recorrer los archivos */
           for(x=0; x<archivos.length; x++)
           {
               /* Validar tamaño y tipo de archivo */
               var size = archivos[x].size;
               var type = archivos[x].type;
               var name = archivos[x].name;
               if (size > 1024*1024)
               {
                   $("#vista-previa").append("<p style='color: red'>El archivo "+name+" supera el máximo permitido 1MB</p>");
               }
               else if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png' && type != 'image/gif')
               {
                   $("#vista-previa").append("<p style='color: red'>El archivo "+name+" no es del tipo de imagen permitida.</p>");
               }
               else
               {
                 var objeto_url = navegador.createObjectURL(archivos[x]);
                 $("#vista-previa").append("<img src="+objeto_url+" width='250' height='250'>");
               }
           }
       });

         $("body").on("change",".previsualizar", function (e) {
             var archivo = document.getElementsByName('video_upload[]');
             //alert(archivo.length);
             for(var j = 0; j<archivo.length; j++)
             {
                 url = archivo[j].value;
                 var aux = "0";
                 for (var i = 0; i< url.length; i++)
                 {
                     var caracter = url.charAt(i);
                     if( caracter == "=")
                     {
                         aux = url.substring((i+1), (url.length));
                     }
                 }
                 if(aux != "0")
                 {
                     $( "#imagen" + j).remove();
                     var url_aux = "http://img.youtube.com/vi/" + aux + "/0.jpg";
                     //alert(url_aux);
                     $("#vista-previa-video"+j).append("<img src="+url_aux+" width='250' height='250' id='imagen" + j + "'>");
                 }
             }

         });

         $(document).ready(function () {
             var contenedor = $("#contenedor");
             var AddButton = $("#agregarCampo");
             //var z = 1;
             var x = $("#contenedor div").length + 1;
             var FieldCount = 1;
             $(AddButton).click(function () {
                 FieldCount++;
                 //$(contenedor).append('<div class="form-group col-md-3 col-sm-6 col-xs-12"><label for="fecha">Fecha</label><input class="form-control" id="fecha_' + FieldCount + '" name="fecha_' + FieldCount + '" type="date"></div><div class="form-group col-md-3 col-sm-6 col-xs-12"><label for="hora_ent">Hora entrada</label><input type="time" name="hora_ent_' + FieldCount + '" class="form-control" id="hora_ent_' + FieldCount + '"></div><div class="form-group col-md-3 col-sm-6 col-xs-12"><label for="hora_sal">Hora salida</label><input type="time" name="hora_sal_' + FieldCount + '" class="form-control" id="hora_sal_' + FieldCount+ '"></div><div class="form-group col-md-3 col-sm-6 col-xs-12"><label for="ubicacion">Ubicación</label><textarea class="form-control" placeholder="Por favor introduzca la ubicación" rows="2" id="ubicacion_' + FieldCount + '" name="ubicacion_' + FieldCount + '" cols="50"></textarea></div>');
                 $(contenedor).append('<div><input type="text" id="video" class="form-control previsualizar" name = "video_upload[]" placeholder="Url del video"><div id="vista-previa-video' + z + '"></div><a href="#" class="eliminar">&times;</a></div>');
                 //console.log(FieldCount);
                 z++;
             });
             return false;
         });

         $("body").on("click",".eliminar", function (e) {
             //if(x>1)
             {
                 $(this).parent('div').remove();
                 z--;
                 //$( ".contenedor" ).remove();
             }
             return false;
         });

       // Interceptamos el evento submit
    $('#formulario').submit(function() {
        //console.log($(this).serialize())
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            // Mostramos un mensaje con la respuesta de PHP
            success: function(data) {
                $('#respuesta').html(data);
                window.location.href = "{{url('home')}}";
            },
            error:function(xhr, status, error) {
              $("#form-errors").show("swing");
              //swal("Cancelado", "Lo sentimos algo se encuentra mal en su entrada", "error");
              var errors = xhr.responseJSON;
              //console.log(errors);
              errorsHtml = '<div class="alert alert-danger"><strong>Whoops!</strong> Hubo algunos problemas con su entrada.<br><br><ul style="padding-left:30px;">';
              $.each( errors , function( key, value ) {
                  errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
              });
              errorsHtml += '</ul></di>';
              $( '#form-errors' ).html( errorsHtml ); //appending to a <div id="form-errors"></div> inside form
            }

        })        
        return false;
    });
       
     });
    </script>