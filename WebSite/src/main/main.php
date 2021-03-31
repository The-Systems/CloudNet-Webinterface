<?php

namespace cloudnet2_webinterface;

class main
{
    protected static $config;
    protected static $version;

    public function __construct($config, $version)
    {
        self::$config = json_decode($config);
        self::$version = json_decode($version);
    }

    public static function getconfig($key)
    {
        $config = self::$config;
        return $config->$key;
    }

    public static function safetyfirst($s)
    {
        return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
    }

    public static function sendRequest($message, $value = "", $extra = "")
    {
        $url = "http://" . self::getconfig("cloudnet_ip") . ":" . self::getconfig("cloudnet_port") . "/" . self::getconfig("cloudnet_api_dir") . "";
        $options = array('http' => array('method' => "GET", 'header' => "-Xcloudnet-user:" . self::getconfig("cloudnet_user") . "\r\n" . "-Xcloudnet-token:" . self::getconfig("cloudnet_token") . "\r\n" . "-Xmessage:" . $message . "\r\n" . "-Xvalue:" . $value . "\r\n" . "-Xextras:" . $extra . "\r\n"));
        $context = stream_context_create($options);
        $json = json_decode(file_get_contents($url, false, $context));

        return $json;
    }

    public static function sendRequest_amount($message, $value = "", $amount = "")
    {
        $url = "http://" . self::getconfig("cloudnet_ip") . ":" . self::getconfig("cloudnet_port") . "/" . self::getconfig("cloudnet_api_dir") . "";
        $options = array('http' => array('method' => "GET", 'header' => "-Xcloudnet-user:" . self::getconfig("cloudnet_user") . "\r\n" . "-Xcloudnet-token:" . self::getconfig("cloudnet_token") . "\r\n" . "-Xmessage:" . $message . "\r\n" . "-Xvalue:" . $value . "\r\n" . "-Xamount:" . $amount . "\r\n"));
        $context = stream_context_create($options);
        $json = json_decode(file_get_contents($url, false, $context));

        return $json;
    }

    public static function sendRequest_login($message, $value, $password)
    {
        $url = "http://" . self::getconfig("cloudnet_ip") . ":" . self::getconfig("cloudnet_port") . "/" . self::getconfig("cloudnet_api_dir") . "";
        $options = array('http' => array('method' => "GET", 'header' => "-Xcloudnet-user:" . self::getconfig("cloudnet_user") . "\r\n" . "-Xcloudnet-token:" . self::getconfig("cloudnet_token") . "\r\n" . "-Xmessage:" . $message . "\r\n" . "-Xvalue:" . $value . "\r\n-Xpassword:" . $password . "\r\n"));
        $context = stream_context_create($options);
        $json = json_decode(file_get_contents($url, false, $context));

        return $json;
    }

    public static function language_getMessage($key)
    {
        $file = dirname(__FILE__) . "/../../config/message.json";
        $json = file_get_contents($file);
        $message = json_decode($json, true);

        return $message[$key];
    }

    public static function getcurrentversion()
    {

        return self::$version->version;
    }

    public static function getversion()
    {
        $jsonlol = file_get_contents(self::$version->version_url, false);
        $json = json_decode($jsonlol);

        return $json;
    }


}