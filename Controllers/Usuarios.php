<?php

	class Usuarios extends Controllers{
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

		public function Usuarios()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location: " . base_url(). '/dashboard');
			}
			$data['page_tag'] = "Usuarios";
			$data['page_title'] = "USUARIOS <small>Tienda Virtual</small>";
			$data['page_name'] = "usuarios";
			$data['page_functions_js'] = "functions_usuarios.js";
			$this->views->getView($this,"usuarios",$data);
		}

		public function setUsuario(){
			if($_POST){
				
				if(empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) || empty($_POST['listRolid']) || empty($_POST['listStatus']) ){
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{
					$idUsuario = intval($_POST['idUsuario']);
					$strIdentificacion = strClean($_POST["txtIdentificacion"]);
					$strNombre = ucwords(strClean($_POST["txtNombre"]));
					$strApellido = ucwords(strClean($_POST["txtApellido"]));
					$intTelefono = intval(strClean($_POST['txtTelefono']));
					// strtolower convierte todas las letras en minusculas
					$strEmail = strtolower(strClean($_POST["txtEmail"]));
					$intTipoId = intval(strClean($_POST['listRolid']));
					$intStatus = intval(strClean($_POST['listStatus']));
					$request_user = "";

					if($idUsuario == 0)
					{
						$option = 1;

						// Validacion de la contraseña, se valida si la contraseña esta vacia, de ser asi se crea una contraseña con la funcion passGenerator creada anteriormente en el archivo Helpers y con el metodo hash se encrypta la contraseña
						// En el caso de que si se haya enviado una contraseña se encryptara con el mismo metodo
						$strPassword = empty($_POST["txtPassword"]) ? hash("SHA256",passGenerator()) : hash("SHA256",strClean($_POST['txtPassword']));
						if($_SESSION['permisosMod']['w'])
						{
							$request_user = $this->model->insertUsuario(
								$strIdentificacion,
								$strNombre,
								$strApellido,
								$intTelefono,
								$strEmail,
								$strPassword,
								$intTipoId,
								$intStatus

							);
						}
					}else{
						$option = 2;
						$strPassword = empty($_POST["txtPassword"]) ? hash("SHA256",passGenerator()) : hash("SHA256",$_POST['txtPassword']);
						if($_SESSION['permisosMod']['u'])
						{
							$request_user = $this->model->updateUsuario(
								$idUsuario,
								$strIdentificacion,
								$strNombre,
								$strApellido,
								$intTelefono,
								$strEmail,
								$strPassword,
								$intTipoId,
								$intStatus

							);
						}
					}


					if($request_user > 0)
					{
						if($option == 1)
						{
							$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');

						}else{
							$arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
						}
					}else if($request_user == 0){
						$arrResponse = array('status' => false, 'msg' => 'El email o la identificación ya existe, ingrese otro.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos.');
					}
				}
				sleep(1);
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getUsuarios()
		{
			if($_SESSION['permisosMod']['r'])
			{

				$arrData = $this->model->selectUsuarios();

				for ($i=0; $i < count($arrData); $i++) { 
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';

					if($arrData[$i]['status'] == 1)
					{
						$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
					}else{
						$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
					}

					if($_SESSION['permisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm btnViewUsuario" onClick="fntViewUsuario('.$arrData[$i]['idpersona']. ')" title="Ver usuario"><i class="far fa-eye"></i></button> ';
					}
					if($_SESSION['permisosMod']['u']){
						if(($_SESSION['idUser'] == 1 and $_SESSION['userData']['idrol'] == 1) ||
							($_SESSION['userData']['idrol'] == 1 and $arrData[$i]['idrol'] != 1)){
							$btnEdit = '<button class="btn btn-primary btn-sm btnEditUsuario" onClick="fntEditUsuario(this,'.$arrData[$i]['idpersona']. ')" title="Editar usuario"><i class="fa-solid fa-pencil"></i></button>';
						}else{
							$btnEdit = '<button class="btn btn-primary btn-sm" disabled><i class="fa-solid fa-pencil"></i></button>';

						}
					}
					if($_SESSION['permisosMod']['d']){
						if(($_SESSION['idUser'] == 1 and $_SESSION['userData']['idrol'] == 1) || 
							($_SESSION['userData']['idrol'] == 1 and $arrData[$i]['idrol'] != 1) and 
							($_SESSION['userData']['idpersona'] != $arrData[$i]['idpersona']) ){
							$btnDelete = '<button class="btn btn-danger btn-sm btnDelUsuario" onClick="fntDelUsuario('.$arrData[$i]['idpersona']. ')" title="Eliminar usuario"><i class="fa-solid fa-trash-alt"></i></button> ';
						}else{
							$btnDelete = '<button class="btn btn-danger btn-sm" disabled><i class="fa-solid fa-trash-alt"></i></button> ';
						}
					}

					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '. $btnDelete.'</div>';
				}

				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getUsuario($idpersona){
			if($_SESSION['permisosMod']['r'])
			{
				$idusuario = intval(strClean($idpersona));
				if($idusuario > 0)
				{
					$arrData = $this->model->selectUsuario($idusuario);
					if(empty($arrData))
					{
						$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
					}else{
						$arrResponse = array('status' => true, 'data' => $arrData);
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}


		public function delUsuario()
		{
			if($_POST){
				if($_SESSION['permisosMod']['d'])
				{
					$intIdpersona = intval($_POST['idUsuario']);
					$requestDelete = $this->model->deleteUsuario($intIdpersona);
					if($requestDelete)
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el usuario.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el usuario.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function perfil(){
			$data['page_tag'] = "Perfil";
			$data['page_title'] = "Perfil de Usuario";
			$data['page_name'] = "perfil";
			$data['page_functions_js'] = "functions_usuarios.js";
			$this->views->getView($this,"perfil",$data);
		}

		public function putPerfil(){
			if($_POST){
				if(empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) )
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{
					$idUsuario = $_SESSION['idUser'];
					$strIdentificacion = strClean($_POST['txtIdentificacion']);
					$strNombre = strClean($_POST['txtNombre']);
					$strApellido = strClean($_POST['txtApellido']);
					$intTelefono = intval(strClean($_POST['txtTelefono']));
					$strPassword = "";
					if(!empty($_POST['txtPassword']))
					{
						$strPassword = hash("SHA256",$_POST['txtPassword']);
					}

					$request_user = $this->model->updatePerfil(
						$idUsuario,
						$strIdentificacion,
						$strNombre,
						$strApellido,
						$intTelefono,
						$strPassword
					);

					if($request_user)
					{
						sessionUser($_SESSION['idUser']);
						$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados Correctamente.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'No es pocible almacenar los datos.');
					}
				}
				sleep(1);
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function putDFiscal(){
			if($_POST){
				if(empty($_POST['txtNit']) || empty($_POST['txtNombreFiscal']) || empty($_POST['txtDirFiscal']) )
				{
					$arrResponse = array("status" => false, "msg" => "Datos Incorrectos.");
				}else{
					$idUsuario = $_SESSION['idUser'];
					$strNit = strClean($_POST['txtNit']);
					$strNomFiscal = strClean($_POST['txtNombreFiscal']);
					$strDirFiscal = strClean($_POST['txtDirFiscal']);
					$request_datafiscal = $this->model->updateDataFiscal($idUsuario, $strNit, $strNomFiscal, $strDirFiscal);
					if($request_datafiscal)
					{
						sessionUser($_SESSION['idUser']);
						$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados Correctamente.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'No es posible actualizar los datos.');
					}
				}
				sleep(1);
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}
	}


?>