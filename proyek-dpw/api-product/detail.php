<?php 
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../config/database.php';
    include_once '../moduls/product.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $post = new Post($db);

    // Get ID
    $post->id = isset($_GET['id_akun']) ? $_GET['id_akun'] : die();

    // Get post
    $post->read_single();

    // Create array
    $post_arr = array(
        'id_akun' => $post->id_akun,
        'email' => $post->email,
        'no_telp' => $post->no_telp,
        'password' => $post->password
    );

    // Make JSON
    print_r(json_encode($post_arr));
