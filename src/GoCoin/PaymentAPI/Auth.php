<?php
/**
 * GoCoin Api  Auth class
 * include functions related with authentication
 *
 * @author Roman A <future.roman3@gmail.com>
 * @version 0.1.3
 *
 * @author Smith L <smith@gocoin.com>
 * @since  0.1.2
 */
namespace GoCoin\PaymentAPI;

class Auth
{

    /** @var Client $client */
    private $client;
    /**
    * constant value for required params of password authentication
    *
    * @var array
    */
    private $required_password_params = array('grant_type', 'client_id', 'client_secret', 'username', 'password', 'scope');

    /**
    * constant value for required params of code authentication
    *
    * @var array
    */
    private $required_code_params = array('grant_type', 'client_id', 'client_secret', 'code', 'redirect_uri');

    /**
    * Constructor
    *
    * @param Client $client
    */
    public function __construct(Client $client)
    {
      $this->client = $client;
    }

    /**
    * Return Authorization url to get auth_code
    *
    * @return string
    */
    public function getAuthURL()
    {
        $url = $this->client->getDashboardURL()."/auth";
        $options = array(
            'response_type' => 'code',
            'client_id' => $this->client->options['client_id'],
            'redirect_uri' => $this->client->getCurrentURL(),
            'scope' => $this->client->options['scope'],
        );
        $url = $this->client->createGetURL($url, $options);

        return $url;
    }

    /**
    * do process authorization
    *
    * @param array $options  Authorization options
    */

    public function authenticate($options)
    {
      //$required = array();
        if ($options['grant_type'] == 'password') {
            $required = $this->required_password_params;
        } elseif ($options['grant_type'] == 'authorization_code') {
            $required = $this->required_code_params;
        } else {
            $this->client->setError("Authenticate: grant_type was not defined properly");

            return false;
        }

      //$headers = $options['headers'] != null ? $options['headers'] : $this->client->default_headers;
      $body = $this->buildBody($options, $required);
      if ($body == false) {
          return false;
      }
      $config = array(
        'host' => $options['host'],
        'path' => $options['path']. "/". $options['api_version'] . "/oauth/token",
        'method' => "POST",
        'port' => $this->client->port($options['secure']),
        'headers' => null,
        'body' => $body
      );

      return $this->client->rawRequest($config);
    }

    /**
    * filter the options array according to the required options array
    *
    * @param array $options
    * @param array $required
    * @return Array result
    */

    public function buildBody($options, $required)
    {
        $result = array();
        foreach ($required as $k) {
            if (!$options[$k]) {
                $this->client->setError("Authenticate: grant_type was not defined properly");

                return false;
            }
            $result[$k] = $options[$k];
        }

        return $result;
    }
}
