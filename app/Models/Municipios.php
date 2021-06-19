<?php
namespace App\Models;

use App\Interfaces\Model;
use Carbon\Carbon;
use Exception;
<<<<<<< HEAD
use JsonSerializable;

final class Municipios extends AbstractDBConnection implements Model, JsonSerializable
=======
use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

final class Municipios extends AbstractDBConnection implements Model
>>>>>>> 0c40e7b3629895ede8d1c65d47ee0b45d2dd63cf
{
    private ?int $id;
    private string $nombre;
    private int $departamento_id;
    private string $acortado;
    private string $estado;
    private Carbon $created_at;
    private Carbon $updated_at;
    private Carbon $deleted_at;
<<<<<<< HEAD

    /* Relaciones */
    private ?Departamentos $departamento;
=======
    /* Objeto de la relacion */
    private Departamentos $departamento;
>>>>>>> 0c40e7b3629895ede8d1c65d47ee0b45d2dd63cf

    /**
     * Municipios constructor. Recibe un array asociativo
     * @param array $municipio
     * @throws Exception
     */
    public function __construct(array $municipio = [])
    {
        parent::__construct();
<<<<<<< HEAD
        $this->setId($municipio['id'] ?? NULL);
=======
        $this->setId($municipio['id'] ?? null);
>>>>>>> 0c40e7b3629895ede8d1c65d47ee0b45d2dd63cf
        $this->setNombre($municipio['nombre'] ?? '');
        $this->setDepartamentoId($municipio['departamento_id'] ?? 0);
        $this->setAcortado($municipio['acortado'] ?? '');
        $this->setEstado($municipio['estado'] ?? '');
        $this->setCreatedAt(!empty($municipio['created_at']) ? Carbon::parse($municipio['created_at']) : new Carbon());
        $this->setUpdatedAt(!empty($municipio['updated_at']) ? Carbon::parse($municipio['updated_at']) : new Carbon());
        $this->setDeletedAt(!empty($municipio['deleted_at']) ? Carbon::parse($municipio['deleted_at']) : new Carbon());
    }

    public function __destruct()
    {
<<<<<<< HEAD
        if($this->isConnected){
=======
        if ($this->isConnected()) {
>>>>>>> 0c40e7b3629895ede8d1c65d47ee0b45d2dd63cf
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

    /**
     * @return int
     */
    public function getDepartamentoId(): int
    {
        return $this->departamento_id;
    }

    /**
     * @param int $departamento_id
     */
    public function setDepartamentoId(int $departamento_id): void
    {
        $this->departamento_id = $departamento_id;
    }

    /**
     * @return string
     */
    public function getAcortado(): string
    {
        return $this->acortado;
    }

    /**
     * @param string $acortado
     */
    public function setAcortado(string $acortado): void
    {
        $this->acortado = $acortado;
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

    /**
     * Relacion con departamento
     *
<<<<<<< HEAD
     * @return Departamentos
     */
    public function getDepartamento(): ?Departamentos
    {
        if(!empty($this->departamento_id)){
            $this->departamento = Departamentos::searchForId($this->departamento_id) ?? new Departamentos();
            return $this->departamento;
        }
        return null;
    }

    static function search($query): ?array
=======
     * @return null|Departamentos
     */
    public function getDepartamento(): ?Departamentos
    {
        if (!empty($this->departamento_id)) {
            $this->departamento = Departamentos::searchForId($this->departamento_id) ?? new Departamentos();
        }
        return $this->departamento;
    }

    public static function search($query): ?array
>>>>>>> 0c40e7b3629895ede8d1c65d47ee0b45d2dd63cf
    {
        try {
            $arrMunicipios = array();
            $tmp = new Municipios();
            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            foreach ($getrows as $valor) {
                $Municipio = new Municipios($valor);
                array_push($arrMunicipios, $Municipio);
                unset($Municipio);
            }
            return $arrMunicipios;
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
    static function getAll(): array
    {
        return Municipios::search("SELECT * FROM parqueadero.municipios");
    }

    static function searchForId(int $id): ?object
=======
    public static function getAll(): array
    {
        return Municipios::search("SELECT * FROM weber.municipios");
    }

    public static function searchForId(int $id): ?Municipios
>>>>>>> 0c40e7b3629895ede8d1c65d47ee0b45d2dd63cf
    {
        try {
            if ($id > 0) {
                $tmpMun = new Municipios();
                $tmpMun->Connect();
<<<<<<< HEAD
                $getrow = $tmpMun->getRow("SELECT * FROM parqueadero.municipios WHERE id =?", array($id));
                $tmpMun->Disconnect();
                return ($getrow) ? new Municipios($getrow) : null;
            }else{
                throw new Exception('Id de municipio Invalido');
            }
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
=======
                $getrow = $tmpMun->getRow("SELECT * FROM municipios WHERE id =?", array($id));
                $tmpMun->Disconnect();
                return ($getrow) ? new Municipios($getrow) : null;
            } else {
                throw new Exception('Id de municipio Invalido');
            }
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception', $e);
>>>>>>> 0c40e7b3629895ede8d1c65d47ee0b45d2dd63cf
        }
        return null;
    }

    public function __toString() : string
    {
        return "Nombre: $this->nombre, Estado: $this->estado";
    }

<<<<<<< HEAD
    public function jsonSerialize()
=======
    #[ArrayShape([
        'id' => "int|null",
        'nombre' => "string",
        'departamento_id' => "array",
        'acortado' => "string",
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
            'departamento_id' => $this->getDepartamento()->jsonSerialize(),
            'acortado' => $this->getAcortado(),
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
