<?php
spl_autoload_register(function ($clase) {
	require_once ($clase . '.php');
});

class Rol extends ConnBD {
	public $conn;
	private $id;
	private $name;
	private $status;

	private $table = "roles";

	function __construct() {
		$this->conn = ConnBD::conection();
	}

	public function getTable() {
		return $this->table;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getId() {
		return $this->id;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getName() {
		return $this->name;
	}

	public function setStatus($id) {
		$this->status = $status;
	}

	public function getStatus() {
		return $this->status;
	}

	public function addRol() {
		$data = null;
		if (!($pquery = $this->conn->prepare("INSERT INTO {$this->getTable()}(name, status) VALUES (?,?)"))) {
			$msj = false; //"Falló la preparación: (" . $this->conn->errno . ") " . $this->conn->error;

		}
		/*
			  | ---------------------------------
			  | valores para bind_param         |
			  | i -> variable tipo entero       |
			  | d -> variable tipo double       |
			  | s -> variable tipo string       |
			  | b -> variable tipo blob         |
			  | ---------------------------------
		*/
		// Unicamente variables pueden pasar la funcion bin_param
		$name = $this->getName();
		$status = $this->getStatus();

		if (!$pquery->bind_param("ss", $name, $status)) {
			$msj = false; //"Falló la vinculación de parámetros: (" . $pquery->errno . ") " . $pquery->error;

		}
		if (!$pquery->execute()) {
			$data = false; //"Falló la ejecución: (" . $pquery->errno . ") " . $pquery->error;

			return @$data;
		} else {
			//$data = "Categoria ingresado correctamente";
			return $shopify_post_id;
		}
	}

	public function editRol() {
		$name = $this->getName();
		$status = $this->getStatus();
		$id = $this->getId();

		if (!($sentencia = $this->conn->prepare("UPDATE {$this->getTable()} SET name = ?, status = ? WHERE id = ?"))) {
			$data = false; //"Falló la preparación: (" . $this->conn->errno . ")" . $this->conn->error;

			return @$data;
		} elseif (!$sentencia->bind_param('ssi', $name, $status, $id)) {
			$data = false; //"Falló la vinculación de parámetros: (" . $sentencia->errno . ") " . $sentencia->error;

			return @$data;
		} elseif (!$sentencia->execute()) {
			$data = false; //"Falló la ejecución: (" . $sentencia->errno . ") " . $sentencia->error;

			return @$data;
		} else {

			$data = true;
			return @$data;
		}
	}

	public function get() {
		if (!($sentencia = $this->conn->prepare("SELECT * FROM {$this->getTable()} WHERE id = ?"))) {
			$data = false; //"Falló la preparación: (" . $this->conn->errno . ")" . $this->conn->error;
			return @$data;
		} else {
			$id = $this->getId();
			if (!$sentencia->bind_param('i', $id)) {
				$data = false; //"Falló la vinculación de parámetros: (" . $this->conn->errno . ")" . $this->conn->error;
				return @$data;
			} else {
				if (!$sentencia->execute()) {
					$data = false; //"Falló la ejecución: (" . $sentencia->errno . ") " . $sentencia->error;
					return @$data;
				} else {
					if (!($resultado = $sentencia->get_result())) {
						$data = false; //"Falló la obtención del conjunto de resultados: (" . $sentencia->errno . ") " . $sentencia->error;
						return @$data;
					} else {
						$data = $resultado->fetch_assoc();

						return @$data;
					}
				}
			}
		}
	}

	public function list(){
		$resultado = $this->conn->query("select * from {$this->getTable()} where status = 'Active'");
		$resultado->data_seek(0);
		$data=[];
		if(mysqli_num_rows($resultado)>0){
			//echo "Total: ".mysqli_num_rows($resultado);
			while ($fila = $resultado->fetch_assoc()) {
				$data[] = $fila;
			}
		}
		
		if($data<0){
			$data = null;
		}
		return @$data;
	}

	public function delete() {
		$id=  $this->getId();
		$resultado = $this->conn->query("DELETE FROM {$this->getTable()} WHERE id=$id");
		if($resultado){
			return true;
		}else{
			return false;
		}
	}
	

}