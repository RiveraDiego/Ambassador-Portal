<?php

session_start();

spl_autoload_register(function ($clase) {
    require_once('../model/' . $clase . '.php');
});

$api_key = "690a34b93c53cb48f5205aa1ebc02605";
$password = "7346897e300d529f86a068eec5def210";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['opt'] == "new") {
        $user = new User();
        $user->setName($_POST['name']);
        $user->setLastName($_POST['last_name']);
        $user->setEmail($_POST['email']);
        $user->setPassword($_POST['password']);
        $user->setIdRol($_POST['id_rol']);
        $user->setCreatedBy($_POST['created_by']);
        $user->setCreatedDate(date("Y-m-d H:i:s"));
        $identify_by = strtolower($_POST['name']) . "" . strtolower($_POST['last_name']);
        $identify_by .= date("HisdmY");
        $user->setIdentifyBy($identify_by);


        if ($_POST['id_rol'] == 2) {
            $title = $_POST['name'] . ' ' . $_POST['last_name'];
            $result = create_profile_blog($title, $api_key, $password);
            if ($result) {
                $handle = $result['blog']['id'];
                $blog_url = $result['blog']['handle'];
                $user->setHandleBlog($handle);
                $user->setBlogUrl($blog_url);
            } else {
                header("Location: " . $_SESSION['root'] . "view/pages/users/?msg=error");
            }
            $user->setStatus($_POST['status']);
        } else if ($_POST['id_rol'] == 1) {
            $user->setStatus("Active");
        }
        if ($user->addUser()) {
            header("Location: " . $_SESSION['root'] . "view/pages/users/?msg=success");
        } else {
            header("Location: " . $_SESSION['root'] . "view/pages/users/?msg=error");
        }
    }
    if ($_POST['opt'] == "edit") {
        $user = new User();
        $user->setId($_POST['id_user']);
        $user->setName($_POST['name']);
        $user->setLastName($_POST['last_name']);
        $user->setEmail($_POST['email']);
        $user->setIdRol($_POST['id_rol']);
        $user->setStatus($_POST['status']);

        if ($user->edit()) {
            header("Location: " . $_SESSION['root'] . "view/pages/users/?msg=success_edit");
        } else {
            header("Location: " . $_SESSION['root'] . "view/pages/users/?msg=error");
        }
    }

    if ($_POST['opt'] == "edit_info") {
        $user = new User();
        $user->setId($_POST['id_user']);
        $user->setName($_POST['name']);
        $user->setLastName($_POST['last_name']);
        $user->setEmail($_POST['email']);
        if ($_POST['password'] != "") {
            $user->setPassword($_POST['password']);
            if ($user->edit_info_and_password()) {
                header("Location: " . $_SESSION['root'] . "view/pages/users/info.php?msg=success");
            } else {
                header("Location: " . $_SESSION['root'] . "view/pages/users/info.php?msg=error");
            }
        } else {
            if ($user->edit_info_no_password()) {
                header("Location: " . $_SESSION['root'] . "view/pages/users/info.php?msg=success");
            } else {
                header("Location: " . $_SESSION['root'] . "view/pages/users/info.php?msg=error");
            }
        }
    }

    if ($_POST['opt'] == "edit_other_info") {
        $user = new User();
        $user->setId($_POST['id_user']);
        $user->setExperienceTimeframe($_POST['experience_timeframe']);
        $user->setFeaturedImage($_POST['featured_image']);
        $user->setKnownAs($_POST['known_as']);
        $user->setAge($_POST['age']);
        $user->setRegion($_POST['region']);
        
        $user->setExperienceNumber($_POST['experience_number']);
        $user->setGrillOfChoice($_POST['grill_of_choice']);
        $user->setBiggestInspiration($_POST['biggest_inspiration']);
        $user->setEquipmentPreferred($_POST['equipment_preferred']);

        if ($_POST['instagram_link'] != "") {
            $user->setInstagramLink($_POST['instagram_link']);
        }

        if ($_POST['twitter_link'] != "") {
            $user->setTwitterLink($_POST['twitter_link']);
        }

        if ($_POST['facebook_link'] != "") {
            $user->setFacebookLink($_POST['facebook_link']);
        }

        if ($_POST['handle_article'] == "") {
            $content = "";
            $metafields = array(
                array(
                    "key" => "age",
                    "value" => $_POST['age'],
                    "value_type" => "integer",
                    "namespace" => "profile"
                ),
                array(
                    "key" => "known_as",
                    "value" => $_POST['known_as'],
                    "value_type" => "string",
                    "namespace" => "profile"
                ),
                array(
                    "key" => "region",
                    "value" => $_POST['region'],
                    "value_type" => "string",
                    "namespace" => "profile"
                ),
                array(
                    "key" => "experience",
                    "value" => $_POST['experience_number'] . ' ' . $_POST['experience_timeframe'],
                    "value_type" => "string",
                    "namespace" => "profile"
                ),
                array(
                    "key" => "grill_of_choice",
                    "value" => $_POST['grill_of_choice'],
                    "value_type" => "string",
                    "namespace" => "profile"
                ),
                array(
                    "key" => "biggest_inspiration",
                    "value" => $_POST['biggest_inspiration'],
                    "value_type" => "string",
                    "namespace" => "profile"
                ),
                array(
                    "key" => "equipment_preferred",
                    "value" => $_POST['equipment_preferred'],
                    "value_type" => "string",
                    "namespace" => "profile"
                ),
                array(
                    "key" => "handle_blog",
                    "value" => $_POST['blog_url'],
                    "value_type" => "string",
                    "namespace" => "profile"
                )
            );
            
            if($_POST['instagram_link'] != ""){
                $metafields[] = array(
                    "key"=>"instagram_link",
                    "value"=>$_POST['instagram_link'],
                    "value_type"=>"string",
                    "namespace"=>"profile"
                );
            }
            
            if($_POST['twitter_link'] != ""){
                $metafields[] = array(
                    "key"=>"twitter_link",
                    "value"=>$_POST['twitter_link'],
                    "value_type"=>"string",
                    "namespace"=>"profile"
                );
            }
            
            if($_POST['facebook_link'] != ""){
                $metafields[] = array(
                    "key"=>"facebook_link",
                    "value"=>$_POST['facebook_link'],
                    "value_type"=>"string",
                    "namespace"=>"profile"
                );
            }
            
            if($_POST['signature_dish_link'] != ""){
                $metafields[] = array(
                    "key" => "signature_dish_name",
                    "value" => $_POST['signature_dish_name'],
                    "value_type" => "string",
                    "namespace" => "profile"
                );
                array(
                    "key" => "signature_dish_link",
                    "value" => $_POST['signature_dish_link'],
                    "value_type" => "string",
                    "namespace" => "profile"
                );
                $user->setSignatureDishName($_POST['signature_dish_name']);
                $user->setSignatureDishlink($_POST['signature_dish_link']);
            }
            
            if ($result = post_to_ambassadors($_SESSION['user_name'], $_SESSION['user_name'], "Ambassador", $content, $_POST['featured_image'], $metafields, $api_key, $password)) {
                $results = json_decode($result, true);
                $user->setHandleArticle($results["article"]["id"]);
                $metafields_imgProfile = array(
                    array(
                        "key" => "featured_image",
                        "value" => $results['article']['image']['src'],
                        "value_type" => "string",
                        "namespace" => "profile"
                    )
                );

                //$getmetafields = get_metafields('49093541952', $results['article']['id'], $api_key, $password);
                //$json_metafields = json_decode($getmetafields, true);
                //print($json_metafields['metafields']);
                $user_info = $user->get();
                $img_setted = save_profile_image($user_info['handle_blog'], $metafields_imgProfile, $api_key, $password);

                if ($img_setted) {
                    if ($user->editExtraInfo()) {
                        $_SESSION['user_status'] = "Active";
                        header("Location: " . $_SESSION['root'] . "view/pages/users/info.php?msg=sue");
                        //print_r($pi);
                    } else {
                        header("Location: " . $_SESSION['root'] . "view/pages/users/info.php?msg=error");
                        //print_r($user);
                    }
                } else {
                    header("Location: " . $_SESSION['root'] . "view/pages/users/info.php?msg=error");
                    //print_r($img_setted);
                }
            }
        } else {
            $content = "";
            $metafields = array(
                array(
                    "key" => "age",
                    "value" => $_POST['age'],
                    "value_type" => "integer",
                    "namespace" => "profile"
                ),
                array(
                    "key" => "known_as",
                    "value" => $_POST['known_as'],
                    "value_type" => "string",
                    "namespace" => "profile"
                ),
                array(
                    "key" => "region",
                    "value" => $_POST['region'],
                    "value_type" => "string",
                    "namespace" => "profile"
                ),
                array(
                    "key" => "experience",
                    "value" => $_POST['experience_number'] . ' ' . $_POST['experience_timeframe'],
                    "value_type" => "string",
                    "namespace" => "profile"
                ),
                array(
                    "key" => "signature_dish_name",
                    "value" => $_POST['signature_dish_name'],
                    "value_type" => "string",
                    "namespace" => "profile"
                ),
                array(
                    "key" => "signature_dish_link",
                    "value" => $_POST['signature_dish_link'],
                    "value_type" => "string",
                    "namespace" => "profile"
                ),
                array(
                    "key" => "grill_of_choice",
                    "value" => $_POST['grill_of_choice'],
                    "value_type" => "string",
                    "namespace" => "profile"
                ),
                array(
                    "key" => "biggest_inspiration",
                    "value" => $_POST['biggest_inspiration'],
                    "value_type" => "string",
                    "namespace" => "profile"
                ),
                array(
                    "key" => "equipment_preferred",
                    "value" => $_POST['equipment_preferred'],
                    "value_type" => "string",
                    "namespace" => "profile"
                ),
                array(
                    "key" => "instagram_link",
                    "value" => $_POST['instagram_link'],
                    "value_type" => "string",
                    "namespace" => "profile"
                ),
                array(
                    "key" => "twitter_link",
                    "value" => $_POST['twitter_link'],
                    "value_type" => "string",
                    "namespace" => "profile"
                ),
                array(
                    "key" => "facebook_link",
                    "value" => $_POST['facebook_link'],
                    "value_type" => "string",
                    "namespace" => "profile"
                ),
                array(
                    "key" => "handle_blog",
                    "value" => $_POST['blog_url'],
                    "value_type" => "string",
                    "namespace" => "profile"
                )
            );

            if ($result = delete_post_ambassador($_POST['handle_article'], $api_key, $password)) {
                $result2 = post_to_ambassadors($_SESSION['user_name'], $_SESSION['user_name'], "Ambassador", $content, $_POST['featured_image'], $metafields, $api_key, $password);
                $new_data = json_decode($result2, true);
                $metafields = array(
                    array(
                        "key" => "featured_image",
                        "value" => $results['article']['image']['src'],
                        "value_type" => "string",
                        "namespace" => "profile"
                    )
                );
                if ($pi = save_profile_image($new_data['article'], $metafields, $api_key, $password)) {
                    
                }
                $user->setHandleArticle($new_data["article"]['id']);
                if ($user->editExtraInfo()) {
                    $_SESSION['user_status'] = "Active";
                    header("Location: " . $_SESSION['root'] . "view/pages/users/info.php?msg=sue");
                } else {
                    header("Location: " . $_SESSION['root'] . "view/pages/users/info.php?msg=error");
                }
            } else {
                echo "Error: Put to ambassadors";
            }
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['opt']) && isset($_GET['id'])) {
        if ($_GET['opt'] == "delete") {
            $user = new User();
            $user->setId($_GET['id']);
            $userdata = $user->get();
            if (delete_blog_profile($userdata["handle_blog"], $api_key, $password)) {
                if (delete_post_ambassador($userdata['handle_article'], $api_key, $password)) {
                    if ($user->delete()) {
                        header("location: " . $_SESSION['root'] . "view/pages/users/?msg=delete_success");
                    } else {
                        header("location: " . $_SESSION['root'] . "view/pages/users/?msg=error");
                    }
                } else {
                    header("location: " . $_SESSION['root'] . "view/pages/users/?msg=error");
                }
            } else {
                header("location: " . $_SESSION['root'] . "view/pages/users/?msg=error");
            }
        }

        if ($_GET['opt'] == "reactivate") {
            $user = new User();
            $user->setId($_GET['id']);
            if ($user->reactivate()) {
                header("location: " . $_SESSION['root'] . "view/pages/users/?msg=reactivated");
            } else {
                header("location: " . $_SESSION['root'] . "view/pages/users/?msg=error");
            }
        }
    } else {
        header("location: {$_SESSION['root']}view/pages/users/");
    }
}

function create_profile_blog($title, $api_key, $password) {
    $url = "https://{$api_key}:{$password}@fogocharcoal.myshopify.com/admin/api/2019-10/blogs.json";
    $ch = curl_init($url);

    $pre_data = array(
        "title" => $title,
        "commentable" => "moderate",
        "template_suffix" => "profile"
    );

    $data = json_encode(array("blog" => $pre_data));

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
        return json_decode($result, true);
    } else {
        return false;
    }

    //print_r($data);
}

function post_to_ambassadors($title, $author, $tags, $content, $featured_image, $metafields, $api_key, $password) {
    $url = "https://{$api_key}:{$password}@fogocharcoal.myshopify.com/admin/api/2019-07/blogs/49093541952/articles.json";
    $ch = curl_init($url);

    $pre_data = array(
        "title" => $title,
        "author" => $author,
        "tags" => $tags,
        "body_html" => $content,
        "metafields" => $metafields,
        "image" => array(
            "attachment" => $featured_image,
            "alt" => $title
        ),
        "published" => "true"
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

function delete_post_ambassador($article, $api_key, $password) {
    $url = "https://{$api_key}:{$password}@fogocharcoal.myshopify.com/admin/api/2019-10/blogs/49093541952/articles/{$article}.json";
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

    //set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    //return response instead of outputting
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //execute the POST request
    $result = curl_exec($ch);

    //close cURL resource
    curl_close($ch);

    /* END of article's information */

    if ($result) {
        return $result;
    } else {
        return false;
    }
    //print_r($data);
}

function save_profile_image($blog_id, $metafields, $api_key, $password) {
    $url = "https://{$api_key}:{$password}@fogocharcoal.myshopify.com/admin/api/2019-10/blogs/{$blog_id}.json";
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

    $pre_data = array(
        "id" => $blog_id,
        "metafields" => $metafields
    );

    $data = json_encode(array("blog" => $pre_data));

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

    /* END of article's information */

    if ($result) {
        return $result;
    } else {
        return false;
    }
    //print_r($data);
}

function delete_blog_profile($blog_id, $api_key, $password) {
    $url = "https://{$api_key}:{$password}@fogocharcoal.myshopify.com/admin/api/2019-10/blogs/{$blog_id}.json";
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

    //set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    //return response instead of outputting
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //execute the POST request
    $result = curl_exec($ch);

    //close cURL resource
    curl_close($ch);

    /* END of article's information */

    if ($result) {
        return $result;
    } else {
        return false;
    }
    //print_r($data);
}

function get_metafields($blog_id, $article_id, $api_key, $password) {
    $url = "https://{$api_key}:{$password}@fogocharcoal.myshopify.com/admin/blogs/{$blog_id}/articles/{$article_id}/metafields.json";
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

    //set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    //return response instead of outputting
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //execute the POST request
    $result = curl_exec($ch);

    //close cURL resource
    curl_close($ch);

    /* END of article's information */

    if ($result) {
        return $result;
    } else {
        return false;
    }
    //print_r($data);
}
