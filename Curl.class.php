<?php

class Curl {

    private $url;
    private $postValues;

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

    public function setPostValues($postValues) {
        $this->postValues = $postValues;
        return $this;
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
     * getContent
     *
     * @return void
     */
    public function getContent() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->getUrl());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
        $postData = $this->postData();
        if ($postData) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        }
        $responseHtml = curl_exec($ch);
        curl_close($ch);
        return $responseHtml;
    }
}
