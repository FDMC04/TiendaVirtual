<?php

	class Permisos extends Controllers{
		public function __construct()
		{
			parent::__construct();
			session_start();
			if(empty($_SESSION['login']))
			{
				header('location: '.base_url().'/login');
			}
		}

		//Metodo getPermisos que recipe el parametro idrol 
		public function getPermisosRol(int $idrol){
			// Se crea la variable rolid que obtiene el valor de idrol pero convertido a entero por el intval
			$rolid = intval($idrol);
			// Se valida si el valor de la variable rolid es mayor a 0
			if($rolid > 0)
			{
				// Se crea la variable arrModulos que se le asigna el metodo selectModulos
				$arrModulos = $this->model->selectModulos();
				// Se crea la variable arrPermisosRol que utiliza el metodo selectPermisosRol del modelo enviando la variable rolid
				$arrPermisosRol = $this->model->selectPermisosRol($rolid);

				// Se crea un array que contendra los valores de los campor r, w, u y d
				$arrPermisos = array('r' => 0, 'w' => 0, 'u' => 0, 'd' => 0);
				// Se crea un array que va a contener como elmento idrol y se le coloca la variable que se recibe como parametro rolid
				$arrPermisoRol = array('idrol' => $rolid);

				// Se valida si el array arrPermisosRol esta vacio
				if(empty($arrPermisosRol))
				{
					// Se crea un ciclo
					for($i = 0; $i < count($arrModulos); $i++){
						// En cada uno de los registros se le agrega el item permisos y se le coloca el array arrPermisos
						$arrModulos[$i]['permisos'] = $arrPermisos;
					}
					// En caso de que la variable arrPermisosRol no este vacia se hace lo siguiente
				}else{
					for($i=0; $i < count($arrModulos); $i++){
						// Se verifica si existe la posicion en el array de permisos
						$arrPermisos = array('r' => 0, 'w' => 0, 'u' => 0, 'd' => 0);
						// Se validad si existen los permisos
						if(isset($arrPermisosRol[$i])){

							// Se crea un array donde se le asignan los valores de los campos del array arrPermisosRol a los campos r, w, u y d
							$arrPermisos = array(
								'r' => $arrPermisosRol[$i]['r'],
								'w' => $arrPermisosRol[$i]['w'],
								'u' => $arrPermisosRol[$i]['u'],
								'd' => $arrPermisosRol[$i]['d']
							);
						}
						
						// Entonces el componente permisos del array arrModulos sera igual al array arrPermisos
						$arrModulos[$i]['permisos'] = $arrPermisos;
						
					}
				}
				// Se le asigna el valor del array arrModulos al componente modulos del array arrPermisoRol
				$arrPermisoRol['modulos'] = $arrModulos;

				// Se crea una variable html que utiliza el metodo getModal, que envia el nombre del modal y el array, de esta manera se cargara todo el array en el modal
				$html = getModal("modalPermisos",$arrPermisoRol);

				// se depura el array para mostrar su contenido
				// dep($arrPermisoRol);

			}
			// Se detiene el proceso
			die();
		}

		// Metodo para guardar los permisos
		public function setPermisos(){
			// Se verifica que se haya enviado un POST
			if($_POST)
			{
				// Se le asigna el valor de idrol a la variable, pero primero se convierte a un valor de tipo entero con el metodo intval
				$intIdrol = intval($_POST['idrol']);
				// Se le asigna el valor de modulos a las variables
				$modulos = $_POST['modulos'];

				// Se utiliza el metodo deletePermisos del modelo enviando la variable intIdrol
				$this->model->deletePermisos($intIdrol);
				// Se busca todos los elementos del array modulos y se le asigna a una nueva variable
				foreach ($modulos as $modulo) {
					// Se obtiene el valor de los elementos del array
					// Se le asigna el elemento idmodulo a la variable
					$idModulo = $modulo['idmodulo'];
					// Se valida cob empty si los elementos estan vacios, eso significa que no se enviaron, si no se enviaron se les da el valor de 0, en el caso contrario se les da el valor de 1
					$r = empty($modulo['r']) ? 0 : 1;
					$w = empty($modulo['w']) ? 0 : 1;
					$u = empty($modulo['u']) ? 0 : 1;
					$d = empty($modulo['d']) ? 0 : 1;
					// Se utiliza el metodo insertPermisos del modelo donde se envian estos parametros 
					$requestPermiso = $this->model->insertPermisos($intIdrol, $idModulo, $r, $w, $u, $d);
				}
				// Se valida si la respuesta regresa tiene un valor, esto significa que si se insertaron los registros
				if($requestPermiso > 0)
				{
					// De ser asi se envia el mensaje de que se guardo correctamente
					$arrResponse = array('status' => true, 'msg' => 'Permisos asignados correctamente.');
				}else{
					// De lo contrario se envia un mensaje de que hubo un error
					$arrResponse = array('status' => false, 'msg' => 'No es posible asignar los permisos.');
				}
				// Se envia la respuesta, pero se convierte en un objeto de tipo JSON
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			// Se termina el proceso
			die();
		}
	}

?>