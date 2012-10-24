<?php

/**
 * Helper for AJAX operations.
 *
 * Helps doing AJAX using the jQuery library.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2009, Damian Jóźwiak (http://www.cakephp.bee.pl)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 */

/**
 * AjaxHelper helper library.
 *
 * Helps doing AJAX using the Prototype library.
 *
 * @package       cake
 * @subpackage    cake.cake.libs.view.helpers
 */
class AjaxHelper extends AppHelper {

    /**
     * Included helpers.
     *
     * @var array
     */
    var $helpers = array('Html', 'Javascript', 'Form');
    /**
     * HtmlHelper instance
     *
     * @var HtmlHelper
     * @access public
     */
    var $Html = null;
    /**
     * JavaScriptHelper instance
     *
     * @var JavaScriptHelper
     * @access public
     */
    var $Javascript = null;
    /**
     * Names of Javascript callback functions.
     *
     * @var array
     */
    var $callbacks = array(
	'beforeSend', 'complete', 'error', 'success', 'dataFilter'
    );
    /**
     * Names of AJAX options.
     *
     * @var array
     */
    var $ajaxOptions = array(
	'after', 'async', 'before', 'confirm', 'condition', 'contentType',
	'form', 'beforeSend', 'complete', 'error',
	'success', 'parameters',
	'cache', 'data', 'dataFilter', 'dataType', 'global', 'ifModified',
	'jsonp', 'password', 'processData', 'scriptCharset', 'timeout', 'type',
	'url', 'username', 'xhr', 'with'
    );
    /**
     * Options for draggable.
     *
     * @var array
     */
    var $dragOptions = array(
	'addClasses', 'appendTo', 'axis', 'cancel', 'connectToSortable', 'containment',
	'cursor', 'cursorAt', 'delay', 'distance', 'grid', 'handle', 'helper', 'iframeFix',
	'opacity', 'refreshPositions', 'revert', 'revertDuration', 'scope', 'scroll',
	'scrollSensitivity', 'scrollSpeed', 'snap', 'snapMode', 'snapTolerance', 'stack', 'zIndex',
	'start', 'drag', 'stop'
    );
    /**
     * Options for droppable.
     *
     * @var array
     */
    var $dropOptions = array(
	'accept', 'activeClass', 'addClasses', 'greedy', 'hoverClass', 'scope', 'tolerance',
	'activate', 'deactivate', 'over', 'out', 'drop'
    );
    /**
     * Options for sortable.
     *
     * @var array
     */
    var $sortOptions = array(
	'appendTo', 'axis', 'cancel', 'connectWith', 'containment', 'cursor', 'cursorAt', 'delay',
	'distance', 'dropOnEmpty', 'forceHelperSize', 'forcePlaceholderSize', 'grid', 'handle',
	'helper', 'items', 'opacity', 'placeholder', 'revert', 'scroll', 'scrollSensitivity',
	'scrollSpeed', 'tolerance', 'zIndex',
	'start', 'sort', 'change', 'beforeStop', 'stop', 'update', 'receive', 'remove', 'over',
	'out', 'activate', 'deactivate',
    );
    /**
     * Options for slider.
     *
     * @var array
     */
    var $sliderOptions = array(
	'animate', 'max', 'min', 'change', 'orientation', 'range', 'slide', 'start', 'step',
	'stop', 'value', 'values'
    );
    /**
     * Options for in-place editor.
     *
     * @var array
     */
    var $editorOptions = array(
	'method', 'callback', 'name', 'id', 'submitdata', 'type', 'rows', 'cols', 'height',
	'width', 'loadurl', 'loadtype', 'loadtext', 'loaddata', 'data', 'indicator', 'tooltip',
	'event', 'submit', 'cancel', 'cssclass', 'style', 'select', 'placeholder', 'onblur',
	'onsubmit', 'onreset', 'onerror', 'ajaxoptions'
    );
    /**
     * Options for old auto-complete editor.
     *
     * @var array
     */
    var $autoCompleteOptions_old = array(
	'autoFill', 'cacheLength', 'delay', 'extraParams', 'formatItem', 'formatMatch',
	'formatResult', 'highlight', 'matchCase', 'matchContains', 'matchSubset', 'max',
	'minChars', 'multiple', 'multipleSeparator', 'mustMatch', 'scroll', 'scrollHeight',
	'selectFirst', 'width'
    );
    
    /**
     * Options for auto-complete editor.
     *
     * @var array
     */
    var $autoCompleteOptions = array(
		'select', 'source', 'minLength', 'appendTo', 'position'
    );
    /**
     * Output buffer for Ajax update content
     *
     * @var array
     */
    var $__ajaxBuffer = array();

    /**
     * Returns link to remote action
     *
     * Returns a link to a remote action defined by <i>options[url]</i>
     * (using the url() format) that's called in the background using
     * XMLHttpRequest. The result of that request can then be inserted into a
     * DOM object whose id can be specified with <i>options[update]</i>.
     *
     * Examples:
     * <code>
     *  link("Delete this post",
     * array("update" => "posts", "url" => "delete/{$postid->id}"));
     *  link(imageTag("refresh"),
     * 		array("update" => "emails", "url" => "list_emails" ));
     * </code>
     *
     * By default, these remote requests are processed asynchronous during
     * which various callbacks can be triggered (for progress indicators and
     * the likes).
     *
     * Example:
     * <code>
     * 	link (word,
     * 		array("url" => "undo", "n" => word_counter),
     * 		array("complete" => "undoRequestCompleted(request)"));
     * </code>
     *
     * The callbacks that may be specified are:
     *
     * - <i>loading</i>::		Called when the remote document is being
     * 							loaded with data by the browser.
     * - <i>loaded</i>::		Called when the browser has finished loading
     * 							the remote document.
     * - <i>interactive</i>::	Called when the user can interact with the
     * 							remote document, even though it has not
     * 							finished loading.
     * - <i>complete</i>:: Called when the XMLHttpRequest is complete.
     *
     * If you for some reason or another need synchronous processing (that'll
     * block the browser while the request is happening), you can specify
     * <i>options[type] = synchronous</i>.
     *
     * You can customize further browser side call logic by passing
     * in Javascript code snippets via some optional parameters. In
     * their order of use these are:
     *
     * - <i>confirm</i>:: Adds confirmation dialog.
     * -<i>condition</i>::	Perform remote request conditionally
     *                      by this expression. Use this to
     *                      describe browser-side conditions when
     *                      request should not be initiated.
     * - <i>before</i>::		Called before request is initiated.
     * - <i>after</i>::		Called immediately after request was
     * 						initiated and before <i>loading</i>.
     *
     * @param string $title Title of link
     * @param string $href Href string "/products/view/12"
     * @param array $options		Options for JavaScript function
     * @param string $confirm		Confirmation message. Calls up a JavaScript confirm() message.
     * @param boolean $escapeTitle  Escaping the title string to HTML entities
     *
     * @return string				HTML code for link to remote action
     */
    function link($title, $href = null, $options = array(), $confirm = null, $escapeTitle = true) {
	if (!isset($href)) {
	    $href = $title;
	}
	if (!isset($options['url'])) {
	    $options['url'] = $href;
	}

	if (isset($confirm)) {
	    $options['confirm'] = $confirm;
	    unset($confirm);
	}
	$htmlOptions = $this->__getHtmlOptions($options, array('url'));

	$htmlDefaults = array('id' => 'link' . intval(mt_rand()), 'onclick' => '');
	$htmlOptions = array_merge($htmlDefaults, $htmlOptions);

	$htmlOptions['onclick'] .= ' return false;';
	$return = $this->Html->link($title, $href, $htmlOptions, null, $escapeTitle);
	$callback = $this->remoteFunction($options);
	$script = $this->Javascript->event("'#{$htmlOptions['id']}'", "click", $callback);

	if (is_string($script)) {
	    $return .= $script;
	}
	return $return;
    }

    /**
     * Creates JavaScript function for remote AJAX call
     *
     * This function creates the javascript needed to make a remote call
     * it is primarily used as a helper for AjaxHelper::link.
     *
     * @param array $options options for javascript
     * @return string html code for link to remote action
     * @see AjaxHelper::link() for docs on options parameter.
     */
    function remoteFunction($options) {
	if (isset($options['update'])) {
	    if (isset($options['position'])) {
		$position = $options['position'];
		unset($options['position']);
	    } else {
		$position = 'html';
	    }
	    if (!is_array($options['update'])) {
		$func = "$.ajax(";
		if (!isset($options['complete'])) {
		    $options['complete'] = '';
		}
		$options['complete'] = "jQuery('#" . $options['update'] . "').$position(request.responseText); " . $options['complete'];
	    } else {
		$func = "$.ajax(";
		if (!isset($options['complete'])) {
		    $options['complete'] = '';
		}
		$selectors = '';
		foreach ($options['update'] as $selector) {
		    $selectors .= '#' . $selector . ', ';
		}
		$options['complete'] = "jQuery('" . $selectors . "').$position(request.responseText); " . $options['complete'];
	    }
	    if (is_array($options['update'])) {
		$options['update'] = join(' ', $options['update']);
	    }
	} else {
	    $func = "$.ajax(";
	}
	$options['url'] = $this->url(isset($options['url']) ? $options['url'] : "");
	$func .= $this->__optionsForAjax($options) . ")";

	if (isset($options['before'])) {
	    $func = "{$options['before']}; $func";
	}
	if (isset($options['after'])) {
	    $func = "$func; {$options['after']};";
	}
	if (isset($options['condition'])) {
	    $func = "if ({$options['condition']}) { $func; }";
	}

	if (isset($options['confirm'])) {
	    $func = "if (confirm('" . $this->Javascript->escapeString($options['confirm'])
		    . "')) { $func; } else { return false; }";
	}
	return $func;
    }

    /**
     * Periodically call remote url via AJAX.
     *
     * Periodically calls the specified url (<i>options[url]</i>) every <i>options[frequency]</i>
     * seconds (default is 10).  Usually used to update a specified div (<i>options[update]</i>) with
     * the results of the remote call.  The options for specifying the target with url and defining
     * callbacks is the same as AjaxHelper::link().
     *
     * @param array $options Callback options
     * @return string Javascript code
     * @see AjaxHelper::link()
     */
    function remoteTimer($options = null) {
	$frequency = (isset($options['frequency'])) ? $options['frequency'] * 1000 : 10;
	$callback = $this->remoteFunction($options);
	$rand = intval(mt_rand());
	$func_name = 'func' . $rand;
	$func = "function $func_name(){ $callback }";
	$timer_name = 'timer' . $rand;
	$code = $func . "var $timer_name = setInterval($func_name, $frequency);";
	return $this->Javascript->codeBlock($code);
    }

    /**
     * Returns form tag that will submit using Ajax.
     *
     * Returns a form tag that will submit using XMLHttpRequest in the background instead of the regular
     * reloading POST arrangement. Even though it's using Javascript to serialize the form elements,
     * the form submission will work just like a regular submission as viewed by the receiving side
     * (all elements available in params).  The options for defining callbacks is the same
     * as AjaxHelper::link().
     *
     * @param mixed $params Either a string identifying the form target, or an array of method parameters, including:
     *  - 'params' => Acts as the form target
     *  - 'type' => 'post' or 'get'
     *  - 'options' => An array containing all HTML and script options used to
     *  generate the form tag and Ajax request.
     * @param array $type How form data is posted: 'get' or 'post'
     * @param array $options Callback/HTML options
     * @return string JavaScript/HTML code
     * @see AjaxHelper::link()
     */
    function form($params = null, $type = 'post', $options = array()) {
	$model = false;
	if (is_array($params)) {
	    extract($params, EXTR_OVERWRITE);
	}

	if (empty($options['url'])) {
	    $options['url'] = array('action' => $params);
	}

	$htmlDefaults = array(
	    'id' => 'form' . intval(mt_rand()),
	    'onsubmit' => "return false;",
	    'type' => $type
	);
	$htmlOptions = $this->__getHtmlOptions($options, array('model', 'with'));
	$htmlOptions = array_merge($htmlDefaults, $htmlOptions);

	$defaults = array('model' => $model, 'with' => "jQuery('#{$htmlOptions['id']}').serialize()", 'type' => $type);
	$options = array_merge($defaults, $options);
	$callback = $this->remoteFunction($options);

	$form = $this->Form->create($options['model'], $htmlOptions);
	$script = $this->Javascript->event("'#" . $htmlOptions['id'] . "'", 'submit', $callback);
	return $form . $script;
    }

    /**
     * Returns a button input tag that will submit using Ajax
     *
     * Returns a button input tag that will submit form using XMLHttpRequest in the background instead
     * of regular reloading POST arrangement. <i>options</i> argument is the same as
     * in AjaxHelper::form().
     *
     * @param string $title Input button title
     * @param array $options Callback options
     * @return string Ajaxed input button
     * @see AjaxHelper::form()
     */
    function submit($title = 'Submit', $options = array()) {
	$htmlOptions = $this->__getHtmlOptions($options);
	$htmlOptions['value'] = $title;

	if (!isset($options['with'])) {
	    $options['with'] = "jQuery(this).parents('form:first').serialize()";
	}
	if (!isset($htmlOptions['id'])) {
	    $htmlOptions['id'] = 'submit' . intval(mt_rand());
	}

	$htmlOptions['onclick'] = "return false;";
	$callback = $this->remoteFunction($options);

	$form = $this->Form->submit($title, $htmlOptions);
	$script = $this->Javascript->event('"#' . $htmlOptions['id'] . '"', 'click', $callback);
	return $form . $script;
    }

    /**
     * Observe field and call ajax on change.
     *
     * Observes the field with the DOM ID specified by <i>field</i> and makes
     * an Ajax when its contents have changed.
     *
     * Required +options+ are:
     * - <i>frequency</i>:: The frequency (in seconds) at which changes to
     * 						this field will be detected.
     * - <i>url</i>::		@see url() -style options for the action to call
     * 						when the field has changed.
     *
     * Additional options are:
     * - <i>update</i>::	Specifies the DOM ID of the element whose
     * 						innerHTML should be updated with the
     * 						XMLHttpRequest response text.
     * - <i>with</i>:: A Javascript expression specifying the
     * 						parameters for the XMLHttpRequest. This defaults
     * 						to Form.Element.serialize('$field'), which can be
     * 						accessed from params['form']['field_id'].
     *
     * Additionally, you may specify any of the options documented in
     * @see linkToRemote().
     *
     * @param string $field DOM ID of field to observe
     * @param array $options ajax options
     * @return string ajax script
     */
    function observeField($field, $options = array()) {
	if (!isset($options['with'])) {
	    $options['with'] = "jQuery('#$field').serialize()";
	}
	$callback = $this->remoteFunction($options);

	return $this->Javascript->event("'#{$field}'", "change", $callback);
    }

    /**
     * Observe entire form and call ajax on change.
     *
     * Like @see observeField(), but operates on an entire form identified by the
     * DOM ID <b>form</b>. <b>options</b> are the same as <b>observeField</b>, except
     * the default value of the <i>with</i> option evaluates to the
     * serialized (request string) value of the form.
     *
     * @param string $form DOM ID of form to observe
     * @param array $options ajax options
     * @return string ajax script
     */
    function observeForm($form, $options = array()) {
	if (!isset($options['with'])) {
	    $options['with'] = "jQuery('#$form').serialize()";
	}
	$callback = $this->remoteFunction($options);
	return $this->Javascript->event("'#{$form} input, #{$form} select, #{$form} textarea'", "change", $callback);
    }

    /**
     * Create a text field with Old Autocomplete.
     *
     * Creates an autocomplete field with the given ID and options.
     * needs include jquery.autocomplete.min.js file
     *
     * @param string $field DOM ID of field to observe
     * @param string $url URL for the autocomplete action
     * @param array $options Ajax options
     * @return string Ajax script
     * check out http://docs.jquery.com/Plugins/Autocomplete
     */
    function autoComplete_old($field, $url = "", $options = array()) {
	$var = '';
	if (isset($options['var'])) {
	    $var = 'var ' . $options['var'] . ' = ';
	    unset($options['var']);
	}

	if (!isset($options['id'])) {
	    $options['id'] = Inflector::camelize(str_replace(".", "_", $field));
	}

	$htmlOptions = $this->__getHtmlOptions($options);
	$htmlOptions['autocomplete'] = "off";

	foreach ($this->autoCompleteOptions as $opt) {
	    unset($htmlOptions[$opt]);
	}

	$options = $this->_optionsToString($options, array('multipleSeparator'));
	$callbacks = array('formatItem', 'formatMatch', 'formatResult', 'highlight');

	foreach ($callbacks as $callback) {
	    if (isset($options[$callback])) {
		$name = $callback;
		$code = $options[$callback];
		switch ($name) {
		    case 'formatResult':
			$options[$name] = "function(data, i, max) {" . $code . "}";
			break;
		    case 'highlight':
			$options[$name] = "function(data, search) {" . $code . "}";
			break;
		    default:
			$options[$name] = "function(row, i, max, term) {" . $code . "}";
			break;
		}
	    }
	}

	$options = $this->_buildOptions($options, $this->autoCompleteOptions_old);

	$text = $this->Form->text($field, $htmlOptions);
	$script = "{$var} jQuery('#{$htmlOptions['id']}').autocomplete_old('";
	$script .= $this->Html->url($url) . "', {$options});";

	return "{$text}\n" . $this->Javascript->codeBlock($script);
    }

    /**
     * Creates an Ajax-updateable DIV element
     *
     * @param string $id options for javascript
     * @return string HTML code
     */
    function div($id, $options = array()) {
	if (env('HTTP_X_UPDATE') != null) {
	    $this->Javascript->enabled = false;
	    $divs = explode(' ', env('HTTP_X_UPDATE'));

	    if (in_array($id, $divs)) {
		@ob_end_clean();
		ob_start();
		return '';
	    }
	}
	$attr = $this->_parseAttributes(array_merge($options, array('id' => $id)));
	return $this->output(sprintf($this->Html->tags['blockstart'], $attr));
    }

    /**
     * Closes an Ajax-updateable DIV element
     *
     * @param string $id The DOM ID of the element
     * @return string HTML code
     */
    function divEnd($id) {
	if (env('HTTP_X_UPDATE') != null) {
	    $divs = explode(' ', env('HTTP_X_UPDATE'));
	    if (in_array($id, $divs)) {
		$this->__ajaxBuffer[$id] = ob_get_contents();
		ob_end_clean();
		ob_start();
		return '';
	    }
	}
	return $this->output($this->Html->tags['blockend']);
    }

    /**
     * Detects Ajax requests
     *
     * @return boolean True if the current request is a Prototype Ajax update call
     */
    function isAjax() {
	return (isset($this->params['isAjax']) && $this->params['isAjax'] === true);
    }

    /**
     * Creates a draggable element.  For a reference on the options for this function,
     * check out http://docs.jquery.com/UI/Draggable
     *
     * @param unknown_type $id
     * @param array $options
     * @return unknown
     */
    function drag($id, $options = array()) {
	$var = '';
	if (isset($options['var'])) {
	    $var = 'var ' . $options['var'] . ' = ';
	    unset($options['var']);
	}

	$strings = array(
	    'appendTo', 'axis', 'cancel', 'connectToSortable', 'cursor', 'cursorAt',
	    'handle', 'helper', 'iframeFix', 'revert', 'scope', 'snap', 'snapMode'
	);

	if (isset($options['grid']) && is_array($options['grid'])) {
	    $options['grid'] = $this->Javascript->object($options['grid']);
	}
	if (isset($options['containment']) && is_array($options['containment'])) {
	    $options['containment'] = $this->Javascript->object($options['containment']);
	} else {
	    $strings[] = 'containment';
	}

	$callbacks = array('start', 'drag', 'stop');

	$options = $this->_optionsToString($options, $strings);
	$options = array_merge($options, $this->_buildUICallbacks($options, $callbacks));


	$options = $this->_buildOptions($options, $this->dragOptions);
	return $this->Javascript->codeBlock("{$var}jQuery('#$id').draggable( " . $options . ");");
    }

    /**
     * For a reference on the options for this function, check out
     * http://docs.jquery.com/UI/Droppable
     *
     * @param unknown_type $id
     * @param array $options
     * @return string
     */
    function drop($id, $options = array()) {
	$var = '';
	if (isset($options['var'])) {
	    $var = 'var ' . $options['var'] . ' = ';
	    unset($options['var']);
	}

	$strings = array(
	    'accept', 'activeClass', 'hoverClass', 'scope', 'tolerance'
	);

	$callbacks = array('activate', 'deactivate', 'over', 'out', 'drop');

	$options = $this->_optionsToString($options, $strings);
	$options = array_merge($options, $this->_buildUICallbacks($options, $callbacks));

	$options = $this->_buildOptions($options, $this->dropOptions);
	return $this->Javascript->codeBlock("{$var}jQuery('#$id').droppable( " . $options . ");");
    }

    /**
     * Make an element with the given $id droppable, and trigger an Ajax call when a draggable is
     * dropped on it.
     *
     * For a reference on the options for this function, check out
     * http://wiki.script.aculo.us/scriptaculous/show/Droppables.add
     *
     * @param string $id
     * @param array $options
     * @param array $ajaxOptions
     * @return string JavaScript block to create a droppable element
     */
    function dropRemote($id, $options = array(), $ajaxOptions = array()) {
	$var = '';
	if (isset($options['var'])) {
	    $var = 'var ' . $options['var'] . ' = ';
	    unset($options['var']);
	}

	$callback = $this->remoteFunction($ajaxOptions);

	if (!isset($options['drop'])) {
	    $options['drop'] = '';
	}
	$options['drop'] = $callback . '; ' . $options['drop'];

	$strings = array(
	    'accept', 'activeClass', 'hoverClass', 'scope', 'tolerance'
	);

	$callbacks = array('activate', 'deactivate', 'over', 'out', 'drop');

	$options = $this->_optionsToString($options, $strings);
	$options = array_merge($options, $this->_buildUICallbacks($options, $callbacks));

	$options = $this->_buildOptions($options, $this->dropOptions);

	return $this->Javascript->codeBlock("{$var}jQuery('#$id').droppable( " . $options . ");");
    }

    /**
     * Makes a slider control.
     *
     * @param string $id DOM ID of slider handle
     * @param array $options Array of options to control the slider
     * @link          http://docs.jquery.com/UI/Slider
     */
    function slider($id, $options = array()) {
	if (isset($options['var'])) {
	    $var = 'var ' . $options['var'] . ' = ';
	    unset($options['var']);
	} else {
	    $var = 'var ' . $id . ' = ';
	}

	$options = $this->_optionsToString($options, array(
		    'orientation', 'range'
		));
	$callbacks = array('change', 'slide', 'stop', 'start');


	$options = array_merge($options, $this->_buildUICallbacks($options, $callbacks));

	if (isset($options['values']) && is_array($options['values'])) {
	    $options['values'] = $this->Javascript->object($options['values']);
	}

	$options = $this->_buildOptions($options, $this->sliderOptions);
	$script = "{$var} jQuery('#$id').slider($options);";
	return $this->Javascript->codeBlock($script);
    }

    /**
     * Makes an Ajax In Place editor control.
     * requires Jeditable jQuery plugin from http://www.appelsiini.net/projects/jeditable
     *
     * @param string $id DOM ID of input element
     * @param string $url Postback URL of saved data
     * @param array $options Array of options to control the editor (see link).
     * @link          http://www.appelsiini.net/projects/jeditable
     */
    //TODO
    function editor($id, $url, $options = array()) {
	$url = $this->url($url);

	if (isset($options['ajaxoptions'])) {
	    $options['ajaxoptions'] = $this->__optionsForAjax($options['ajaxoptions']);
	}
	if (isset($options['submitdata']) && is_array($options['submitdata'])) {
	    $options['submitdata'] = $this->Javascript->object($options['submitdata']);
	}

	$var = '';
	if (isset($options['var'])) {
	    $var = 'var ' . $options['var'] . ' = ';
	    unset($options['var']);
	}

	$options = $this->_optionsToString($options, array(
		    'method', 'name', 'id', 'type', 'height', 'width', 'loadurl',
		    'loadtype', 'loadtext', 'indicator', 'tooltip', 'event', 'submit',
		    'cancel', 'cssclass', 'style', 'select', 'placeholder', 'onblur',
		));
	$callbacks = array('callback', 'onsubmit', 'onreset', 'onerror');

	if (isset($options['loaddata'])) {
	    if (is_array($options['loaddata'])) {
		$options['loaddata'] = $this->Javascript->object($options['loaddata']);
	    } else {
		$callbacks[] = 'loaddata';
	    }
	}
	if (isset($options['data'])) {
	    if (is_array($options['data'])) {
		$options['data'] = $this->Javascript->object($options['data']);
	    } else {
		$callbacks[] = 'data';
	    }
	}

	foreach ($callbacks as $callback) {
	    if (isset($options[$callback])) {
		$name = $callback;
		$code = $options[$callback];
		switch ($name) {
		    case 'callback':
			$options[$name] = "function(value, settings) {" . $code . "}";
			break;
		    case 'onerror':
			$options[$name] = "function(settings, original, xhr) {" . $code . "}";
			break;
		    default:
			$options[$name] = "function(settings, original) {" . $code . "}";
			break;
		}
	    }
	}

	$options = $this->_buildOptions($options, $this->editorOptions);
	$script = "{$var}jQuery('#{$id}').editable('{$url}', {$options});";
	return $this->Javascript->codeBlock($script);
    }

    /**
     * Makes a list or group of floated objects sortable.
     *
     * @param string $id DOM ID of parent
     * @param array $options Array of options to control sort.
     * @link          http://docs.jquery.com/UI/Sortable
     */
    function sortable($id, $options = array()) {
	if (isset($options['var'])) {
	    $var = 'var ' . $options['var'] . ' = ';
	    unset($options['var']);
	} else {
	    $var = 'var ' . $id . ' = ';
	}
	if (!empty($options['url'])) {
	    if (empty($options['with'])) {
		$options['with'] = "jQuery('#$id').sortable('serialize')";
	    }
	    $upd = '';
	    if (isset($options['update'])) {
		$upd = $options['update'];
		unset($options['update']);
	    }
	    $options['update'] = $this->remoteFunction($options) . '; ' . $upd;
	}
	$block = true;

	if (isset($options['block'])) {
	    $block = $options['block'];
	    unset($options['block']);
	}
	$strings = array(
	    'appendTo', 'axis', 'cancel', 'connectWith', 'containment', 'cursor', 'cursorAt',
	    'handle', 'helper', 'items', 'placeholder', 'tolerance',
	);

	if (isset($options['grid']) && is_array($options['grid'])) {
	    $options['grid'] = $this->Javascript->object($options['grid']);
	}

	$callbacks = array('start', 'sort', 'change', 'beforeStop', 'stop', 'update',
	    'receive', 'remove', 'over', 'out', 'activate', 'deactivate');

	$options = $this->_optionsToString($options, $strings);
	$options = array_merge($options, $this->_buildUICallbacks($options, $callbacks));
	$options = $this->_buildOptions($options, $this->sortOptions);
	$result = "{$var} jQuery('#$id').sortable($options);";

	if (!$block) {
	    return $result;
	}
	return $this->Javascript->codeBlock($result);
    }

    /**
     * Private helper function for Javascript.
     *
     * @param array $options Set of options
     * @access private
     */
    function __optionsForAjax($options) {
	if (isset($options['indicator'])) {
	    if (isset($options['beforeSend'])) {
		$loading = $options['beforeSend'];

		if (!empty($loading) && substr(trim($loading), -1, 1) != ';') {
		    $options['beforeSend'] .= '; ';
		}
		$options['beforeSend'] .= "jQuery('#{$options['indicator']}').show()";
	    } else {
		$options['beforeSend'] = "jQuery('#{$options['indicator']}').show();";
	    }
	    if (isset($options['complete'])) {
		$complete = $options['complete'];

		if (!empty($complete) && substr(trim($complete), -1, 1) != ';') {
		    $options['complete'] .= '; ';
		}
		$options['complete'] .= "jQuery('#{$options['indicator']}').hide()";
	    } else {
		$options['complete'] = "jQuery('#{$options['indicator']}').hide()";
	    }
	    unset($options['indicator']);
	}

	$jsOptions = array_merge(
		array('async' => 'true', 'type' => '\'post\''), $this->_buildCallbacks($options)
	);

	$options = $this->_optionsToString($options, array(
		    'contentType', 'dataType', 'jsonp', 'password', 'scriptCharset', 'type', 'url', 'username'
		));
	foreach ($options as $key => $value) {
	    switch ($key) {
		case 'async':
		    $jsOptions['async'] = ($value == 'synchronous') ? 'false' : 'true';
		    break;
		case 'with':
		    $jsOptions['data'] = $options['with'];
		    break;
		case 'form':
		    $jsOptions['data'] = 'jQuery(this).serialize()';
		    break;
		default:
		    if (!in_array($key, $this->callbacks) && !in_array($key, array('before', 'after', 'confirm', 'condition', 'interactive', 'update')))
			$jsOptions[$key] = $value;
		    break;
	    }
	}
	return $this->_buildOptions($jsOptions, $this->ajaxOptions);
    }

    /**
     * Private Method to return a string of html options
     * option data as a JavaScript options hash.
     *
     * @param array $options	Options in the shape of keys and values
     * @param array $extra	Array of legal keys in this options context
     * @return array Array of html options
     * @access private
     */
    function __getHtmlOptions($options, $extra = array()) {
	foreach (array_merge($this->ajaxOptions, $this->callbacks, $extra) as $key) {
	    if (isset($options[$key])) {
		unset($options[$key]);
	    }
	}
	return $options;
    }

    /**
     * Returns a string of JavaScript with the given option data as a JavaScript options hash.
     *
     * @param array $options	Options in the shape of keys and values
     * @param array $acceptable	Array of legal keys in this options context
     * @return string	String of Javascript array definition
     */
    function _buildOptions($options, $acceptable) {
	if (is_array($options)) {
	    $out = array();

	    foreach ($options as $k => $v) {
		if (in_array($k, $acceptable)) {
		    if ($v === true) {
			$v = 'true';
		    } elseif ($v === false) {
			$v = 'false';
		    }
		    $out[] = "$k:$v";
		} elseif ($k === 'with' && in_array('parameters', $acceptable)) {
		    $out[] = "parameters:${v}";
		}
	    }

	    $out = join(', ', $out);
	    $out = '{' . $out . '}';
	    return $out;
	} else {
	    return false;
	}
    }

    /**
     * Return Javascript text for callbacks.
     *
     * @param array $options Option array where a callback is specified
     * @return array Options with their callbacks properly set
     * @access protected
     */
    function _buildCallbacks($options) {
	$callbacks = array();

	foreach ($this->callbacks as $callback) {
	    if (isset($options[$callback])) {
		$name = $callback;
		$code = $options[$callback];
		switch ($name) {
		    case 'complete':
			$callbacks[$name] = "function(request, json) {" . $code . "}";
			break;
		    case 'success':
			$callbacks[$name] = "function(request, xhr) {" . $code . "}";
			break;
		    case 'error':
			$callbacks[$name] = "function(request, textStatus, exception) {" . $code . "}";
			break;
		    case 'dataFilter':
			$callbacks[$name] = "function(data, type) {" . $code . "}";
			break;
		    default:
			$callbacks[$name] = "function(request) {" . $code . "}";
			break;
		}
		if (isset($options['bind'])) {
		    $bind = $options['bind'];

		    $hasBinding = (
			    (is_array($bind) && in_array($callback, $bind)) ||
			    (is_string($bind) && strpos($bind, $callback) !== false)
			    );

		    if ($hasBinding) {
			$callbacks[$name] .= ".bind(this)";
		    }
		}
	    }
	}
	return $callbacks;
    }

    function _buildUICallbacks($options, $ui_calbacks = array()) {
	$callbacks = array();
	foreach ($ui_calbacks as $callback) {
	    if (isset($options[$callback])) {
		$name = $callback;
		$code = $options[$callback];
		$callbacks[$name] = "function(event, ui) {" . $code . "}";
	    }
	}
	return $callbacks;
    }

    /**
     * Returns a string of JavaScript with a string representation of given options array.
     *
     * @param array $options	Ajax options array
     * @param array $stringOpts	Options as strings in an array
     * @access private
     * @return array
     */
    function _optionsToString($options, $stringOpts = array()) {
	foreach ($stringOpts as $option) {
	    $hasOption = (
		    isset($options[$option]) && !empty($options[$option]) &&
		    is_string($options[$option]) && $options[$option][0] != "'"
		    );

	    if ($hasOption) {
		if ($options[$option] === true || $options[$option] === 'true') {
		    $options[$option] = 'true';
		} elseif ($options[$option] === false || $options[$option] === 'false') {
		    $options[$option] = 'false';
		} else {
		    $options[$option] = "'{$options[$option]}'";
		}
	    }
	}
	return $options;
    }

    /**
     * Executed after a view has rendered, used to include bufferred code
     * blocks.
     *
     * @access public
     */
    //TODO Moze jednak to kiedys naprawics
    function afterRender() {
	if (env('HTTP_X_UPDATE') != null && !empty($this->__ajaxBuffer)) {
	    @ob_end_clean();

	    $data = array();
	    $divs = explode(' ', env('HTTP_X_UPDATE'));
	    $keys = array_keys($this->__ajaxBuffer);

	    if (count($divs) == 1 && in_array($divs[0], $keys)) {
		echo $this->__ajaxBuffer[$divs[0]];
	    } else {
		foreach ($this->__ajaxBuffer as $key => $val) {
		    if (in_array($key, $divs)) {
			$data[] = $key . ':"' . rawurlencode($val) . '"';
		    }
		}
		$out = 'var __ajaxUpdater__ = {' . join(", \n", $data) . '};' . "\n";
		$out .= 'for (n in __ajaxUpdater__) { if (typeof __ajaxUpdater__[n] == "string" && jQuery(n)) jQuery(\'#n\').html(unescape(decodeURIComponent(__ajaxUpdater__[n])));}';
		echo $this->Javascript->codeBlock($out, false);
	    }
	    $scripts = $this->Javascript->getCache();

	    if (!empty($scripts)) {
		echo $this->Javascript->codeBlock($scripts, false);
	    }
	    $this->_stop();
	}
    }

    /**
     * Create a text field with Jquery UI Autocomplete.
     *
     * Creates an autocomplete field with the given ID and options.
     * needs include jQuery UI Autocomplete file
     *
     * @param string $field DOM ID of field to observe
     * @param array $options Ajax options
     * @return string Ajax script
     * check out http://jqueryui.com/demos/autocomplete/
     */
    function autoComplete($field, $options = array()) {
	$var = '';
	if (isset($options['var'])) {
	    $var = 'var ' . $options['var'] . ' = ';
	    unset($options['var']);
	}
	
	if(isset($options['source'])) {
	    $options['source'] = "'".Router::url($options['source'])."'";
	}
	
	if (!isset($options['id'])) {
	    $options['id'] = Inflector::camelize(str_replace(".", "_", $field));
	}

	$htmlOptions = $this->__getHtmlOptions($options);
	$htmlOptions['autocomplete'] = "off";

	foreach ($this->autoCompleteOptions as $opt) {
	    unset($htmlOptions[$opt]);
	}

	$options = $this->_optionsToString($options, array('multipleSeparator'));
	$callbacks = array('formatItem', 'formatMatch', 'formatResult', 'highlight');

	foreach ($callbacks as $callback) {
	    if (isset($options[$callback])) {
		$name = $callback;
		$code = $options[$callback];
		switch ($name) {
		    case 'formatResult':
			$options[$name] = "function(data, i, max) {" . $code . "}";
			break;
		    case 'highlight':
			$options[$name] = "function(data, search) {" . $code . "}";
			break;
		    default:
			$options[$name] = "function(row, i, max, term) {" . $code . "}";
			break;
		}
	    }
	}
	$options = $this->_buildOptions($options, $this->autoCompleteOptions);

	$text = $this->Form->text($field, $htmlOptions);
	$script = "
		jQuery(document).ready
		(
			function()
			{
				{$var} jQuery('#{$htmlOptions['id']}').autocomplete(";
	$script .= "{$options});
			}
		);
	";

	return "{$text}\n" . $this->Javascript->codeBlock($script);
    }

}

?>