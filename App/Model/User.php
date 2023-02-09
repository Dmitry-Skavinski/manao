<?php
namespace App\Model;

class User extends Model
{
    public int $id;
    public string $login;
    public string $email;
    public string $password;
    public string $name;

    public function __construct($data)
    {
        $this->login = $data['login'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->name = $data['name'];
        if (isset($data['id'])) {
            $this->id = $data['id'];
        } else {
            $this->id = self::nextId();
        }
    }

    public static function getById(int $id)
    {
        foreach (User::all() as $index => $value) {
            if ($value['id'] === $id) {
                $key = $index;
                break;
            }
        }
        if (isset($key)) {
            return new self(User::all()[$key]);
        }
    }

    public static function getByLogin(string $login)
    {
        foreach (self::all() as $key => $record) {
            if ($record['login'] === $login) {
                return new self($record);
            }
        }
        return false;
    }
}