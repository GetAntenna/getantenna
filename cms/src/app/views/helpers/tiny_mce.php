<?php
	class TinyMceHelper extends AppHelper
	{
		var $helpers = array('Javascript');
		var $defaults = array(
			'theme' => 'advanced', 
			'plugins' => 'autolink,advlink,iespell,inlinepopups,paste,xhtmlxtras,wordcount,contextmenu,spellchecker',
			'dialog_type' => 'modal', 
			'theme_advanced_toolbar_location' => 'top',
			'theme_advanced_toolbar_align' => 'left',
			'theme_advanced_statusbar_location' => 'bottom',
			'theme_advanced_buttons1' => 'undo,redo,|,cut,copy,paste,pasteword,|,bold,italic,underline,strikethrough,|,link,unlink,|,cleanup,code,|,spellchecker',
			'theme_advanced_buttons2' => '',
			'relative_urls' => 'false',
			'convert_urls' => 'true',
			'paste_auto_cleanup_on_paste' => 'true',
			'paste_remove_styles' => 'true',                                                   
		);

		public function __construct()
		{
			if(Configure::read('Application.tinymce.css') != '')
			{
				$this->defaults['content_css'] = Router::url('/') . Configure::read('Application.tinymce.css');
			}
			$this->defaults['mode'] = Configure::read('Application.tinymce.mode');
			$this->defaults['height'] = Configure::read('Application.tinymce.height');
		}

		function init($options = false)
		{
			if($options)
			{
				$options = Set::merge($this->defaults, $options);
			}
			$code = 'var init_object = ' . json_encode($options) . ";\n";
			$code .= "init_object.setup = function(ed) { ed.addCommand('customPasteAsText', function(ui, v) { ed.execCommand('mcePasteText'); ed.execCommand('Paste'); })};\n";
			$code .= "tinyMCE.init(init_object);\n";
			return $this->Javascript->codeBlock($code);
		}
	}