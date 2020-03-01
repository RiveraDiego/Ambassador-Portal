<?php
spl_autoload_register(function ($clase) {
	require_once ($clase . '.php');
});

class Article extends ConnBD {
	public $conn;
	private $id;
	private $title;
	private $content;
	private $featured_image;
	private $tags;
	private $author;
	private $user_id;
	private $published;
	private $created_date;
	private $blog;
	private $shopify_post_id;
	private $table = "articles";
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

	public function setTitle($title) {
		$this->title = $title;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setContent($content) {
		$this->content = $content;
	}

	public function getContent() {
		return $this->content;
	}

	public function setFeaturedImage($featured_image) {
		$this->featured_image = $featured_image;
	}

	public function getFeaturedImage() {
		return $this->featured_image;
	}

	public function setTags($tags) {
		$this->tags = $tags;
	}

	public function getTags() {
		return $this->tags;
	}

	public function setAuthor($author) {
		$this->author = $author;
	}

	public function getAuthor() {
		return $this->author;
	}

	public function setUserId($user_id) {
		$this->user_id = $user_id;
	}

	public function getUserId() {
		return $this->user_id;
	}

	public function setPublished($published) {
		$this->published = $published;
	}

	public function getPublished() {
		return $this->published;
	}

	public function setCreatedDate($created_date) {
		$this->created_date = $created_date;
	}

	public function getCreatedDate() {
		return $this->created_date;
	}

	public function setBlog($blog) {
		$this->blog = $blog;
	}

	public function getBlog() {
		return $this->blog;
	}

	public function setShopifyPostId($shopify_post_id) {
		$this->shopify_post_id = $shopify_post_id;
	}

	public function getShopifyPostId() {
		return $this->shopify_post_id;
	}

	public function getApiKey() {
		return $this->api_key;
	}

	public function getPassword() {
		return $this->password;
	}

	public function addPost() {
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

	public function editPost() {
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
		if (!($sentencia = $this->conn->prepare("SELECT * FROM {$this->getTable()} WHERE shopify_post_id = ?"))) {
			$data = false; //"Falló la preparación: (" . $this->conn->errno . ")" . $this->conn->error;
			return @$data;
		} else {
			$shopify_post_id = $this->getShopifyPostId();
			if (!$sentencia->bind_param('i', $shopify_post_id)) {
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

	public function listByUser($user_id){
		$resultado = $this->conn->query("select * from {$this->getTable()} LEFT JOIN users ON articles.user_id=users.id where {$this->getTable()}.user_id = {$user_id} AND users.status = 'Active';");
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

	public function deletePost() {
		$id=  $this->getShopifyPostId();
		$resultado = $this->conn->query("DELETE FROM {$this->getTable()} WHERE shopify_post_id=$id");
		if($resultado){
			return true;
		}else{
			return false;
		}
	}

	public function listArticlesForAdmin(){
		$resultado = $this->conn->query("select * from {$this->getTable()} a order by id desc");
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

	public function listShopify($data, $handle_blog){
		$api_key = $this->getApiKey();
		$password = $this->getPassword();
		$all_data = [];

		if($handle_blog == "1"){
			$handle_blog = "25032196";
		}

		foreach($data as $row){
			
			$url = "https://{$api_key}:{$password}@fogocharcoal.myshopify.com/admin/api/2019-07/blogs/{$handle_blog}/articles/{$row['shopify_post_id']}.json";
			$ch = curl_init($url);

			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
			//set the content type to application/json
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
			//return response instead of outputting
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			//execute the POST request
			$result = curl_exec($ch);

			//close cURL resource
			$response = json_decode($result,true);
			
			$all_data[] = $response['article'];

			curl_close($ch);
		}

		return $all_data;
	}

	

}