<?php
namespace app\models;

use abstractions\Model;

class Task extends Model
{
    /**
     * @var string $description
     */
    public $description;

    /**
     * @var string $email
     */
    public $email;

    /**
     * @var int $id
     */
    public $id;

    /**
     * @var int $status
     */
    public $status = 1;

    /**
     * @var array $statuses
     */
    public $statuses = [
        0 => 'done',
        1 => 'on work'
    ];

    /**
     * @var string $userName
     */
    public $userName;

    /**
     * @return int
     */
    public function insert()
    {
        $this->setDb();
        
        if (!is_null($this->db)) {
            $sth = $this->db->prepare('INSERT INTO ' . $this->tableName
                . ' (description, userName, email) VALUES'
                . ' (:description, :userName, :email)');
            $sth->bindValue(':description', $this->description, \PDO::PARAM_STR);
            $sth->bindValue(':userName', $this->userName, \PDO::PARAM_STR);
            $sth->bindValue(':email', $this->email, \PDO::PARAM_STR);
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
        $id = (int) $this->id;
        if ($id > 0) {
            $this->setDb();
            
            if (!is_null($this->db)) {
                $sth = $this->db->prepare('UPDATE ' . $this->tableName . ' SET'
                    . ' description = :description, status = :status'
                    . ' WHERE id = :id');
                $sth->bindValue(':description', $this->description, \PDO::PARAM_STR);
                $sth->bindValue(':status', $this->status, \PDO::PARAM_INT);
                $sth->bindValue(':id', $id, \PDO::PARAM_INT);
                $sth->execute();
            }
        }
    }
}