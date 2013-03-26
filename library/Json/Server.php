<?php
/**
 * Final class for json server
 * @author Sebastian Widelak
 * @class Json_Server
 *
 */

require_once('Zend/Json/Server.php');
require_once('Json/Server/Request/Http.php');
require_once('Json/Server/Response/Http.php');
final class Json_Server extends Zend_Json_Server
{

    /**
     * Request object
     * @var Json_Server_Request_Http
     */
    protected $_request;
    /**
     * @var
     */
    protected $_json;
    /**
     * @var array|mixed
     */
    protected $_requests;
    /**
     * @var array
     */
    protected $_responses = array();

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $json = file_get_contents('php://input');

        if ($json) {
            $decode = json_decode($json);
            $this->_requests = is_array($decode) ? $decode : array($decode);
            $json = json_encode(current(array_splice($this->_requests, 0, 1)));
        }
        // Handle request
        $this->setJson($json);
    }

    /**
     *
     * @param array $argv
     */
    public function getApiMap($argv = false)
    {
        $objDir = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(APPLICATION_PATH . DIRECTORY_SEPARATOR . 'api' . DIRECTORY_SEPARATOR), true);
        foreach ($objDir as $objFile) {
            if (
                is_file((string)$objFile) && preg_match('/(.*)\.php/',(string)$objFile)
            ) {

                $name = explode("api" . DIRECTORY_SEPARATOR, $objFile);
                $name = explode(DIRECTORY_SEPARATOR, $name[1]);
                foreach($name as $i => $part){
                    if(!$part){
                        unset($name[$i]);
                    }
                }
                $name[1] = substr(ucfirst($name[1]), strpos(".", $name[1]), -4);
                //include only once those files
                include_once (string)$objFile;
                try {
                    $reflection = Zend_Server_Reflection::reflectClass(join("_", $name), $argv, join(".", $name));
                } catch (Exception $e) {
                    echo $e->getTraceAsString();
                }
                foreach ($reflection->getMethods() as $method) {
                    $definition = $this->_buildSignature($method, join("_", $name));
                    $this->_addMethodServiceMap($definition);
                }
            }
        }
    }

    /**
     * Get JSON-RPC request object
     *
     * @return Zend_Json_Server_Request
     */
    public function getRequest()
    {

        if (null === ($request = $this->_request)) {
            $this->setRequest(new Json_Server_Request_Http($this->getJson()));
        }
        return $this->_request;
    }

    /**
     * Get response object
     *
     * @return Zend_Json_Server_Response
     */
    public function getResponse()
    {
        if (null === ($response = $this->_response)) {
            require_once 'Zend/Json/Server/Response/Http.php';
            $this->setResponse(new Json_Server_Response_Http());
        }
        return $this->_response;
    }

    /**
     * @return mixed
     */
    public function getJson()
    {
        return $this->_json;
    }

    /**
     * @param $json
     * @return Json_Server
     */
    public function setJson($json)
    {
        $this->_json = $json;
        $this->_request = NULL;
        return $this;
    }

    /**
     * @param bool $request
     * @return null|string|Zend_Json_Server_Response
     * @throws Exception
     */
    public function handle($request = false)
    {
        if ((false !== $request) && (!$request instanceof Zend_Json_Server_Request)) {
            require_once 'Zend/Json/Server/Exception.php';
            throw new Exception('Invalid request type provided; cannot handle');
        } elseif ($request) {
            $this->setRequest($request);
        }
            while (true) {
                if ($this->getRequest()->getMethod()) {
                    $include = explode(".", $this->getRequest()->getMethod());

                    include_once realpath(
                        APPLICATION_PATH .
                            DIRECTORY_SEPARATOR .
                            'api' . DIRECTORY_SEPARATOR .
                            $include[0] . DIRECTORY_SEPARATOR .
                            $include[1] . '.php'
                    );

                    $this->setClass($include[0] . '_' . $include[1], $include[0] . '.' . $include[1]);
                    $modeLoader = new Zend_Application_Module_Autoloader(array(
                        'namespace' => ucfirst($include[0]),
                        'basePath' => APPLICATION_PATH . DIRECTORY_SEPARATOR . 'api' . DIRECTORY_SEPARATOR . $include[0]
                    ));
                }
                $this->_handle();
                // Get response
                $response = $this->_getReadyResponse();
                array_push($this->_responses, $response->toJson());
                if (empty($this->_requests))
                    break;
                $json = json_encode(current(array_splice($this->_requests, 0, 1)));
                // Handle request
                $this->setJson($json);
            }

            // Emit response
            if ($this->autoEmitResponse()) {
                if (count($this->_responses) > 1) {
                    $response = '[' . implode(",", $this->_responses) . ']';
                }
                echo $response;
                return;
            }

            // or return it
            return $response;

    }

}
