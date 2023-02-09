<?php
namespace App\Model;
abstract class Model
{
    protected int $id;
    public function delete()
    {
        $database = json_decode(file_get_contents(self::source()), true);
        $table = $database[self::table()];
        foreach ($table as $key => $value) {
            if ($value['id'] === $this->id) {
                $id = $key;
                break;
            }
        }
        if (isset($id)) {
            unset($database[self::table()][$id]);
        }

        $database[self::table()] = array_values($database[self::table()]);
        file_put_contents(self::source(), json_encode($database));
    }
    public function save()
    {
        $database = json_decode(file_get_contents(self::source()), true);
        $table = $database[self::table()];
        foreach ($table as $key => $value) {
            if ($value['id'] === $this->id) {
                $id = $key;
                break;
            }
        }
        $record = [];
        foreach ($this as $key => $value) {
            $record[$key] = $value;
        }

        if (isset($id)) {
            $database[self::table()][$id] = $record;
        } else {
            $database[self::table()][] = $record;
            $database['nextId'][self::table()] = self::nextId() + 1;
        }
        file_put_contents(self::source(), json_encode($database));
    }

    protected static function table(): string
    {
        $path = explode('\\', get_called_class());
        return strtolower(array_pop($path)) . 's';

    }
    protected static function source(): string
    {
        return $GLOBALS['basePath'] . 'database.json';
    }

    public static function all(): array
    {
        $database = json_decode(file_get_contents(self::source()), true);
        if (self::table() == 'models') {
            return $database;
        }
        return $database[self::table()];
    }

    public static function nextId()
    {
        return json_decode(file_get_contents(self::source()), true)['nextId'][self::table()];
    }
}