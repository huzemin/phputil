MailHelper Class
================

这个类主要是对`PHPMailer`的操作进行封装成类。

1. `mailconfig.php` 是邮件的配置文件
2. 该辅助类支出邮件模版设置

    ```php
        // 邮件模版存放位置
        define('EMAIL_TEMPLATE_PATH', dirname(__FILE__) . '/../views/email/');
    ```
3. 具体的使用方式例子:
    
    ```php
        $mailer = new Mailer();
        $mailer->addAddress($email, $username);

        $mailer->setSubject("邮箱标题");
        $params = array('url' => $url, 'name' => $username);
        $mailer->setTemplate('template_file.tpl', $params);
        if($mailer->send()) {
            echo '发送成功！';
        } else {
            echo '发送失败';
        }
    ```
    
    模版文件`template_file.tpl`:

    ```php
        你好, <?php echo $name ?>:
            你访问的链接为 ：<?php echo $url ?>
    ```