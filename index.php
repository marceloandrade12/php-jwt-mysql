<?php
header('Content-Type: application/json');

require_once './vendor/autoload.php';

// api/users/1
if (isset($_GET['url'])) {
    $url = explode('/', $_GET['url']);

    if ($url[0] === 'api') {
        array_shift($url);

        $service = '\\App\Services\\' . ucfirst($url[0]) . 'Service';
        array_shift($url);

        $method = strtolower($_SERVER['REQUEST_METHOD']);

        try {
            if (method_exists($service, $method)) {
                $response = call_user_func_array(array(new $service, $method), $url);
            } else {
                throw new \Exception("METHOD_NOT_FOUND");
            }

            http_response_code(200);
            echo json_encode(array('status' => 'success', 'data' => $response));
            exit;
        } catch (\Exception $e) {
            http_response_code(200);
            echo json_encode(array('status' => 'error', 'data' => $e->getMessage()), JSON_UNESCAPED_UNICODE);
            exit;
        }
    }
} else {
    header("HTTP/1.1 404 Not Found");
    exit();
}
