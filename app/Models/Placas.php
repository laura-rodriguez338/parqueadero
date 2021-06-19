<?php

namespace App\Models;

use App\Interfaces\Model;
use Carbon\Carbon;
use Exception;
use JsonSerializable;

class Placas extends AbstractDBConnection implements Model, JsonSerializable
{
    private ?int $id;
    private string $nombre;
    private string $descripcion;
    private string $estado;
    private Carbon $created_at;
    private Carbon $updated_at;

    /* Relaciones */
    private ?array $productosPlacas;

    /**
     * Categorias constructor. Recibe un array asociativo
     * @param array $placa
     */
    public function __construct(array $placa = [])
    {
        parent::__construct();
        $this->setId($placa['id'] ?? NULL);
        $this->setNombre($placa['nombre'] ?? '');
        $this->setDescripcion($placa['descripcion'] ?? '');
        $this->setEstado($placa['estado'] ?? '');
        $this->setCreatedAt(!empty($placa['created_at']) ? Carbon::parse($placa['created_at']) : new Carbon());
        $this->setUpdatedAt(!empty($placa['updated_at']) ? Carbon::parse($placa['updated_at']) : new Carbon());
    }

    function __destruct()
    {
        if($this->isConnected){
            $this->Disconnect();
        }
    }

    /**
     * @return int|null
     */
    public function getId() : ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed|string
     */
    public function getNombre() : string
    {
        return ucwords($this->nombre);
    }

    /**
     * @param mixed|string $nombre
     */
    public function setNombre(string $nombre): void
    {
        $this->nombre = trim(mb_strtolower($nombre, 'UTF-8'));
    }

    /**
     * @return string|mixed
     */
    public function getDescripcion() : string
    {
        return $this->descripcion;
    }

    /**
     * @param string|mixed $descripcion
     */
    public function setDescripcion(string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return mixed|string
     */
    public function getEstado() : string
    {
        return $this->estado;
    }

    /**
     * @param mixed|string $estado
     */
    public function setEstado(string $estado): void
    {
        $this->estado = $estado;
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->created_at->locale('es');
    }

    /**
     * @param Carbon $created_at
     */
    public function setCreatedAt(Carbon $created_at): void
    {
        $this->created_at = $created_at->locale('es');
    }

    /**
     * @return Carbon
     */
    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at->locale('es');
    }

    /**
     * @param Carbon $updated_at
     */
    public function setUpdatedAt(Carbon $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    /* Relaciones */
    /**
     * retorna un array de productos que pertenecen a una categoria
     * @return array
     */
    public function getProductosPlaca(): ?array
    {
        $this->productosPlaca = Productos::search("SELECT * FROM parqueadero.productos WHERE placa_id = ".$this->id." and estado = 'Activo'");
        return $this->productosPlaca;
    }

    /**
     * @param string $query
     * @return bool|null
     */
    protected function save(string $query): ?bool
    {
        $arrData = [
            ':id' =>    $this->getId(),
            ':nombre' =>   $this->getNombre(),
            ':descripcion' =>   $this->getDescripcion(),
            ':estado' =>   $this->getEstado(),
            ':created_at' =>  $this->getCreatedAt()->toDateTimeString(), //YYYY-MM-DD HH:MM:SS
            ':updated_at' =>  $this->getUpdatedAt()->toDateTimeString() //YYYY-MM-DD HH:MM:SS
        ];
        $this->Connect();
        $result = $this->insertRow($query, $arrData);
        $this->Disconnect();
        return $result;
    }

    /**
     * @return bool|null
     */
    function insert(): ?bool
    {
        $query = "INSERT INTO parqueadero.placas VALUES (:id,:nombre,:descripcion,:estado,:created_at,:updated_at)";
        return $this->save($query);
    }

    /**
     * @return bool|null
     */
    public function update(): ?bool
    {
        $query = "UPDATE parqueadero.placas SET 
            nombre = :nombre, descripcion = :descripcion,
            estado = :estado, created_at = :created_at, 
            updated_at = :updated_at WHERE id = :id";
        return $this->save($query);
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function deleted(): bool
    {
        $this->setEstado("Inactivo"); //Cambia el estado del Usuario
        return $this->update();                    //Guarda los cambios..
    }

    /**
     * @param $query
     * @return Placas|array
     * @throws Exception
     */
    public static function search($query) : ?array
    {
        try {
            $arrPlacas = array();
            $tmp = new Placas();
            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            foreach ($getrows as $valor) {
                $Placa = new Placas($valor);
                array_push($arrPlacas, $Placa);
                unset($Placa);
            }
            return $arrPlacas;
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return null;
    }

    /**
     * @param $id
     * @return Placas
     * @throws Exception
     */
    public static function searchForId($id) : ?Placas
    {
        try {
            if ($id > 0) {
                $Placa = new Placas();
                $Placa->Connect();
                $getrow = $Placa->getRow("SELECT * FROM parqueadero.placas WHERE id =?", array($id));
                $Placa->Disconnect();
                return ($getrow) ? new Placas($getrow) : null;
            }else{
                throw new Exception('Id de placa Invalida');
            }
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return null;
    }

    /**
     * @return array
     * @throws Exception
     */
    public static function getAll() : ?array
    {
        return Placas::search("SELECT * FROM parqueadero.placas");
    }

    /**
     * @param $nombre
     * @return bool
     * @throws Exception
     */
    public static function placaRegistrada($nombre): bool
    {
        $nombre = trim(strtolower($nombre));
        $result = Placas::search("SELECT id FROM parqueadero.placas where nombre = '" . $nombre. "'");
        if ( !empty($result) && count ($result) > 0 ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return "Nombre: $this->nombre, Descripción: $this->descripcion, Estado: $this->estado";
    }


    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4
     */
    public function jsonSerialize()
    {
        return [
            'nombre' => $this->getNombre(),
            'descripcion' => $this->getDescripcion(),
            'estado' => $this->getEstado(),
            'created_at' => $this->getCreatedAt()->toDateTimeString(),
            'updated_at' => $this->getUpdatedAt()->toDateTimeString(),
        ];
    }
}