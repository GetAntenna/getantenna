jQuery.fn.vibrate=function(conf){var config=jQuery.extend({speed:50,duration:600,frequency:5000,spread:10},conf);return this.each(function(){var t=jQuery(this);var vibrate=function(){var topPos=Math.floor(Math.random()*config.spread)-((config.spread-1)/2);var leftPos=Math.floor(Math.random()*config.spread)-((config.spread-1)/2);t.css({position:"relative",left:leftPos+"px",top:topPos+"px"})};var doVibration=function(){var vibrationInterval=setInterval(vibrate,config.speed);var stopVibration=function(){clearInterval(vibrationInterval);t.css({position:"static"})};setTimeout(stopVibration,config.duration)};doVibration()})};