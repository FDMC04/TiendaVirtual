<?php 

	class Clientes extends Controllers{
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
			getPermisos(3);
		}

		public function Clientes()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location: " . base_url(). '/dashboard');
			}
			$data['page_tag'] = "Clientes";
			$data['page_title'] = "Clientes <small>Tienda Virtual</small>";
			$data['page_name'] = "clientes";
			$data['page_functions_js'] = "functions_clientes.js";
			$this->views->getView($this,"clientes",$data);
		}

		public function setCliente(){
			if($_POST){
				error_reporting(0);
				
				if(empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) || empty($_POST['txtNit']) || empty($_POST['txtNombreFiscal']) || empty($_POST['txtDirFiscal']) ){
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{
					$idUsuario = intval($_POST['idUsuario']);
					$strIdentificacion = strClean($_POST["txtIdentificacion"]);
					$strNombre = ucwords(strClean($_POST["txtNombre"]));
					$strApellido = ucwords(strClean($_POST["txtApellido"]));
					$intTelefono = intval(strClean($_POST['txtTelefono']));
					// strtolower convierte todas las letras en minusculas
					$strEmail = strtolower(strClean($_POST["txtEmail"]));
					$strNit = strClean($_POST['txtNit']);
					$strNomFiscal = strClean($_POST['txtNombreFiscal']);
					$strDirFiscal = strClean($_POST['txtDirFiscal']);
					$intTipoId = 7;
					$request_user = "";

					if($idUsuario == 0)
					{
						$option = 1;
						$strPassword = empty($_POST["txtPassword"]) ? passGenerator() : strClean($_POST['txtPassword']);
						$strPasswordEncript = hash("SHA256",$strPassword);
						if($_SESSION['permisosMod']['w'])
						{
							$request_user = $this->model->insertCliente(
								$strIdentificacion,
								$strNombre,
								$strApellido,
								$intTelefono,
								$strEmail,
								$strPasswordEncript,
								$intTipoId,
								$strNit,
								$strNomFiscal,
								$strDirFiscal

							);
						}
					}else{
						$option = 2;
						$strPassword = empty($_POST["txtPassword"]) ? hash("SHA256",passGenerator()) : hash("SHA256",$_POST['txtPassword']);
						if($_SESSION['permisosMod']['u'])
						{
							$request_user = $this->model->updateCliente(
								$idUsuario,
								$strIdentificacion,
								$strNombre,
								$strApellido,
								$intTelefono,
								$strEmail,
								$strPassword,
								$strNit,
								$strNomFiscal,
								$strDirFiscal

							);
						}
					}


					if($request_user > 0)
					{
						if($option == 1)
						{
							$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');

							

							$nombreusuario = $strNombre.' '.$strApellido;

							$dataUsuario = array(
								'nombreUsuario'=>$nombreusuario,
								'email'=>$strEmail,
								'password'=>$strPassword,
								'asunto'=>'Bienvendio a nuestra pagina',
							);
							sendEmail($dataUsuario,'email_bienvenida');

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

		public function getClientes()
		{
			if($_SESSION['permisosMod']['r'])
			{

				$arrData = $this->model->selectClientes();

				for ($i=0; $i < count($arrData); $i++) { 
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';

					if($_SESSION['permisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm btnViewInfo" onClick="fntViewInfo('.$arrData[$i]['idpersona']. ')" title="Ver cliente"><i class="far fa-eye"></i></button> ';
					}
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary btn-sm btnEditCliente" onClick="fntEditCliente(this,'.$arrData[$i]['idpersona']. ')" title="Editar cliente"><i class="fa-solid fa-pencil"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm btnDelCliente" onClick="fntDelCliente('.$arrData[$i]['idpersona']. ')" title="Eliminar cliente"><i class="fa-solid fa-trash-alt"></i></button> ';
					}

					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '. $btnDelete.'</div>';
				}

				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getCliente($idpersona){
			if($_SESSION['permisosMod']['r'])
			{
				$idusuario = intval(strClean($idpersona));
				if($idusuario > 0)
				{
					$arrData = $this->model->selectCliente($idusuario);
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

		public function delCliente()
		{
			if($_POST){
				if($_SESSION['permisosMod']['d'])
				{
					$intIdpersona = intval($_POST['idUsuario']);
					$requestDelete = $this->model->deleteCliente($intIdpersona);
					if($requestDelete)
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el cliente.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el cliente.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
	}

?>