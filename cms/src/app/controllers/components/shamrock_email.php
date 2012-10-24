<?php  
	class shamrockEmailComponent
	{ 
		var $from = null;
		var $fromName = null;
		var $mailer = 'sendmail';

		var $text_body = null;
		var $html_body = null;
		var $to = null;
		var $toName = null;
		var $subject = null;
		var $template = null;
		var $templateName = 'default';
		var $files = array();
		var $strings = array();
		var $settings = array();


		function initialize(&$controller, $config = array())
		{
			// Set some initial variables
			$this->from = Configure::read('Application.email.from');
			$this->fromName = Configure::read('Application.email.name');
			$this->template = 'email'. DS;

			$this->settings = array_merge($this->settings, $config);
			$this->controller = &$controller; 
		} 

		function isEmail($email)
		{
			if(!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) { return 0; }
			$email_array = explode("@", $email);
			$local_array = explode(".", $email_array[0]);
			for($index = 0; $index < sizeof($local_array); $index += 1)
			{
				if(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$index])) { return 0; }
			}
			if(!ereg("^\[?[0-9\.]+\]?$", $email_array[1]))
			{
				$domain_array = explode(".", $email_array[1]);
				if(sizeof($domain_array) < 2) { return 0; }
				for($index = 0; $index < sizeof($domain_array); $index += 1)
				{
					if(!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$index])) { return 0; }
				}
			}
			return 1;
		}

		/** 
		* This is the body in plain text for non-HTML mail clients 
		*/
		function bodyText()
		{
			$temp_layout = $this->controller->layout;
			$mail = $this->controller->render('mail', 'email'. DS .'default', $this->template . $this->templateName .'_text');
			$this->controller->layout = $temp_layout;
			$this->controller->output = '';
			return $mail; 
		} 

		/** 
		* This is HTML body text for HTML-enabled mail clients 
		*/
		function bodyHTML()
		{
			$temp_layout = $this->controller->layout;
			$mail = $this->controller->render('mail', 'email'. DS .'default', $this->template . $this->templateName .'_html'); 
			$this->controller->layout = $temp_layout; 
			$this->controller->output = ''; 
			return $mail; 
		} 

		function attachFile($filename, $name = '', $encoding = 'base64', $type = 'application/octet-stream')
		{
			$count = count($this->files); 
			$this->files[$count + 1]['filename'] = $filename; 
			$this->files[$count + 1]['name'] = $name; 
			$this->files[$count + 1]['encoding'] = $encoding; 
			$this->files[$count + 1]['type'] = $type;
		} 

		function attachString($string, $name, $encoding = 'base64', $type = 'application/octet-stream')
		{
			$count = count($this->strings); 
			$this->strings[$count + 1]['string'] = $string; 
			$this->strings[$count + 1]['name'] = $name; 
			$this->strings[$count + 1]['encoding'] = $encoding; 
			$this->strings[$count + 1]['type'] = $type; 
		} 

		function send() 
		{
			App::import('Vendor', 'PHPMailer', array('file'=>'phpmailer'. DS .'class.phpmailer.php'));
		
			$mail = new PHPMailer();

			$mail->From = $this->from;
			$mail->FromName = $this->fromName;
			$mail->AddAddress($this->to, $this->toName);
			$mail->AddReplyTo($this->from, $this->fromName);

			$mail->CharSet = strtolower(Configure::read('App.encoding'));
			$mail->WordWrap = 80;
		
			if(!empty($this->files))
			{
				foreach($this->files as $attachment)
				{
					$mail->AddAttachment($attachment['filename'], $attachment['name'], $attachment['encoding'], $attachment['type']);
				}
			} 

			if(!empty($this->strings))
			{
				foreach($this->strings as $attachment)
				{
					$mail->AddStringAttachment($attachment['string'], $attachment['name'], $attachment['encoding'], $attachment['type']); 
				} 
			} 

			// Set email format to HTML 
			$mail->IsHTML(true); 

			$mail->Subject = $this->subject; 
			$mail->Body = $this->bodyHTML(); 
			$mail->AltBody = $this->bodyText(); 

			$result = $mail->Send(); 

			if($result == false) { $result = $mail->ErrorInfo; }
			return $result; 
		} 
	} 
