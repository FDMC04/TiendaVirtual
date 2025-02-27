<?php

    class EmpresasModel extends Mysql
    {
        private $intIdEmp;
		private $strNombre;
		private $strRFC;
		private $intTelefono;
		private $strEmail;
        private $intStatus;

        private $intIdUEmp;
        private $intEmpresa;
        private $strNombreU;
        private $intTelU;
        private $strCorreo;
        private $intEstado;

        public function __construct()
        {
            parent::__construct();
        }

        public function insertEmpresa(string $nombre, string $RFC, int $telefono, string $email, int $status){
			$this->strNombre = $nombre;
			$this->strRFC = $RFC;
			$this->intTelefono = $telefono;
			$this->strEmail = $email;
			$this->intStatus = $status;
			$return = 0;

			$sql = "SELECT * FROM empresas WHERE correo = '{$this->strEmail}'";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$query_insert = "INSERT INTO empresas(nombreemp, rfc, telefono, correo, status) VALUES(?,?,?,?,?)";
				$arrData = array(
					$this->strNombre,
					$this->strRFC,
					$this->intTelefono,
					$this->strEmail,
					$this->intStatus
				);

				$request_insert = $this->insert($query_insert,$arrData);
				$return = $request_insert;
			}else{
				$return = 0;
			}
			return $return;
		}

        public function insertUsuarioEmp(int $empresa, string $nombreU, int $telU, string $correo, int $estado){
            $this->intEmpresa = $empresa;
            $this->strNombreU = $nombreU;
            $this->intTelU = $telU;
            $this->strCorreo = $correo;
            $this->intEstado = $estado;
            $return = 0;

            $sql = "SELECT * FROM usuarioemp WHERE correo = '{$this->strCorreo}'";
            $request = $this->select_all($sql);

            if(empty($request))
            {
                $query_insert = "INSERT INTO usuarioemp(empresaid,nombreusuario,telefono,correo,status) VALUES(?,?,?,?,?)";
                $arrData = array(
                    $this->intEmpresa,
                    $this->strNombreU,
                    $this->intTelU,
                    $this->strCorreo,
                    $this->intEstado
                );
                $request_insert = $this->insert($query_insert,$arrData);
                $return = $request_insert;
            }else{
                $return = 0;
            }
            return $request;
        }

        public function selectEmpUsuarios()
        {
            $sql = "SELECT u.idusuario, u.nombreusuario, u.telefono, u.correo, u.status, e.idemp, e.nombreemp FROM usuarioemp u INNER JOIN empresas e ON u.empresaid = e.idemp WHERE u.status != 0";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectEmpresas()
        {
            $sql = "SELECT idemp, nombreemp, rfc, telefono, correo, status FROM empresas WHERE status != 0";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectEmpresa(int $idemp){
            $this->intIdEmp = $idemp;
            $sql = "SELECT idemp,nombreemp,rfc,telefono,correo,status FROM empresas WHERE idemp = '$this->intIdEmp'";
			$request = $this->select($sql);
			return $request;
        }

        public function selectEmpUsuario(int $idusuario){
            $this->intIdUEmp = $idusuario;
            $sql = "SELECT idusuario,empresaid,nombreusuario,telefono,correo,status FROM usuarioemp WHERE idusuario = '$this->intIdUEmp'";
			$request = $this->select($sql);
			return $request;
        }

        public function updateEmpresa(int $idEmp, string $nombre, string $RFC, int $telefono, string $email, int $status)
		{
			$this->intIdEmp = $idEmp;
			$this->strNombre = $nombre;
			$this->strRFC = $RFC;
			$this->intTelefono = $telefono;
			$this->strEmail = $email;
			$this->intStatus = $status;

			$sql = "SELECT * FROM empresas WHERE (correo = '{$this->strEmail}' AND idemp != $this->intIdEmp)";

			$request = $this->select_all($sql);

			if(empty($request))
			{
                $sql = "UPDATE empresas SET nombreemp=?,rfc=?,telefono=?,correo=?,status=? WHERE idemp = $this->intIdEmp ";
                $arrData = array(
                    $this->strNombre,
                    $this->strRFC,
                    $this->intTelefono,
                    $this->strEmail,
                        $this->intStatus
                );
				$request = $this->update($sql,$arrData);
			}else{
				$request = 0;
			}

			return $request;
		}

        public function updateUsuarioEmp(int $idUsuario, int $empresa, string $nombreU, int $telU, string $correo, int $estado)
		{
			$this->intIdUEmp = $idUsuario;
			$this->intEmpresa = $empresa;
			$this->strNombreU = $nombreU;
			$this->intTelU = $telU;
			$this->strCorreo = $correo;
			$this->intEstado = $estado;

			$sql = "SELECT * FROM usuarioemp WHERE (correo = '{$this->strCorreo}' AND idusuario != $this->intIdUEmp)";

			$request = $this->select_all($sql);

			if(empty($request))
			{
                $sql = "UPDATE usuarioemp SET empresaid=?,nombreusuario=?,telefono=?,correo=?,status=? WHERE idusuario = $this->intIdUEmp ";
                $arrData = array(
                    $this->intEmpresa,
                    $this->strNombreU,
                    $this->intTelU,
                    $this->strCorreo,
                        $this->intEstado
                );
				$request = $this->update($sql,$arrData);
			}else{
				$request = 0;
			}

			return $request;
		}

        public function deleteEmpresa(int $idemp)
		{
			$this->intIdEmp = $idemp;
			$sql = "UPDATE empresas SET status = ? WHERE idemp = $this->intIdEmp ";
			$arrData = array(0);
			$request = $this->update($sql,$arrData);
			return $request;
		}

        public function deleteUEmp(int $idusuario)
        {
			$this->intIdUEmp = $idusuario;
			$sql = "UPDATE usuarioemp SET status = ? WHERE idusuario = $this->intIdUEmp ";
			$arrData = array(0);
			$request = $this->update($sql,$arrData);
			return $request;
        }
    }

?>