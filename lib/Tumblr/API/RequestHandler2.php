<?php

namespace Tumblr\API;

use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Token\AccessToken as AccessToken;

/**
 * A request handler for Tumblr authentication
 * and requests
 */
class RequestHandler2
{

    private $token;
    private $baseUrl;

    /**
     * Instantiate a new RequestHandler
     */
    public function __construct()
    {
        $this->baseUrl = 'https://api.tumblr.com/';
        $this->version = '0.1.2';

        $this->client = new \GuzzleHttp\Client(array(
            'allow_redirects' => false,
        ));

        // options were required
        $options = [
            'urlAuthorize' => '',
            'urlAccessToken' => '',
            'urlResourceOwnerDetails' => '',
        ];
        $this->provider = new GenericProvider($options);
    }

    /**
     * Set the token for this request handler
     *
     * @param string $token  the oauth token
     * @param string $secret the oauth secret
     */
    public function setToken($options)
    {
        $this->token = new AccessToken($options);
    }

    /**
     * Set the base url for this request handler.
     *
     * @param string $url The base url (e.g. https://api.tumblr.com)
     */
    public function setBaseUrl($url)
    {
        // Ensure we have a trailing slash since it is expected in {@link request}.
        if (substr($url, -1) !== '/') {
            $url .= '/';
        }

        $this->baseUrl = $url;
    }

    /**
     * Make a request with this request handler
     *
     * @param string $method  one of GET, POST
     * @param string $path    the path to hit
     * @param array  $options the array of params
     *
     * @return \stdClass response object
     */
    public function request($method, $path, $options)
    {
        // Ensure we have options
        $options = $options ?: array();

        // Take off the data param, we'll add it back after signing
        $file = isset($options['data']) ? $options['data'] : false;
        unset($options['data']);

        // Get the oauth signature to put in the request header
        $url = $this->baseUrl . $path;

        // Set up the request and get the response
        $uri = new \GuzzleHttp\Psr7\Uri($url);
        $authorization_header = "Bearer " . $this->token->getToken();
        $guzzleOptions = [
            'headers' => [
                'Authorization' => $authorization_header,
                'User-Agent' => 'tumblr.php/' . $this->version,
            ],
            // Swallow exceptions since \Tumblr\API\Client will handle them
            'http_errors' => false,
        ];
        if ($method === 'GET') {
            $uri = $uri->withQuery(http_build_query($options));
        } elseif ($method === 'POST') {
            if (!$file) {
                $guzzleOptions['form_params'] = $options;
            } else {
                // Add the files back now that we have the signature without them
                $form = [];
                foreach ($options as $name => $contents) {
                    $form[] = [
                        'name'      => $name,
                        'contents'  => $contents,
                    ];
                }
                foreach ((array) $file as $idx => $path) {
                    $form[] = [
                        'name'      => "data[$idx]",
                        'contents'  => file_get_contents($path),
                        'filename'  => pathinfo($path, PATHINFO_FILENAME),
                    ];
                }
                $guzzleOptions['multipart'] = $form;
            }
        }
        $response = $this->client->request($method, $uri, $guzzleOptions);

        // Construct the object that the Client expects to see, and return it
        $obj = new \stdClass;
        $obj->status = $response->getStatusCode();
        // Turn the stream into a string
        $obj->body = $response->getBody()->__toString();
        $obj->headers = $response->getHeaders();

        return $obj;
    }

}
