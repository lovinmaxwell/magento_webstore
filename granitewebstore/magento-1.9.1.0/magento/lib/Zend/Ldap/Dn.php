<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Ldap
 * @copyright  Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */

/**
 * Zend_Ldap_Dn provides an API for DN manipulation
 *
 * @category   Zend
 * @package    Zend_Ldap
 * @copyright  Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Ldap_Dn implements ArrayAccess
{
    const ATTR_CASEFOLD_NONE  = 'none';
    const ATTR_CASEFOLD_UPPER = 'upper';
    const ATTR_CASEFOLD_LOWER = 'lower';

    /**
     * The default case fold to use
     *
     * @var string
     */
    protected static $_defaultCaseFold = self::ATTR_CASEFOLD_NONE;

    /**
     * The case fold used for this instance
     *
     * @var string
     */
    protected $_caseFold;

    /**
     * The DN data
     *
     * @var array
     */
    protected $_dn;

    /**
     * Creates a DN from an array or a string
     *
     * @param  string|array $dn
     * @param  string|null  $caseFold
     * @return Zend_Ldap_Dn
     * @throws Zend_Ldap_Exception
     */
    public static function factory($dn, $caseFold = null)
    {
        if (is_array($dn)) {
            return self::fromArray($dn, $caseFold);
        } else if (is_string($dn)) {
            return self::fromString($dn, $caseFold);
        } else {
            /**
             * Zend_Ldap_Exception
             */
            #require_once 'Zend/Ldap/Exception.php';
            throw new Zend_Ldap_Exception(null, 'Invalid argument type for $dn');
        }
    }

    /**
     * Creates a DN from a string
     *
     * @param  string      $dn
     * @param  string|null $caseFold
     * @return Zend_Ldap_Dn
     * @throws Zend_Ldap_Exception
     */
    public static function fromString($dn, $caseFold = null)
    {
        $dn = trim($dn);
        if (empty($dn)) {
            $dnArray = array();
        } else {
            $dnArray = self::explodeDn((string)$dn);
        }
        return new self($dnArray, $caseFold);
    }

    /**
     * Creates a DN from an array
     *
     * @param  array       $dn
     * @param  string|null $caseFold
     * @return Zend_Ldap_Dn
     * @throws Zend_Ldap_Exception
     */
    public static function fromArray(array $dn, $caseFold = null)
    {
         return new self($dn, $caseFold);
    }

    /**
     * Constructor
     *
     * @param array       $dn
     * @param string|null $caseFold
     */
    protected function __construct(array $dn, $caseFold)
    {
        $this->_dn = $dn;
        $this->setCaseFold($caseFold);
    }

    /**
     * Gets the RDN of the current DN
     *
     * @param  string $caseFold
     * @return array
     * @throws Zend_Ldap_Exception if DN has no RDN (empty array)
     */
    public function getRdn($caseFold = null)
    {
        $caseFold = self::_sanitizeCaseFold($caseFold, $this->_caseFold);
        return self::_caseFoldRdn($this->get(0, 1, $caseFold), null);
    }

    /**
     * Gets the RDN of the current DN as a string
     *
     * @param  string $caseFold
     * @return string
     * @throws Zend_Ldap_Exception if DN has no RDN (empty array)
     */
    public function getRdnString($caseFold = null)
    {
        $caseFold = self::_sanitizeCaseFold($caseFold, $this->_caseFold);
        return self::implodeRdn($this->getRdn(), $caseFold);
    }

    /**
     * Get the parent DN $levelUp levels up the tree
     *
     * @param  int $levelUp
     * @return Zend_Ldap_Dn
     */
    public function getParentDn($levelUp = 1)
    {
        $levelUp = (int)$levelUp;
        if ($levelUp < 1 || $levelUp >= count($this->_dn)) {
            /**
             * Zend_Ldap_Exception
             */
            #require_once 'Zend/Ldap/Exception.php';
            throw new Zend_Ldap_Exception(null, 'Cannot retrieve parent DN with given $levelUp');
        }
        $newDn = array_slice($this->_dn, $levelUp);
        return new self($newDn, $this->_caseFold);
    }

    /**
     * Get a DN part
     *
     * @param  int    $index
     * @param  int    $length
     * @param  string $caseFold
     * @return array
     * @throws Zend_Ldap_Exception if index is illegal
     */
    public function get($index, $length = 1, $caseFold = null)
    {
        $caseFold = self::_sanitizeCaseFold($caseFold, $this->_caseFold);
        $this->_assertIndex($index);
        $length = (int)$length;
        if ($length <= 0) {
            $length = 1;
        }
        if ($length === 1) {
            return self::_caseFoldRdn($this->_dn[$index], $caseFold);
        }
        else {
            return self::_caseFoldDn(array_slice($this->_dn, $index, $length, false), $caseFold);
        }
    }

    /**
     * Set a DN part
     *
     * @param  int   $index
     * @param  array $value
     * @return Zend_Ldap_Dn Provides a fluent interface
     * @throws Zend_Ldap_Exception if index is illegal
     */
    public function set($index, array $value)
    {
        $this->_assertIndex($index);
        self::_assertRdn($value);
        $this->_dn[$index] = $value;
        return $this;
    }

    /**
     * Remove a DN part
     *
     * @param  int $index
     * @param  int $length
     * @return Zend_Ldap_Dn Provides a fluent interface
     * @throws Zend_Ldap_Exception if index is illegal
     */
    public function remove($index, $length = 1)
    {
        $this->_assertIndex($index);
        $length = (int)$length;
        if ($length <= 0) {
            $length = 1;
        }
        array_splice($this->_dn, $index, $length, null);
        return $this;
    }

    /**
     * Append a DN part
     *
     * @param  array $value
     * @return Zend_Ldap_Dn Provides a fluent interface
     */
    public function append(array $value)
    {
        self::_assertRdn($value);
        $this->_dn[] = $value;
        return $this;
    }

    /**
     * Prepend a DN part
     *
     * @param  array $value
     * @return Zend_Ldap_Dn Provides a fluent interface
     */
    public function prepend(array $value)
    {
        self::_assertRdn($value);
        array_unshift($this->_dn, $value);
        return $this;
    }

    /**
     * Insert a DN part
     *
     * @param  int   $index
     * @param  array $value
     * @return Zend_Ldap_Dn Provides a fluent interface
     * @throws Zend_Ldap_Exception if index is illegal
     */
    public function insert($index, array $value)
    {
        $this->_assertIndex($index);
        self::_assertRdn($value);
        $first = array_slice($this->_dn, 0, $index + 1);
        $second = array_slice($this->_dn, $index + 1);
        $this->_dn = array_merge($first, array($value), $second);
        return $this;
    }

    /**
     * Assert index is correct and usable
     *
     * @param  mixed $index
     * @return boolean
     * @throws Zend_Ldap_Exception
     */
    protected function _assertIndex($index)
    {
        if (!is_int($index)) {
            /**
             * Zend_Ldap_Exception
             */
            #require_once 'Zend/Ldap/Exception.php';
            throw new Zend_Ldap_Exception(null, 'Parameter $index must be an integer');
        }
        if ($index < 0 || $index >= count($this->_dn)) {
            /**
             * Zend_Ldap_Exception
             */
            #require_once 'Zend/Ldap/Exception.php';
            throw new Zend_Ldap_Exception(null, 'Parameter $index out of bounds');
        }
        return true;
    }

    /**
     * Assert if value is in a correct RDN format
     *
     * @param  array $value
     * @return boolean
     * @throws Zend_Ldap_Exception
     */
    protected static function _assertRdn(array $value)
    {
        if (count($value)<1) {
            /**
             * Zend_Ldap_Exception
             */
            #require_once 'Zend/Ldap/Exception.php';
            throw new Zend_Ldap_Exception(null, 'RDN Array is malformed: it must have at least one item');
        }

        foreach (array_keys($value) as $key) {
            if (!is_string($key)) {
                /**
                 * Zend_Ldap_Exception
                 */
                #require_once 'Zend/Ldap/Exception.php';
                throw new Zend_Ldap_Exception(null, 'RDN Array is malformed: it must use string keys');
            }
        }
    }

    /**
     * Sets the case fold
     *
     * @param string|null $caseFold
     */
    public function setCaseFold($caseFold)
    {
        $this->_caseFold = self::_sanitizeCaseFold($caseFold, self::$_defaultCaseFold);
    }

    /**
     * Return DN as a string
     *
     * @param  string $caseFold
     * @return string
     * @throws Zend_Ldap_Exception
     */
    public function toString($caseFold = null)
    {
        $caseFold = self::_sanitizeCaseFold($caseFold, $this->_caseFold);
        return self::implodeDn($this->_dn, $caseFold);
    }

    /**
     * Return DN as an array
     *
     * @param  string $caseFold
     * @return array
     */
    public function toArray($caseFold = null)
    {
        $caseFold = self::_sanitizeCaseFold($caseFold, $this->_caseFold);

        if ($caseFold === self::ATTR_CASEFOLD_NONE) {
            return $this->_dn;
        } else {
            return self::_caseFoldDn($this->_dn, $caseFold);
        }
    }

    /**
     * Do a case folding on a RDN
     *
     * @param  array  $part
     * @param  string $caseFold
     * @return array
     */
    protected static function _caseFoldRdn(array $part, $caseFold)
    {
        switch ($caseFold) {
            case self::ATTR_CASEFOLD_UPPER:
                return array_change_key_case($part, CASE_UPPER);
            case self::ATTR_CASEFOLD_LOWER:
                return array_change_key_case($part, CASE_LOWER);
            case self::ATTR_CASEFOLD_NONE:
            default:
                return $part;
        }
    }

    /**
     * Do a case folding on a DN ort part of it
     *
     * @param  array  $dn
     * @param  string $caseFold
     * @return array
     */
    protected static function _caseFoldDn(array $dn, $caseFold)
    {
        $return = array();
        foreach ($dn as $part) {
            $return[] = self::_caseFoldRdn($part, $caseFold);
        }
        return $return;
    }

    /**
     * Cast to string representation {@see toString()}
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * Required by the ArrayAccess implementation
     *
     * @param  int $offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        $offset = (int)$offset;
        if ($offset < 0 || $offset >= count($this->_dn)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Proxy to {@see get()}
     * Required by the ArrayAccess implementation
     *
     * @param  int $offset
     * @return array
     */
     public function offsetGet($offset)
     {
         return $this->get($offset, 1, null);
     }

     /**
      * Proxy to {@see set()}
      * Required by the ArrayAccess implementation
      *
      * @param int   $offset
      * @param array $value
      */
     public function offsetSet($offset, $value)
     {
         $this->set($offset, $value);
     }

     /**
      * Proxy to {@see remove()}
      * Required by the ArrayAccess implementation
      *
      * @param int $offset
      */
     public function offsetUnset($offset)
     {
         $this->remove($offset, 1);
     }

    /**
     * Sets the default case fold
     *
     * @param string $caseFold
     */
    public static function setDefaultCaseFold($caseFold)
    {
        self::$_defaultCaseFold = self::_sanitizeCaseFold($caseFold, self::ATTR_CASEFOLD_NONE);
    }

    /**
     * Sanitizes the case fold
     *
     * @param  string $caseFold
     * @return string
     */
    protected static function _sanitizeCaseFold($caseFold, $default)
    {
        switch ($caseFold) {
            case self::ATTR_CASEFOLD_NONE:
            case self::ATTR_CASEFOLD_UPPER:
            case self::ATTR_CASEFOLD_LOWER:
                return $caseFold;
                break;
            default:
                return $default;
                break;
        }
    }

    /**
     * Escapes a DN value according to RFC 2253
     *
     * Escapes the given VALUES according to RFC 2253 so that they can be safely used in LDAP DNs.
     * The characters ",", "+", """, "\", "<", ">", ";", "#", " = " with a special meaning in RFC 2252
     * are preceeded by ba backslash. Control characters with an ASCII code < 32 are represented as \hexpair.
     * Finally all leading and trailing spaces are converted to sequences of \20.
     * @see Net_LDAP2_Util::escape_dn_value() from Benedikt Hallinger <beni@php.net>
     * @link http://pear.php.net/package/Net_LDAP2
     * @author Benedikt Hallinger <beni@php.net>
     *
     * @param  string|array $values An array containing the DN values that should be escaped
     * @return array The array $values, but escaped
     */
    public static function escapeValue($values = array())
    {
        /**
         * @see Zend_Ldap_Converter
         */
        #require_once 'Zend/Ldap/Converter.php';

        if (!is_array($values)) $values = array($values);
        foreach ($values as $key => $val) {
            // Escaping of filter meta characters
            $val = str_replace(array('\\', ',', '+', '"', '<', '>', ';', '#', '=', ),
                array('\\\\', '\,', '\+', '\"', '\<', '\>', '\;', '\#', '\='), $val);
            $val = Zend_Ldap_Converter::ascToHex32($val);

            // Convert all leading and trailing spaces to sequences of \20.
            if (preg_match('/^(\s*)(.+?)(\s*)$/', $val, $matches)) {
                $val = $matches[2];
                for ($i = 0; $i<strlen($matches[1]); $i++) {
                    $val = '\20' . $val;
                }
                for ($i = 0; $i<strlen($matches[3]); $i++) {
                    $val = $val . '\20';
                }
            }
            if (null === $val) $val = '\0';  // apply escaped "null" if string is empty
            $values[$key] = $val;
        }
        return (count($values) == 1) ? $values[0] : $values;
    }

    /**
     * Undoes the conversion done by {@link escapeValue()}.
     *
     * Any escape sequence starting with a baskslash - hexpair or special character -
     * will be transformed back to the corresponding character.
     * @see Net_LDAP2_Util::escape_dn_value() from Benedikt Hallinger <beni@php.net>
     * @link http://pear.php.net/package/Net_LDAP2
     * @author Benedikt Hallinger <beni@php.net>
     *
     * @param  string|array $values Array of DN Values
     * @return array Same as $values, but unescaped
     */
    public static function unescapeValue($values = array())
    {
        /**
         * @see Zend_Ldap_Converter
         */
        #require_once 'Zend/Ldap/Converter.php';

        if (!is_array($values)) $values = array($values);
        foreach ($values as $key => $val) {
            // strip slashes from special chars
            $val = str_replace(array('\\\\', '\,', '\+', '\"', '\<', '\>', '\;', '\#', '\='),
                array('\\', ',', '+', '"', '<', '>', ';', '#', '