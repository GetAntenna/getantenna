<?php
	class ExtrasController extends AppController
	{
		public $name = 'Extras';
		private $_currentUser = null;
		public $helpers = array('TinyMce');
		
		function beforeFilter()
		{
			// Get the details for the current user
			$this->_currentUser = @$this->shamrockAuthentication->user();
			$this->_currentUser = $this->_currentUser['User'];

			// Set some basic strings
			$this->set('userFirstName', ($this->_currentUser['firstname']));
			$this->set('userEmail', $this->_currentUser['email']);

			// Check if the user is an admin
			if($this->_currentUser['group_id'] != Configure::read('Application.acl.admingroup')) { $this->set('isUser', true); } else { $this->set('isUser', false); }
		}

		function index()
		{
			$this->set('title_for_layout', __('About &amp; Statistics', true));
			$this->layout = 'default';

			// Show the feedback message
			$this->shamrockFeedback->feedbackLoad();

			if(!empty($this->data))
			{
				// Save the mobile subscribers numbers
				$statsMobile = $this->Extra->findByOption('STATS_MOBILE');
				$this->Extra->id = $statsMobile['Extra']['id'];
				$this->Extra->set('value', $this->data['Extra']['mobile']);
				$this->Extra->save();

				// Save the newsletter subscribers numbers
				$statsNewsletter = $this->Extra->findByOption('STATS_NEWSLETTER');
				$this->Extra->id = $statsNewsletter['Extra']['id'];
				$this->Extra->set('value', $this->data['Extra']['newsletter']);
				$this->Extra->save();

				// Save the facebook subscribers numbers
				$statsFacebook = $this->Extra->findByOption('STATS_FACEBOOK');
				$this->Extra->id = $statsFacebook['Extra']['id'];
				$this->Extra->set('value', $this->data['Extra']['facebook']);
				$this->Extra->save();

				// Save the intro and the outro
				$aboutIntro = $this->Extra->findByOption('ABOUT_INTRO');
				$this->Extra->id = $aboutIntro['Extra']['id'];
				$this->Extra->set('value', $this->data['Extra']['intro']);
				$this->Extra->save();
				$aboutOutro = $this->Extra->findByOption('ABOUT_OUTRO');
				$this->Extra->id = $aboutOutro['Extra']['id'];
				$this->Extra->set('value', $this->data['Extra']['outro']);
				$this->Extra->save();

				// Save the sponsor
				$aboutSponsor = $this->Extra->findByOption('ABOUT_SPONSOR');
				$this->Extra->id = $aboutSponsor['Extra']['id'];
				$this->Extra->set('value', $this->data['Extra']['sponsor']);
				$this->Extra->save();

				// Check the image
				if(!empty($this->data['Extra']['banner']['type']) && (
						$this->data['Extra']['banner']['type'] == 'image/jpeg' || 
						$this->data['Extra']['banner']['type'] == 'image/png' || 
						$this->data['Extra']['banner']['type'] == 'image/gif'
					))
				{
					if((isset($this->data['Extra']['banner']['error']) && $this->data['Extra']['banner']['error'] == 0) || (!empty($this->data['Extra']['banner']['tmp_name']) && $this->data['Extra']['banner']['tmp_name'] != 'none'))
					{
						if(is_uploaded_file($this->data['Extra']['banner']['tmp_name']))
						{
							$source = new File($this->data['Extra']['banner']['tmp_name']);
							$filedata = base64_encode($source->read());
							$filesize = $this->data['Extra']['banner']['size'];
							$filename = $this->data['Extra']['banner']['name'];
							$filetype = $this->data['Extra']['banner']['type'];
							$source->close();

							// Save the banner information
							$bannerName = $this->Extra->findByOption('BANNER_NAME');
							$this->Extra->id = $bannerName['Extra']['id'];
							$this->Extra->set('value', $filename);
							$this->Extra->save();
							$bannerType = $this->Extra->findByOption('BANNER_TYPE');
							$this->Extra->id = $bannerType['Extra']['id'];
							$this->Extra->set('value', $filetype);
							$this->Extra->save();
							$bannerSize = $this->Extra->findByOption('BANNER_SIZE');
							$this->Extra->id = $bannerSize['Extra']['id'];
							$this->Extra->set('value', $filesize);
							$this->Extra->save();
							$bannerData = $this->Extra->findByOption('BANNER_DATA');
							$this->Extra->id = $bannerData['Extra']['id'];
							$this->Extra->set('value', $filedata);
							$this->Extra->save();
						}
					}
				}
				else
				{
					if(isset($this->data['Extra']['bannern']) && ($this->data['Extra']['bannern'] == ''))
					{
						// No image from the beginning or the image has been removed
						$filename = '';
						$filetype = '';
						$filesize = 0;
						$filedata = '';

						// Save the banner information
						$bannerName = $this->Extra->findByOption('BANNER_NAME');
						$this->Extra->id = $bannerName['Extra']['id'];
						$this->Extra->set('value', $filename);
						$this->Extra->save();
						$bannerType = $this->Extra->findByOption('BANNER_TYPE');
						$this->Extra->id = $bannerType['Extra']['id'];
						$this->Extra->set('value', $filetype);
						$this->Extra->save();
						$bannerSize = $this->Extra->findByOption('BANNER_SIZE');
						$this->Extra->id = $bannerSize['Extra']['id'];
						$this->Extra->set('value', $filesize);
						$this->Extra->save();
						$bannerData = $this->Extra->findByOption('BANNER_DATA');
						$this->Extra->id = $bannerData['Extra']['id'];
						$this->Extra->set('value', $filedata);
						$this->Extra->save();
					}
				}

				$this->shamrockFeedback->feedbackSave(__('Information saved', true), 'success');
				$this->redirect(array('action' => 'index'), null, true);
			}
			else
			{
				// Load the values
				$statsMobile = $this->Extra->findByOption('STATS_MOBILE');
				$statsNewsletter = $this->Extra->findByOption('STATS_NEWSLETTER');
				$statsFacebook = $this->Extra->findByOption('STATS_FACEBOOK');
				$aboutIntro = $this->Extra->findByOption('ABOUT_INTRO');
				$aboutOutro = $this->Extra->findByOption('ABOUT_OUTRO');
				$aboutSponsor = $this->Extra->findByOption('ABOUT_SPONSOR');
				$bannerName = $this->Extra->findByOption('BANNER_NAME');

				$this->data['Extra']['mobile'] = $statsMobile['Extra']['value'];
				$this->data['Extra']['newsletter'] = $statsNewsletter['Extra']['value'];
				$this->data['Extra']['facebook'] = $statsFacebook['Extra']['value'];
				$this->data['Extra']['intro'] = $aboutIntro['Extra']['value'];
				$this->data['Extra']['outro'] = $aboutOutro['Extra']['value'];
				$this->data['Extra']['sponsor'] = $aboutSponsor['Extra']['value'];
				$this->data['Extra']['bannern'] = $bannerName['Extra']['value'];
			}
		}
	}