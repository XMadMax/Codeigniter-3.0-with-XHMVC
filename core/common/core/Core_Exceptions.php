<?php

/**
 * Description of cORE_Exceptions
 *
 * @author XPerez
 */
class Core_Exceptions extends CI_Exceptions
{
	function show_404($page = '', $log_error = TRUE){
        if (trim($page) == '')
            $page = $_SERVER['REQUEST_URI'];
		return parent::show_404($page, $log_error);
	}
	
	function show_error($heading, $message, $template = 'error_general', $status_code = 500) {
		$this->my_show_error($heading, $message, $template, $status_code);
	}
	
	function show_php_error($severity, $message, $filepath, $line) {
		return parent::show_php_error($severity, $message, $filepath, $line);
	}
	
	function log_exception($severity, $message, $filepath, $line) {
		if (($severity & error_reporting()) == $severity)
			return parent::log_exception($severity, $message, $filepath, $line);
	}
	
	function my_show_error($heading, $message, $template = 'error_general', $status_code = 500)
	{
		set_status_header($status_code);

		$message = '<p>'.implode('</p><p>', ( ! is_array($message)) ? array($message) : $message).'</p>';

		if (ob_get_level() > $this->ob_level + 1)
		{
			ob_end_flush();
		}
		ob_start();
		include(APPPATH.'errors/'.$template.EXT);
		$buffer = ob_get_contents();
		ob_end_clean();
		echo $buffer;
	}

	
}
