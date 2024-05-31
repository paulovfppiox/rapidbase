<?php
namespace App\Entity;

use \App\Db\Database;
use \PDO;

class Author
{
        public $id;
    public $name;


    private const TABLE_NAME = 'Author';

    public function __construct(array $data = null) {
        if ($data != null) {
            $this->setData($data);
        }
    }

    public function setData(array $data) {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public function insert(array $data = null) {
        if ($data != null) {
            $this->setData($data);
        }

        $obDatabase = Database::getInstance(self::TABLE_NAME);
        $this->id = $obDatabase->insert(get_object_vars($this));
        return true;
    }

    public function update(array $data = null) {
        if ($data != null) {
            $this->setData($data);
        }

        return (Database::getInstance(self::TABLE_NAME)->update('id = ' . $this->id, get_object_vars($this)));
    }

    public function delete(array $data = null) {
        if ($data != null) {
            $this->setData($data);
        }
        return (Database::getInstance(self::TABLE_NAME)->delete('id = ' . $this->id));
    }

    public static function getAuthorById($id) {
        $obj = (Database::getInstance(self::TABLE_NAME)->select('id = ' . $id)->fetchObject(self::class));
        return $obj ?: null;
    }

    public static function getAuthorByField($field, $value) {
        $obj = (Database::getInstance(self::TABLE_NAME)->select("$field = " . $value)->fetchObject(self::class));
        return $obj ?: null;
    }

    public static function getAllAuthors($where = null, $order = null, $limit = null) {
        return (Database::getInstance(self::TABLE_NAME)->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class));
    }

    public function toJson() {
        return json_encode(get_object_vars($this));
    }
}
?>
