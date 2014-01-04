<?php
/**
 * App Class
 *
 * @author Roman A <future.roman3@gmail.com>
 * @version 0.1.2
 *
 * @author Smith L <smith@gocoin.com>
 * @since  0.1.2
 */
namespace GoCoin\PaymentAPI\API;
use GoCoin\PaymentAPI\Api;

class  Apps
{
    private $api;

    public function __construct(Api $api)
    {
        $this->api = $api;
    }
    public function create($params)
    {
        $route = '/oauth/applications';
        $options = array(
            'method' => 'POST',
            'body' => $params
        );

        return $this->api->request($route, $options);
    }

    public function createCode($params)
    {
        $route = '/oauth/authorize';
        $options = array(
            'method' => 'POST',
            'body' => $params
        );

        return $this->api->request($route, $options);
    }

    public function delete($id, $callback)
    {
        $route = "/oauth/applications/" . $id;
        $options = array(
            'method' => 'DELETE'
        );

        return $this->api->request($route, $options);
    }

    public function deleteAuthorized($id, $callback)
    {
        $route = "/oauth/authorized_applications/" . $id;
        $options = array(
            'method' => 'DELETE'
        );

        return $this->api->request($route, $options);
    }

    public function get($id, $callback)
    {
        $route = "/oauth/applications/" . $id;
        $options = array();

        return $this->api->request($route, $options);
    }

    public function alist($id, $callback)
    {
        $route = "/users/" . $id . "/applications";
        $options = array();

        return $this->api->request($route, $options);
    }

    public function listAuthorized($id, $callback)
    {
        $route = "/users/" . $id . "/authorized_applications";
        $options = array();

        return $this->api->request($route, $options);
    }

    public function update($params)
    {
        $route = "/oauth/applications/" . $params['id'];
        $options = array(
            'method' => 'PATCH',
            'body' => $params['data']
        );

        return $this->api->request($route, $options);
    }

    public function newSecret($id, $callback)
    {
        $route = "/oauth/applications/" . $id . "/request_new_secret";
        $options = array(
            'method' => 'POST'
        );

        return $this->api->request($route, $options);
    }
}
