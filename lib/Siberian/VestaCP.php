<?php

/**
 * Class Siberian_VestaCP
 */

class Siberian_VestaCP {

    /**
     * @var Siberian_VestaCP_Api
     */
    protected $api;

    /**
     * @var mixed|null
     */
    public $logger = null;

    /**
     * @var array
     */
    protected $config = array(
        "host" => "",
        "username" => "",
        "password" => "",
    );

    public function __construct() {
        $this->logger = Zend_Registry::get("logger");
        if(version_compare(phpversion(), "5.6", "<")) {
            $this->logger->info("[Siberian_VestaCP] requires php 5.6+");
            throw new Exception(__("[Siberian_VestaCP] requires php 5.6+"));
        }

        $vestacp_api = Api_Model_Key::findKeysFor("vestacp");

        $this->config["host"]       = $vestacp_api->getHost();
        $this->config["username"]   = $vestacp_api->getUser();
        $this->config["password"]   = $vestacp_api->getPassword();

        $this->api = new Siberian_VestaCP_Api($this->config["host"], $this->config["username"], $this->config["password"]);
        $this->api->login();
    }

    /**
     * @param $ssl_certificate
     */
    public function updateCertificate($ssl_certificate) {
        if(version_compare(phpversion(), "5.6", "<")) {
            $this->logger->info("[Siberian_VestaCP] requires php 5.6+");
            throw new Exception(__("[Siberian_VestaCP] requires php 5.6+"));
        }

        $this->api->updateDomain($ssl_certificate);

        return true;
    }
}