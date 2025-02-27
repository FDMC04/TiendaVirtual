<?php  

	class EcModel extends Mysql
	{
		private $strNombre;
		private $strRFC;
		private $intTelefono;
		private $strEmail;

		public function __construct()
		{
			parent::__construct();
		}

        public function selectArticulos()
		{
			$sql = "SELECT idarticulo,remision,reporte,descripcion,usuarioid,fechacot,cotizacion,oc,factura,importe,iva,abono,restan,fechapago,complemento,status
				FROM inventario 
				WHERE status != 0 ";
				$request = $this->select_all($sql);
				return $request;
		}

    }
?>