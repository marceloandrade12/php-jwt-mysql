<?php

namespace App\Http;

class Rest
{
    private $request;

    private $class;
    private $method;
    private $params = array();

    public function __construct($req)
    {
        $this->request = $req;
        $this->load();
    }

    public function load()
    {
        $newUrl = explode('/', $this->request['url']);

        if (isset($newUrl[0])) {
            $this->class = ucfirst($newUrl[0]) . 'Service';
            array_shift($newUrl);


            if (isset($newUrl[0]) && strlen($newUrl[0]) > 0) {
                $this->method = $newUrl[0];
                array_shift($newUrl);

                if (isset($newUrl[0]) && strlen($newUrl[0]) > 0) {
                    $this->params = $newUrl;
                }
            }
        }
    }

    public function run()
    {

        if (class_exists('\App\Services\\' . $this->class) && method_exists('\App\Services\\' . $this->class, $this->method)) {

            try {
                $control = "\App\Services\\" . $this->class;
                $response = call_user_func_array(array(new $control, $this->method), $this->params);
                return json_encode(array('data' => $response, 'status' => 'success'));
            } catch (\Exception $e) {
                return json_encode(array('data' => $e->getMessage(), 'status' => 'error'));
            }
        } else {

            return json_encode(array('data' => 'Invalid Operation', 'status' => 'error'));
        }
    }
}
