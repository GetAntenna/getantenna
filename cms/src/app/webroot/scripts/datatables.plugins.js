/*
========================================================================
	EU date format
========================================================================
*/

jQuery.fn.dataTableExt.aTypes.unshift(
    function(sData)
    {
        if (sData !== null && sData.match(/^(0[1-9]|[12][0-9]|3[01])\-(0[1-9]|1[012])\-(19|20|21)\d\d$/))
        {
            return 'shdate';
        }
        return null;
    } 
);

jQuery.fn.dataTableExt.oSort['shdate-asc']  = function(a,b)
{
	var shDatea = a.split('-');
	var shDateb = b.split('-');

	var x = (shDatea[2] + shDatea[1] + shDatea[0]) * 1;
	var y = (shDateb[2] + shDateb[1] + shDateb[0]) * 1;

	return ((x < y) ? -1 : ((x > y) ?  1 : 0));
};
 
jQuery.fn.dataTableExt.oSort['shdate-desc'] = function(a,b)
{
	var shDatea = a.split('-');
	var shDateb = b.split('-');

	var x = (shDatea[2] + shDatea[1] + shDatea[0]) * 1;
	var y = (shDateb[2] + shDateb[1] + shDateb[0]) * 1;

	return ((x < y) ? 1 : ((x > y) ?  -1 : 0));
};





/*
========================================================================
	English weekdays
========================================================================
*/

jQuery.fn.dataTableExt.aTypes.unshift(
	function(sData)
	{
		var sValidStrings = 'monday,tuesday,wednesday,thursday,friday,saturday,sunday';
		if(sValidStrings.indexOf(sData.toLowerCase()) >= 0)
		{
			return 'weekday';
		}
		return null;
	}
);

var weekdays = new Array();
weekdays['monday'] = 1;
weekdays['tuesday'] = 2;
weekdays['wednesday'] = 3;
weekdays['thursday'] = 4;
weekdays['friday'] = 5;
weekdays['saturday'] = 6;
weekdays['sunday'] = 7;
 
jQuery.fn.dataTableExt.oSort['weekday-asc']  = function(a,b)
{
	a = a.toLowerCase();
	b = b.toLowerCase();
	return ((weekdays[a] < weekdays[b]) ? -1 : ((weekdays[a] > weekdays[b]) ?  1 : 0));
};
 
jQuery.fn.dataTableExt.oSort['weekday-desc'] = function(a,b)
{
	a = a.toLowerCase();
	b = b.toLowerCase();
	return ((weekdays[a] < weekdays[b]) ? 1 : ((weekdays[a] > weekdays[b]) ?  -1 : 0));
};





/*
========================================================================
	EU date and time format
========================================================================
*/

jQuery.fn.dataTableExt.aTypes.unshift(
    function(sData)
    {
        if (sData !== null && sData.match(/^(0[1-9]|[12][0-9]|3[01])\-(0[1-9]|1[012])\-\d\d (0[1-9]|[12][0-9])\:([0-5][0-9])$/))
        {
            return 'megadate';
        }
        return null;
    } 
);

jQuery.fn.dataTableExt.oSort['megadate-asc'] = function(a, b)
{
   var megaDateATokens = a.split(' ');
	var megaDateADate = megaDateATokens[0].split('-'); // Date
	var megaDateATime = megaDateATokens[1].split(':'); // Time
	var x = new Date(megaDateADate[2], megaDateADate[1] - 1, megaDateADate[0], megaDateATime[0], megaDateATime[1]);

   var megaDateBTokens = b.split(' ');
	var megaDateBDate = megaDateBTokens[0].split('-'); // Date
	var megaDateBTime = megaDateBTokens[1].split(':'); // Time
	var y = new Date(megaDateBDate[2], megaDateBDate[1] - 1, megaDateBDate[0], megaDateBTime[0], megaDateBTime[1]);

	return ((x < y) ? -1 : ((x > y) ?  1 : 0));
};
 
jQuery.fn.dataTableExt.oSort['megadate-desc'] = function(a, b)
{
   var megaDateATokens = a.split(' ');
	var megaDateADate = megaDateATokens[0].split('-'); // Date
	var megaDateATime = megaDateATokens[1].split(':'); // Time
	var x = new Date(megaDateADate[2], megaDateADate[1] - 1, megaDateADate[0], megaDateATime[0], megaDateATime[1]);

   var megaDateBTokens = b.split(' ');
	var megaDateBDate = megaDateBTokens[0].split('-'); // Date
	var megaDateBTime = megaDateBTokens[1].split(':'); // Time
	var y = new Date(megaDateBDate[2], megaDateBDate[1] - 1, megaDateBDate[0], megaDateBTime[0], megaDateBTime[1]);

	return ((x < y) ? 1 : ((x > y) ?  -1 : 0));
};