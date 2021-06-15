<?php


namespace App\Models;

require ("AbstractDBConnection.php");
require (__DIR__.'\..\interfaces\Model.php');
require(__DIR__ .'/../../vendor/autoload.php');
use App\Interfaces\Model;
use App\Models\AbstractDBConnection;
use Carbon\Carbon;
class Empresa
{
    private ?int $id;
    private string $nombre;
    private string $telefono;
    private string $direccion;
    public function __construct(array $Empresa = [])
    {
        parent::__construct();
        $this->setId($empresa['id'] ?? null);
        $this->setNombre($empresa['nombre'] ?? '');
        $this->settelefono($empresa['telefono'] ?? '');
        $this->setdireccion($empresa['direccion'] ?? '');
    }
    public function __destruct()
    {
        if ($this->isConnected()) {
            $this->Disconnect();
        }
    }
    /**
     * @return int|null
     */
    public function getId(): ?int
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
     * @return string
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return string
     */
    public function gettelefono(): string
    {
        return $this->telefono;
    }

    /**
     * @param string $telefono
     */
    public function settelefono(string $telefono): void
    {
        $this->telefono = $telefono;
    }

    /**
     * @return string
     */
    public function getdireccion(): string
    {
        return $this->direccion;
    }

    /**
     * @param string $direccion
     */
    public function setdireccion(string $direccion): void
    {
        $this->direccion = $direccion;
    }


    protected function save(string $query): ?bool
    {

        $arrData = [
            ':id' =>    $this->getId(),
            ':nombre' =>   $this->getNombre(),
            ':telefono' =>   $this->gettelefono(),
            ':direccion' =>  $this->getdireccion(),
        ];
        $this->Connect();
        $result = $this->insertRow($query, $arrData);
        $this->Disconnect();
        return $result;
    }
    /**
     * @return bool|null
     */
    public function insert(): ?bool
    {
        $query = "INSERT INTO Empresa VALUES (
            :id,:nombre,:telefono,:direccion
            
        )";
        if($this->save($query)){
            $idEmpresa = $this->getLastId("Empresa");
            $this->setId($idEmpresa);
            return true;

        }else{
            return false;
        }
        return $this->save($query);
    }

    /**
     * @return bool|null
     */
    public function update(): ?bool
    {
        $query = "UPDATE Empresa SET 
            nombre = :nombre, telefono = :telefono, direccion = :direccion 
             WHERE id = :id";
        return $this->save($query);
    }


    function deleted()
    {

    }

    static function search($query): ?array
    {
        try {
            $arrEmpresa = array();
            $tmp = new Empresa();

            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            if (!empty($getrows)) {
                foreach ($getrows as $valor) {
                    $Empresa = new Empresa($valor);
                    array_push($arrEmpresa, $Empresa);
                    unset($Empresa); //Borrar el contenido del objeto
                }
                return $arrEmpresa;
            }
            return null;
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception', $e);
        }
        return null;
    }


    static function searchForId(int $id): ?Empresa
    {
        {
            try {
                if ($id > 0) {
                    $tmpEmpresa = new Empresa();
                    $tmpEmpresa->Connect();
                    $getrow = $tmpEmpresa->getRow("SELECT * FROM empresa WHERE id = ?", array($id) );

                    $tmpEmpresa->Disconnect();
                    return ($getrow) ? new Empresa($getrow) : null;
                } else {
                    throw new Exception('Id de empresa Invalido');
                }
            } catch (Exception $e) {
                GeneralFunctions::logFile('Exception', $e);
            }
            return null;
        }
    }

    static function getAll(): ?array
    {
        return Empresa::search("SELECT * FROM empresa");
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'nombre' => $this->getNombre(),
            'telefono' => $this->gettelefono(),
            'direccion' => $this->getdireccion(),
        ];

    }
}