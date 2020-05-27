<?php

class Curl {

    private $url;
    private $IP = "";
    private $postValues;
    private $randIP = false;
    private $headers = Array();
    private $auxHeaders = Array();
    private $userAgent = "";

    /**
     * getUrl
     *
     * @return void
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * setUrl
     *
     * @param  mixed $url
     *
     * @return void
     */
    public function setUrl($url) {
        $this->url = $url;
        return $this;
    }

    /**
     * getPostValues
     *
     * @return void
     */
    public function getPostValues() {
        return $this->postValues;
    }
    
    /**
     * setPostValues
     *
     * @param  mixed $postValues
     *
     * @return void
     */
    public function setPostValues($postValues) {
        $this->postValues = $postValues;
        return $this;
    }
    
    /**
     * setRandIP
     * 
     * "RAND" = Random ou "0.0.0.0" = IP Request 
     *
     * @return void
     */
    public function setIP($IP = "RAND") {
        if($IP) {
            if($IP == "RAND") {
                $this->randIP = true;
            } else {
                $this->randIP = false;
                $this->IP = $IP;
            }
        } else {
            $this->IP = "";
        }
    }

    /**
     * set randIP
     *
     * @return void
     */
    private function randIP() {
        $this->IP = mt_rand(0,255) . "." . mt_rand(0,255) . "." . mt_rand(0,255) . "." . mt_rand(0,255);
    }

    /**
     * set setUserAgent
     *
     * @return void
     */
    public function setUserAgent($agent) {
        $this->userAgent = $agent;
    }

    /**
     * postData
     *
     * @return void
     */
    private function postData() {
        $postData = "";
        if ($this->postValues) {
            if (is_array($this->postValues)) {
                foreach ($this->postValues as $key => $value) {
                    $postData .= $key . "=" . $value . "&";
                }
                $postData = substr($postData, 0, -1);
            }
        }
        return $postData;
    }

    /**
     * empyHeaders function
     *
     * @return void
     */
    private function empyHeaders() {
        $this->headers = Array();
    }

    public function setHeaders($headers) {
        $this->auxHeaders = $headers;
    }

    /**
     * getContent
     *
     * @return void
     */
    public function getContent() {
        $ch = curl_init();
        
        // Habilita o envio de CURL local
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        
        curl_setopt($ch, CURLOPT_URL, $this->getUrl());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 3);

        $this->empyHeaders();

        if($this->auxHeaders) {
            foreach($this->auxHeaders as $value) {
                $this->headers[] = $value;
            }
        }

        // Seto o IP requisitante como random
        if($this->randIP) {
            $this->randIP();
        }

        if($this->randIP || $this->IP) {
            $this->headers[] = 'X-Forwarded-For: ' . $this->IP;
        }
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        
        $postData = $this->postData();
        if ($postData) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        }

        if($this->userAgent != "") {
            curl_setopt($ch,CURLOPT_USERAGENT, $this->userAgent);
        }
        
        $responseHtml = curl_exec($ch);
        curl_close($ch);
        return $responseHtml;
    }
}
