<?php
/**
 * 通过自定义文件保存session
 *
 * @author huzemin
 * @email  huzemin8@126.com
 */
 
/**
 * Session 异常类
 * Class SessionException
 */
class SessionException extends Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

}


/**
 * 通过文件保存session操作类
 * Class FileSession
 */
class FileSession implements SessionHandlerInterface
{
    private $savePath;
    private $session_file_parts;
    public function open($save_path, $session_id)
    {
        // 创建session保存目录
        $this->savePath = realpath($save_path);
        if(!is_dir($save_path)) {
            if(!@mkdir($save_path, 0777)) {
                throw new SessionException('Session save path is unable to create!');
            }
        }
        $this->session_file_parts = "{$this->savePath}".DIRECTORY_SEPARATOR."sess_";
        return true;
    }

    public function read($session_id)
    {
        return (string)@file_get_contents($this->session_file_parts.$session_id);
    }

    public function write($session_id, $session_data)
    {
        $fh = @fopen($this->session_file_parts.$session_id, 'w');
        if($fh) {
            fwrite($fh, $session_data);
            fclose($fh);
            return true;
        }
        return false;
    }

    public function close()
    {
        return true;
    }

    public function destroy($session_id)
    {
        if (file_exists($this->session_file_parts.$session_id)) {
            unlink($this->session_file_parts.$session_id);
        }
        return true;
    }

    public function gc($maxlifetime)
    {
        // 使用glob匹配session保存文件夹中所有的session文件，通过判断修改时间判断是否过期
        foreach (glob("$this->savePath/sess_*") as $file) {
            if (filemtime($file) + $maxlifetime < time() && file_exists($file)) {
                unlink($file);
            }
        }
        return true;
    }
}

/*-----------------------------使用方法-------------------------
require_once 'FileSession.php';
$fileSession = new FileSession();
session_set_save_handler($fileSession, true); // 设置自定义session操作方式
session_save_path("./secret");  // 设定自己的session保存目录路径
session_start(); // 启动session

*-----------------------------使用方法-------------------------*/
