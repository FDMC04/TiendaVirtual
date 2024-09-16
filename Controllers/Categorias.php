<?php  

	class Categorias extends Controllers{
		public function __construct()
		{
			sessionStart();
			parent::__construct();
			if(empty($_SESSION['login']))
			{
				header('location: '.base_url().'/login');
			}
			getPermisos(6);
		}

		public function Categorias()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location: " . base_url(). '/dashboard');
			}
			$data['page_tag'] = "Categorias";
			$data['page_title'] = "Categorias <small>Tienda Virtual</small>";
			$data['page_name'] = "categorias";
			$data['page_functions_js'] = "functions_categorias.js";
			$this->views->getView($this,"categorias",$data);
		}

		public function setCategoria(){
			if($_POST){
				if(empty($_POST['txtNombre']) || empty($_POST['txtDescripcion']) || empty($_POST['listStatus']))
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos');
				}else{
					$intIdcategoria = intval($_POST['idCategoria']);

					$strCategoria = strClean($_POST['txtNombre']);
					$strDescripcion = strClean($_POST['txtDescripcion']);
					$intStatus = intval($_POST['listStatus']);

					$ruta = strtolower(clear_cadena($strCategoria));
					$ruta = str_replace(" ", "-", $ruta);

					$request_categoria = "";

					$foto = $_FILES['foto'];
					$nombre_foto = $foto['name'];
					$type = $foto['type'];
					$url_temp = $foto['tmp_name'];
					$imgPortada = 'portada_categoria.png';

					if($nombre_foto != ''){
						$imgPortada = 'img_'.md5(date('d-m-Y H:m:s')).'.jpg';
					}
					
					if($intIdcategoria == 0)
					{
						if($_SESSION['permisosMod']['w'])
						{
							$request_categoria = $this->model->insertCategoria($strCategoria, $strDescripcion, $imgPortada, $ruta, $intStatus);
							$option = 1;
						}
					}else{
						if($_SESSION['permisosMod']['u'])
						{
							if($nombre_foto == ''){
								if($_POST['foto_actual'] != 'portada_categoria.png' && $_POST['foto_remove'] == 0){
									$imgPortada = $_POST['foto_actual'];
								}
							}
							$request_categoria = $this->model->updateCategoria($intIdcategoria, $strCategoria, $strDescripcion, $imgPortada, $ruta, $intStatus);
							$option = 2;
						}
					}

					if($request_categoria > 0)
					{
						if($option == 1)
						{
							$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
							if($nombre_foto != ''){ uploadImage($foto,$imgPortada); }
						}else{
							$arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
							if($nombre_foto != ''){ uploadImage($foto,$imgPortada); }
							if(($nombre_foto == '' && $_POST['foto_remove'] == 1 && $_POST['foto_actual'] != 'portada_categoria.png') || ($nombre_foto != '' && $_POST['foto_actual'] != 'portada_categoria.png')){
								deleteFile($_POST['foto_actual']);
							}
						}
						
					}else if($request_categoria == 'false'){
						$arrResponse = array('status' => false, 'msg' => 'La categoria que intenta crear ya existe.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos.');
					}

				}
				sleep(1);
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getCategorias()
		{
			if($_SESSION['permisosMod']['r'])
			{

				$arrData = $this->model->selectCategorias();

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
						$btnView = '<button class="btn btn-info btn-sm btnViewInfo" onClick="fntViewInfo('.$arrData[$i]['idcategoria']. ')" title="Ver categoria"><i class="far fa-eye"></i></button> ';
					}
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary btn-sm btnEditCliente" onClick="fntEditInfo(this,'.$arrData[$i]['idcategoria']. ')" title="Editar categoria"><i class="fa-solid fa-pencil"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm btnDelCliente" onClick="fntDelInfo('.$arrData[$i]['idcategoria']. ')" title="Eliminar categoria"><i class="fa-solid fa-trash-alt"></i></button> ';
					}

					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '. $btnDelete.'</div>';
				}

				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getCategoria($idcategoria)
		{
			if($_SESSION['permisosMod']['r'])
			{
				$intIdcategoria = intval($idcategoria);
				if($intIdcategoria > 0)
				{
					$arrData = $this->model->selectCategoria($intIdcategoria);
					if(empty($arrData))
					{
						$arrResponse = array('status' => false, 'msg' => 'Datos no encotrados.');
					}else{
						$arrData['url_portada'] = media().'/images/uploads/'.$arrData['portada'];
						$arrResponse = array('status' => true, 'data' => $arrData);
					}
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function delCategoria()
		{
			if ($_POST) {
				if($_SESSION['permisosMod']['d'])
				{
					$intIdcategoria = intval($_POST['idCategoria']);
					$requestDelete = $this->model->deleteCategoria($intIdcategoria);
					if($requestDelete == "ok")
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la Categoria');
					}else if($requestDelete == "exist"){
						$arrResponse = array('status' => false, 'msg' => 'No es posible eliminar una categoria con productos asociados.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar la Categoria.');
					}
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function getSelectCategorias(){
			$htmlOptions = "";
			$arrData =$this->model->selectCategorias();
			if(count($arrData) > 0 ){
				for($i=0; $i<count($arrData); $i++){
					if($arrData[$i]['status'] == 1){
						$htmlOptions .= '<option value="'.$arrData[$i]['idcategoria'].'">'.$arrData[$i]['nombre'].'</option>';
					}
				}
			}
			echo $htmlOptions;
			die();
		}
	}

?>