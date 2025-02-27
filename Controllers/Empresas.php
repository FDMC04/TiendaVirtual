<?php

    class Empresas extends Controllers{
        public function __construct()
        {
            sessionStart();
            parent::__construct();
            if(empty($_SESSION['login']))
            {
                header('location: '.base_url().'/login');
            }
            getPermisos(2);
        }

        public function Empresas()
        {
            if(empty($_SESSION['permisosMod']['r'])){
                header("Location: " . base_url(). '/dashboard');
            }
            $data['page_tag'] = "Empresas";
            $data['page_title'] = "EMPRESAS <small>Tienda Virtual</small>";
            $data['page_name'] = "empresas";
            $data['page_functions_js'] = "functions_empresas.js";
            $this->views->getView($this,"empresas",$data);
        }

        public function getEmpresas()
        {
            if($_SESSION['permisosMod']['r'])
            {
                $arrData = $this->model->selectEmpresas();
                for ($i=0; $i < count($arrData); $i++){
                    // $btnView = '';
                    $btnEdit = '';
                    $btnDelete = '';

                    if($arrData[$i]['status'] == 1)
                    {
                        $arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
                    }else{
                        $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
                    }

                    // if($_SESSION['permisosMod']['r']){
                        // $btnView = '<button class="btn btn-info btn-sm btnViewEmpresa" onClick="fntViewEmpresa('.$arrData[$i]['idemp'].')" title="Ver empresa"><i class="far fa-eye"></i></button> ';
                    // }
                    if($_SESSION['permisosMod']['u']){
                        $btnEdit = '<button class="btn btn-primary btn-sm btnEditEmpresa" onClick="fntEditEmpresa(this,'.$arrData[$i]['idemp'].')" title="Editar empresa"><i class="fa-solid fa-pencil"></i></button>';
                    }
					if($_SESSION['permisosMod']['d']){
						
                        $btnDelete = '<button class="btn btn-danger btn-sm btnDelEmpresa" onClick="fntDelEmpresa('.$arrData[$i]['idemp']. ')" title="Eliminar empresa"><i class="fa-solid fa-trash-alt"></i></button> ';
					}
                    // $arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '. $btnDelete.'</div>';
                    $arrData[$i]['options'] = '<div class="text-center">'.$btnEdit.' '. $btnDelete.'</div>';
                }
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            }
			die();
        }

        public function getEmpUsuarios()
        {
            if($_SESSION['permisosMod']['r'])
            {
                $arrData = $this->model->selectEmpUsuarios();
                for ($i=0; $i < count($arrData); $i++){
                    // $btnView = '';
                    $btnEdit = '';
                    $btnDelete = '';

                    if($arrData[$i]['status'] == 1)
                    {
                        $arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
                    }else{
                        $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
                    }

                    // if($_SESSION['permisosMod']['r']){
                        // $btnView = '<button class="btn btn-info btn-sm btnViewEmpresa" onClick="fntViewEmpresa('.$arrData[$i]['idusuario'].')" title="Ver empresa"><i class="far fa-eye"></i></button> ';
                    // }
                    if($_SESSION['permisosMod']['u']){
                        $btnEdit = '<button class="btn btn-primary btn-sm btnEditEmpUsuario" onClick="fntEditEmpUsuario(this,'.$arrData[$i]['idusuario'].')" title="Editar usuarios"><i class="fa-solid fa-pencil"></i></button>';
                    }
					if($_SESSION['permisosMod']['d']){
						
                        $btnDelete = '<button class="btn btn-danger btn-sm btnDelEmpUsuario" onClick="fntDelEmpUsuario('.$arrData[$i]['idusuario']. ')" title="Eliminar usuario"><i class="fa-solid fa-trash-alt"></i></button> ';
					}
                    // $arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '. $btnDelete.'</div>';
                    $arrData[$i]['options'] = '<div class="text-center">'.$btnEdit.' '. $btnDelete.'</div>';
                }
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            }
			die();
        }
        
        
        public function setEmpresa(){
            // dep($_POST);die;
            if($_POST){
                
                if(empty($_POST['txtNombreEmp']) || empty($_POST['txtRFC']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) || empty($_POST['listStatus']) ){
                    $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
                }else{
                    $idEmp = intval($_POST['idEmp']);
                    $strNombre = ucwords(strClean($_POST["txtNombreEmp"]));
                    $strRFC = ucwords(strClean($_POST["txtRFC"]));
                    $intTelefono = intval(strClean($_POST['txtTelefono']));
                    $strEmail = strtolower(strClean($_POST["txtEmail"]));
                    $intStatus = intval(strClean($_POST['listStatus']));
                    $request_user = "";
                    if($idEmp == 0)
                    {
                        $option = 1;
                        if($_SESSION['permisosMod']['w'])
                        {
                            $request_user = $this->model->insertEmpresa(
                                $strNombre,
                                $strRFC,
                                $intTelefono,
                                $strEmail,
                                $intStatus
                            );
                        }
                    }else{
                        $option = 2;
                        if($_SESSION['permisosMod']['u'])
                        {
                            $request_user = $this->model->updateEmpresa(
                                $idEmp,
                                $strNombre,
                                $strRFC,
                                $intTelefono,
                                $strEmail,
                                $intStatus
                            );
                        }
                    }
                    
                    if($request_user > 0)
                    {
                            $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');

                    }else if($request_user == 0){
                        $arrResponse = array('status' => false, 'msg' => 'El email ya existe, ingrese otro.');
                    }else{
                        $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos.');
                    }
                }
                sleep(1);
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        public function setUsuario(){
            if($_POST){
				if(empty($_POST['listEmpid']) || empty($_POST['txtNombreU']) || empty($_POST['txtTelUsuario']) || empty($_POST['txtCorreo']) || empty($_POST['listEstado'])){
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{
					$idUemp = intval($_POST['idUemp']);
					$intEmpresa = intval(strClean($_POST["listEmpid"]));
					$strNombreU = ucwords(strClean($_POST["txtNombreU"]));
					$intTelUs = intval(strClean($_POST["txtTelUsuario"]));
					$strCorreo = strtolower(strClean($_POST['txtCorreo']));
					$intEstado = strtolower(strClean($_POST["listEstado"]));
					$request_user = "";

					if($idUemp == 0)
					{
						$option = 1;

						if($_SESSION['permisosMod']['w'])
						{
							$request_user = $this->model->insertUsuarioEmp(
								$intEmpresa,
								$strNombreU,
								$intTelUs,
								$strCorreo,
								$intEstado
							);
						}
					}else{
						$option = 2;
						if($_SESSION['permisosMod']['u'])
						{
							$request_user = $this->model->updateUsuarioEmp(
								$idUemp,
								$intEmpresa,
								$strNombreU,
								$intTelUs,
								$strCorreo,
								$intEstado

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
						$arrResponse = array('status' => false, 'msg' => 'El correo ya existe, ingrese otro.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos.');
					}
				}
				sleep(1);
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
        }

        public function getEmpUsuario($idusuario){
            if($_SESSION['permisosMod']['r'])
            {
                $idusu = intval(strClean($idusuario));
                if($idusu > 0)
                {
                    $arrData = $this->model->selectEmpUsuario($idusu);
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

        public function getEmpresa($idemp){
            if($_SESSION['permisosMod']['r'])
            {
                $idempresa = intval(strClean($idemp));
                if($idempresa > 0)
                {
                    $arrData = $this->model->selectEmpresa($idempresa);
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

        public function getSelectEmpresas()
        {
            $htmlOptions = "";
            $arrData = $this->model->selectEmpresas();
            if(count($arrData) > 0){
                for ($i = 0; $i < count($arrData); $i++){
                    if($arrData[$i]['status'] == 1){
                        $htmlOptions .= '<option value="'.$arrData[$i]['idemp'].'">'.$arrData[$i]['nombreemp'].'</option>';
                    }
                }
            }
            echo $htmlOptions;
            die();
        }

        public function delEmpresa()
		{
			if($_POST){
				if($_SESSION['permisosMod']['d'])
				{
					$intIdemp = intval($_POST['idEmp']);
					$requestDelete = $this->model->deleteEmpresa($intIdemp);
					if($requestDelete)
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la empresa.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar la empresa.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

        public function delEmpUsuario()
        {
			if($_POST){
				if($_SESSION['permisosMod']['d'])
				{
					$intIdUemp = intval($_POST['idUemp']);
					$requestDelete = $this->model->deleteUEmp($intIdUemp);
					if($requestDelete)
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el usuario de la empresa.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el usuario de la empresa.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
        }

    }


?>