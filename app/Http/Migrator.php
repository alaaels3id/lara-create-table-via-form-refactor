<?php

namespace App\Http;

use Illuminate\Filesystem\Filesystem;

class Migrator
{
    public static function create($tableName)
    {
        $file_path = base_path('database/migrations/') . static::setMigrationFileName($tableName) . '.php';

        $content = static::getFileContent($tableName);

        (new Filesystem)->put($file_path, $content);
    }

    private static function setMigrationFileName($table)
    {
        return date('Y_m_d_His') . '_create_' . $table . '_table';
    }

    private static function getFileContent($table)
    {
        $content = file_get_contents(__DIR__ . '/../../stubs/migrator.stub');

        $content = str_replace('{{ table }}', $table, $content);

        return str_replace('{{ slot }}', static::getSlot(), $content);
    }

    private static function getSlot(): string
    {
        $slot = '';

        $last = array_key_last(request('columns'));

        foreach (request('columns') as $i => $name)
        {
            $attributes = request()->get('attributes')[$i];

            $_attr = '$table';

            foreach ($attributes as $j => $attribute)
            {
                $_attr .= "->" . $attribute . (($j == 0) ? '(\''.$name.'\')' : '()');
            }

            $slot .= $_attr . ';' . (($last !== $i) ? PHP_EOL : '') . "\t\t\t";
        }

        return $slot;
    }
}
