<?php

namespace App\Models;

use Exception;
use PDO;
use PDOException;

/**
 * Created by PhpStorm.
 * @author: Gustavo Rozo
 * Date: 10/06/2021
 * Time: 9:17
 */

abstract class AbstractDBConnection {

    public bool $isConnected = false;
    protected PDO $datab;

    abstract protected function save(string $query) : ?bool;

    public function __construct(){

    }

    public function __destruct()
    {
        if($this->isConnected){
            $this->Disconnect();
        }
    }

    public function Connect(){
        $this->isConnected = true;
        try {
            GeneralFunctions::loadEnv(['DB_CONNECTION', 'DB_HOST', 'DB_PORT', 'DB_DATABASE', 'DB_USERNAME', 'DB_PASSWORD'],['DB_PORT']);
            if(array_search($_ENV['DB_CONNECTION'], PDO::getAvailableDrivers()) !== false){
                $this->datab = new PDO(
                    ($_ENV['DB_CONNECTION'] != "sqlsrv") ?
                        "{$_ENV['DB_CONNECTION']}:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_DATABASE']};charset={$_ENV['DB_CHAR_SET']}" :
                        "{$_ENV['DB_CONNECTION']}:Server={$_ENV['DB_HOST']},{$_ENV['DB_PORT']};database={$_ENV['DB_DATABASE']}",
                    $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
                );
                $this->datab->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->datab->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                $this->datab->setAttribute(PDO::ATTR_PERSISTENT, true);
            }else{
                throw new Exception('Driver de BD no soportado por el servidor');
            }
        }catch(PDOException | Exception $e) {
            $this->isConnected = false;
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    /**
     *  Método para desconectarse de la base de datos
     *  $database->Disconnect();
     * @return void
     */
    public function Disconnect() : void{
        unset($this->datab);
        $this->isConnected = false;
    }

    /**
     * Devuelve un solo registro (fila) de una Tabla como un array asociativo.
     *
     * $database->getRow("SELECT email, username FROM users WHERE username = ? and password = ?", array("gustavo","123456"));
     * @param string $query
     * @param array $params
     * @return array|false
     */
    public function getRow(string $query, array $params = []){
        try{
            if(!empty($query)){
                $stmt = $this->datab->prepare($query);
                $stmt->execute($params);
                return $stmt->fetch();
            }
            throw new Exception("Consulta vacía o errónea");
        }catch(PDOException | Exception $e){
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return false;
    }

    /**
     * Devuelve una matriz de registros (filas) de una tabla como un array asociativo.
     *
     * $database->getRows("SELECT id, username FROM users");
     * @param string $query
     * @param array $params
     * @return array|null
     */
    public function getRows(string $query, array $params = []) : ?array{
        try{
            if(!empty($query)){
                $stmt = $this->datab->prepare($query);
                $stmt->execute($params);
                return $stmt->fetchAll();
            }
            throw new Exception("Consulta vacía o errónea");
        }catch(PDOException | Exception $e){
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return null;
    }

    /**
     * Inserta registros en una tabla.
     *
     * $database ->insertRow("INSERT INTO users (username, email) VALUES (?, ?)", array("Gustavo", "gustavo@email.com"));
     * @param string $query
     * @param array $params
     * @return bool|null
     */
    public function insertRow(string $query, array $params = []): ?bool {
        try{
            if(!empty($query)) {
                $stmt = $this->datab->prepare($query);
                foreach ($params as $key => $value){
                    $stmt->bindValue($key, $value);
                }
                $this->getStringQuery($query, $params);
                return $stmt->execute();
            }
            throw new Exception("Consulta vacía o errónea");
        }catch(PDOException | Exception $e){
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return null;
    }

    /**
     * Actualizar registros de una tabla
     *
     * $database->updateRow("UPDATE users SET username = ?, email = ? WHERE id = ?", array("gustavo", "gustavo@email.com", "1"));
     * @param string $query
     * @param array $params
     * @return bool|null
     */
    public function updateRow(string $query, array $params = []){
        return $this->insertRow($query, $params);
    }

    /**
     * Elimina registros de la base de datos
     *
     *  $database->deleteRow("DELETE FROM users WHERE id = ?", array("1"));
     * @param string $query
     * @param array $params
     * @return bool|null
     */
    public function deleteRow(string $query, array $params = []){
        return $this->insertRow($query, $params);
    }

    /**
     * Obtener el ID del ultimo registro que se haya insertado en la BD
     *
     * $database->getLastId();
     * @param string|null $table
     * @return int|null
     * @throws Exception
     */
    public function getLastId(string $table = null) : ?int {
        try{
            if(!empty($table)){
                if($this->countRowsTable($table) > 0){
                    $result = $this->getRow("SELECT id FROM ".$table." ORDER BY id DESC LIMIT 1", []);
                    return $result['id'];
                }
                return 0;
            }else{
                return $this->datab->lastInsertId();
            }
        }catch(PDOException | Exception $e){
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return null;
    }

    /**
     * Cuenta el numero de filas en una tabla
     *
     * $database->getLastId();
     * @param string|null $table
     * @return int|null
     * @throws Exception
     */
    public function countRowsTable(string $table = null) : ?int {
        try{
            if(!empty($table)){
                $sql = "SELECT COUNT(*) FROM ".$table;
                if ($resultado = $this->datab->query($sql)) {
                    return (int) $resultado->fetchColumn();
                }
            }
        }catch(PDOException | Exception $e){
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return null;
    }

    /**
     * Retorna un query preparado
     *
     *  $database->getStringQuery("DELETE FROM users WHERE id = ?", array("1"));
     * @param string $query
     * @param array $params
     * @return string|null
     */
    public function getStringQuery(string $query, array $params) {
        $keys = array();
        $values = $params;

        foreach ($params as $key => $value) {
            if (is_string($key)) {
                $keys[] = '/'.$key.'/';
            } else {
                $keys[] = '/[?]/';
            }
            if (is_string($value))
                $values[$key] = "'" . $value . "'";

            if (is_array($value))
                $values[$key] = "'" . implode("','", $value) . "'";

            if (is_null($value))
                $values[$key] = 'NULL';
        }
        $query = preg_replace($keys, array_values($values), $query);
        return $query;
    }
}