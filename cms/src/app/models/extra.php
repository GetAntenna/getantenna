<?php
	class Extra extends AppModel
	{
		var $name = 'Extra';

/*		function isUploadedImage($params)
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
			// Get the data from the uploaded file
			if(!empty($this->data['Extra']['banner']['tmp_name']))
			{
				$source = new File($this->data['Extra']['banner']['tmp_name']);
				$filedata = $source->read();
				$filesize = $this->data['Extra']['banner']['size'];
				$source->close();

				// Save the file details
				$this->data['Extra']['bannern'] = $this->data['Extra']['banner']['name'];
				$this->data['Extra']['bannert'] = $this->data['Extra']['banner']['type'];
				$this->data['Extra']['banners'] = $filesize;
				$this->data['Extra']['bannerd'] = base64_encode($filedata);
			}
			else
			{
				if(isset($this->data['Extra']['bannern']) && ($this->data['Extra']['bannern'] == ''))
				{
					// No image from the beginning or the image has been removed
					$this->data['Extra']['bannern'] = '';
					$this->data['Extra']['bannert'] = '';
					$this->data['Extra']['banners'] = 0;
					$this->data['Extra']['bannerd'] = '';
				}
				else
				{
					$this->data['Extra']['bannern'] = $this->field('bannern');
					$this->data['Extra']['bannert'] = $this->field('bannert');
					$this->data['Extra']['banners'] = $this->field('banners');
					$this->data['Extra']['bannerd'] = $this->field('bannerd');
				}
			}
			return true;
		}*/
	}