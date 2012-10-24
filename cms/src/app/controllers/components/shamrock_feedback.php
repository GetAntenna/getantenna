<?php
	class shamrockFeedbackComponent extends Object
	{
		var $controller = null;

		function startup(&$controller)
		{
			// Access the controller methods and properties
			$this->controller = $controller; 
		}

		function feedbackSave($message, $type = 'error')
		{
			if(!empty($this->controller->Session))
			{
				$this->controller->Session->write('Shamrock.feedback', array('message' => $message, 'type' => $type));
			}
		}

		function feedbackLoad()
		{
			$feedback = $this->controller->Session->read('Shamrock.feedback');
			if(!empty($feedback))
			{
				switch($feedback['type'])
				{
					case 'success':
					{
						$this->feedbackSuccess($feedback['message']);
						break;
					}
					case 'error':
					{
						$this->feedbackError($feedback['message']);
						break;
					}
					case 'warning':
					{
						$this->feedbackWarning($feedback['message']);
						break;
					}
					case 'notice':
					{
						$this->feedbackNotice($feedback['message']);
						break;
					}
				}
				$this->controller->Session->delete('Shamrock.feedback');
			}
		}

		function feedbackSuccess($message = null)
		{
			// Show a success message
			if($message != null)
			{
				$this->controller->set('shamrockFeedback', '<div class="feedback feedbackSuccess">'. $message .'</div>');
			}
		}

		function feedbackError($message = null)
		{
			// Show a error message
			if($message != null)
			{
				$this->controller->set('shamrockFeedback', '<div class="feedback feedbackError">'. $message .'</div>');
			}
		}

		function feedbackWarning($message = null)
		{
			// Show a warning message
			if($message != null)
			{
				$this->controller->set('shamrockFeedback', '<div class="feedback feedbackWarning">'. $message .'</div>');
			}
		}

		function feedbackNotice($message = null)
		{
			// Show a notice
			if($message != null)
			{
				$this->controller->set('shamrockFeedback', '<div class="feedback feedbackNotice">'. $message .'</div>');
			}
		}
	}
