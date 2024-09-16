<?php  

	class UsuariosModel extends Mysql
	{
		private $intIdUsuario;
		private $strIdentificacion;
		private $strNombre;
		private $strApellido;
		private $intTelefono;
		private $strEmail;
		private $strPassword;
		private $strToken;
		private $intTipoId;
		private $intStatus;
		private $strNit;
		private $strNomFiscal;
		private $strDirFiscal;

		public function __construct()
		{
			parent::__construct();
		}

		public function insertUsuario(string $identificacion, string $nombre, string $apellido, int $telefono, string $email, string $password, int $tipoid, int $status){
			$this->strIdentificacion = $identificacion;
			$this->strNombre = $nombre;
			$this->strApellido = $apellido;
			$this->intTelefono = $telefono;
			$this->strEmail = $email;
			$this->strPassword = $password;
			$this->intTipoId = $tipoid;
			$this->intStatus = $status;
			$return = 0;

			$sql = "SELECT * FROM persona WHERE email_user = '{$this->strEmail}' or identificacion = '{$this->strIdentificacion}'";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$query_insert = "INSERT INTO persona(identificacion, nombres, apellidos, telefono, email_user, password, rolid, status) VALUES(?,?,?,?,?,?,?,?)";
				$arrData = array(
					$this->strIdentificacion,
					$this->strNombre,
					$this->strApellido,
					$this->intTelefono,
					$this->strEmail,
					$this->strPassword,
					$this->intTipoId,
					$this->intStatus
				);

				$request_insert = $this->insert($query_insert,$arrData);
				$return = $request_insert;
			}else{
				$return = 0;
			}
			return $return;
		}

		public function selectUsuarios()
		{
			$whereAdmin = "";
			if($_SESSION['idUser'] != 1){
				$whereAdmin = " and p.idpersona != 1";
			}
			$sql = "SELECT p.idpersona,p.identificacion,p.nombres,p.apellidos,p.telefono,p.email_user,p.password,p.status, r.idrol,r.nombrerol
				FROM persona p
				INNER JOIN rol r 
				ON p.rolid = r.idrol 
				WHERE p.status != 0 " . $whereAdmin;
				$request = $this->select_all($sql);
				return $request;
		}

		// DATE_FORMAT es una funcion que le da formato a la fecha
		// Este es el formato que se le da al dato datecreated: %d-%m-%Y
		// De esta forma solo mostrara el año, mes y dia
		public function selectUsuario(int $idpersona){
			$this->intIdUsuario = $idpersona;
			$sql = "SELECT p.idpersona,p.identificacion,p.nombres,p.apellidos,p.telefono,p.email_user,p.nit,p.nombrefiscal,p.direccionfiscal,r.idrol,r.nombrerol,p.status,DATE_FORMAT(p.datecreated, '%d-%m-%Y') as fechaRegistro FROM persona p INNER JOIN rol r ON p.rolid = r.idrol WHERE p.idpersona = '{$this->intIdUsuario}'";
			// echo $sql; exit();
			$request = $this->select($sql);
			return $request;
		}

		public function updateUsuario(int $idUsuario, string $identificacion, string $nombre, string $apellido, int $telefono, string $email, string $password, int $tipoid, int $status)
		{
			$this->intIdUsuario = $idUsuario;
			$this->strIdentificacion = $identificacion;
			$this->strNombre = $nombre;
			$this->strApellido = $apellido;
			$this->intTelefono = $telefono;
			$this->strEmail = $email;
			$this->strPassword = $password;
			$this->intTipoId = $tipoid;
			$this->intStatus = $status;

			$sql = "SELECT * FROM persona WHERE (email_user = '{$this->strEmail}' AND idpersona != $this->intIdUsuario) OR (identificacion = '{$this->strIdentificacion}' AND idpersona != $this->intIdUsuario) ";

			$request = $this->select_all($sql);

			if(empty($request))
			{
				if($this->strPassword != "")
				{
					$sql = "UPDATE persona SET identificacion=?,nombres=?,apellidos=?,telefono=?,email_user=?,password=?,rolid=?,status=? WHERE idpersona = $this->intIdUsuario ";
					$arrData = array(
						$this->strIdentificacion,
						$this->strNombre,
						$this->strApellido,
						$this->intTelefono,
						$this->strEmail,
						$this->strPassword,
						$this->intTipoId,
						$this->intStatus
					);
				}else{
					$sql = "UPDATE persona SET identificacion=?,nombres=?,apellido=?,telefono=?,email_user=?,rolid=?,status=? WHERE idpersona = $this->intIdUsuario ";
					$arrData = array(
						$this->strIdentificacion,
						$this->strNombre,
						$this->strApellido,
						$this->intTelefono,
						$this->strEmail,
						$this->intTipoId,
						$this->intStatus
					);
				}
				$request = $this->update($sql,$arrData);
			}else{
				$request = 0;
			}

			return $request;
		}

		public function deleteUsuario(int $idtipousuario)
		{
			$this->intIdUsuario = $idtipousuario;
			$sql = "UPDATE persona SET status = ? WHERE idpersona = $this->intIdUsuario ";
			$arrData = array(0);
			$request = $this->update($sql,$arrData);
			return $request;
		}

		public function updatePerfil(int $idUsuario, string $identificacion, string $nombre, string $apellido, int $telefono, string $password)
		{
			$this->intIdUsuario = $idUsuario;
			$this->strIdentificacion = $identificacion;
			$this->strNombre = $nombre;
			$this->strApellido = $apellido;
			$this->intTelefono = $telefono;
			$this->strPassword = $password;

			if($this->strPassword != "")
			{
				$sql = "UPDATE persona SET identificacion=?, nombres=?,apellidos=?,telefono=?,password=? WHERE idpersona = $this->intIdUsuario ";
				$arrData = array(
					$this->strIdentificacion,
					$this->strNombre,
					$this->strApellido,
					$this->intTelefono,
					$this->strPassword
				);
			}else{
				$sql = "UPDATE persona SET identificacion=?, nombres=?,apellidos=?,telefono=? WHERE idpersona = $this->intIdUsuario ";
				$arrData = array(
					$this->strIdentificacion,
					$this->strNombre,
					$this->strApellido,
					$this->intTelefono,
				);
			}
			$request = $this->update($sql,$arrData);
			return $request;
		}

		public function updateDataFiscal(int $idUsuario, string $strNit, string $strNomFiscal, string $strDirFiscal)
		{
			$this->intIdUsuario = $idUsuario;
			$this->strNit = $strNit;
			$this->strNomFiscal = $strNomFiscal;
			$this->strDirFiscal = $strDirFiscal;

			$sql = "UPDATE persona SET nit=?,nombrefiscal=?,direccionfiscal=? WHERE idpersona = $this->intIdUsuario ";
			$arrData = array($this->strNit, $this->strNomFiscal, $this->strDirFiscal);
			$request = $this->update($sql,$arrData);
			return $request;
		}

	}

?>