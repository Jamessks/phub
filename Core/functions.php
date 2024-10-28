<?php

use Core\Response;

function dd($value, $option = 1)
{
    echo "<pre>";
    $option ? print_r($value) : var_dump($value);
    echo "</pre>";

    die();
}

function urlIs($value)
{
    $requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    return $requestPath === $value;
}

function abort($code = 404)
{
    http_response_code($code);

    require base_path("views/{$code}.php");

    die();
}

function authorize($condition, $status = Response::FORBIDDEN)
{
    if (! $condition) {
        abort($status);
    }

    return true;
}

function base_path($path)
{
    return BASE_PATH . $path;
}

function view($path, $attributes = [])
{
    extract($attributes);

    require base_path('views/' . $path);
}

function redirect($path)
{
    header("location: {$path}");
    exit();
}

function old($key, $default = '')
{
    return Core\Session::get('old')[$key] ?? $default;
}

function getThumbnailAttributes($thumbnailUrl, $itemName)
{
    if (!empty($thumbnailUrl)) {
        $src = $_ENV['IMAGE_PATH_DIR'] . $thumbnailUrl;
        $alt = $itemName;
    } else {
        $src = $_ENV['IMAGE_PATH_DIR'] . $_ENV['DEFAULT_IMAGE'];
        $alt = 'Not-Found Image';
    }

    echo 'src="' . $src . '" alt="' . $alt . '"';
}
