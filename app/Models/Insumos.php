<?php


namespace App\Models;

require ("AbstractDBConnection.php");
require (__DIR__.'\..\interfaces\Model.php');
require(__DIR__ .'/../../vendor/autoload.php');
use App\Interfaces\Model;
use App\Models\AbstractDBConnection;
use Carbon\Carbon;

class Insumos extends AbstractDBConnection implements Model
{
    private ?int $id;
    private string $nombre;
    private string $cantidad;
    private string $presentasion;
    private int $valor;
    public function __construct(array $usuario = [])
    {
        parent::__construct();
        $this->setId($usuario['id'] ?? null);
        $this->setNombre($usuario['nombre'] ?? '');
        $this->setCantidad($usuario['cantidad'] ?? '');
        $this->setPresentasion($usuario['presentasion'] ?? '');
        $this->setValor($usuario['valor'] ?? 0);
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
    public function getCantidad(): string
    {
        return $this->cantidad;
    }

    /**
     * @param string $cantidad
     */
    public function setCantidad(string $cantidad): void
    {
        $this->cantidad = $cantidad;
    }

    /**
     * @return string
     */
    public function getPresentasion(): string
    {
        return $this->presentasion;
    }

    /**
     * @param string $presentasion
     */
    public function setPresentasion(string $presentasion): void
    {
        $this->presentasion = $presentasion;
    }

    /**
     * @return int
     */
    public function getValor(): int
    {
        return $this->valor;
    }

    /**
     * @param int $valor
     */
    public function setValor(int $valor): void
    {
        $this->valor = $valor;
    }


    protected function save(string $query): ?bool
    {
        $hashPassword = password_hash($this->password, self::HASH, ['cost' => self::COST]);

        $arrData = [
            ':id' =>    $this->getId(),
            ':nombre' =>   $this->getNombre(),
            ':cantidad' =>   $this->getcantidad(),
            ':presentasion' =>  $this->getpresentasion(),
            ':valor' =>   $this->getvalor(),
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
        $query = "INSERT INTO insumos VALUES (
            :id,:nombre,:cantidad,:presentacion,:valor,
            
        )";
        return $this->save($query);
    }

    /**
     * @return bool|null
     */
    public function update(): ?bool
    {
        $query = "UPDATE insumos SET 
            nombre = :nombre, cantidad = :cantidad, presentasion = :presentasion, 
            valor = :valor WHERE id = :id";
        return $this->save($query);
    }


    function deleted()
    {
        $this->setValor("Inactivo"); //Cambia el estado del Usuario
        return $this->update();                    //Guarda los cambios..
    }

    static function search($query): ?array
    {
        // TODO: Implement search() method.
    }

    static function searchForId(int $id): ?object
    {
        // TODO: Implement searchForId() method.
    }

    static function getAll(): ?array
    {
        // TODO: Implement getAll() method.
    }

    public function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
    }
}