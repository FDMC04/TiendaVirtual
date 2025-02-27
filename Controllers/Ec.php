<?php
	class Ec extends Controllers{

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

		public function Ec()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location: " . base_url(). '/dashboard');
			}
			$data['page_tag'] = "Ec";
			$data['page_title'] = "Estado De Cuenta <small>Tienda Virtual</small>";
			$data['page_name'] = "ec";
			$data['page_functions_js'] = "functions_ec.js";
			$this->views->getView($this,"ec",$data);
		}
		
		
		public function getArticulos()
		{
			if($_SESSION['permisosMod']['r'])
			{
				$arrData = $this->model->selectArticulos();

				for($i=0; $i < count($arrData); $i++){
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';

					if($arrData[$i]['status'] == 1)
					{
						$arrData[$i]['status'] = '<span class="badge badge-warning">SIN ORDEN</span>';
					}else if($arrData[$i]['status'] == 2)
					{
						$arrData[$i]['status'] = '<span class="badge badge-primary">FALTA FACTURAR</span>';
					}else{
						$arrData[$i]['status'] = '<span class="badge badge-success">COMPLETADO</span>';
					}

					if($_SESSION['permisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm btnViewArticulo" onClick="fntViewArticulo('.$arrData[$i]['idarticulo']. ')" title="Ver articulo"><i class="far fa-eye"></i></button> ';
					}
					if($_SESSION['permisosMod']['u']){
						if(($_SESSION['idUser'] == 1 and $_SESSION['userData']['idrol'] == 1) ||
							($_SESSION['userData']['idrol'] == 1 and $arrData[$i]['idrol'] != 1)){
							$btnEdit = '<button class="btn btn-primary btn-sm btnEditArticulo" onClick="fntEditArticulo(this,'.$arrData[$i]['idarticulo']. ')" title="Editar articulo"><i class="fa-solid fa-pencil"></i></button>';
						}else{
							$btnEdit = '<button class="btn btn-primary btn-sm" disabled><i class="fa-solid fa-pencil"></i></button>';

						}
					}
					if($_SESSION['permisosMod']['d']){
						if(($_SESSION['idUser'] == 1 and $_SESSION['userData']['idrol'] == 1) || 
							($_SESSION['userData']['idrol'] == 1 and $arrData[$i]['idrol'] != 1)){
							$btnDelete = '<button class="btn btn-danger btn-sm btnDelArticulo" onClick="fntDelArticulo('.$arrData[$i]['idarticulo']. ')" title="Eliminar articulo"><i class="fa-solid fa-trash-alt"></i></button> ';
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
		
		// public function getUsuario($idpersona){
		// 	if($_SESSION['permisosMod']['r'])
		// 	{
		// 		$idEmpresa = intval(strClean($idpersona));
		// 		if($idusuario > 0)
		// 		{
		// 			$arrData = $this->model->selectUsuario($idusuario);
		// 			if(empty($arrData))
		// 			{
		// 				$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
		// 			}else{
		// 				$arrResponse = array('status' => true, 'data' => $arrData);
		// 			}
		// 			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		// 		}
		// 	}
		// 	die();
		// }
    }
?>