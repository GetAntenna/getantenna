<?php
	class NewsletterHelper extends AppHelper
	{
		function styleHTML($content)
		{   
			
			// Mozilla adds in rubbish when using TinyMCE, this gets rid of it. There might be more classes to remove.
			$sources = array('class="moz-txt-link-freetext"', 'class="moz-txt-link-abbreviated"');
			$target = '';
			$content = str_replace($sources, $target, $content);
			
			
			$source = "{<\s*a\s*(href=[^>]*)>([^<]*)</a>}i";
			$target = "<a $1 style=\"color:#cc2979;text-decoration:none;\">$2</a>";
			$content = preg_replace($source, $target, $content);

			$source = "{<\s*p\s*>([^<]*)</p>}i";
			$target = "<p style=\"margin:10px 0;\">$1</a>";
			return preg_replace($source, $target, $content);
		}
	}