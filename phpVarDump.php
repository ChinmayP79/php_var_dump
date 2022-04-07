<?php
/**
 * PHP Variable Dump
 *
 * @author Chinmay G. Palekar [ChinmayP79]
 * @copyright (C) 2022-forever, Chinmay G. Palekar [ChinmayP79]
 * @license GPL-3.0
**/

/**
 * PHP Variable Dump Class
 */
class phpVarDump
{

	/** @var string		Default Variable Dump Message */
	public $default_var_dump_msg = 'Variable Dump';

	/**
	 * Xdebug INI Set
	 *
	 * @access private
	 **/
	private function php_var_dump(...$args)
	{
		ini_set('xdebug.var_display_max_children', '-1');
		ini_set('xdebug.var_display_max_data', '-1');
		ini_set('xdebug.var_display_max_depth', '-1');

		ob_start();
		var_dump(...$args);
		$ob_content = ob_get_contents();
		ob_end_clean();

		ini_restore('xdebug.var_display_max_children');
		ini_restore('xdebug.var_display_max_data');
		ini_restore('xdebug.var_display_max_depth');

		return $ob_content;
	}

	/**
	 * Variable Dump wrapped inside HTML `<pre><code>` tags
	 *
	 * @access private
	 **/
	public function preformat(...$args)
	{
		echo('<pre><code>');
		$this->php_var_dump(...$args);
		echo('</code></pre>');
	}

	/**
	 * Variable Dump to file
	 *
	 * @access private
	 **/
	public function file(...$args)
	{
		$this->php_var_dump(...$args);
	}

	/**
	 * Variable Dump to Email
	 *
	 * @access private
	 **/
	public function email(...$args)
	{
		$this->php_var_dump(...$args);
	}

}
?>
