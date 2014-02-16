<?php
class csCatalog extends xPDOSimpleObject {
     /**
     * An array of field names that have not been loaded from the source.
     * @var array
     * @access public
     */
    public $_lazy= array ();
  
     /**
     * Load persistent data from the source for the field(s) indicated.
     *
     * @access protected
     * @param string|array $fields A field name or array of field names to load
     * from the data source.
     */
    protected function _loadFieldData($fields) {
        if (!is_array($fields)) $fields= array($fields);
        else $fields= array_values($fields);
        $criteria= $this->xpdo->newQuery($this->_class, $this->getPrimaryKey());
        $criteria->select($fields);
        if ($rows= xPDOObject :: _loadRows($this->xpdo, $this->_class, $criteria)) {
            $row= $rows->fetch(PDO::FETCH_ASSOC);
            $rows->closeCursor();
            $this->fromArray($row, '', false, true);
            $this->_lazy= array_diff($this->_lazy, $fields);
        }
    }
    
    /**
     * Get a field propety value (or a set of values) by the field key(s) or name(s).
     *
     * Warning: do not use the $format parameter if retrieving multiple values of
     * different types, as the format string will be applied to all types, most
     * likely with unpredictable results.  Optionally, you can supply an associate
     * array of format strings with the field key as the key for the format array.
     *
     * @param string|array $k A string (or an array of strings) representing the field
     * key or name.
     * @param string|array $format An optional variable (or an array of variables) to
     * format the return value(s).
     * @param mixed $formatTemplate An additional optional variable that can be used in
     * formatting the return value(s).
     * @return mixed The value(s) of the field(s) requested.
     */
    public function getPropKey($k, $format = null, $formatTemplate= null) {
        $value= null;
        if (is_array($k)) {
            foreach ($k as $key) {
                if (array_key_exists($key, $this->_fields)) {
                    if (is_array($format) && isset ($format[$key])) {
                        $formatTpl= null;
                        if (is_array ($formatTemplate) && isset ($formatTemplate[$key])) {
                            $formatTpl= $formatTemplate[$key];
                        }
                        $value[$key]= $this->get($key, $format[$key], $formatTpl);
                    } elseif (!empty ($format) && is_string($format)) {
                        $value[$key]= $this->get($key, $format, $formatTemplate);
                    } else {
                        $value[$key]= $this->get($key);
                    }
                }
            }
        } elseif (is_string($k) && !empty($k)) {
            if (array_key_exists($k, $this->_fields)) {
                if ($this->isLazy($k)) {
                    $this->_loadFieldData($k);
                }
                $dbType= $this->_getDataType($k);
                $fieldType= $this->_getPHPType($k);
                $value= $this->_fields[$k];
                if ($value !== null) {
                    switch ($fieldType) {
                        case 'boolean' :
                            $value= (boolean) $value;
                            break;
                        case 'integer' :
                            $value= intval($value);
                            if (is_string($format) && !empty ($format)) {
                                if (strpos($format, 're:') === 0) {
                                    if (!empty ($formatTemplate) && is_string($formatTemplate)) {
                                        $value= preg_replace(substr($format, 3), $formatTemplate, $value);
                                    }
                                } else {
                                    $value= sprintf($format, $value);
                                }
                            }
                            break;
                        case 'float' :
                            $value= (float) $value;
                            if (is_string($format) && !empty ($format)) {
                                if (strpos($format, 're:') === 0) {
                                    if (!empty ($formatTemplate) && is_string($formatTemplate)) {
                                        $value= preg_replace(substr($format, 3), $formatTemplate, $value);
                                    }
                                } else {
                                    $value= sprintf($format, $value);
                                }
                            }
                            break;
                        case 'timestamp' :
                        case 'datetime' :
                            if (preg_match('/int/i', $dbType)) {
                                $ts= intval($value);
                            } elseif (in_array($value, $this->xpdo->driver->_currentTimestamps)) {
                                $ts= time();
                            } else {
                                $ts= strtotime($value);
                            }
                            if ($ts !== false && !empty($value)) {
                                if (is_string($format) && !empty ($format)) {
                                    if (strpos($format, 're:') === 0) {
                                        $value= date('Y-m-d H:M:S', $ts);
                                        if (!empty ($formatTemplate) && is_string($formatTemplate)) {
                                            $value= preg_replace(substr($format, 3), $formatTemplate, $value);
                                        }
                                    } elseif (strpos($format, '%') === false) {
                                        $value= date($format, $ts);
                                    } else {
                                        $value= strftime($format, $ts);
                                    }
                                } else {
                                    $value= strftime('%Y-%m-%d %H:%M:%S', $ts);
                                }
                            }
                            break;
                        case 'date' :
                            if (preg_match('/int/i', $dbType)) {
                                $ts= intval($value);
                            } elseif (in_array($value, $this->xpdo->driver->_currentDates)) {
                                $ts= time();
                            } else {
                                $ts= strtotime($value);
                            }
                            if ($ts !== false && !empty($value)) {
                                if (is_string($format) && !empty ($format)) {
                                    if (strpos($format, 're:') === 0) {
                                        $value= strftime('%Y-%m-%d', $ts);
                                        if (!empty ($formatTemplate) && is_string($formatTemplate)) {
                                            $value= preg_replace(substr($format, 3), $formatTemplate, $value);
                                        }
                                    } elseif (strpos($format, '%') === false) {
                                        $value= date($format, $ts);
                                    } elseif ($ts !== false) {
                                        $value= strftime($format, $ts);
                                    }
                                } else {
                                    $value= strftime('%Y-%m-%d', $ts);
                                }
                            }
                            break;
                        case 'array' :
                            if (is_string($value)) {
                                $value= unserialize($value);
                            }
                            break;
                        case 'json' :
                            if (is_string($value) && strlen($value) > 1) {
                                $value= $this->xpdo->fromJSON($value, true);
                            }
                            break;
                        default :
                            if (is_string($format) && !empty ($format)) {
                                if (strpos($format, 're:') === 0) {
                                    if (!empty ($formatTemplate) && is_string($formatTemplate)) {
                                        $value= preg_replace(substr($format, 3), $formatTemplate, $value);
                                    }
                                } else {
                                    $value= sprintf($format, $value);
                                }
                            }
                            break;
                    }
                }
            }
        }
        return $value;
    }
}