<?php
spl_autoload_register(function ($clase) {
	require_once ($clase . '.php');
});

class Usersmetafields extends ConnBD {
	public $conn;
	private $id;
	private $metafield_id;
	private $namespace;
	private $metafield_key;
	private $value;
	private $value_type;
	private $created_at;
	private $owner_resource;
	private $user_id;
	private $table = "users_metafields";
	private $api_key = "690a34b93c53cb48f5205aa1ebc02605";
	private $password = "7346897e300d529f86a068eec5def210";

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

	public function seMetafieldtId($metafield_id) {
		$this->metafield_id = $metafield_id;
	}

	public function getMetafieldId() {
		return $this->metafield_id;
	}

	public function setNamespace($namespace) {
		$this->namespace = $namespace;
	}

	public function getNamespace() {
		return $this->namespace;
	}

	public function setMetafieldKey($metafield_key) {
		$this->metafield_key = $metafield_key;
	}

	public function getMetafieldKey() {
		return $this->metafield_key;
	}

	public function setValue($value) {
		$this->value = $value;
	}

	public function getValue() {
		return $this->value;
	}

	public function setValueType($value_type) {
		$this->value_type = $value_type;
	}

	public function getValueType() {
		return $this->value_type;
	}

	public function setCreatedAt($created_at) {
		$this->created_at = $created_at;
	}

	public function getCreatedAt() {
		return $this->created_at;
	}

	public function setOwnerResource($owner_resource) {
		$this->owner_resource = $owner_resource;
	}

	public function getOwnerResource() {
		return $this->owner_resource;
	}

	public function setUserId($user_id) {
		$this->user_id = $user_id;
	}

	public function getUserId() {
		return $this->user_id;
	}
	
	public function getApiKey() {
		return $this->api_key;
	}

	public function getPassword() {
		return $this->password;
	}

	public function add() {
		/* It doesn't have been made it yet */
		$data = null;
		if (!($pquery = $this->conn->prepare("INSERT INTO {$this->getTable()}(title, content, featured_image, tags, author, user_id, published, created_date, blog, shopify_post_id) VALUES (?,?,?,?,?,?,?,?,?,?)"))) {
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
		$title = $this->getTitle();
		$content = $this->getContent();
		$featured_image = $this->getFeaturedImage();
		$tags = $this->getTags();
		$author = $this->getAuthor();
		$user_id = $this->getUserId();
		$published = $this->getPublished();
		$created_date = $this->getCreatedDate();
		$blog = $this->getBlog();
		$shopify_post_id = $this->getShopifyPostId();

		if (!$pquery->bind_param("sssssissii", $title, $content, $featured_image, $tags, $author, $user_id, $published, $created_date, $blog, $shopify_post_id)) {
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

	public function edit() {
		/* It doesn't have been made it yet */
		$title = $this->getTitle();
		$content = $this->getContent();
		$featured_image = $this->getFeaturedImage();
		$tags = $this->getTags();
		$author = $this->getAuthor();
		$shopify_post_id = $this->getShopifyPostId();

		if (!($sentencia = $this->conn->prepare("UPDATE {$this->getTable()} SET title = ?, content = ?, featured_image = ?, tags = ?, author = ? WHERE shopify_post_id = ?"))) {
			$data = false; //"Falló la preparación: (" . $this->conn->errno . ")" . $this->conn->error;

			return @$data;
		} elseif (!$sentencia->bind_param('sssssi', $title, $content, $featured_image, $tags, $author, $shopify_post_id)) {
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

	public function delete() {
		$id = $this->getId();
		$resultado = $this->conn->query("DELETE FROM {$this->getTable()} WHERE id = $id");
		if($resultado){
			return true;
		}else{
			return false;
		}
	}	

}