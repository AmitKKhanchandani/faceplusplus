<?php namespace Amitk\Faceplusplus;

class Facepp {
    
    public $server          = 'https://api-us.faceplusplus.com/facepp/v3';
    
    private $api_key        = '';        // set your API KEY or set the key static in the property
    private $api_secret     = '';        // set your API SECRET or set the secret static in the property
    
    /**
     * constructor
     *
     * @param string $appId
     * @param string $appSecret
     */
    public function __construct($api_key, $api_secret) {
        $api_key = trim(strval($api_key));
        $api_secret = trim(strval($api_secret));
        if (($api_key == '') || ($api_secret == '')) {
            throw new Exception('API properties are not set');
        }
        $this->api_key = $api_key;
        $this->api_secret = $api_secret;
    }
    
    /**
     * Face++
     *
     * @param string $method - The Face++ API
     * @param string array $params - Request Parameters
     *
     * @return array - {'http_code':'Http Status Code', 'request_url':'Http Request URL','body':' JSON Response'}
     */
    public function execute($method, array $params) {
        $params['api_key']      = $this->api_key;
        $params['api_secret']   = $this->api_secret;
        return $this->request("{$this->server}{$method}", $params);
    }
    
    private function request($request_url, $request_body) {
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $request_url);
        curl_setopt($curl_handle, CURLOPT_FILETIME, true);
        curl_setopt($curl_handle, CURLOPT_FRESH_CONNECT, false);
        if(version_compare(phpversion(),"5.5","<=")){
            curl_setopt($curl_handle, CURLOPT_CLOSEPOLICY,CURLCLOSEPOLICY_LEAST_RECENTLY_USED);
        }
        curl_setopt($curl_handle, CURLOPT_MAXREDIRS, 5);
        curl_setopt($curl_handle, CURLOPT_HEADER, false);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_TIMEOUT, 5184000);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($curl_handle, CURLOPT_NOSIGNAL, true);
        curl_setopt($curl_handle, CURLOPT_REFERER, $request_url);
        
        if (extension_loaded('zlib')) {
            curl_setopt($curl_handle, CURLOPT_ENCODING, '');
        }
        curl_setopt($curl_handle, CURLOPT_POST, true);
        if (array_key_exists('img', $request_body)) {
            $request_body['img'] = '@' . $request_body['img'];
        } else {
            $request_body = http_build_query($request_body);
        }
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $request_body);
        $response_text      = curl_exec($curl_handle);
        $response_header    = curl_getinfo($curl_handle);
        curl_close($curl_handle);
        return array (
            'http_code'     => $response_header['http_code'],
            'request_url'   => $request_url,
            'body'          => $response_text
        );
    }
    
}