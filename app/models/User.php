<?php
namespace app\models;

use abstractions\Model;

class User extends Model
{
    /**
     * @var string $confirmPassword
     */
    public $confirmPassword;

    /**
     * @var string $email
     */
    public $email;

    /**
     * @var string $hash
     */
    public $hash;

    /**
     * @var int $id
     */
    public $id;

    /**
     * @var string $login
     */
    public $login;

    /**
     * @var string $password
     */
    public $password;

    public function calculateHash()
    {
        $this->hash = md5($this->login . ':' . $this->password);
    }

    /**
     * @return array
     */
    public function getByHash()
    {
        $result = [];

        if (is_string($this->login) && is_string($this->password)) {
            $this->calculateHash();
        }
        
        if (!empty($this->hash)) {
            $this->setDb();
            
            if (!is_null($this->db)) {
                $sth = $this->db->prepare('SELECT * FROM ' . $this->tableName
                     . ' WHERE hash = :hash AND login = :login LIMIT 1');
                $sth->bindValue(':hash', $this->hash, \PDO::PARAM_STR);
                $sth->bindValue(':login', $this->login, \PDO::PARAM_STR);
                $sth->execute();
                
                $className = static::class;
                $array = $sth->fetch(\PDO::FETCH_ASSOC);
                if (!empty($array)) {
                    $result = new $className;
                    $result->loadFromArray($array);
                }
            }
        }

        return $result;
    }

    /**
     * @return int
     */
    public function insert()
    {
        $this->calculateHash();
        
        $this->setDb();
        
        if (!is_null($this->db)) {
            $sth = $this->db->prepare('INSERT INTO ' . $this->tableName
                . ' (login, email, hash) VALUES'
                . ' (:login, :email, :hash)');
            $sth->bindValue(':login', $this->login, \PDO::PARAM_STR);
            $sth->bindValue(':email', $this->email, \PDO::PARAM_STR);
            $sth->bindValue(':hash', $this->hash, \PDO::PARAM_STR);
            $sth->execute();
            
            return $this->db->lastInsertId();
        }
        
        return null;
    }

    public function delete()
    {
        $id = (int) $this->id;
        if ($id > 0) {
            $this->setDb();
            
            if (!is_null($this->db)) {
                $sth = $this->db->prepare('DELETE FROM ' . $this->tableName
                    . ' WHERE id = :id');
                $sth->bindValue(':id', $id, \PDO::PARAM_INT);
                $sth->execute();
            }
        }
    }

    public function update()
    {
        $this->calculateHash();
        
        $id = (int) $this->id;
        if ($id > 0) {
            $this->setDb();
            
            if (!is_null($this->db)) {
                $sth = $this->db->prepare('UPDATE ' . $this->tableName . ' SET'
                    . ' login = :login, email = :email, hash = :hash'
                    . ' WHERE id = :id');
                $sth->bindValue(':login', $this->login, \PDO::PARAM_STR);
                $sth->bindValue(':email', $this->email, \PDO::PARAM_STR);
                $sth->bindValue(':hash', $this->hash, \PDO::PARAM_STR);
                $sth->bindValue(':id', $id, \PDO::PARAM_INT);
                $sth->execute();
            }
        }
    }
}