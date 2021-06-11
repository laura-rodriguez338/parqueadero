<?php
namespace App\Models;

require ("AbstractDBConnection.php");
require (__DIR__.'\..\interfaces\Model.php');
require(__DIR__ .'/../../vendor/autoload.php');
use App\Interfaces\Model;
use App\Models\AbstractDBConnection;
use Carbon\Carbon;

final class Municipios extends AbstractDBConnection implements Model
{
    private ?int $id;
    private string $nombre;
    /**
     * Municipios constructor. Recibe un array asociativo
     * @param array $municipios
     * @throws Exception
     */
    public function __construct(array $municipios = [])
    {
        parent::__construct();
        $this->setId($municipios['id'] ?? null);
        $this->setNombre($municipios['nombre'] ?? '');
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
     * @return Municipios
     */
    public function setId(?int $id): Municipios
    {
        $this->id = $id;
        return $this;
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
     * @return Municipios
     */
    public function setNombre(string $nombre): Municipios
    {
        $this->nombre = $nombre;
        return $this;
    }

    public static function search($query): ?array
    {
        try {
            $arrMunicipios = array();
            $tmp = new Municipios();
            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            foreach ($getrows as $valor) {
                $Municipio = new Municipios($valor);
                array_push($arrMunicipios, $arrMunicipios);
                unset($Municipios);
            }
            return $arrMunicipios;
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception', $e);
        }
        return null;
    }

    public static function getAll(): array
    {
        return Municipios::search("SELECT * FROM parqueadero.municipios");
    }

    public static function searchForId(int $id): ?Municipios
    {
        try {
            if ($id > 0) {
                $tmpMun = new Municipios();
                $tmpMun->Connect();
                $getrow = $tmpMun->getRow("SELECT * FROM municipios WHERE id =?", array($id));
                $tmpMun->Disconnect();
                return ($getrow) ? new Municipios($getrow) : null;
            } else {
                throw new Exception('Id de municipio Invalido');
            }
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception', $e);
        }
        return null;
    }

    public function __toString() : string
    {
        return "Nombre: $this->nombre";
    }

    #[ArrayShape([
        'id' => "int|null",
        'nombre' => "string",

    ])]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'nombre' => $this->getNombre(),
        ];
    }

    protected function save(string $query): ?bool
    {
        $arrData = [
            ':id' =>    $this->getId(),
            ':nombre' =>   $this->getNombre(),

        ];
        $this->Connect();
        $result = $this->insertRow($query, $arrData);
        $this->Disconnect();
        return $result;
    }
    /**
     * @return bool|null
     */

    function insert()
    {
        $query = "INSERT INTO Municipios VALUES (
            :id,:nombre
            
        )";
        if($this->save($query)){
            $idMunicipios = $this->getLastId("Municipios");
            $this->setId($idMunicipios);
            return true;

        }else{
            return false;
        }
        return $this->save($query);
    }
    /**
     * @return bool|null
     */

    function update()
    {
        $query = "UPDATE Municipios SET 
            nombre = :nombre  WHERE id = :id";
        return $this->save($query);
    }

    function deleted()
    {

    }



}

