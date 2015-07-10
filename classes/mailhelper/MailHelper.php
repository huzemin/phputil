<?php

require LIB_DIR."phpmailer/PHPMailerAutoload.php";
/**
 * 对PHPMailer进行类封装，简化后期邮件发送的代码操作
 */
class MailHelper {
    var $phpmailer;

    var $template_path;

    var $mail_body;

    public function __construct() {
        $this->phpmailer = new PHPMailer();
        $this->phpmailer->isSMTP();
        $this->phpmailer->Host = EMAIL_HOST;
        $this->phpmailer->SMTPAuth = EMAIL_SMTPAUTH;
        $this->phpmailer->Username = EMAIL_USER;
        $this->phpmailer->Password = EMAIL_PSWD;
        $this->phpmailer->SMTPSecure = SMTPSECURE;
        $this->phpmailer->Port = EMAIL_PORT;
        $this->phpmailer->isHTML(ISHTML);
        /*$this->phpmailer->SMTPDebug = 3;*/
        $this->template_path = EMAIL_TEMPLATE_PATH;
        $this->phpmailer->CharSet = EMAIL_CHARSET;
        $this->setFrom(EMAIL_FROM);
        $this->setFromName(EMAIL_FROMNAME);
    }

    public function getPHPMailer() {
        return $this->phpmailer;
    }

    public function setFrom($from) {
        $this->phpmailer->From = $from;
    }

    public function setFromName($fromName) {
        $this->phpmailer->FromName = $fromName;
    }

    public function addAddress($address, $name = null) {
        if (is_array($address)) {
            foreach ($address as $name => $addr) {
                $this->phpmailer->addAddress($addr, $name);
            }
        } else {
            $this->phpmailer->addAddress($address, $name);
        }
    }

    public function setSubject($subject) {
        $this->phpmailer->Subject = $subject;
    }

    public function setAltBody($altBody) {
        $this->phpmailer->AltBody = $altBody;
    }

    public function setTemplate($file, Array $data = null) {
        if (isset($file)) {
            if (is_array($data)) {
                extract($data);
            }

            $path = $this->template_path . $file;

            ob_start();
            require $path;
            $template = ob_get_contents();
            ob_end_clean();

            $this->phpmailer->Body = $template;
        }
    }

    public function send() {
        if (!$this->phpmailer->send()) {
            return false;
        } else {
            return true;
        }
    }
}
