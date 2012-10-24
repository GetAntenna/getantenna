<?php 
	class CategoriesHelper extends FormHelper
	{
		public $helpers = array('Form');
		private $defaultCategory = '';
		private $categories = array(
			"" => "- Please select -", 
			"category_01" => "Category 01",
			"category_02" => "Category 02",
			"category_03" => "Category 03",
			"category_04" => "Category 04",
			"category_05" => "Category 05",
			"category_06" => "Category 06",
			"category_07" => "Category 07",
			"category_08" => "Category 08",
			"category_09" => "Category 09",
			"category_10" => "Category 10",
			"category_11" => "Category 11"
		);

		public function __construct() { }

		public function setDefaults($category = '')
		{
			if($category !== '')
			{
				$this->defaultCategory = $category;
			}
			return true;
		}

		private function getSelected($fieldName)
		{
			if(empty($this->data))
			{
				return '';
			}
			$view =& ClassRegistry::getObject('view');
			$this->setEntity($fieldName);
			$ent = $view->entity();
			if(empty($ent))
			{
				return '';
			}
			$obj = $this->data;
			$i = 0;
			while(true)
			{
				if(is_array($obj))
				{
					if(array_key_exists($ent[$i], $obj))
					{
						$obj = $obj[$ent[$i]];
						$i++;
					}
				}
				else
				{
					return $obj;
				}
			}
		}

		public function categorySelect($fieldName, $options=array())
		{
			$options = array_merge(
				array(
					'label' => __('Category', true),
					'default' => $this->defaultCategory,
					'class' => null
				), $options);
			$selected = $this->getSelected($fieldName);

			$opts = array();
			$opts['options'] = $this->categories;
			$opts['selected'] = $selected;
			$opts['multiple'] = false;
			$opts['label'] = $options['label'];
			$opts['error'] = $options['error'];
			if($options['class'] !== null)
			{
				$opts['class'] = $options['class'];
			}
			$out = $this->Form->input($fieldName, $opts);
			return $this->output($out);
		}
	}