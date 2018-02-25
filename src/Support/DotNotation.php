<?php

namespace AOD\Support;

class DotNotation
{
	/**
	 * Returns a static instance of the class inheriting this trait
	 * @return null|static
	 */
	public static function getInstance()
	{
		static $instance = null;
		if (null === $instance)
			$instance = new static();

		return $instance;
	}

	/**
	 * Protected constructor to prevent creating a new instance of the
	 * class via the `new` operator from outside of this class.
	 */
	protected function __construct() { }

	/**
	 * Checks to see if a key is a dot notation key
	 * @param $name
	 * @param string $needle
	 * @return bool
	 */
	protected function _check($name, $needle = '.')
	{
		return strpos($name, $needle) !== false;
	}

    /**
     * Returns the value of an array key using dot notation
     * @param string $_path
     * @param array $_data
     * @return null
     */
    protected function _parse($_path, $_data)
    {
        if(empty($_path)) {
            return null;
        }

        $_field = null;

        if($this->_check($_path)) {
            $split = explode('.', $_path, 2);
            if(count($split) == 2) {
                $_path = $split[0];
                $_field = $split[1];
            }
        }

        if(isset($_data[$_path])) {
            if(!empty($_field)) {
                if($this->_check($_field)) {
                    return $this->_parse($_field, $_data[$_path]);
                } else if(isset($_data[$_path][$_field])) {
                    return $_data[$_path][$_field];
                }
            } else {
                return $_data[$_path];
            }
        }

        return null;
    }

	/**
	 * Turns a string into an array
	 * @param $path
	 * @return array
	 */
	protected function _split($path)
	{
		if($this->_check($path))
			$path = array_map('trim', explode('.', $path));

		return (array) $path;
	}

	/**
	 * Turns a string into an array based on dot notation
	 * @param string $path
	 * @return array
	 */
	public static function split($path = '')
	{
		return self::getInstance()->_split($path);
	}

	/**
	 * @param string $path
	 * @return string
	 */
	public static function dotToPath($path = '')
	{
		return implode('/', self::split($path));
	}

    /**
     * Static wrapper for $this->_parse()
     * @param string $path
     * @param array $data
     * @return mixed
     */
    public static function parse($path = '', $data = [])
    {
        return static::getInstance()->_parse($path, $data);
    }

	/**
	 * @param string $path
	 * @param array $data
	 * @return bool
	 */
	public static function exists($path = '', $data = [])
	{
		return is_string($path) && self::parse($path, $data) !== null;
	}
}