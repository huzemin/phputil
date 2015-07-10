<?php
/**
 * CURL使用操作的辅助类
 * @author huzemin8@126.com
 * @date 2015-7-10
 */
class CurlHelper {

    var $ch;

    var $content;

    var $is_returntransfer = false;

    public function __construct($options = null) {
        $this->ch = curl_init();
        $this->setCurlOptions($options);
    }

    /**
     * 设置批量设置CURL
     */
    public function setCurlOptions($curl_options) {
        if(is_array($curl_options)) {
            if(is_array($curl_options)) {
                foreach($curl_options as $key => $val) {
                    if(preg_match('#^CURLOPT_#', $key)) {
                        if($key == 'CURLOPT_RETURNTRANSFER') {
                            $this->is_returntransfer = $val = boolval($val);
                        }
                        curl_setopt($this->ch, $key, $val);
                    }
                }
            }
        }
    }

    // CURL的执行访问的URL
    public function setUrl($url) {
        curl_setopt($this->ch, CURLOPT_URL, $url);
    }

    // 快捷CURL设置方法
    public function setHeader($has_header) {
        curl_setopt($this->ch, CURLOPT_HEADER, boolval($has_header));
    }

    public function setReturnTransfer($is_rt) {
        $this->is_returntransfer = boolval($is_rt);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, $this->is_returntransfer);
    }

    // CURL执行的过期时间
    public function setTimeOut($seconds) {
        curl_setopt($this->ch, CURLOPT_TIMEOUT, $seconds);
    }

    public function setCookie($cookie_string) {
        curl_setopt($this->ch, CURLOPT_COOKIE, $cookie_string);
    }

    public function setCookieJar($filename, $create = true) {
        if(!file_exists($filename)) {
            if($create) {
                $f = @fopen($filename, 'w+');
                fclose($f);
            }
        }
        $filename = realpath($filename);
        curl_setopt($this->ch, CURLOPT_COOKIEJAR, $filename);
        return $filename;
    }

    public function setCookieFile($filename) {
        if(file_exists($filename)) {
            curl_setopt($this->ch, CURLOPT_COOKIEFILE, $filename);
        }
    }

    public function setHttpHeader($header) {
        if(isset($header)){
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, $header);
        }
    }

    public function setPostFields($fields) {
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $fields)
    }

    // CURL执行
    public function exec() {
        if( !$this->is_returntransfer)
            ob_start();
            curl_exec($this->ch);
            $this->content = ob_get_contents();
            ob_end_clean()
        } else {
            $this->content = curl_exec($this->ch);
        }
        return $this->content;
    }

    // 获取CURL返回的头部信息
    public function getheader() {
        if(!isset($this->content)) {
            $this->exec();
        }
        $header_size = curl_getinfo($this->ch,CURLINFO_HEADER_SIZE);
        $header = substr($this->content, 0, $header_size);
        return $header;
    }

    // 获取CURL返回的内容主体
    public function getBody() {
        if(!isset($this->content)) {
            $this->exec();
        }
        $header_size = curl_getinfo($this->ch,CURLINFO_HEADER_SIZE);
        $body = substr($this->content, $header_size);
        return $body;
    }

    // 获取CURL返回的完整信息
    public function getCurlInfo() {
        if(!isset($this->content)) {
            $this->exec();
        }
        return curl_getinfo($this->ch);
    }

    // 获取CURL返回的HTTP 状态码
    public function getHeaderStatus() {
        if(!isset($this->content)) {
            $this->exec();
        }
        return curl_info($this->ch, CURLINFO_HTTP_CODE);
    }

    // 返回CURL执行后的全部信息，包括头部和内容主体
    public function getContent() {
        if(!isset($this->content)) {
            $this->exec();
        }
        return $this->content;
    }
}
