<?php
spl_autoload_register(function ($clase) {
	require_once ($clase . '.php');
});
/**
 * Description of ConnBD
 *
 * @author name
 */
class ConnBD {

	private $dbhost = "localhost";
	private $dbuser = "id10981376_fogo";
	private $dbpass = "Fogo2019!";
	private $dbname = "id10981376_ambassador_portal";

	public function conection() {
		/**
		 * @return object conn con la conexión
		 */
		$conn = new mysqli($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);
		if ($conn->connect_error) {
			echo "Error de Conexion ($conn->connect_errno)$conn->connect_error\n";
			header('Location: /view/pages/templates/error-conection.php');
			exit;
		} else {
			return $conn;
		}
	}

}
?>