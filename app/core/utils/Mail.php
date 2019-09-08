<?php

class Mail {


    private $smtp_username;
    private $smtp_password;
    private $smtp_host;
    private $smtp_port;
    private $smtp_charset;

    private $emailBody;
    private $emailTo;
    private $emailSubject;

    public function __construct() {
        $this->smtp_username = SMTP_USERNAME;
        $this->smtp_password = SMTP_PASSWORD;
        $this->smtp_host = SMTP_HOST;
        $this->smtp_port = SMTP_PORT;
        $this->smtp_charset = SMTP_CHARSET;
    }
    
    /**
    * Отправка письма
    * 
    * @param string $mailTo - получатель письма
    * @param string $subject - тема письма
    * @param string $message - тело письма
    * @param string $headers - заголовки письма
    *
    * @return bool|string В случаи отправки вернет true, иначе текст ошибки    *
    */
    private function sendEmail($mailTo, $subject, $message, $headers) {
        $contentMail = "Date: " . date("D, d M Y H:i:s") . " UT\r\n";
        $contentMail .= 'Subject: =?' . $this->smtp_charset . '?B?'  . base64_encode($subject) . "=?=\r\n";
        $contentMail .= $headers . "\r\n";
        $contentMail .= $message . "\r\n";
        
        try {
            if(!$socket = @fsockopen($this->smtp_host, $this->smtp_port, $errorNumber, $errorDescription, 30)){
                throw new Exception($errorNumber.".".$errorDescription);
            }
            if (!$this->_parseServer($socket, "220")){
                throw new Exception('Connection error 1');
            }
			
			$server_name = $_SERVER["SERVER_NAME"];
            fputs($socket, "helo $server_name\r\n");
            if (!$this->_parseServer($socket, "250")) {
                fclose($socket);
                throw new Exception('Error of command sending: HELO 2');
            }

            fputs($socket, "auth login\r\n");
            if (!$this->_parseServer($socket, "334")) {
                fclose($socket);
                throw new Exception('Autorization error 3');
            }
			

            fputs($socket, base64_encode($this->smtp_username) . "\r\n");
            if (!$this->_parseServer($socket, "334")) {
                fclose($socket);
                throw new Exception('Autorization error 4');
            }

            fputs($socket, base64_encode($this->smtp_password) . "\r\n");
            if (!$this->_parseServer($socket, "235")) {
                fclose($socket);
                throw new Exception('Autorization error 5');
            }

            fputs($socket, "mail from: <".$this->smtp_username.">\r\n");
            if (!$this->_parseServer($socket, "250")) {
                fclose($socket);
                throw new Exception('Error of command sending: MAIL FROM 6');
            }

			$mailTo = ltrim($mailTo, '<');
			$mailTo = rtrim($mailTo, '>');

            fputs($socket, "rcpt to: <".$mailTo.">\r\n");
            if (!$this->_parseServer($socket, "250")) {
                fclose($socket);
                throw new Exception('Error of command sending: RCPT TO 7');
            }

            fputs($socket, "data\r\n");
            if (!$this->_parseServer($socket, "354")) {
                fclose($socket);
                throw new Exception('Error of command sending: DATA 8');
            }

            fputs($socket, $contentMail."\r\n.\r\n");
            if (!$this->_parseServer($socket, "250")) {
                fclose($socket);
                throw new Exception("E-mail didn't sent 9");
            }
            
            fputs($socket, "quit\r\n");
            fclose($socket);
        } catch (Exception $e) {
            return  $e->getMessage();
        }
        return true;
    }
    
    private function _parseServer($socket, $response) {
        while (@substr($responseServer, 3, 1) != ' ') {
            if (!($responseServer = fgets($socket, 256))) {
                return false;
            }
        }
        if (!(substr($responseServer, 0, 3) == $response)) {
            return false;
        }
        return true;
        
    }


    private static function getEmailHeaders($from_email,$to_email) {
        $headers = 'From: ' . $from_email . PHP_EOL;
        $headers .= 'Reply-To: ' . $to_email . PHP_EOL;
        $headers .= 'X-Mailer: Webcursive PHP script' . PHP_EOL;
        $headers .= 'Content-type: text/html; charset=utf-8' . PHP_EOL;
        return $headers;
    }

    private static function cleanupEmail($email) {
        $email = Mail::encodeForForm($email);
        $email = preg_replace('=((<CR>|<LF>|0x0A/%0A|0x0D/%0D|\\n|\\r)\S).*=i', null, $email);
        return $email;
    }

    private static function cleanupMessage($message) {
        $message = wordwrap($message, 70, "\r\n");
        return $message;
    }

    private static function encodeForForm($text) {
        $text = stripslashes($text);
        return htmlentities($text, ENT_QUOTES, 'UTF-8');// need ENT_QUOTES or webpro.js jQuery.parseJSON fails
    }

    public function setBody($templatePath, $params) {
        if (($htmltemplate = file_get_contents($templatePath))==false) throw new Exception("Email template not found");
        foreach ($params as $param => $value) {
            $htmltemplate = str_replace("{{".$param."}}",Mail::encodeForForm($value),$htmltemplate);
        }
        $this->emailBody = Mail::cleanupMessage($htmltemplate);
        return $this;
    }

    public function setTo($emailTo) {
        $this->emailTo = Mail::cleanupEmail($emailTo);
        return $this;
    }

    public function setSubject($emailSubject) {
        $this->emailSubject = $emailSubject;
        return $this;
    }

    public function send() {
        $sent = $this->sendEmail($this->emailTo, $this->emailSubject, $this->emailBody, Mail::getEmailHeaders(SMTP_USERNAME,$this->emailTo));
        if(!$sent) die("Email not send");
    }

}


