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

	/** @var string		New line */
	private $nl = "";

	/** @var string		Default Variable Dump Message */
	public $default_var_dump_msg = 'Variable Dump';

	/**
	 * PHP Variable Dump
	 *
	 * @access private
	 **/
	private function php_var_dump(...$vars)
	{
		$dump = '';
		$dbt = @debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3)[2];
		if (!empty($dbt))
		{
			$dump .= 'In '.$dbt['file'].':'.$dbt['line'].':';
			$dump .= !empty($dbt['class']) ? $dbt['class'] : '';
			$dump .= !empty($dbt['type']) ? $dbt['type'] : '';
			$dump .= !empty($dbt['function']) ? $dbt['function'].':' : '';
			$dump .= $this->nl;
		}

		ini_set('xdebug.var_display_max_children', '-1');
		ini_set('xdebug.var_display_max_data', '-1');
		ini_set('xdebug.var_display_max_depth', '-1');

		ob_start();
		var_dump(...$vars); $vd_line = __LINE__;
		$dump .= ob_get_contents();
		ob_end_clean();

		ini_restore('xdebug.var_display_max_children');
		ini_restore('xdebug.var_display_max_data');
		ini_restore('xdebug.var_display_max_depth');

		$vd_line = preg_quote(str_replace(__DIR__ . DIRECTORY_SEPARATOR,'',__FILE__) .':'. $vd_line);
		$dump = preg_replace('/\<small\>(.*?)'.$vd_line.'\:\<\/small\>/','',$dump);

		return $dump;
	}

	/**
	 * Variable Dump wrapped inside HTML `<pre><code>` tags
	 *
	 * @access private
	 **/
	public function preformat(...$vars)
	{
		$this->nl = "<br>";
		echo('<pre><code>' . $this->php_var_dump(...$vars) . '</code></pre>');
	}

	/**
	 * Variable Dump to file
	 *
	 * @access private
	 **/
	public function file(...$vars)
	{
		$this->nl = "\n";
		$this->php_var_dump(...$vars);
	}

	/**
	 * Variable Dump to Email
	 *
	 * @access private
	 **/
	public function email(...$vars)
	{
		$this->nl = "<br>";
		$this->php_var_dump(...$vars);
	}

}
?>
