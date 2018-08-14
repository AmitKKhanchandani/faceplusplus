# Face++
Uses Face++ v3 US Server.

## Installation
```
composer require amitkkhanchandani/faceplusplus:dev-master
```


## Examples:

#### Namespace

```
use Amitk\Faceplusplus\Facepp;
```

### Get Face Token

```php
$api_key = env('FACEPP_API_KEY',null);
$api_secret = env('FACEPP_API_SECRET',null);
$facepp = new Facepp($api_key, $api_secret);
$params = array(
    'image_url'    =>   '<--Image Absolute URL-->'
);
$response = $facepp->execute('/detect',$params);

$response = json_decode(json_encode($response));
if($response->http_code == 200){
    $data = json_decode($response->body);
    //Token Data is in the $data variable
}
else{
    //Handle if response is not 200.
}
```


### Face Compare

```php
$api_key = env('FACEPP_API_KEY',null);
$api_secret = env('FACEPP_API_SECRET',null);
$facepp = new Facepp($api_key, $api_secret);
$params = array(
    'face_token1'   =>  '<Face Token 1>',
    'face_token2'   =>  '<Face Token 2>'
);
$response = $facepp->execute('/compare',$params);

$response = json_decode(json_encode($response));
if($response->http_code == 200){
    $data = json_decode($response->body);
    /** Data Available
     *  confidence
        request_id
        time_used
        thresholds  */
    $confidence = $data->confidence;
    // Handle Confidence Level.
    return $confidence;
}
else{
    //Handle if response is not 200.
}
```

[More APIS Details on Face++ Doc Center](https://console.faceplusplus.com/documents/5679127)


### Copyright and License

Copyright (c) 2018, Amit K Khanchandani and Contributors. All Rights Reserved.

This project is licenced under the [MIT License](LICENSE.txt).