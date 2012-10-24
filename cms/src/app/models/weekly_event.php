<?php
	class WeeklyEvent extends AppModel
	{
		var $validate = array(
			'title' => array(
				'rule' => 'notEmpty',
				'required' => true, 
			),
			'category' => array(
				'rule' => 'notEmpty',
				'required' => true, 
			),
			'start' => array(
				'rule' => array('date', 'dmy'), 
				'required' => true, 
			),
			'stime' => array(
				'rule' => '/^[0-9][0-9]:[0-9][0-9]$/i',  
				'required' => true, 
			),
			'address' => array(
				'rule' => 'notEmpty',
				'required' => true, 
			),
			'summary' => array(
				'rule' => 'notEmpty',
				'required' => true, 
			),
			'picture' => array(
				'rule' => 'isUploadedImage', 
				'message' => 'file', 
			),
		);

		function isUploadedImage($params)
		{
			$val = array_shift($params);
			if(empty($val['tmp_name']))
			{
				// No file has been uploaded
				return true;
			}

			// The file need to be an image
			if(!empty($val['type']) && ($val['type'] == 'image/jpeg' || $val['type'] == 'image/png' || $val['type'] == 'image/gif'))
			{
				if((isset($val['error']) && $val['error'] == 0) || (!empty($val['tmp_name']) && $val['tmp_name'] != 'none'))
				{
					return is_uploaded_file($val['tmp_name']);
				}
			}

			return false;
		}

		function beforeSave() 
		{
			if(isset($this->data['WeeklyEvent']['clone']) && ($this->data['WeeklyEvent']['clone'] == true))
			{
				return true;
			}

			// Get the data from the uploaded file
			if(!empty($this->data['WeeklyEvent']['picture']['tmp_name']))
			{
				$imageInfo = getimagesize($this->data['WeeklyEvent']['picture']['tmp_name']);
				switch($imageInfo[2])
				{
					case IMAGETYPE_GIF:
					{
						$oldImage = imagecreatefromgif($this->data['WeeklyEvent']['picture']['tmp_name']);
						break;
					}
					case IMAGETYPE_JPEG:
					{
						$oldImage = imagecreatefromjpeg($this->data['WeeklyEvent']['picture']['tmp_name']);
						break;
					}
					case IMAGETYPE_PNG:
					{
						$oldImage = imagecreatefrompng($this->data['WeeklyEvent']['picture']['tmp_name']);
						break;
					}
				}

				// The height of the image exceed the maximum height
				if($imageInfo[1] >= Configure::read('Application.core.imageheight'))
				{
					$imageWidth = Configure::read('Application.core.imageheight') * $imageInfo[0] / $imageInfo[1];
					$newImage = imagecreatetruecolor($imageWidth, Configure::read('Application.core.imageheight'));
					imagecopyresampled($newImage, $oldImage, 0, 0, 0, 0, $imageWidth, Configure::read('Application.core.imageheight'), $imageInfo[0], $imageInfo[1]);

					// Save the image to a variable
					ob_start();

					switch($imageInfo[2])
					{
						case IMAGETYPE_GIF:
						{
							imagegif($newImage);
							break;
						}
						case IMAGETYPE_JPEG:
						{
							imagejpeg($newImage, NULL, 100);
							break;
						}
						case IMAGETYPE_PNG:
						{
							imagepng($newImage, NULL, 0);
							break;
						}
					}

					// Save the contents on the variable
					$filedata = ob_get_contents();
					$filesize = mb_strlen($filedata, '8bit');

					// Flush the display cache
					ob_end_clean();

					// Deallocate the new image
					imagedestroy($newImage);
				}
				else
				{
					$source = new File($this->data['WeeklyEvent']['picture']['tmp_name']);
					$filedata = $source->read();
					$filesize = $this->data['WeeklyEvent']['picture']['size'];
					$source->close();
				}

				// Deallocate the old image
				imagedestroy($oldImage);

				// Save the file details
				$this->data['WeeklyEvent']['picturen'] = $this->data['WeeklyEvent']['picture']['name'];
				$this->data['WeeklyEvent']['picturet'] = $this->data['WeeklyEvent']['picture']['type'];
				$this->data['WeeklyEvent']['pictures'] = $filesize;
				$this->data['WeeklyEvent']['pictured'] = base64_encode($filedata);
			}
			else
			{
				if(isset($this->data['WeeklyEvent']['picturen']) && ($this->data['WeeklyEvent']['picturen'] == ''))
				{
					// No image from the beginning or the image has been removed
					$this->data['WeeklyEvent']['picturen'] = '';
					$this->data['WeeklyEvent']['picturet'] = '';
					$this->data['WeeklyEvent']['pictures'] = 0;
					$this->data['WeeklyEvent']['pictured'] = '';
				}
				else
				{
					$this->data['WeeklyEvent']['picturen'] = $this->field('picturen');
					$this->data['WeeklyEvent']['picturet'] = $this->field('picturet');
					$this->data['WeeklyEvent']['pictures'] = $this->field('pictures');
					$this->data['WeeklyEvent']['pictured'] = $this->field('pictured');
				}
			}

			// Convert the date to the MySQL format
			list($day, $month, $year) = explode("-", $this->data['WeeklyEvent']['start']);
			$this->data['WeeklyEvent']['start'] = $year ."-". $month ."-". $day;

			// Set the end time to null if empty
			if($this->data['WeeklyEvent']['etime'] == '')
			{
				$this->data['WeeklyEvent']['etime'] = null;
			}

			return true;
		}
	}