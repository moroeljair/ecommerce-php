$(document).ready(function(){
    var funcion;
    var palabras;
    cargarPalabras();
    llenar_departamentos();
    llenar_provincia();
    llenar_ciudad();
    verificar_sesion();
    obtener_datos();
    llenar_direcciones();

    function cargarPalabras(){
        funcion='lenguaje';
        $.ajax({
            type: "POST",
            url: '../Controllers/idiomas.php',
            data: 'funcion='+funcion,
            async: false,
            success: function(response){
                idioma = response;
                $.getJSON( "./idiomas/"+idioma+".json", function( json )
                {     
                    //cargar palabras del lenguaje   
                    palabras=json;

                    $('#departamento').select2({
                        placeholder: palabras.mi_perfil.departamento_p,
                        language: {
                            noResults: function(){
                                return palabras.mi_perfil.noResults;
                            },
                            searching: function(){
                                return palabras.mi_perfil.searching;
                            }
                        }
                    });
                    
                    $('#provincia').select2({
                        placeholder: palabras.mi_perfil.provincia,
                        language: {
                            noResults: function(){
                                return palabras.mi_perfil.noResults;
                            },
                            searching: function(){
                                return palabras.mi_perfil.searching;
                            }
                        }
                    });

                    $('#distrito').select2({
                        placeholder: palabras.mi_perfil.ciudad,
                        language: {
                            noResults: function(){
                                return palabras.mi_perfil.noResults;
                            },
                            searching: function(){
                                return palabras.mi_perfil.searching;
                            }
                        }
                    });

                });
            }
          })
    }

    function llenar_direcciones(){
        funcion="llenar_direcciones";
        $.post("../Controllers/UsuarioDistritoController.php",{funcion},(response)=>{
            //console.log(response);
            let direcciones = JSON.parse(response);
            let template='';
            direcciones.forEach(direccion => {
                template+=`
                <div class="callout callout-info">
                    <div class="card-header">            
                      <div class="card-tools">
                        <h2 class="lead"><b>${direccion.direccion}</b></h2>
                        <button dir_id="${direccion.id}" type="button" class="eliminar_direccion btn btn-tool">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body"
                        <p class="text-muted text-sm">${direccion.referencia}</p>
                        <ul class="ml-4 mb-0 fa-ul text-muted">
                            <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span>
                                ${direccion.ciudad}
                            </li>
                        </ul>
                    </div>   
                </div>
                `;
            });
            $('#direcciones').html(template);
        })
    }

     $(document).on('click','.eliminar_direccion',(e)=>{
        let elemento = $(this)[0].activeElement;
        let id = $(elemento).attr('dir_id');
        let idioma = identificarIdioma();
        $.getJSON( "./idiomas/"+idioma+".json", function( json )
        {     
            //cargar palabras del lenguaje   
            palabras=json;
            //console.log(palabras);

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                  confirmButton: 'btn btn-success m-3',
                  cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
              })
              
              swalWithBootstrapButtons.fire({
                title: palabras.borrar_direccion.title,
                text: palabras.borrar_direccion.text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: palabras.borrar_direccion.confirmButtonText,
                cancelButtonText: palabras.borrar_direccion.cancelButtonText,
                reverseButtons: true
              }).then((result) => {
                if (result.isConfirmed) {
                    funcion="eliminar_direccion";
                    $.post("../Controllers/UsuarioDistritoController.php",{funcion,id},(response)=>{
                        response=response.trim();
                        if(response=='success'){
                            swalWithBootstrapButtons.fire(
                                palabras.borrar_direccion.deleted,
                                '',
                                'success'
                              );
                              //location.href='./mi_perfil.php';
                              llenar_direcciones();
                        }else{
                            swalWithBootstrapButtons.fire(
                                palabras.borrar_direccion.error,
                                '',
                                'error'
                              )
                        }
                    });
                
                  
                } else if (
                  /* Read more about handling dismissals below */
                  result.dismiss === Swal.DismissReason.cancel
                ) {
                  swalWithBootstrapButtons.fire(
                    palabras.borrar_direccion.no,
                    '',
                    'error'
                  );
                  
                }
              })

        });

        
     })

    function llenar_departamentos(){
        funcion="llenar_departamentos";
        $.post("../Controllers/DepartamentoController.php",{funcion},(response)=>{
            let departamentos = JSON.parse(response);
            let template='';
            departamentos.forEach(departamento => {
                template+=`
                <option value="${departamento.id}">${departamento.nombre}</option>
                `;
            });
            $('#departamento').html(template);
            $('#departamento').val('').trigger('change');
        })
    }

    function llenar_provincia(){
        funcion="llenar_provincia";
        $.post("../Controllers/DepartamentoController.php",{funcion},(response)=>{
            let departamentos = JSON.parse(response);
            let template='';
            departamentos.forEach(departamento => {
                template+=`
                <option value="${departamento.id}">${departamento.nombre}</option>
                `;
            });
            $('#provincia').html(template);
            $('#provincia').val('').trigger('change');
        })
    }

    function llenar_ciudad(){
        funcion="llenar_ciudad";
        $.post("../Controllers/DepartamentoController.php",{funcion},(response)=>{
            let departamentos = JSON.parse(response);
            let template='';
            departamentos.forEach(departamento => {
                template+=`
                <option value="${departamento.id}">${departamento.nombre}</option>
                `;
            });
            $('#distrito').html(template);
            $('#distrito').val('').trigger('change');
        })
    }

    
    /*
    $('#departamento').change(function (){
        let id_departamento = $('#departamento').val();
        funcion="llenar_provincia";
        $.post("../Controllers/DepartamentoController.php",{funcion, id_departamento},(response)=>{
            let provincias = JSON.parse(response);
            let template='';
            provincias.forEach(provincia => {
                template+=`
                <option value="${provincia.id}">${provincia.nombre}</option>
                `;
            });
            $('#provincia').html(template);
        })
    })
    */


    
            

    

    function verificar_sesion(){
        funcion = 'verificar_sesion';
        $.post('../Controllers/UsuarioController.php', {funcion}, (response)=>{
            //console.log(response);
            if(response != ''){
                let sesion=JSON.parse(response);
                $('#nav_login').hide();
                $('#nav_register').hide();
                $('#usuario_nav').text(sesion.user);
                $('#avatar_nav').attr('src','../Util/Img/'+sesion.avatar);
                $('#avatar_menu').attr('src','../Util/Img/'+sesion.avatar);
                $('#usuario_menu').text(sesion.user);
                
            }else{
                
                location.href = './login.php';
            }
        });
    }

    function obtener_datos(){
        funcion = 'obtener_datos';
        $.post('../Controllers/UsuarioController.php', {funcion}, (response)=>{
            let usuario = JSON.parse(response);
            $('#username').text(usuario.username);
            $('#tipo_usuario').text(usuario.tipo_usuario);
            $('#nombres').text(usuario.nombres+' '+usuario.apellidos);
            $('#avatar_perfil').attr('src','../Util/Img/'+usuario.avatar);
            $('#dni').text(usuario.dni);
            $('#email').text(usuario.email);
            $('#telefono').text(usuario.telefono);

            
        });
    }



    $("#direccion").change(function(){
        $('#direccion').val( ($("#direccion").val().trim()) );
    });
    
    $('#form-direccion').submit(e=>{
        funcion='crear_direccion';
        let id_distrito = $('#distrito').val();
        let direccion = $('#direccion').val();
        let referencia = $('#referencia').val();
        $.post('../Controllers/UsuarioDistritoController.php', {funcion,id_distrito,direccion,referencia}, (response)=>{
            var respuesta = JSON.parse(response);
            //console.log(respuesta);
            response = respuesta[0].trim();
                      if(response=="ok"){
                        Swal.fire({
                          position: 'center',
                          icon: 'success',
                          title: respuesta[1],
                          showConfirmButton: false,
                          timer: 2500
                        }).then(function(){
                          $('#form-direccion').trigger('reset');
                          location.href='./mi_perfil.php';
                        });
                      }else{
                        Swal.fire({
                          icon: 'error',
                          title: 'X',
                          text: respuesta[1]
                        })
                      }
            
        })

        //console.log(user+' '+pass);
        //para que al dar click en el boton submit no se reinicie la pagina
        e.preventDefault();
    })

    
});

