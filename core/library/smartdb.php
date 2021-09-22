<?php
return $this->smartDB = new class(){
    public $version = '1.0';
    /**
     * @var PDO Zmienna z połączeniem z bazą danych
     */
    private $connect;
    /**
     * @var array Tablica z JOIN
     */
    private $join;
    /**
     * @var array Dodatkowe dane where
     */
    private $where;
    /**
     * @var string Ostatnio wykonane zapytanie SQL
     */
    private $_lastQuery;
    /**
     * @var string Treść ostatniego błędu
     */
    private $_lastError;

    /**
     * Łączenie z bazą danych
     * @param string $username Użytkowniik
     * @param string $password Hasło
     * @param string $dbName Nazwa bazy
     * @param string $host Host
     * @param string $charset Kodowanie znaków
     * @return bool
     * @throws ErrorException
     */
    public function connect(string $username, string $password, string $dbName, string $host = 'localhost', string $charset = 'utf8') : bool {
        try {
            $connect = new PDO('mysql:host=' . $host . ';dbname=' . $dbName . '', $username, $password);

            $connect->exec("SET NAMES " . $charset);
            $connect->exec("SET CHARACTER SET " . $charset);

            $this->connect = $connect;
            return true;
        } catch (PDOException $error) {
            throw new ErrorException('Database connect failed: ' . $error->getMessage());
        }
    }

    //Optional

    /**
     * Dane JOIN
     * @param $data
     * @return $this
     */
    public function join($data) : LibrarySmartDB {
        $this->join = $data;

        return $this;
    }

    /**
     * Dodanie dodatkowych parametrów where
     * @param array $where
     * @return $this
     */
    public function where(array $where) : LibrarySmartDB {
        $this->where = $where;

        return $this;
    }

    //SQL

    /**
     * Wykonanie selecta
     * @param $tableName
     * @param array $where
     * @param string|array $column
     * @return array|false
     */
    public function select(string $tableName, array $where = [], string|array $column = '*') {
        $sql = $this->_generateSql('select', $tableName, $column, $where);

        try {
            $prepare = $this->connect->prepare($sql);
            $prepare->execute();

            return $this->_dataToArray($prepare->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            $this->_lastError = $e;

            return false;
        }
    }

    /**
     * Dodanie danych do tabeli
     * @param string $tableName
     * @param array $data
     * @return bool
     */
    public function insert(string $tableName, array $data) : bool {
        if ($this->where) {
            $count = $this->count($tableName, $this->where);

            if ($count > 0) {
                return $this->update($tableName, $data, $this->where) > 0;
            }
        }

        $sql = $this->_generateSql('insert', $tableName, [], [], $data);

        try {
            $prepare = $this->connect->prepare($sql);

            foreach ($data as $name => $value) {
                $prepare->bindValue(':' . $name, $value);
            }

            $prepare->execute();

            return $prepare->rowCount();
        } catch (Exception $e) {
            $this->_lastError = $e;

            return false;
        }
    }

    /**
     * Aktualizacja danych
     * @param $tableName
     * @param $data
     * @param array $where
     * @return bool|int
     */
    public function update(string $tableName, $data, array $where = []) : bool|int {
        $sql = $this->_generateSql('update', $tableName, [], $where, $data);

        try {
            $prepare = $this->connect->prepare($sql);

            foreach ($data as $name => $value) {
                $prepare->bindValue(':' . $name, $value);
            }

            $prepare->execute();

            return $prepare->rowCount();
        } catch (Exception $e) {
            $this->_lastError = $e;

            return false;
        }
    }

    /**
     * Zliczenie rekordów z tabeli
     * @param string $tableName
     * @param array $where
     * @return int
     */
    public function count(string $tableName, array $where = []) : int {
        $sql = $this->_generateSql('count', $tableName, [], $where, []);

        try {
            $prepare = $this->connect->prepare($sql);
            $prepare->execute();

            return $prepare->fetch(PDO::FETCH_ASSOC)['count'];
        } catch (Exception $e) {
            $this->_lastError = $e;

            return false;
        }
    }

    /**
     * Wykonanie skryptu SQL
     * @param string $sql
     * @return false|mixed
     */
    public function query(string $sql) {
        try {
            $prepare = $this->connect->prepare($sql);
            $prepare->execute();

            return $prepare->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $this->_lastError = $e;

            return false;
        }
    }

    //Adding

    /**
     * @return string Ostatnie zapytanie SQL
     */
    public function getLastQuery() {
        return $this->_lastQuery;
    }

    /**
     * @return string Ostatni błąd PDO
     */
    public function getLastError() {
        return $this->_lastError;
    }

    //Private

    /**
     * Generowanie SQL
     * @param string $type
     * @param string $tableName
     * @param array|string $column
     * @param array $where
     * @param array $data
     * @return string
     */
    private function _generateSql(string $type, string $tableName, array|string $column = [], array $where = [], array $data = []) {
        $column = $this->_generateColumn((array)$column);
        $useWhere = true;
        $useJoin = false;

        switch ($type) {
            case 'select':
                $useJoin = true;
                $sql = 'SELECT ' . $column . ' FROM `' . $tableName . '`';
                break;
            case 'update':
                $sql = 'UPDATE ' . $tableName . ' SET ';

                $set = [];

                foreach ($data as $name => $value) {
                    $set[] = '`' . $name . '` = :' . $name . '';
                }

                $sql .= implode(', ', $set);

                break;
            case 'insert':
                $useWhere = false;
                $sql = 'INSERT INTO ' . $tableName . ' (`' . implode('`, `', array_keys($data)) . '`) VALUES (:' . implode(', :', array_keys($data)) . ')';
                break;
            case 'count':
                $sql = 'SELECT count(*) as `count` FROM ' . $tableName;
                break;
        }

        if ($useJoin) {
            $join = $this->_generateJoin();
            $sql .= ' ' . $join;
        }

        if ($useWhere) {
            $whereString = $this->_generateWhere($where + (array)$this->where);

            if (!empty($whereString)) {
                $sql .= ' WHERE ' . $whereString;
            }
        }

        $this->_lastQuery = $sql;
        $this->join = [];
        $this->where = [];
        return $sql;
    }

    /**
     * Generowanie kolumn
     * @param array $columns
     * @param string|bool $tableName
     * @return string
     */
    private function _generateColumn(array $columns) {
        if ($columns === ['*'] && $this->join) {
            $columns = [];
            $tables = [$this->tableName];

            foreach ($this->join as $joinKey => $joinData) {
                if (str_contains($joinKey, 'INNER JOIN')) {
                    $tables[] = trim(str_replace('INNER JOIN', '', $joinKey));
                } elseif (str_contains($joinKey, 'LEFT JOIN')) {
                        $tables[] = trim(str_replace('LEFT JOIN', '', $joinKey));
                    }
            }

            foreach ($tables as $tName) {
                $tableList = $this->connect->query('DESCRIBE `' . $tName . '`')->fetchAll(PDO::FETCH_ASSOC);

                foreach ($tableList as $name) {
                    $columns[] = $tName . '.`' . $name['Field'] . '` as `' . $tName . '.' . $name['Field'] . '`';
                }
            }
        } else {
            foreach ($columns as $id => $column) {
                if ($column === '*') {
                    continue;
                }

                if (str_contains($column, '.')) {
                    $column = explode('.', $column);
                    $columns[$id] = $column[0] . ".`" . trim(str_replace("'", "\'", $column[1])) . "` as `" . implode('.', $column) . "`";
                } else {
                    $columns[$id] = "`" . trim(str_replace("'", "\'", $column)) . "`" . ($this->tableName ? ' as `' . ($this->tableName . '.' . $column) . '`' : '');
                }
            }
        }

        return implode(', ', $columns);
    }

    //TODO: do przepisania
    /**
     * Generowanie where
     * @param array $where
     * @param string $implode
     * @param bool $isolate
     * @return string
     */
    private function _generateWhere(array $where, string $implode = 'AND', bool $isolate = false) {
        $whereArray = [];

        foreach ($where as $columnName => $whereValue) {
            $char = ' = ';
            $addToArray = true;

            if (is_int($columnName) && is_array($whereValue)) {
                if (is_array($whereValue) && count($whereValue) === 3 && count($whereValue) == count($whereValue, COUNT_RECURSIVE)) {
                    $columnName = $whereValue[0];
                    $char = ' ' . $whereValue[1] . ' ';
                    $whereValue = !is_int($whereValue[2]) ? ("'" . str_replace("'", '\'', $whereValue[2]) . "'") : $whereValue[2];

                    if (str_contains($columnName, '.')) {
                        $columnName = explode('.', $columnName);
                        $columnName = $columnName[0] . '.`' . $columnName[1] . '`';
                    } else {
                        $columnName = '`' . $columnName . '`';
                    }

                    $whereArray[] = "{$columnName}{$char}{$whereValue}";

                } else {
                    $whereArray[] = $this->_generateWhere($whereValue, 'AND', true);
                }
            } else {
                if ($columnName === 'OR') {
                    $whereArray[] = $this->_generateWhere($whereValue, 'OR', true);
                    $addToArray = false;
                } elseif (!is_int($columnName) && is_array($whereValue)) {
                    $char = ' ';
                    $whereValue = 'IN(\'' . implode("','", $whereValue) . '\')';
                } elseif (!is_int($whereValue)) {
                    $whereValue = "'" . str_replace("'", "\'", $whereValue) . "'";
                }

                if ($addToArray) {
                    if (str_contains($columnName, '.')) {
                        $columnName = explode('.', $columnName);
                        $columnName = $columnName[0] . '.`' . $columnName[1] . '`';
                    } else {
                        $columnName = '`' . $columnName . '`';
                    }

//                    $whereValue = !is_int($whereValue) ? ("'" . str_replace("'", '\'', $whereValue) . "'") : $whereValue;

                    $whereArray[] = "{$columnName}{$char}{$whereValue}";
                }
            }
        }

        return ($isolate ? '(' : '') . implode(' ' . $implode . ' ', $whereArray) . ($isolate ? ')' : '');
    }

    /**
     * Generowanie JOIN
     * @return string
     */
    private function _generateJoin() {
        $join = [];

        foreach ($this->join as $joinKey => $joinData) {
            if (!$joinKey) {
                $joinKey = $joinData;
                $joinData = null;
            }

            $table1 = $joinData['primary'] ?? ($this->tableName . '.id');

            if (str_contains($joinKey, 'INNER JOIN')) {
                $tableName = trim(str_replace('INNER JOIN', '', $joinKey));
                $table2 = $joinData['secondary'] ?? ($tableName . '.' . $this->tableName . '_id');
                $join[] = 'INNER JOIN `'.$tableName . '` on ' . $table1 . ' = ' . $table2;
            } elseif (str_contains($joinKey, 'LEFT JOIN')) {
                $tableName = trim(str_replace('LEFT JOIN', '', $joinKey));
                $table2 = $joinData['secondary'] ?? ($tableName . '.' . $this->tableName . '_id');
                $join[] = 'LEFT JOIN `'.$tableName . '` on ' . $table1 . ' = ' . $table2;
            }
        }

        return implode(' ', $join);
    }

    /**
     * Konwenteruje dane do tablicy
     * @param $data
     * @return array
     */
    private function _dataToArray($data) {
        $return = [];

        foreach ($data as $mainId => $mainData) {
            $return[$mainId] = [];

            foreach($mainData as $key => $value) {
                $keys = explode('.', $key);
                $return[$mainId][$keys[0]][$keys[1]] = $value;
            }
        }

        return $return;
    }
}