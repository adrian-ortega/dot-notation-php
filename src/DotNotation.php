<?php

namespace AOD;

class DotNotation
{
    /**
     * Checks to see if a key is a dot notation key
     * @param string $name
     * @return bool
     */
    protected function _check($name)
    {
        return strpos($name, '.') !== false;
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
     * Static wrapper for $this->_parse()
     * @param string $path
     * @param array $data
     * @return mixed
     */
    public static function parse($path = '', $data = [])
    {
        $dot = new static;
        return $dot->_parse($path, $data);
    }
}