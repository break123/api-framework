<?php
/**
 * Request class.
 * 
 * @package api-framework
 * @author  Martin Bean <martin@martinbean.co.uk>
 */
class Request
{
    /**
     * The URL as a string.
     * @var string
     */
    public $url;
    
    /**
     * URL segments as an array.
     * @var array
     */
    public $segments = array();
    
    /**
     * The request method (GET, POST etc).
     * @var string
     */
    public $method;
    
    /**
     * Parameters array, depending on HTTP method used.
     * @var array
     */
    public $parameters = array();
    
    /**
     * Constructs a request object from an URL.
     *
     * @param string $url Optional; will default to current URL if none is passed
     */
    public function __construct($url = null)
    {
        if (is_null($url)) {
            $path_info = '';
            $path_info = (isset($_SERVER['PATH_INFO'])) ? $_SERVER['PATH_INFO'] : $path_info;
            $path_info = (isset($_SERVER['ORIG_PATH_INFO'])) ? $_SERVER['ORIG_PATH_INFO'] : $path_info;
            $url = $path_info;
        }
        
        $this->url = $url;
        $this->segments = explode('/', trim($this->url, '/'));
        $this->method = strtoupper($_SERVER['REQUEST_METHOD']);
        
        switch (strtolower($this->method)) {
            case 'get':
                $this->parameters = $_GET;
            break;
            case 'post':
                $this->parameters = $_POST;
            break;
            case 'put':
                parse_str(file_get_contents('php://input'), $this->parameters);
            break;
        }
    }
}