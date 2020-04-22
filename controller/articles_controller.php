<?php

spl_autoload_register(function ($clase) {
    require_once('../model/' . $clase . '.php');
});

session_start();

$api_key = "690a34b93c53cb48f5205aa1ebc02605";
$password = "7346897e300d529f86a068eec5def210";
$blog_cook_id = "25032196";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['opt'] == "new") {
        // Quita la variable $_POST["blog_id"], porque cada articulo es enviado a cook,
        // ya no a cada blog de cada embajador.
        $userobj = new User();
        $userobj->setId($_SESSION['user_id']);
        $user_info = $userobj->get();
        
        $_POST['tags'] = $_POST['tags'].",".$user_info['identify_by'];
        
        $shopify_data = add_to_shopify($_POST['title'], $_POST['author'], $_POST['tags'], $_POST['content'], $_POST['featured_image'], $blog_cook_id, $api_key, $password);

        if ($shopify_data) {
            $article = new Article();
            $shopify_info = json_decode($shopify_data, true);
            $article->setTitle($shopify_info['article']['title']);
            $article->setContent($shopify_info['article']['body_html']);
            $article->setFeaturedImage($shopify_info['article']['image']['src']);
            $article->setTags($shopify_info['article']['tags']);
            $article->setAuthor($shopify_info['article']['author']);
            $article->setUserId($_SESSION['user_id']);
            $article->setPublished("false");
            $article->setCreatedDate(date("Y-m-d H:i:s"));
            $article->setBlog($shopify_info['article']['blog_id']);
            $article->setShopifyPostId($shopify_info['article']['id']);

            if ($article->addPost()) {
                header("Location: " . $_SESSION['root'] . "view/pages/articles/edit.php?id=" . $shopify_info['article']['id'] . "&msg=new");
            } else {
                header("Location: " . $_SESSION['root'] . "view/pages/articles/new.php?msg=error");
            }
        } else {
            header("Location: " . $_SESSION['root'] . "view/pages/articles/new.php?msg=error");
        }
    }

    if ($_POST['opt'] == "edit") {
        $shopify_data = update_to_shopify($_POST['title'], $_POST['author'], $_POST['tags'], $_POST['content'], $_POST['featured_image'], $_POST['shopify_post_id'], $_POST['blog_id'], '690a34b93c53cb48f5205aa1ebc02605', '7346897e300d529f86a068eec5def210');
        if ($shopify_data) {
            $article = new Article();
            $shopify_info = json_decode($shopify_data, true);
            $article->setTitle($shopify_info['article']['title']);
            $article->setContent($shopify_info['article']['body_html']);
            $article->setFeaturedImage($shopify_info['article']['image']['src']);
            $article->setTags($shopify_info['article']['tags']);
            $article->setAuthor($shopify_info['article']['author']);
            $article->setShopifyPostId($_POST['shopify_post_id']);

            if ($article->editPost()) {
                header("Location: " . $_SESSION['root'] . "view/pages/articles/edit.php?id=" . $shopify_info['article']['id'] . "&msg=success");
            } else {
                header("Location: " . $_SESSION['root'] . "view/pages/articles/edit.php?id=" . $shopify_info['article']['id'] . "&msg=error");
            }
        } else {
            header("Location: " . $_SESSION['root'] . "view/pages/articles/edit.php?id=" . $shopify_info['article']['id'] . "&msg=error");
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['opt']) && isset($_GET['post'])) {
        if ($_GET['opt'] == "delete") {
            $article = new Article();
            $article->setShopifyPostId($_GET['post']);
            $userblog = new User();
            $userblog->setId($_SESSION['user_id']);
            $userdata = $userblog->get();
            if ($article->deletePost()) {
                if (delete_post($_GET['post'], $userdata["handle_blog"], $api_key, $password)) {
                    header("location: " . $_SESSION['root'] . "?msg=delete_success");
                } else {
                    header("location: " . $_SESSION['root'] . "?msg=error");
                }
            } else {
                header("location: " . $_SESSION['root'] . "?msg=error");
            }
        } else {
            header("location: " . $_SESSION['root']);
        }
    } else {
        header("location: " . $_SESSION['root']);
    }
}

function add_to_shopify($title, $author, $tags, $content, $featured_image, $blog_cook_id, $api_key, $password) {
    $url = "https://{$api_key}:{$password}@fogocharcoal.myshopify.com/admin/api/2019-07/blogs/{$blog_cook_id}/articles.json";
    $ch = curl_init($url);

    $pre_data = array(
        "title" => $title,
        "author" => $author,
        "tags" => $tags,
        "body_html" => $content,
        "image" => array(
            "attachment" => $featured_image,
            "alt" => $title
        ),
        "published" => "false"
    );

    $data = json_encode(array("article" => $pre_data));

    curl_setopt($ch, CURLOPT_POST, 1);

    //attach encoded JSON string to the POST fields
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    //set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    //return response instead of outputting
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //execute the POST request
    $result = curl_exec($ch);

    //close cURL resource
    curl_close($ch);

    if ($result) {
        return $result;
    } else {
        return false;
    }

    //print_r($data);
}

function update_to_shopify($title, $author, $tags, $content, $featured_image, $article_id, $blog_id, $api_key, $password) {
    $url = "https://{$api_key}:{$password}@fogocharcoal.myshopify.com/admin/api/2019-07/blogs/{$blog_id}/articles/{$article_id}.json";
    $ch = curl_init($url);

    $pre_data = array(
        "id" => $article_id,
        "title" => $title,
        "author" => $author,
        "tags" => $tags,
        "body_html" => $content,
        "image" => array(
            "attachment" => $featured_image,
            "alt" => $title
        ),
        "published" => "false"
    );

    $data = json_encode(array("article" => $pre_data));

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');

    //attach encoded JSON string to the POST fields
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    //set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    //return response instead of outputting
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //execute the POST request
    $result = curl_exec($ch);

    //close cURL resource
    curl_close($ch);

    if ($result) {
        return $result;
    } else {
        return false;
    }

    //print_r($data);
}

function delete_post($article_id, $blog_id, $api_key, $password) {
    $url = "https://{$api_key}:{$password}@fogocharcoal.myshopify.com/admin/api/2019-07/blogs/{$blog_id}/articles/{$article_id}.json";
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    //set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    //return response instead of outputting
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //execute the POST request
    $result = curl_exec($ch);

    //close cURL resource
    curl_close($ch);
    return true;
}
