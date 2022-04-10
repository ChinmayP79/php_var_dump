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
	/**
	 * Edit only public properties after this :
	**/

	/** @var string		Dump Message */
	public string $dump_msg = 'Variable Dump';

	/**
	 * Do not edit anything after this :
	**/

	/** @var bool		Store the dump */
	public bool $dump_store = false;

	/** @var string		New line */
	private string $nl = "";

	/** @var string		Dump */
	private string $dump = '';

	/**
	 * Set public property of same type
	 *
	 * @param string	$name
	 * @param mixed		$value
	 * @access public
	 **/
	final public function propSet(string $name, $value)
	{
		$prop = new ReflectionProperty($this, $name);
		if ($prop->isPublic() && $prop->getType()->isBuiltin() && $prop->getType()->getName() === gettype($value)) $this->$name = $value;
		unset($prop);
		return $this;
	}

	/**
	 * PHP Variable Dump
	 *
	 * @param mixed		...$vars
	 * @access private
	 **/
	final private function php_var_dump(...$vars)
	{
		$dbt = @debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3)[2];
		if (!empty($dbt))
		{
			$this->dump .= 'In '.$dbt['file'].':'.$dbt['line'].':';
			$this->dump .= !empty($dbt['class']) ? $dbt['class'] : '';
			$this->dump .= !empty($dbt['type']) ? $dbt['type'] : '';
			$this->dump .= !empty($dbt['function']) ? $dbt['function'].':' : '';
			$this->dump .= $this->nl;
		}
		unset($dbt);

		ini_set('xdebug.var_display_max_children', '-1');
		ini_set('xdebug.var_display_max_data', '-1');
		ini_set('xdebug.var_display_max_depth', '-1');

		ob_start();
		var_dump(...$vars); $vd_line = __LINE__;
		$this->dump .= ob_get_contents();
		ob_end_clean();

		ini_restore('xdebug.var_display_max_children');
		ini_restore('xdebug.var_display_max_data');
		ini_restore('xdebug.var_display_max_depth');

		// Remove first mis-info line for Xdebug var_dump
		$vd_line = preg_quote(str_replace(__DIR__ . DIRECTORY_SEPARATOR,'',__FILE__) .':'. $vd_line);
		$this->dump = preg_replace('/\<small\>(.*?)'.$vd_line.'\:\<\/small\>/', '', $this->dump);
	}

	/**
	 * Variable Dump wrapped inside HTML `<pre><code>` tags
	 *
	 * @param mixed		...$vars
	 * @access public
	 **/
	final public function preFormat(...$vars)
	{
		$this->nl = "<br>";
		$this->php_var_dump(...$vars);

		if (!$this->dump_store)
		{
			echo('<pre><code>' . $this->dump . '</code></pre>');
			$this->dump = '';
		}
	}

	/**
	 * Variable Dump to file
	 *
	 * @param mixed		...$vars
	 * @access public
	 **/
	final public function file(...$vars)
	{
		$this->nl = "\n";
		$this->php_var_dump(...$vars);

		if (!$this->dump_store)
		{
			// ToDo file
			$this->dump = '';
		}
	}

	/**
	 * Variable Dump to Email
	 *
	 * @param mixed		...$vars
	 * @access public
	 **/
	final public function email(...$vars)
	{
		$this->nl = "<br>";
		$this->php_var_dump(...$vars);

		if (!$this->dump_store)
		{
			// ToDo mail
			$this->dump = '';
		}
	}

	/**
	 * Variable Dump to PHP Error Log
	 *
	 * @param mixed		...$vars
	 * @access public
	 **/
	final public function errorLog(...$vars)
	{
		$this->nl = "\n";
		$this->php_var_dump(...$vars);

		if (!$this->dump_store)
		{
			// ToDo error_log
			$this->dump = '';
		}
	}

}
?>
