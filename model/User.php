<?php
spl_autoload_register(function ($clase) {
	require_once ($clase . '.php');
});

class User extends ConnBD {
	public $conn; // Atributo publico para crear la conexion a la BD desde cualquier metodo
	// Acontinuacion los atributos privados de la clase, que vendran a representar los campos de la tabla USER
	private $id;
	private $name;
	private $last_name;
	private $email;
	private $password;
	private $featured_image;
	private $known_as;
	private $age;
	private $region;
	private $signature_dish_name;
	private $signature_dish_link;
	private $experience_number;
	private $experience_timeframe;
	private $grill_of_choice;
	private $biggest_inspiration;
	private $equipment_preferred;
	private $instagram_link;
	private $twitter_link;
	private $facebook_link;
	private $handle_blog;
	private $handle_article;
	private $blog_url;
	private $id_rol;
	private $created_by;
	private $created_date;
	private $status;

	private $table = "users";

	function __construct() {
		$this->conn = ConnBD::conection(); // Se conecta al metodo "conection" de la clase ConnBD
	}

	/*
		Funciones publicas para acceder a los atributos de la clase, desde otro lado
		Sin estas funciones, no seria posible poder utilizar las funciones (metodos) de la clase

		Funciones con "get" son para poder obtener la informacion
		Funciones con "set" son para poder establecer un valor al campo, para ya sea hacer una INSERCION, MODIFICACION, BORRADO O CONSULTA
	*/

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

	public function setLastName($last_name) {
		$this->last_name = $last_name;
	}

	public function getLastName() {
		return $this->last_name;
	}

	public function setEmail($email) {
		$this->email = $email;
	}

	public function getEmail() {
		return $this->email;
	}

	public function setPassword($password) {
		$this->password = $password;
	}

	public function getPassword() {
		return sha1($this->password);
	}

	public function setFeaturedImage($featured_image) {
		$this->featured_image = $featured_image;
	}

	public function getFeaturedImage() {
		return $this->featured_image;
	}

	public function setKnownAs($known_as) {
		$this->known_as = $known_as;
	}

	public function getKnownAs() {
		return $this->known_as;
	}

	public function setAge($age) {
		$this->age = $age;
	}

	public function getAge() {
		return $this->age;
	}

	public function setRegion($region) {
		$this->region = $region;
	}

	public function getRegion() {
		return $this->region;
	}

	public function setSignatureDishName($signature_dish_name) {
		$this->signature_dish_name = $signature_dish_name;
	}

	public function getSignatureDishName() {
		return $this->signature_dish_name;
	}

	public function setSignatureDishLink($signature_dish_link) {
		$this->signature_dish_link = $signature_dish_link;
	}

	public function getSignatureDishLink() {
		return $this->signature_dish_link;
	}

	public function setExperienceNumber($experience_number) {
		$this->experience_number = $experience_number;
	}

	public function getExperienceNumber() {
		return $this->experience_number;
	}

	public function setExperienceTimeframe($experience_timeframe) {
		$this->experience_timeframe = $experience_timeframe;
	}

	public function getExperienceTimeframe() {
		return $this->experience_timeframe;
	}

	public function setGrillOfChoice($grill_of_choice) {
		$this->grill_of_choice = $grill_of_choice;
	}

	public function getGrillOfChoice() {
		return $this->grill_of_choice;
	}

	public function setBiggestInspiration($biggest_inspiration) {
		$this->biggest_inspiration = $biggest_inspiration;
	}

	public function getBiggestInspiration() {
		return $this->biggest_inspiration;
	}

	public function setEquipmentPreferred($equipment_preferred) {
		$this->equipment_preferred = $equipment_preferred;
	}

	public function getEquipmentPreferred() {
		return $this->equipment_preferred;
	}

	public function setInstagramLink($instagram_link) {
		$this->instagram_link = $instagram_link;
	}

	public function getInstagramLink() {
		return $this->instagram_link;
	}

	public function setTwitterLink($twitter_link) {
		$this->twitter_link = $twitter_link;
	}

	public function getTwitterLink() {
		return $this->twitter_link;
	}

	public function setFacebookLink($facebook_link) {
		$this->facebook_link = $facebook_link;
	}

	public function getFacebookLink() {
		return $this->facebook_link;
	}

	public function setHandleBlog($handle_blog) {
		$this->handle_blog = $handle_blog;
	}

	public function getHandleBlog() {
		return $this->handle_blog;
	}

	public function setHandleArticle($handle_article) {
		$this->handle_article = $handle_article;
	}

	public function getHandleArticle() {
		return $this->handle_article;
	}

	public function setBlogUrl($blog_url) {
		$this->blog_url = $blog_url;
	}

	public function getBlogUrl() {
		return $this->blog_url;
	}

	public function setIdRol($id_rol) {
		$this->id_rol = $id_rol;
	}

	public function getIdRol() {
		return $this->id_rol;
	}

	public function setCreatedBy($created_by) {
		$this->created_by = $created_by;
	}

	public function getCreatedBy() {
		return $this->created_by;
	}

	public function setcreatedDate($created_date) {
		$this->created_date = $created_date;
	}

	public function getCreatedDate() {
		return $this->created_date;
	}

	public function setStatus($status) {
		$this->status = $status;
	}

	public function getStatus() {
		return $this->status;
	}

	// FIN FUNCIONES PUBLICAS DE LA CLASE

	/*
		Metodos para realizar operaciones a la base de datos.

		Aqui se pueden crear todos los metodos (funciones) que sean necesarios para realizar operaciones con la tabla CLIENTE
		de la BASE DE DATOS
	*/
	/*
		public function log_in() {
			$email = $this->getEmail();
			$password = $this->getPassword();
			$resultado = $this->conn->query("select * from {$this->getTabla()} where email = '{$email}' and password = '{$password}' and status='Active'");
			$resultado->data_seek(0);
			$data = null;
			if (mysqli_num_rows($resultado) > 0) {
				while ($fila = $resultado->fetch_assoc()) {
					$data[] = $fila;
				}
			}
			if ($data < 0) {
				$data = null;
			}
			return $data;
		}
	*/

	public function log_in() {
		if (!($sentencia = $this->conn->prepare("SELECT * FROM {$this->getTable()} WHERE email = ? and password = ? and status != 'Inactive' "))) {
			$data = false; //"Falló la preparación: (" . $this->conn->errno . ")" . $this->conn->error;
			return @$data;
		} else {
			$email = $this->getEmail();
			$password = $this->getPassword();
			if (!$sentencia->bind_param('ss', $email, $password)) {
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

	public function addUser() {
		$data = null;
		if (!($pquery = $this->conn->prepare("INSERT INTO {$this->getTable()}(name, last_name, email, password, id_rol, created_by, created_date, status, handle_blog, blog_url) VALUES (?,?,?,?,?,?,?,?,?,?)"))) {
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
		$last_name = $this->getLastName();
		$email = $this->getEmail();
		$password = $this->getPassword();
		$id_rol = $this->getIdRol();
		$created_by = $this->getCreatedBy();
		$created_date = $this->getCreatedDate();
		$status = $this->getStatus();
		$handle_blog = $this->getHandleBlog();
		$blog_url = $this->getBlogUrl();
		if (!$pquery->bind_param("ssssiissss", $name, $last_name, $email, $password, $id_rol, $created_by, $created_date, $status, $handle_blog, $blog_url)) {
			$msj = false; //"Falló la vinculación de parámetros: (" . $pquery->errno . ") " . $pquery->error;

		}
		if (!$pquery->execute()) {
			$data = false; //"Falló la ejecución: (" . $pquery->errno . ") " . $pquery->error;

			return @$data;
		} else {
			//$data = "Categoria ingresado correctamente";
			return true;
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
		$resultado = $this->conn->query("select users.id, users.name, users.last_name, users.email, users.id_rol, users.created_date, users.status, created.name as created_name, created.last_name as created_lastname from users users left join users created on created.id = users.created_by");
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
		return $data;
	}

	public function api_list(){
		$resultado = $this->conn->query("select * from api_list");
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
		return $data;
	}

	public function edit() {
		$id = $this->getId();
		$name = $this->getName();
		$last_name = $this->getLastName();
		$email = $this->getEmail();
		$id_rol = $this->getIdRol();
		$status = $this->getStatus();
		if (!($sentencia = $this->conn->prepare("UPDATE {$this->getTable()} SET name = ?, last_name = ?, email = ?, id_rol = ?, status = ? WHERE id = ?"))) {
			$data = false; //"Falló la preparación: (" . $this->conn->errno . ")" . $this->conn->error;

			return @$data;
		} elseif (!$sentencia->bind_param('sssisi', $name, $last_name, $email, $id_rol, $status, $id)) {
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

	public function editExtraInfo() {
		$id = $this->getId();
		$status = "Active";
		$experience_timeframe = $this->getExperienceTimeframe();
		$featured_image = $this->getFeaturedImage();
		$known_as = $this->getKnownAs();
		$age = $this->getAge();
		$region = $this->getRegion();
		$signature_dish_name = $this->getSignatureDishName();
		$signature_dish_link = $this->getSignatureDishlink();
		$experience_number = $this->getExperienceNumber();
		$grill_of_choice = $this->getGrillOfChoice();
		$biggest_inspiration = $this->getBiggestInspiration();
		$equipment_preferred = $this->getEquipmentPreferred();
		$instagram_link = $this->getInstagramLink();
		$twitter_link = $this->getTwitterLink();
		$facebook_link = $this->getFacebookLink();
		$handle_article = $this->getHandleArticle();

		if (!($sentencia = $this->conn->prepare("UPDATE {$this->getTable()} SET featured_image = ?, known_as = ?, age = ?, region = ?, signature_dish_name = ?, signature_dish_link = ?, experience_number = ?, experience_timeframe = ?, grill_of_choice = ?, biggest_inspiration = ?, equipment_preferred = ?, instagram_link = ?, twitter_link = ?, facebook_link = ?, status = ?, handle_article = ? WHERE id = ?"))) {
			$data = false; //"Falló la preparación: (" . $this->conn->errno . ")" . $this->conn->error;

			return @$data;
		} elseif (!$sentencia->bind_param('ssisssisssssssssi', $featured_image, $known_as, $age, $region, $signature_dish_name, $signature_dish_link, $experience_number, $experience_timeframe, $grill_of_choice, $biggest_inspiration, $equipment_preferred, $instagram_link, $twitter_link, $facebook_link, $status, $handle_article, $id)) {
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

	public function edit_info_and_password() {
		$id = $this->getId();
		$name = $this->getName();
		$last_name = $this->getLastName();
		$email = $this->getEmail();
		$password = $this->getPassword();
		if (!($sentencia = $this->conn->prepare("UPDATE {$this->getTable()} SET name = ?, last_name = ?, email = ?, password = ? WHERE id = ?"))) {
			$data = false; //"Falló la preparación: (" . $this->conn->errno . ")" . $this->conn->error;

			return @$data;
		} elseif (!$sentencia->bind_param('ssssi', $name, $last_name, $email, $password, $id)) {
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

	public function edit_info_no_password() {
		$id = $this->getId();
		$name = $this->getName();
		$last_name = $this->getLastName();
		$email = $this->getEmail();
		if (!($sentencia = $this->conn->prepare("UPDATE {$this->getTable()} SET name = ?, last_name = ?, email = ? WHERE id = ?"))) {
			$data = false; //"Falló la preparación: (" . $this->conn->errno . ")" . $this->conn->error;

			return @$data;
		} elseif (!$sentencia->bind_param('sssi', $name, $last_name, $email, $id)) {
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

	

	public function delete() {
		$status = "Suspended";
		$id = $this->getId();
		if (!($sentencia = $this->conn->prepare("UPDATE {$this->getTable()} SET status = ? WHERE id = ?"))) {
			$data = false; //"Falló la preparación: (" . $this->conn->errno . ")" . $this->conn->error;
			return @$data;
		} elseif (!$sentencia->bind_param('si', $status, $id)) {
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

	public function reactivate() {
		$status = "Uncompleted";
		$id = $this->getId();
		if (!($sentencia = $this->conn->prepare("UPDATE {$this->getTable()} SET status = ? WHERE id = ?"))) {
			$data = false; //"Falló la preparación: (" . $this->conn->errno . ")" . $this->conn->error;
			return @$data;
		} elseif (!$sentencia->bind_param('si', $status, $id)) {
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

	public function cambiar_contra() {
		$password = $this->getPassword();
		$id = $this->getId();
		if (!($sentencia = $this->conn->prepare("UPDATE {$this->getTabla()} SET password = ? WHERE id = ?"))) {
			$data = false; //"Falló la preparación: (" . $this->conn->errno . ")" . $this->conn->error;
			return @$data;
		} elseif (!$sentencia->bind_param('si', $password, $id)) {
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
}