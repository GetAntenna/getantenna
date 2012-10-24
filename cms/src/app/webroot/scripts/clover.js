


if(typeof jQuery == 'undefined') 
{
	// jQuery not detected
	alert('Clover requires jQuery 1.5');
}
else
{
	(
		function(window, undefined)
		{

			var Clover = (function()
				{
					var Clover = function() { return new Clover.core.init(); };
					Clover.core = Clover.prototype = 
						{
							constructor: Clover,
							init: function() {  }
						};			
					Clover.core.init.prototype = Clover.core;
					Clover.version = Clover.core.version = '0.1';
					return Clover;
				})();



			/*
			==================================================================
				Clover System
			==================================================================
			*/
		
			Clover.System = { constructor: 'Clover.System' };



			/*
			==================================================================
				Clover System - Logging
			==================================================================
			*/

			Clover.System.Log = 
				{
					constructor: 'Clover.System.Log', 
					isEnabled: false, 
					isActive: typeof (console) === 'undefined' ? false : true, 
					useProfile: false, 
					enableLog: function() { this.isEnabled = true; },
					disableLog: function() { this.isEnabled = false; },
					startProfiling: function(object)
					{
						if(this.isEnabled && this.isActive) 
						{
							if(arguments.length === 0) { object = ''; }
							if(this.useProfile) { console.info('Profile started'); }
							if(object.constructor == String) { this.useProfile ? console.profile(object) : console.time(object); }
						}
					},
					stopProfiling: function(object)
					{
						if(this.isEnabled && this.isActive) 
						{
							if(arguments.length === 0) { object = ''; }
							if(object.constructor == String) { this.useProfile ? console.profileEnd() : console.timeEnd(object); }
							if(this.useProfile) { console.info('Profile stopped'); }
						}
					},
					log: function(object)
					{
						if(this.isEnabled && this.isActive) 
						{
							if(arguments.length === 0) { object = ''; }
							var objectType = typeof object;

							switch(objectType)
							{
								case 'xml':
									console.groupCollapsed('%c[XML]', Clover.System.Log.Styles.XML); 
									console.log(object.toXMLString());
									console.groupEnd();
									break;
								case 'function':
									console.groupCollapsed('%c[Function]', Clover.System.Log.Styles.FUNCTION); 
									console.dir(object);
									console.groupEnd();
									break;
								case 'object':
									if(object === null)
									{
										console.log('%c' + object, Clover.System.Log.Styles.NULL); 
									}
									else
									{
										(jQuery.isArray(object)) ? console.groupCollapsed('%c[Array]', Clover.System.Log.Styles.ARRAY) : console.groupCollapsed('%c[Object]', Clover.System.Log.Styles.OBJECT);
										console.dir(object);
										console.groupEnd();
									}
									break;
								case 'number':
									console.log('%c[Number]' + object, Clover.System.Log.Styles.NUMBER); 
									break;
								case 'string':
									console.log('%c[String]' + object, Clover.System.Log.Styles.STRING); 
									break;
								case 'boolean':
									console.log('%c[Boolean]' + object, object ? Clover.System.Log.Styles.BOOLEANTRUE : Clover.System.Log.Styles.BOOLEANFALSE); 
									break;
								case undefined:
									console.log('%c' + object, Clover.System.Log.Styles.UNDEFINED); 
									break;
								default:
									console.log(object); 
							}
						}
					}
				};
			Clover.System.Log.Styles = 
				{
					XML: 'color: #006ebb;',
					FUNCTION: 'color: #4d00bb;',
					OBJECT: 'color: #81b915;',
					ARRAY: 'color: #af5211;',
					NUMBER: 'color: #ea7400;',
					STRING: 'color: #808000;',
					BOOLEANTRUE: 'font-weight: bolder; color: #0000ff;',
					BOOLEANFALSE: 'font-weight: bolder; color: #ff0000;',
					UNDEFINED: 'font-style: italics; color: #666666;',
					NULL: 'font-style: italics; color: #666666;'
				};
				
			// Define some aliases
			Clover.logEnable = function() { Clover.System.Log.isEnabled = true; };
			Clover.logDisable = function() { Clover.System.Log.isEnabled = false; };
			Clover.log = function(object) { Clover.System.Log.log.call(Clover.System.Log, object) };



			/*
			==================================================================
				Clover UI
			==================================================================
			*/
		
			Clover.UI = { constructor: 'Clover.UI' };



			/*
			==================================================================
				Clover UI - Tooltips
			==================================================================
			*/

			Clover.UI.Tooltips = 
			{
				constructor: 'Clover.UI.Tooltips', 
				maxWidth: 280,
				fadeEffect: true,
				closeLabel: 'Close',
				arrowTop: 16,
				currentTarget: null, 
				defaultSelector: '.cTooltipEnabled', 
				create: function(selector)
				{
					var self = this;
					var validInstance = false;

					// Create the tooltip structure
					// First the wrapper
					var tooltipStructure = jQuery('<div/>');
					tooltipStructure.addClass('cTooltip');
					tooltipStructure.css({
							position: 'absolute',
							display: 'none',
							width: self.maxWidth
				        });

					// Then the body
					var tooltipBody = jQuery('<div/>').addClass('cTooltipBody');

					// Then the close button
					var tooltipCloseButton = jQuery('<div/>').addClass('cTooltipCloseButton');

					// Then the link that will close the tooltip
					var tooltipCloseControl = jQuery('<a/>');
					tooltipCloseControl.append(self.closeLabel);
					tooltipCloseControl.bind("click.ctooltip", function(ui, event) 
						{ 
							self.close(true);
							jQuery(self.currentTarget).focus();
						});

					// Put everything together and save the tooltip structure and the body
					tooltipCloseButton.append(tooltipCloseControl);
					tooltipStructure.append(tooltipBody);
					tooltipStructure.append(tooltipCloseButton);
					self._tooltipStructure = tooltipStructure;
					self._tooltipBody = tooltipBody;

					if(typeof selector === 'string') self.defaultSelector = selector;
					jQuery(self.defaultSelector).each(function()
						{
							var $currentObject = jQuery(this);
							self.validInstance = true;

							// Save the tooltip content and get rid of the title attribute
							var tooltipContent = jQuery(this).attr('title');
							$currentObject.attr('ctooltip', tooltipContent);
							$currentObject.removeAttr('title');

							// Bind the focus event on the owner element
							$currentObject.bind("focus.ctooltip", function(ui, event) { self.open(ui, $currentObject, tooltipContent); });

							// Bind the blur event on the owner element
							$currentObject.bind("blur.ctooltip", function(event) { self.close(); });

							// Bind the mouse over to the tooltip structure
							self._tooltipStructure.bind("mouseover.ctooltip", function(event) 
								{ 
									// Disable the blur on the element owner
									$currentObject.unbind("blur.ctooltip");
								});

							// Bind the mouse out to the tooltip structure
							self._tooltipStructure.bind("mouseout.ctooltip", function(event) 
								{ 
									// Re-enable the blur on the element owner
									$currentObject.bind("blur.ctooltip", function(event) { self.close(); });
								});
						});
				},
				open: function(ui, $caller, tooltipContent)
				{
					var self = this;
					if(!self.validInstance) return false;

					if(Clover.UI.Tooltips.currentTarget != ui.currentTarget)
					{
						// Add the content to the tooltip structure
						self._tooltipBody.html(tooltipContent);

						// Get the current position of the owner element
						var ownerOffset = $caller.position();
						var ownerWidth = $caller.outerWidth();
						var ownerHeight = $caller.outerHeight();

						// Attach the tooltip
						$caller.after(self._tooltipStructure);
						Clover.UI.Tooltips.currentTarget = ui.currentTarget;

						// Change the position the tooltip
						self._tooltipStructure.css({
								top: ownerOffset.top - Math.round(self.arrowTop / 2) + 3,
								left: ownerOffset.left + ownerWidth - 3
							});

						// Display the tooltip
						(self.fadeEffect) ? self._tooltipStructure.fadeIn(400) : self._tooltipStructure.show();
					}
				},
				close: function(forceClose)
				{
					var self = this;
					if(!self.validInstance) return false;

					// Hide the tooltip
					self._tooltipStructure.hide();

					// Detach the tooltip
					self._tooltipStructure.detach();

					if(!forceClose) Clover.UI.Tooltips.currentTarget = null;
				},
				destroy: function()
				{
					var self = this;
					if(!self.validInstance) return false;

					// Close the last opened tooltip if any
					this.close();

					jQuery('.cTooltipEnabled').each(function()
						{
							// Revert back the original title attribute
							var tooltipContent = jQuery(this).attr('ctooltip');
							jQuery(this).attr('title', tooltipContent);
							jQuery(this).removeAttr('ctooltip');

							// Unbind all tooltips events
							jQuery(this).unbind("focus.ctooltip");
							jQuery(this).unbind("blur.ctooltip");
						});
				}
			};



			window.Clover = window.$C = Clover;
		}
	)(window);
}