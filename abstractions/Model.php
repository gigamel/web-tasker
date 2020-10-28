<?php
namespace abstractions;

use libs\Db;

abstract class Model extends Base
{
    /**
     * @var object $db 
     */
    public $db;

    /**
     * @var string $tableName
     */
    public $tableName;

    public function __construct() {
        if (is_null($this->tableName)) {
            $this->tableName = $this->getDefaultTableName();
        }
    }

    /**
     * @param array $data
     */
    public function loadFromArray($data = [])
    {
        $data = is_array($data) ? $data : [];
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    final public function getList($limit = 100000, $offset = 0, $orderBy = '')
    {
        $result = [];

        $limit = (int) $limit;
        $offset = (int) $offset;
        
        $orderBy = is_string($orderBy) ? htmlspecialchars($orderBy) : '';
        
        $this->setDb();

        if ($limit > 0 && $offset >= 0 && !is_null($this->db)) {
            $sql = 'SELECT * FROM ' . $this->tableName;
            $sql .= empty($orderBy) ? '' : " {$orderBy}";
            $sql .= ' LIMIT :limit OFFSET :offset';
            
            $sth = $this->db->prepare($sql);
            $sth->bindValue(':limit', $limit, \PDO::PARAM_INT);
            $sth->bindValue(':offset', $offset, \PDO::PARAM_INT);
            $sth->execute();
            
            $className = static::class;
            $array = $sth->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($array as $key => $item) {
                $result[$key] = new $className;
                $result[$key]->loadFromArray($item);
            }
        }

        return $result;
    }

    /**
     * @param int $id
     * @return array
     */
    final public function getById($id = null)
    {
        $result = null;

        $id = (int) $id;
        
        $this->setDb();
        
        if ($id > 0 && !is_null($this->db)) {
            $className = static::class;
            
            $sth = $this->db->prepare('SELECT * FROM ' . $this->tableName
                . ' WHERE id = :id');
            $sth->bindValue(':id', $id, \PDO::PARAM_INT);
            $sth->execute();
            
            $array = $sth->fetch(\PDO::FETCH_ASSOC);
            if (!empty($array)) {
                $result = new $className;
                $result->loadFromArray($array);   
            }
        }

        return $result;
    }

    /**
     * @return int
     */
    final public function getAllCount()
    {
        $totalCount = 0;
        
        $this->setDb();
        
        if (!is_null($this->db)) {
            $sth = $this->db->prepare('SELECT COUNT(*)'
                . ' AS totalCount FROM ' . $this->tableName);
            $sth->execute();
            
            $totalCount = $sth->fetch(\PDO::FETCH_ASSOC)['totalCount'];
        }

        return $totalCount;
    }

    /**
     * @return string
     */
    final protected function getDefaultTableName()
    {
        return strtolower(basename(str_replace('\\', '/', static::class)));
    }

    /**
     * @param string $tableName
     */
    final public function setTableName($tableName = '')
    {
        $tableName = is_string($tableName) ? trim($tableName) : '';
        $tableName = empty($tableName) ? $this->getDefaultTableName()
            : $tableName;

        $this->tableName = $tableName;
    }

    final protected function setDb()
    {
        $this->db = is_null($this->db) ? Db::createObject()->db : $this->db;
    }

    /**
     * 
     * @param string $tableWith
     * @param string $joinType
     * @param string $condition
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function joinWith($tableWith = '', $joinType = 'LEFT JOIN',
        $condition = '', $columns = '', $orderBy = '', $limit = 10000,
        $offset = 0)
    {
        $result = [];
        
        $tableWith = is_string($tableWith) ? htmlspecialchars($tableWith) : '';
        $condition = is_string($condition) ? htmlspecialchars($condition) : '';
        $columns = is_string($columns) ? htmlspecialchars($columns) : '';
        $orderBy = is_string($orderBy) ? htmlspecialchars($orderBy) : '';
        
        switch (strtolower($joinType)) {
            case 'right join':
            case 'inner join':
                break;

            default:
                $joinType = 'left join';
                break;
        }
        
        $limit = (int) $limit;
        $offset = (int) $offset;
        
        if (!empty($tableWith) && $limit > 0 && $offset >= 0) {
            $this->setDb();

            if (!is_null($this->db)) {
                $sql = 'SELECT ';
                $sql .= empty($columns) ? '*' : $columns;
                $sql .= ' FROM ' . $this->tableName . ' ' . $joinType;
                $sql .= ' ' . $tableWith;
                $sql .= empty($condition) ? '' : ' ' . $condition;
                $sql .= empty($orderBy) ? '' : ' ' . $orderBy;
                $sql .= ' LIMIT :limit OFFSET :offset';
                
                $sth = $this->db->prepare($sql);
                $sth->bindValue(':limit', $limit, \PDO::PARAM_INT);
                $sth->bindValue(':offset', $offset, \PDO::PARAM_INT);
                $sth->execute();
                
                $className = static::class;
                $array = $sth->fetchAll(\PDO::FETCH_ASSOC);
                foreach ($array as $key => $item) {
                    $result[$key] = new $className;
                    $result[$key]->loadFromArray($item);
                }
            }
        }
        
        return $result;
    }

    public function __destruct()
    {
        $this->db = null;
    }
}