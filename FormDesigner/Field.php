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
     * @var array
     */
    public $enum;

    /**
     * @var mixed
     */
    public $value;

    /**
     * Options and his casts.
     * @var array
     */
    private $options = [
        'form' => ['label' => 'Form', 'cast' => 'boolean', 'value' => true],
        'visible' => ['label' => 'Visible', 'cast' => 'boolean', 'value' => true],
        'required' => ['label' => 'Required', 'cast' => 'boolean', 'value' => true],
        'readonly' => ['label' => 'Readonly', 'cast' => 'boolean', 'value' => true],
        'label' => ['label' => 'Label', 'cast' => 'string', 'value' => ''],
        'bottom' => ['label' => 'Bottom line', 'cast' => 'string', 'value' => ''],
        'placeholder' => ['label' => 'Placeholder', 'cast' => 'string', 'value' => ''],
        'mask' => ['label' => 'Mask', 'cast' => 'string', 'value' => null],
        'maxlen' => ['label' => 'Show Max Length', 'cast' => 'boolean', 'value' => false],
        'input' => ['label' => 'Input', 'cast' => 'string', 'value' => 'text'],
        'order' => ['label' => 'Order', 'cast' => 'integer', 'value' => null],
        'columns' => ['label' => 'Columns', 'cast' => 'string', 'value' => 6],
    ];

    private static $optionsKeys = [
        'form',
        'visible',
        'required',
        'readonly',
        'label',
        'placeholder',
        'bottom',
        'mask',
        'maxlen',
        'input',
        'order',
        'columns'
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

        if ($this->default == 'NULL') {
            $this->value = null;
        } else {
            $this->value = $this->default;
        }

    }

    public function loadOptions($options)
    {
        if (is_array($options)) {

            foreach ($this->options as $key => $value) {
                if (isset($options[$key])) {
                    $this->options[$key]['value'] = $this->cast($key, $options[$key]);
                } else {
                    if ($this->options[$key]['cast'] == 'boolean') {
                        $this->options[$key]['value'] = false;
                    }
                }
            }

        }
    }

    public function cast($key, $value)
    {

        switch ($this->options[$key]['cast']) {
            case 'boolean':
                $value = $value=== 'false' ? false : (boolean)$value;
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
            } elseif ($this->type == 'enum') {
                $this->enum = explode(',', $value);
                array_walk($this->enum, function(&$value, $key) {
                    $value = trim($value, "'");
                });
            } else {
                $this->maxlength = (int)$value;
            }
        }
    }

    public function getOptions($json=true)
    {
        return $json ? json_encode($this->options) : $this->options;
    }

    public static function getOptionsKeys()
    {
        return self::$optionsKeys;
    }

    function __isset($name)
    {
        return isset($this->options[$name]);
    }

    function __get($name)
    {
        return $this->options[$name]['value'] ?? null;
    }

    function __set($name, $value)
    {
        if (isset($this->options[$name])) {
            $this->options[$name]['value'] = $this->cast($name, $value);
        }
    }
}