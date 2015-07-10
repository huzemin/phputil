<?php
// 邮箱配置
define('EMAIL_HOST', '');

define('EMAIL_PORT', 25);

define('EMAIL_USER', '');

define('EMAIL_PSWD', '');

define('EMAIL_FROM', EMAIL_USER);

define('EMAIL_FROMNAME','');

define('EMAIL_CHARSET', 'utf-8');

define('IS_STMP', true);

define('EMAIL_SMTPAUTH', true);

define('ISHTML',true);

define('SMTPSECURE', false);

// 邮件模版存放位置
define('EMAIL_TEMPLATE_PATH', dirname(__FILE__) . '/../views/email/');
