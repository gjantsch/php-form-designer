<?php
/**
 * Represents the form.
 *
 * @author Gustavo Jantsch <jantsch@gmail.com>
 *
 */

namespace FormDesigner;


class Form
{

    private static $methods = ['POST', 'GET', 'PATCH', 'DELETE'];

    public static function Open($name = 'form', $method = 'POST', $action = '', $multipart = null)
    {
        $method = strtoupper($method);
        $method = in_array($method, self::$methods) ? $method : 'POST';

        $options = [
            "name=\"$name\"",
            "method=\"$method\"",
            "action=\"action\"",
            "class=\"needs-validation\""
        ];

        if ($multipart) {
            $options[] = 'enctype="multipart/form-data"';
        }

        echo "<form " . implode(' ', $options) . " novalidate>";
    }

    public static function Close()
    {
        echo "</form>";
    }

    public static function renderTable(Table $table)
    {
        self::renderFields($table->getFields());
    }

    public static function renderFields(array $fields)
    {
        foreach ($fields as $field) {
            self::renderField($field);
        }
    }

    public static function renderField(Field $field, $options = null)
    {

        if ($field->form) {

            $view = __DIR__ . '/views/' . $field->input . '.php';

            if (!is_file($view)) {
                $view = __DIR__ . '/views/text.php';
            }

            include $view;
        }

    }
}