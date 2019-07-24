<?php

/**
 * Created by PhpStorm.
 * @author Gustavo Jantsch <jantsch@gmail.com>
 * @package FormDesigner
 *
 * @property boolean form
 * @property boolean visible
 * @property string label
 * @property string mask
 * @property string input
 * @property integer order
 * @property integer columns
 *
 */

namespace FormDesigner;

class Field
{

    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $flag;

    /**
     * @var string
     */
    public $collation;

    /**
     * @var boolean
     */
    public $null;

    /**
     * @var string
     */
    public $key;

    /**
     * @var mixed
     */
    public $default;

    /**
     * @var string
     */
    public $extra;

    /**
     * @var string
     */
    public $privileges;

    /**
     * @var string
     */
    public $comment;

    /**
     * @var integer
     */
    public $length;

    /**
     * @var integer
     */
    public $decimals;

    /**
     * Options and his casts.
     * @var array
     */
    private $options = [
        'form' => ['label' => 'Form', 'cast' => 'boolean'],
        'visible' => ['label' => 'Visible', 'cast' => 'boolean'],
        'name' => ['label' => 'Label', 'cast' => 'string'],
        'mask' => ['label' => 'Mask', 'cast' => 'string'],
        'input' => ['label' => 'Input', 'cast' => 'string'],
        'order' => ['label' => 'Order', 'cast' => 'integer'],
        'label' => ['label' => 'Columns', 'cast' => 'string'],
    ];

    /**
     * Options values.
     * @var array
     */
    private $values = [
        'form' => true,
        'visible' => true,
        'label' => 'Label',
        'mask' => null,
        'input' => 'text',
        'order' => null,
        'columns' => 6
    ];



    /**
     * Field constructor.
     * @param $column_definition
     */
    public function __construct($column_definition)
    {

        $options = json_decode($column_definition["Comment"], true);

        $this->name = $column_definition['Field'];
        $this->collation = $column_definition['Collation'];
        $this->null = $column_definition['Null'] == 'YES';
        $this->key = $column_definition['Key'];
        $this->default = $column_definition['Default'];
        $this->extra = $column_definition['Extra'];
        $this->comment = $column_definition['Comment'];
        $this->privileges = $column_definition['Privileges'];

        $this->setType($column_definition['Type']);

        $this->loadOptions($options);

    }

    public function loadOptions($options)
    {
        foreach ($options as $key => $value) {
            if (isset($this->values[$key])) {
                $this->values[$key] = $this->cast($key, $value);
            }
        }
    }

    public function cast($key, $value)
    {

        switch ($this->options[$key]['cast']) {
            case 'boolean':
                $value = (boolean)$value;
                break;

            case 'integer':
                $value = (int)$value;
                break;

            case 'float':
                $value = (float)$value;
                break;

            default:
                $value = (string)$value;

        }

        return $value;
    }

    public function setType($type)
    {
        $parts = explode(' ', $type);
        $type = $parts[0];
        $this->flag = $parts[1] ?? null;

        $parse = explode('(', $type);
        $this->type = $parse[0] ?? null;

        if (isset($parse[1])) {
            $value = trim($parse[1], ')');
            if ($this->type == 'float' || $this->type == 'decimal') {
                $value = explode(',', $value);
                $this->maxlength = (int)$value[0];
                $this->decimals = (int)$value[1];
            } else {
                $this->maxlength = (int)$value;
            }
        }
    }

    function __isset($name)
    {
        return isset($this->values[$name]);
    }

    function __get($name)
    {
        return $this->values[$name] ?? null;
    }

    function __set($name, $value)
    {
        if (isset($this->value[$name])) {
            $this->values[$name] = $this->cast($name, $value);
        }
    }
}