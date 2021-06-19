<?php


namespace App\Models;

require ("AbstractDBConnection.php");
require (__DIR__.'\..\interfaces\Model.php');
require(__DIR__ .'/../../vendor/autoload.php');
use App\Interfaces\Model;
use App\Models\AbstractDBConnection;
use Carbon\Carbon;

class Empresa extends AbstractDBConnection implements Model
{
    private ?int $id;
    private string $nombre;
    private int $telefono;
    private string $direccion;
    private int $municipios_id; //Id numero

    /* Relacion */
    private Municipios $municipio; //Todos los datos del municipio

    public function __construct(array $empresa = [])
    {
        parent::__construct();
        $this->setId($empresa['id'] ?? null);
        $this->setNombre($empresa['nombre'] ?? '');
        $this->settelefono($empresa['telefono'] ?? 0);
        $this->setdireccion($empresa['direccion'] ?? '');
        $this->setMunicipiosId($empresa['municipios_id'] ?? 0);
    }

    public static function EmpresaRegistrada(mixed $nombre, mixed $telefono)
    {
        $query = "SELECT * FROM empresa where nombre = '" . $nombre. "' or telefono = ".$telefono;
        $result = Empresa::search($query);
        if (!empty($result) && count($result)>0) {
            return true;
        } else {
            return false;
        }
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
     * @param int $telefono
     */
    public function settelefono(int $telefono): void
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

    /**
     * @return int
     */
    public function getMunicipiosId(): int
    {
        return $this->municipios_id;
    }

    /**
     * @param int $municipios_id
     */
    public function setMunicipiosId(int $municipios_id): void
    {
        $this->municipios_id = $municipios_id;
    }

    /**
     * @return Municipios|null
     */
    public function getMunicipio(): Municipios|null
    {
        if (!empty($this->municipio_id)) {
            return Municipios::searchForId($this->municipio_id) ?? new Municipios();
        }
        return null;
    }

    protected function save(string $query): ?bool
    {

        $arrData = [
            ':id' =>    $this->getId(),
            ':nombre' =>   $this->getNombre(),
            ':telefono' =>   $this->gettelefono(),
            ':direccion' =>  $this->getdireccion(),
            ':municipios_id' =>  $this->getMunicipiosId(),
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
            :id,:nombre,:telefono,:direccion,:municipios_id 
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
            nombre = :nombre, telefono = :telefono, direccion = :direccion, municipios_id = :municipios_id 
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

            if (!empty($getrows) && count($getrows) > 0) {
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
            'municipios_id' => $this->getMunicipio()
        ];

    }
}