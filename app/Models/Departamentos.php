<?php
namespace App\Models;

use App\Interfaces\Model;
use Carbon\Carbon;
use Exception;
<<<<<<< HEAD
use JsonSerializable;

final class Departamentos extends AbstractDBConnection implements Model, JsonSerializable
{

=======
use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

final class Departamentos extends AbstractDBConnection implements Model
{
>>>>>>> 0c40e7b3629895ede8d1c65d47ee0b45d2dd63cf
    private ?int $id;
    private string $nombre;
    private string $region;
    private string $estado;
    private Carbon $created_at;
    private Carbon $updated_at;
    private Carbon $deleted_at;

    /* Relaciones */
    private ?array $MunicipiosDepartamento;

    /**
     * Departamentos constructor. Recibe un array asociativo
     * @param array $departamento
     */
    public function __construct(array $departamento = [])
    {
        parent::__construct();
<<<<<<< HEAD
        $this->setId($departamento['id'] ?? NULL);
        $this->setNombre($departamento['nombre'] ?? '');
        $this->setRegion($departamento['region'] ?? '');
        $this->setEstado($departamento['estado'] ?? '');
        $this->setCreatedAt(!empty($departamento['created_at']) ? Carbon::parse($departamento['created_at']) : new Carbon());
        $this->setUpdatedAt(!empty($departamento['updated_at']) ? Carbon::parse($departamento['updated_at']) : new Carbon());
        $this->setDeletedAt(!empty($departamento['deleted_at']) ? Carbon::parse($departamento['deleted_at']) : new Carbon());
=======
        $this->setId($departamento['id'] ?? null);
        $this->setNombre($departamento['nombre'] ?? '');
        $this->setRegion($departamento['region'] ?? '');
        $this->setEstado($departamento['estado'] ?? '');
        $this->setCreatedAt(!empty($departamento['created_at']) ?
            Carbon::parse($departamento['created_at']) : new Carbon());
        $this->setUpdatedAt(!empty($departamento['updated_at']) ?
            Carbon::parse($departamento['updated_at']) : new Carbon());
        $this->setDeletedAt(!empty($departamento['deleted_at']) ?
            Carbon::parse($departamento['deleted_at']) : new Carbon());
>>>>>>> 0c40e7b3629895ede8d1c65d47ee0b45d2dd63cf
    }

    public function __destruct()
    {
        parent::__destruct();
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
    public function getRegion(): string
    {
        return $this->region;
    }

    /**
     * @param string $region
     */
    public function setRegion(string $region): void
    {
        $this->region = $region;
    }

    /**
     * @return string
     */
    public function getEstado(): string
    {
        return $this->estado;
    }

    /**
     * @param string $estado
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
        $this->created_at = $created_at;
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

    /**
     * @return Carbon
     */
    public function getDeletedAt(): Carbon
    {
        return $this->deleted_at->locale('es');
    }

    /**
     * @param Carbon $deleted_at
     */
    public function setDeletedAt(Carbon $deleted_at): void
    {
        $this->deleted_at = $deleted_at;
    }

    /* Relaciones */
    /**
     * retorna un array de municipios que perteneces a un departamento
     * @return array
     */
    public function getMunicipiosDepartamento(): ?array
    {
<<<<<<< HEAD
        if(!empty($this-> MunicipiosDepartamento)){
            $this-> MunicipiosDepartamento = Municipios::search("SELECT * FROM parqueadero.municipios WHERE departamento_id = ".$this->id);
            return $this-> MunicipiosDepartamento;
        }
        return null;
    }

    static function search($query): ?array
=======
        $this-> MunicipiosDepartamento = Municipios::search(
            "SELECT * FROM municipios WHERE departamento_id = ".$this->id
        );
        return $this-> MunicipiosDepartamento ?? null;
    }

    public static function search($query): ?array
>>>>>>> 0c40e7b3629895ede8d1c65d47ee0b45d2dd63cf
    {
        try {
            $arrDepartamentos = array();
            $tmp = new Departamentos();
            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            foreach ($getrows as $valor) {
                $Departamento = new Departamentos($valor);
                array_push($arrDepartamentos, $Departamento);
                unset($Departamento);
            }
            return $arrDepartamentos;
        } catch (Exception $e) {
<<<<<<< HEAD
            GeneralFunctions::logFile('Exception',$e, 'error');
=======
            GeneralFunctions::logFile('Exception', $e);
>>>>>>> 0c40e7b3629895ede8d1c65d47ee0b45d2dd63cf
        }
        return null;
    }

<<<<<<< HEAD
    static function searchForId(int $id): ?Departamentos
=======
    public static function searchForId(int $id): ?Departamentos
>>>>>>> 0c40e7b3629895ede8d1c65d47ee0b45d2dd63cf
    {
        try {
            if ($id > 0) {
                $tmpDepartamento = new Departamentos();
                $tmpDepartamento->Connect();
<<<<<<< HEAD
                $getrow = $tmpDepartamento->getRow("SELECT * FROM parqueadero.departamentos WHERE id =?", array($id));
                $tmpDepartamento->Disconnect();
                return ($getrow) ? new Departamentos($getrow) : null;
            }else{
                throw new Exception('Id de departamento Invalido');
            }
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
=======
                $getrow = $tmpDepartamento->getRow("SELECT * FROM departamentos WHERE id =?", array($id));
                $tmpDepartamento->Disconnect();
                return ($getrow) ? new Departamentos($getrow) : null;
            } else {
                throw new Exception('Id de departamento Invalido');
            }
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception', $e);
>>>>>>> 0c40e7b3629895ede8d1c65d47ee0b45d2dd63cf
        }
        return null;
    }

<<<<<<< HEAD
    static function getAll(): array
    {
        return Departamentos::search("SELECT * FROM parqueadero.departamentos");
=======
    public static function getAll(): array
    {
        return Departamentos::search("SELECT * FROM departamentos");
>>>>>>> 0c40e7b3629895ede8d1c65d47ee0b45d2dd63cf
    }

    public function __toString() : string
    {
        return "Nombre: $this->nombre, Region: $this->region, Estado: $this->estado";
    }

<<<<<<< HEAD
    public function jsonSerialize()
=======
    #[ArrayShape([
        'id' => "int|null",
        'nombre' => "string",
        'region' => "string",
        'estado' => "string",
        'created_at' => "string",
        'updated_at' => "string",
        'deleted_at' => "string"
    ])]
    public function jsonSerialize(): array
>>>>>>> 0c40e7b3629895ede8d1c65d47ee0b45d2dd63cf
    {
        return [
            'id' => $this->getId(),
            'nombre' => $this->getNombre(),
            'region' => $this->getRegion(),
            'estado' => $this->getEstado(),
            'created_at' => $this->getCreatedAt()->toDateTimeString(),
            'updated_at' => $this->getUpdatedAt()->toDateTimeString(),
            'deleted_at' => $this->getDeletedAt()->toDateTimeString(),
        ];
    }

<<<<<<< HEAD
    protected function save(string $query): ?bool { return null; }
    function insert(){ }
    function update() { }
    function deleted() { }

}
=======
    protected function save(string $query): ?bool
    {
        return null;
    }

    public function insert(): ?bool
    {
        return false;
    }

    public function update(): ?bool
    {
        return false;
    }

    public function deleted(): ?bool
    {
        return false;
    }
}
>>>>>>> 0c40e7b3629895ede8d1c65d47ee0b45d2dd63cf
