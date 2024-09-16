<?php  

class Conexion{
	private $connect;

	public function __construct(){
		// Especificamos el nombre del servidor, base de datos
		$connectionString = "mysql:host=".DB_HOST.";dbname=".DB_NAME.';'.DB_CHARSET;
		try{
			// Se realiza la conexion por medio del nuevo objeto
			$this->connect = new PDO($connectionString,DB_USER,DB_PASSWORD);
			// Esta linea de codigo sirve para detectar los errores en la conexion
			$this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}catch(Exception $e){
			$this->connect = 'Error de conexion';
			echo "ERROR: ". $e->getMessage();
		}
	}

public function conect(){
	return $this->connect;
}

}

?>