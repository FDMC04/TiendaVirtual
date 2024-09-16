<?php  

	class Productos extends Controllers{
		public function __construct()
		{
			sessionStart();
			parent::__construct();
			if(empty($_SESSION['login']))
			{
				header('location: '.base_url().'/login');
			}
			getPermisos(4);
		}

		public function Productos()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location: " . base_url(). '/dashboard');
			}
			$data['page_tag'] = "Productos";
			$data['page_title'] = "Productos <small>Tienda Virtual</small>";
			$data['page_name'] = "productos";
			$data['page_functions_js'] = "functions_productos.js";
			$this->views->getView($this,"productos",$data);
		}

		public function getProductos()
		{
			if($_SESSION['permisosMod']['r'])
			{

				$arrData = $this->model->selectProductos();

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

					$arrData[$i]['precio'] = SMONEY.formatMoney($arrData[$i]['precio']);

					if($_SESSION['permisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm btnViewInfo" onClick="fntViewInfo('.$arrData[$i]['idproducto']. ')" title="Ver producto"><i class="far fa-eye"></i></button> ';
					}
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary btn-sm btnEditCliente" onClick="fntEditInfo(this,'.$arrData[$i]['idproducto']. ')" title="Editar producto"><i class="fa-solid fa-pencil"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm btnDelCliente" onClick="fntDelInfo('.$arrData[$i]['idproducto']. ')" title="Eliminar producto"><i class="fa-solid fa-trash-alt"></i></button> ';
					}

					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '. $btnDelete.'</div>';
				}

				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}


		public function setProducto(){
			if($_POST){
				if(empty($_POST['txtNombre']) || empty($_POST['txtCodigo']) || empty($_POST['listCategoria']) || empty($_POST['txtPrecio']) || empty($_POST['listStatus']) )
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos');
				}else{
					$idProducto = intval($_POST['idProducto']);
					$strNombre = strClean($_POST['txtNombre']);
					$strDescripcion = strClean($_POST['txtDescripcion']);
					$strCodigo = strClean($_POST['txtCodigo']);
					$intCategoriaId = intval($_POST['listCategoria']);
					$strPrecio = strClean($_POST['txtPrecio']);
					$intStock = intval($_POST['txtStock']);
					$intStatus = intval($_POST['listStatus']);

					$request_producto = "";

					$ruta = strtolower(clear_cadena($strNombre));
					$ruta = str_replace(" ", "-", $ruta);

					if($idProducto == 0)
					{
						if($_SESSION['permisosMod']['w']){
							$option = 1;
							$request_producto = $this->model->insertProducto(
								$strNombre,
								$strDescripcion,
								$strCodigo,
								$intCategoriaId,
								$strPrecio,
								$intStock,
								$ruta,
								$intStatus
							);
						}
					}else{
						if($_SESSION['permisosMod']['u']){
							$option = 2;
							$request_producto = $this->model->updateProducto(
								$idProducto,
								$strNombre,
								$strDescripcion,
								$strCodigo,
								$intCategoriaId,
								$strPrecio,
								$intStock,
								$ruta,
								$intStatus

							);
						}	
					}
					if($request_producto > 0)
					{
						if($option == 1)
						{
							$arrResponse = array('status' => true, 'idProducto' => $request_producto, 'msg' => 'Datos guardados correctamente.');
						}else{
							$arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
						}
					}else if($request_producto == 0){
						$arrResponse = array('status' => false, 'idProducto' => $idProducto, 'msg' => 'Ya existe un producto con el Código Ingresado.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos.');
					}

				}
				sleep(1);
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getProducto( $idproducto)
		{
			if($_SESSION['permisosMod']['r']){
				$idproducto = intval($idproducto);
				if($idproducto > 0)
				{
					$arrData = $this->model->selectProducto($idproducto);
					if(empty($arrData)){
						$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
					}else{
						$arrImg = $this->model->selectImages($idproducto);
						if(count($arrImg) > 0)
						{
							for($i=0; $i < count($arrImg); $i++)
							{
								$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
							}
						}
						$arrData['images'] = $arrImg;
						$arrResponse = array('status' => true, 'data' => $arrData);
					}
					// dep($arrResponse);
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();	
		}

		public function setImage(){
			// dep($_POST);
			// dep($_FILES);
			if($_POST){
				if (empty($_POST['idproducto'])) {
					$arrResponse = array('status' => false, 'msg' => 'Es necesario registrar el producto antes de asignarle una imagen.');
				}else{
					$idProducto = intval($_POST['idproducto']);
					$foto = $_FILES['foto'];
					$imgNombre = 'pro_'.md5(date('d-m-Y H:m:s')).'.jpg';
					$request_image = $this->model->insertImage($idProducto, $imgNombre);
					if($request_image)
					{
						$uploadImage = uploadImage($foto,$imgNombre);
						$arrResponse = array('status' => true, 'imgname' => $imgNombre, 'msg' => 'Archivo cargado.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error de carga.');
					}
				}
				sleep(1);
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function delFile(){
			if($_POST)
			{
				if(empty($_POST['idproducto']) || empty($_POST['file'])){
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos');
				}else{
					$idProducto = intval($_POST['idproducto']);
					$imgNombre = strClean($_POST['file']);
					$request_image = $this->model->deleteImage($idProducto,$imgNombre);
					if($request_image){
						$deleteFile = deleteFile($imgNombre);
						$arrResponse = array("status" => true, 'msg' => 'Archivo eliminado.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function delProducto(){
			if($_POST)
			{
				if($_SESSION['permisosMod']['d']){
					$intIdproducto = intval($_POST['idProducto']);
					$requestDelete = $this->model->deleteProducto($intIdproducto);
					if($requestDelete)
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el producto.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el producto.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
	}

?>