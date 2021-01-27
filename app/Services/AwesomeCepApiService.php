<?php

namespace App\Services;

use App\Traits\HttpClientTrait;
use App\Utils\MasksUtil;

class AwesomeCepApiService {

    use HttpClientTrait;

    private $baseUrl;

    function __construct()
    {
        $this->baseUrl = config('services.awesome_api_cep.base_url');
    }

    public function fetchZipCodeData($zipCode){
        $zipCode = MasksUtil::unmask($zipCode);
        $url = "$this->baseUrl/{$zipCode}";
        $data = $this->jsonRequest('GET', $url);
        return $data;
    }
}
