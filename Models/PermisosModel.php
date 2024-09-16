<?php  

	class PermisosModel extends Mysql
	{
		// Se crean las variables de los permisos
		public $intIdpermisos;
		public $intRolid;
		public $intModuloid;
		public $r; //leer
		public $w; //escribir
		public $u; //actualizar
		public $d; //eliminar

		public function __construct()
		{
			parent::__construct();
		}

		// Se crea el metodo para seleccionar los modulos
		public function selectModulos(){
			// Se crea una consulta que busca todos los registros en la tabla modulo cuando el valor de sus status sea diferende de 0
			$sql = "SELECT * FROM modulo WHERE status != 0";
			// Se utiliza el metodo select_all de MySql, enviando la variable con la consulta
			$request = $this->select_all($sql);
			// Se regresa la respuesta
			return $request;
		}

		// Se crea el metodo para seleccionar los permisos
		public function selectPermisosRol(int $idrol)
		{
			// Se le asigna a la variable intIdrol el valor del parametro idrol
			$this->intRolid = $idrol;
			// Se crea una consulta que busca todos los registros de la tabla permisos cuando el campo rolid es igual a la variable intRolid
			$sql = "SELECT * FROM permisos WHERE rolid = $this->intRolid";
			// Se utiliza el metodo select_all, donde se envia la consulta
			$request = $this->select_all($sql);
			// Se regresa la informacion
			return $request;
		}

		// Funcion para eliminar permisos que recibe el parametro idrol
		public function deletePermisos(int $idrol)
		{
			// Se le asigna a la variable intRolid el valor del parametro recibido
			$this->intRolid = $idrol;
			// Se crea una consulta para eliminar los permisos
			$sql = "DELETE FROM permisos WHERE rolid = $this->intRolid";
			// Se utiliza el metodo delete enviandole la consulta
			$request = $this->delete($sql);
			// Se regresa la respuesta
			return $request;
		}

		// Funcion para insertar permisos que recibe esto parametros
		public function insertPermisos(int $idrol, int $idmodulo, int $r, int $w, int $u, int $d){
			// Se le agrega a las variables el valor de los parametros obtenidos
			$this->intRolid = $idrol;
			$this->intModuloid = $idmodulo;
			$this->r = $r;
			$this->w = $w;
			$this->u = $u;
			$this->d = $d;
			// Se crea una consulta para insertar la informacion
			$query_insert = "INSERT INTO permisos(rolid,moduloid,r,w,u,d) VALUES(?,?,?,?,?,?)";
			// Se crea un array con la informacion que se va a insertar
			$arrData = array($this->intRolid, $this->intModuloid, $this->r, $this->w, $this->u, $this->d);
			// Se utiliza el metodo insert enviandole la consulta y los datos que se van a insertar
			$request_insert = $this->insert($query_insert,$arrData);
			// Se regresa la respuesta
			return $request_insert;
		}

		public function permisosModulo(int $idrol)
		{
			$this->intRolid = $idrol;
			$sql = "SELECT p.rolid, p.moduloid, m.titulo as modulo, p.r, p.w, p.u, p.d FROM permisos p INNER JOIN modulo m ON p.moduloid = m.idmodulo WHERE p.rolid = $this->intRolid ";
			$request = $this->select_all($sql);

			$arrPermisos = array();
			for($i=0; $i<count($request); $i++)
			{
				$arrPermisos[$request[$i]['moduloid']] = $request[$i];
			}
			return $arrPermisos;
		}

	}

?>