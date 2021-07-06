<?php


class API
{

    /**
     * @var CurlHandle|false|resource
     */
    private $curl;

    public function __construct()
    {
        $this->curl = curl_init();
    }

    private function CALL_API(string $method,string $url,$data=false,$user_password=false)
    {
        switch ($method)
        {
            case "POST":
                curl_setopt($this->curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($this->curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        if($user_password){
            curl_setopt($this->curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($this->curl, CURLOPT_USERPWD, $user_password);
        }


        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($this->curl);

        curl_close($this->curl);

        return $result;
    }

    public function POST (string $url)
    {
        return $this->CALL_API("POST",$url);
    }

    public function POST_DATA(string $url,string $data)
    {
        return $this->CALL_API("POST",$url,$data);
    }

    public function POST_DATA_AUT(string $url,string $data,string $user,string $password)
    {
        $up="$user:$password";
        return $this->CALL_API("POST",$url,$data,$up);
    }

    public function JSON_POST_DATA_AUT(string $url,array $data,string $user,string $passord):string
    {
        $up="$user:$passord";
        $json=json_encode($data,true);
        return $this->CALL_API("POST",$url,$json,$up);
    }

    public function JSON_POST_DATA_AUT_ARRAY(string $url,array $data,string $user,string $passord):array
    {
        $up="$user:$passord";
        $json=json_encode($data,true);
        return json_decode($this->CALL_API("POST",$url,$json,$up));
    }

    public function PUT (string $url)
    {
        return $this->CALL_API("PUT",$url);
    }

    public function PUT_DATA(string $url,string $data)
    {
        return $this->CALL_API("PUT",$url,$data);
    }

    public function PUT_DATA_AUT(string $url,string $data,string $user,string $password)
    {
        $up="$user:$password";
        return $this->CALL_API("PUT",$url,$data,$up);
    }

    public function JSON_PUT_DATA_AUT(string $url,array $data,string $user,string $passord):string
    {
        $up="$user:$passord";
        $json=json_encode($data,true);
        return $this->CALL_API("PUT",$url,$json,$up);
    }

    public function JSON_PUT_DATA_AUT_ARRAY(string $url,array $data,string $user,string $passord):array
    {
        $up="$user:$passord";
        $json=json_encode($data,true);
        return json_decode($this->CALL_API("PUT",$url,$json,$up));
    }

}