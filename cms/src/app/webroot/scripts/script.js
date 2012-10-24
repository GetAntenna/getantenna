



	jQuery.noConflict(); 

	/*
	========================================================================
		JQuery ready function
	========================================================================
	*/

	jQuery(document).ready
	(
		function()
		{
			// Opening ready function



			/*
			==================================================================
				Top bar opacity
			==================================================================
			*/

			var fadeSpeed = 200, fadeTo = .5, topDistance = 30;
			var topbarME = function() { jQuery("#metaNavigationWrapper.fancy").fadeTo(fadeSpeed, 1); };
			var topbarML = function() { jQuery("#metaNavigationWrapper.fancy").fadeTo(fadeSpeed, fadeTo); };
			var semaphore = false;

			jQuery(window).scroll(function() 
			{
				position = jQuery(window).scrollTop();
				if(position > topDistance && !semaphore) 
				{
					topbarML();
					jQuery("#metaNavigationWrapper.fancy").bind("mouseenter", topbarME);
					jQuery("#metaNavigationWrapper.fancy").bind("mouseleave", topbarML);
					semaphore = true;
				}
				else if (position < topDistance)
				{
					topbarME();
					jQuery("#metaNavigationWrapper.fancy").unbind("mouseenter", topbarME);
					jQuery("#metaNavigationWrapper.fancy").unbind("mouseleave", topbarML);
					semaphore = false;
				}
			});





			/*
			==================================================================
				Tooltips
			==================================================================
			*/

			$C.UI.Tooltips.create();





			/*
			==================================================================
				Accordion
			==================================================================
			*/

			jQuery("#accordion").accordion({ autoHeight: false });
			jQuery("#accordion").show();
			jQuery("#faqPanelTrigger").bind("click.clover", function()
				{
					if(jQuery("#faqPanel").is(':visible'))
					{
						jQuery("#faqPanel").slideUp();
					}
					else
					{
						jQuery("#faqPanel").slideDown();
					}
					return false;
				});





			/*
			==================================================================
				Draft and ready buttons
			==================================================================
			*/

			jQuery('#draftButton').bind('click.clover', function()
				{
					jQuery('#draftButtonField').val('1');
					return true;
				});
			jQuery('#readyButton').bind('click.clover', function()
				{
					jQuery('#draftButtonField').val('0');
					return true;
				});
			jQuery('#draftButtonTop').bind('click.clover', function()
				{
					jQuery('#draftButtonField').val('1');
					return true;
				});
			jQuery('#readyButtonTop').bind('click.clover', function()
				{
					jQuery('#draftButtonField').val('0');
					return true;
				});





			/*
			==================================================================
				Shadowbox
			==================================================================
			*/

			Shadowbox.init(
				{
					players: ["html"], 
					modal: false, 
					overlayOpacity: 0.75,
					handleOversize: "none", 
					onFinish: function(item)
						{ 
							if(typeof shadowBoxFinish === 'function') { shadowBoxFinish(); }
						}
				});





			/*
			==================================================================
				DataTables
			==================================================================
			*/

			jQuery('.dataEventTable').dataTable({
				"aaSorting": [
					[ 1, "asc" ]
				],
				"aoColumns": [ 
					{ "bSortable": false },
					{ "sType": "megadate", "bSortable": true },
					{ "sType": "string", "bSortable": true },
					{ "sType": "html", "bSortable": true },
					{ "sType": "string", "bSortable": true },
					{ "bSortable": false },
					{ "bSortable": false },
					{ "sType": "numeric", "bSortable": true }
				],
				"bPaginate": false, 
				"bFilter": false,
				"bInfo": false,
				"bProcessing": false
			});
			jQuery('.dataWeeklyTable').dataTable({
				"aaSorting": [
					[ 1, "asc" ]
				],
				"aoColumns": [ 
					{ "bSortable": false },
					{ "sType": "megadate", "bSortable": true },
					{ "sType": "html", "bSortable": true },
					{ "sType": "string", "bSortable": true },
					{ "sType": "numeric", "bSortable": true }
				],
				"bPaginate": false, 
				"bFilter": false,
				"bInfo": false,
				"bProcessing": false
			});
			jQuery('.dataScrapbookTable').dataTable({
				"aaSorting": [
					[ 0, "desc" ]
				],
				"aoColumns": [ 
					{ "sType": "shdate", "bSortable": true },
					{ "bSortable": false },
					{ "sType": "megadate", "bSortable": true },
					{ "sType": "html", "bSortable": true },
					{ "sType": "string", "bSortable": true },
					{ "sType": "numeric", "bSortable": true }
				],
				"bPaginate": false, 
				"bFilter": false,
				"bInfo": false,
				"bProcessing": false
			});
			jQuery('.dataSubmittedTable').dataTable({
				"aaSorting": [
					[ 0, "desc" ]
				],
				"aoColumns": [ 
					{ "sType": "shdate", "bSortable": true },
					{ "bSortable": false },
					{ "sType": "megadate", "bSortable": true },
					{ "sType": "html", "bSortable": true },
					{ "sType": "html", "bSortable": true },
					{ "bSortable": false }
				],
				"bPaginate": false, 
				"bFilter": false,
				"bInfo": false,
				"bProcessing": false
			});




			// Closing ready function
		}
	);    
	
   // TinyMCE setPlainText for all pastes 
	
	function setPlainText() {
	        var ed = tinyMCE.get('elm1');

	        ed.pasteAsPlainText = true;  

	        //adding handlers crossbrowser
	        if (tinymce.isOpera || /Firefox\/2/.test(navigator.userAgent)) {
	            ed.onKeyDown.add(function (ed, e) {
	                if (((tinymce.isMac ? e.metaKey : e.ctrlKey) && e.keyCode == 86) || (e.shiftKey && e.keyCode == 45))
	                    ed.pasteAsPlainText = true;
	            });
	        } else {            
	            ed.onPaste.addToTop(function (ed, e) {
	                ed.pasteAsPlainText = true;
	            });
	        }
	    }	
	
 		function strip_tags (str, allowed_tags)
		{
            var key = '', allowed = false;
		    var matches = [];    var allowed_array = [];
		    var allowed_tag = '';
		    var i = 0;
		    var k = '';
		    var html = ''; 
		    var replacer = function (search, replace, str) {
		        return str.split(search).join(replace);
		    };
		    // Build allowes tags associative array
		    if (allowed_tags) {
		        allowed_array = allowed_tags.match(/([a-zA-Z0-9]+)/gi);
		    }
		    str += '';

		    // Match tags
		    matches = str.match(/(<\/?[\S][^>]*>)/gi);
		    // Go through all HTML tags
		    for (key in matches) {
		        if (isNaN(key)) {
		                // IE7 Hack
		            continue;
		        }

		        // Save HTML tag
		        html = matches[key].toString();
		        // Is tag not in allowed list? Remove from str!
		        allowed = false;

		        // Go through all allowed tags
		        for (k in allowed_array) {            // Init
		            allowed_tag = allowed_array[k];
		            i = -1;

		            if (i != 0) { i = html.toLowerCase().indexOf('<'+allowed_tag+'>');}
		            if (i != 0) { i = html.toLowerCase().indexOf('<'+allowed_tag+' ');}
		            if (i != 0) { i = html.toLowerCase().indexOf('</'+allowed_tag)   ;}

		            // Determine
		            if (i == 0) {                allowed = true;
		                break;
		            }
		        }
		        if (!allowed) {
		            str = replacer(html, "", str); // Custom replace. No regexing
		        }
		    }
		    return str;
		}