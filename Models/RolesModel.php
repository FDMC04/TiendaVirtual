<?php  

	class RolesModel extends Mysql
	{
		// Definir las propiedades de los roles
		public $intIdrol;
		public $strRol;
		public $strDescripcion;
		public $intStatus;

		public function __construct()
		{
			parent::__construct();
		}

		public function selectRoles()
		{
			$whereAdmin = "";
			if($_SESSION['idUser'] != 1){
				$whereAdmin = " and idrol !=1 ";
			}
			// Extrae los roles de la base de datos
			$sql = "SELECT * FROM rol WHERE status != 0 " . $whereAdmin;
			$request = $this->select_all($sql);
			return $request;
		}

		// Metodo para extraer un rol
		// Recibe como parametro la variable idrol de tipo entero
		public function selectRol(int $idrol)
		{
			// Buscar un rol
			// Coloca a la propiedad intIdrol el valor del parametro enviado
			$this->intIdrol = $idrol;
			// Se crea una variable que contiene la consulta a la base de datos, en la que se selecciona el registro que tenga el id igual al de la propiedad intIdrol
			$sql = "SELECT * FROM rol WHERE idrol = $this->intIdrol";
			// Se obtiene el resultado ejecutado por medio del metodo select del archivo Mysql donde se envia parametro sql
			$request = $this->select($sql);
			// Se regresa el valor de la variable request
			return $request;
		}

		// Se crea este metodo que recibe 3 parametros
		public function insertRol(string $rol, string $descripcion, int $status){
			// Se asignan los valores de los paramatros recibidos a las propiedades definidas
			$return = '';
			$this->strRol = $rol;
			$this->strDescripcion = $descripcion;
			$this->intStatus = $status;

			// Se hace una consulta para verificar si ya existe el rol que se quiere crear
			$sql = "SELECT * FROM rol WHERE nombrerol = '{$this->strRol}' ";
			// select_all selecciona todos los registros y envia la consulta
			$request = $this->select_all($sql);

			// Si el request esta vacio 
			if(empty($request))
			{
				// Se ejecuta un query para insertar los datos
				$query_insert = "INSERT INTO rol (nombrerol,descripcion,status) VALUES(?,?,?)";
				// Armar el array de los datos, donde se acomoda el orden de los elementos del array
				$arrData = array($this->strRol, $this->strDescripcion, $this->intStatus);
				// Se envia el query y el array al metodo insert
				$request_insert = $this->insert($query_insert, $arrData);
				// Se retorna el id
				return $request_insert;
			}else{
				// Si existe se regresa esto para mencionar que si existe el rol
				$return = "false";
			}
		}

		// Metodo para actualizar los roles
		// Se crea la funcion updateRol que recibe estos parametros
		public function updateRol(int $idrol, string $rol, string $description, int $status)
		{
			// Se le asignan los valores de los parametros recibidos a las variables creadas anteriormente
			$this->intIdrol = $idrol;
			$this->strRol = $rol;
			$this->strDescripcion = $description;
			$this->intStatus = $status;

			// Se crea una consulta que busca todos los registros que tengan el nombre de rol igual al de la variable strRol y que la id sea diferente al de los datos proporcionados
			// Esto lo que hace es buscar si hay un registro ya creado con el mismo nombre
			$sql = "SELECT * FROM rol WHERE nombrerol = '$this->strRol' AND idrol != '$this->intIdrol'";
			$request = $this->select_all($sql);
			// Se valida si la variable request esta vacia, esto significa que no hay un rol con el mismo nombre que se quiere actualizar
			if(empty($request))
			{
				// De ser asi se actualizan los datos 
				$sql = "UPDATE rol SET nombrerol = ?, descripcion = ?, status = ? WHERE idrol = '$this->intIdrol'";
				// Se crea un array donde se envia como items los datos 
				$arrData = array($this->strRol, $this->strDescripcion, $this->intStatus);
				// Se hace referencia al metodo update del archivo MySql, donde se envian los parametros, la consulta y el array de los datos que se van a actualizar
				$request = $this->update($sql,$arrData);
			}else{
				// En caso de que la variable request si haya traido un dato se le dará el valor de exist
				$request = "exist";
			}
			// Y se regresara la variable request hacia el controlador
			return $request;
		}

		// funcion para eliminar un rol que obtiene el parametro de idrol
		public function deleteRol(int $idrol)
		{
			// Se le asigna a la variable intIdrol el valor del parametro recibido
			$this->intIdrol = $idrol;
			// Se crea la consulta que busca en la tabla de personas un registro que tenga en su campo rolid el valor de la variable intIdrol
			$sql = "SELECT * FROM persona WHERE rolid = $this->intIdrol";
			// Se utiliza el metodo select_all con la consulta antes creada
			$request = $this->select_all($sql);
			// Se verifica si la cosulta regreso vacia
			if(empty($request))
			{
				// En caso de ser asi se crea esta consulta que actualiza el status del registro con el campo idrol igual a la variable intIdrol
				$sql = "UPDATE rol SET status = ? WHERE idrol = $this->intIdrol ";
				// El valor que se envia al campo status es 0
				$arrData = array(0);
				// Se utiliza el metodo update donde se envia la consulta junto con el valor del status en el arrData
				$request = $this->update($sql,$arrData);
				// Si es igual a 1 o verdadero
				if($request)
				{
					// De ser asi se envia un ok
					$request = 'ok';
				}else{
					// De no ser asi se envia un error
					$request = 'error';
				}
			}else{
				// En caso de que regrese un valor se envia el request que envia la respuesta exist
				$request = 'exist';
			}
			// Se regresa el valor de la variable request
			return $request;
		}
	}




?>