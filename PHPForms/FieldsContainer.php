<?php
/**
 * Created by PhpStorm.
 * User: Chrille
 * Date: 2015-03-23
 * Time: 14:27
 */
class FieldsContainer implements Iterator {
    private $fields = array();

    public function __construct($array = [])
    {
        if (is_array($array)) {
            $this->fields = $array;
        }
    }
    public function add_field(Field $field){
        $this->fields[] = $field;
    }
    public function rewind()
    {
        reset($this->fields);
    }

    /**
     * @return Field
     */
    public function current()
    {
        $field = current($this->fields);
        return $field;
    }

    /**
     * @return Field
     */
    public function key()
    {
        $field = key($this->fields);
        return $field;
    }
    /**
     * @return Field
     */
    public function next()
    {
        $field = next($this->fields);
        return $field;
    }
    /**
     * @return Field
     */
    public function valid()
    {
        $key = key($this->fields);
        $field = ($key !== NULL && $key !== FALSE);
        return $field;
    }

}