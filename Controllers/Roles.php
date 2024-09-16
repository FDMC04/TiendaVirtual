<?php

	class Roles extends Controllers{
		public function __construct()
		{
			sessionStart();
			parent::__construct();
			// session_start();
			// session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('location: '.base_url().'/login');
			}
			getPermisos(2);
		}

		public function Roles()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location: " . base_url(). '/dashboard');
			}
			$data['page_id'] = 3;
			$data['page_tag'] = "Roles usuario";
			$data['page_title'] = "Roles Usuario <small>Tienda Virtual</small>";
			$data['page_name'] = "rol_usuario";
			$data['page_functions_js'] = "functions_roles.js";
			$this->views->getView($this,"roles",$data);
		}

		// Funcion que extrae todos los roles
		public function getRoles()
		{
			$btnView = '';
			$btnEdit = '';
			$btnDelete = '';			
			if($_SESSION['permisosMod']['r'])
				{
				$arrData = $this->model->selectRoles();

				for ($i=0; $i < count($arrData); $i++) { 
					if($arrData[$i]['status'] == 1)
					{
						$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
					}else{
						$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
					}

					if($_SESSION['permisosMod']['u']){
						$btnView = '<button class="btn btn-secondary btn-sm btnPermisosRol" onClick="fntPermisos('.$arrData[$i]['idrol']. ')" title="Permisos"><i class="fa-solid fa-key"></i></button>';
						$btnEdit = '<button class="btn btn-primary btn-sm btnEditRol" onClick="fntEditRol(this,'.$arrData[$i]['idrol']. ')" title="Editar"><i class="fa-solid fa-pencil"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm btnDelRol" onClick="fntDelRol('.$arrData[$i]['idrol']. ')" title="Eliminar"><i class="fa-solid fa-trash"></i></button>';
					}

					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '. $btnDelete.'</div>';
				}

				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		// Funcion para extrar los roles y enviarlos al formulario de usuarios
		public function getSelectRoles()
		{
			$htmlOptions = "";
			$arrData = $this->model->selectRoles();
			if(count($arrData) > 0){
				// Los array inician con la posicion 0 por eso la variable $i tiene el valor de 0
				for ($i = 0; $i < count($arrData); $i++){
					if($arrData[$i]['status'] == 1){
						$htmlOptions .= '<option value="'.$arrData[$i]['idrol'].'">'.$arrData[$i]['nombrerol'].'</option>';
					}
				}
			}
			echo $htmlOptions;
			die();
		}

		// Funcion para extraer un rol que recibe un parametro de tipo entero
		public function getRol($idrol)
		{
			if($_SESSION['permisosMod']['r'])
			{
				// Se crea una variable que valida que el parametro sea de tipo entero, con intval se transforma y con strClean se limpia el parametro en caso de que se quiera hacer una inyeccion de datos
				$intIdrol = intval(strClean($idrol));
				// Se verifica que la variable sea mayor a 0
				if($intIdrol > 0)
				{
					// Se crea un array que hace referencia al metodo selectRol y le envia el parametro
					// En el metodo se ejecuta la consulta sql y regresa una respuesta
					$arrData = $this->model->selectRol($intIdrol);
					// Se valida si la respuesta esta vacia, de ser asi significa que no existe este rol
					if(empty($arrData))
					{
						// Se crea un array que envia una respuesta al servidor mostrandole un status falso y enviando el mensaje Datos no encontrados
						$arrResponse = array('status' => false, 'msg' => 'Datos no encotrados.');
					}else{
						// En el caso de que la variable no regrese vacia se crea un array que muestra al servidor un status verdadero y envia los datos
						$arrResponse = array('status' => true, 'data' => $arrData);
					}
					// Se devuelven los datos en un formato json el array con la respuesta hacia el servidor
					// Con el JSON_UNESCAPED_UNICODE se verifica que los caracteres especiales vayan de forma correcta
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		// Metodo para mostrar la informacion del formulario
		public function setRol(){
			
			// Se crea la variable intIdrol, la cual tiene el metodo intval que sirve para convertir los datos en tipo entero y se reciben los datos por medio del formulario, del input con el id idRol
			$intIdrol = intval($_POST['idRol']);

			// Se crean variables para almacenar los datos que se estan mandando en el formulario
			// strClean es una funcion que limpia la cadena de informacion para evitar la inyeccion de datos
			// intval es para obtener un valor de tipo entero
			$strRol = strClean($_POST['txtNombre']);
			$strDescripcion = strClean($_POST['txtDescripcion']);
			$intStatus = intval($_POST['listStatus']);
			$request_user = "";

			// Se valida si el id viene sin ningun valor
			if($intIdrol == 0)
			{
				if($_SESSION['permisosMod']['w'])
				{
					// En el caso de que asi sea se hace lo siguiente
					// Crear
					// Se le asigna a la variable request_rol, donde se envia la informacion al modelo insertRol
					$request_rol = $this->model->insertRol($strRol, $strDescripcion, $intStatus);
				}
				// Se crea una variable de nombre option con el valor de 1
				$option = 1;
			}else{
				if($_SESSION['permisosMod']['w'])
				{
					// En el caso de que la variable intIdrol tenga un valor se le asignara a la variable request_rol el objeto, donde se enviara los datos al modelo updateRol
					// Actualizar
					$request_rol = $this->model->updateRol($intIdrol, $strRol, $strDescripcion, $intStatus);
				}
				// Se crea la variable option con el valor de 2
				$option = 2;
			}

			// Se valida la respuesta obtenida del modelo insertRol
			// Si la respuesta es mayor a cero
			if($request_rol > 0)
			{
				// Se valida si la variable option tiene el valor de 1
				if($option == 1)
				{
					// En caso de ser asi se envia un mensaje donde menciona que los datos se guardaron correctamente
					$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
				}else{
					// En el caso de que la variable option no tenga valor se enviara el mensaje que menciona que se actualizaron los datos correctamente
					$arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
				}
				
			}else if($request_rol == 'false'){
				$arrResponse = array('status' => false, 'msg' => 'El rol que intenta crear ya existe.');
			}else{
				$arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos.');
			}
			sleep(1);
			// retornar el array en formato JSON
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			
			// se detiene el proceso
			die();
		}

		// Funcio para eliminar el rol
		public function delRol()
		{
			// Se verifica si se envio una peticion post
			if ($_POST) {
				if($_SESSION['permisosMod']['d'])
				{
					// De ser asi se obtiene el valor del campo idrol y se asigna a la variable intIdrol
					$intIdrol = intval($_POST['idrol']);
					// Se crea la variable requestDeletete en la que se envia el valor de la variable intIdrol al metodo deleteRol del modelo
					$requestDelete = $this->model->deleteRol($intIdrol);
					// Si se recibe un ok 
					if($requestDelete == "ok")
					{
						// Se crea este array que manda el valor del status y un mensaje
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Rol');
						// Si el valor de la variable es exist
					}else if($requestDelete == "exist"){
						// Se crea el array con el valor de status false y el mensaje
						$arrResponse = array('status' => false, 'msg' => 'No es posible eliminar un Rol asociado a usuarios.');
					}else{
						// En caso de que no sea ninguno de los anteriores se muestra este error
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el Rol.');
					}
					// Se retorna la variable, pero convirtiendola en formato JSON con json_encode
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				}
			}
			// Se cierra el proceso
			die();
		}
	}

?>