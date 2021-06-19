<?php

namespace App\Models;

use App\Interfaces\Model;
use Carbon\Carbon;
use Carbon\Traits\Creator;
use Exception;
use JsonSerializable;

class Productos extends AbstractDBConnection implements Model, JsonSerializable
{
    private ?int $id;
    private string $nombre;
    private float $precio;
    private float $porcentaje_ganancia;
    private int $stock;
    private int $placa_id;
    private int $marca_id;
    private int $colores_id;
    private int $vehiculo_id;
    private string $estado;
    private Carbon $created_at;
    private Carbon $updated_at;

    /* Relaciones */
    private ?Placas $placa;
    private ?Marcas $marca;
    private ?Coloress $colores;
    private ?Vehiculos $vehiculo;
    private ?array $fotosProducto;

    /**
     * Producto constructor. Recibe un array asociativo
     * @param array $placa
     */
    public function __construct(array $placa = [])
    {
        parent::__construct();
        $this->setId($placa['id'] ?? NULL);
        $this->setNombre($placa['nombre'] ?? '');
        $this->setPrecio($placa['precio'] ?? 0.0);
        $this->setPorcentajeGanancia($placa['porcentaje_ganancia'] ?? 0.0);
        $this->setStock($placa['stock'] ?? 0);
        $this->setPlacaId($placa['placa_id'] ?? 0);
        $this->setMarcaId($placa['marca_id'] ?? 0);
        $this->setColoresId($placa['colores_id'] ?? 0);
        $this->setVehiculoId($placa['vehiculo_id'] ?? 0);
        $this->setEstado($placa['estado'] ?? '');
        $this->setCreatedAt(!empty($placa['created_at']) ? Carbon::parse($placa['created_at']) : new Carbon());
        $this->setUpdatedAt(!empty($placa['updated_at']) ? Carbon::parse($placa['updated_at']) : new Carbon());
    }

    /**
     * Producto constructor. Recibe un array asociativo
     * @param array $marca
     */
    public function __construct2(array $marca = [])
    {
        parent::__construct2();
        $this->setId($marca['id'] ?? NULL);
        $this->setNombre($marca['nombre'] ?? '');
        $this->setPrecio($marca['precio'] ?? 0.0);
        $this->setPorcentajeGanancia($marca['porcentaje_ganancia'] ?? 0.0);
        $this->setStock($marca['stock'] ?? 0);
        $this->setPlacaId($marca['placa_id'] ?? 0);
        $this->setMarcaId($marca['marca_id'] ?? 0);
        $this->setColoresId($marca['colores_id'] ?? 0);
        $this->setVehiculoId($marca['vehiculo_id'] ?? 0);
        $this->setEstado($marca['estado'] ?? '');
        $this->setCreatedAt(!empty($marca['created_at']) ? Carbon::parse($marca['created_at']) : new Carbon());
        $this->setUpdatedAt(!empty($marca['updated_at']) ? Carbon::parse($marca['updated_at']) : new Carbon());
    }

     /**
     * Producto constructor. Recibe un array asociativo
     * @param array $colores
     */
    public function __construct1 (array $colores = [])
    {
        parent::__construct1();
        $this->setId($colores['id'] ?? NULL);
        $this->setNombre($colores['nombre'] ?? '');
        $this->setPrecio($colores['precio'] ?? 0.0);
        $this->setPorcentajeGanancia($colores['porcentaje_ganancia'] ?? 0.0);
        $this->setStock($colores['stock'] ?? 0);
        $this->setPlacaId($colores['placa_id'] ?? 0);
        $this->setMarcaId($colores['marca_id'] ?? 0);
        $this->setColoresId($colores['colores_id'] ?? 0);
        $this->setVehiculoId($colores['vehiculo_id'] ?? 0);
        $this->setEstado($colores['estado'] ?? '');
        $this->setCreatedAt(!empty($colores['created_at']) ? Carbon::parse($colores['created_at']) : new Carbon());
        $this->setUpdatedAt(!empty($colores['updated_at']) ? Carbon::parse($colores['updated_at']) : new Carbon());
    }
      /**
     * Producto constructor. Recibe un array asociativo
     * @param array $vehiculo
     */
    public function __construct3 (array $vehiculo = [])
    {
        parent::__construct3();
        $this->setId($vehiculo['id'] ?? NULL);
        $this->setNombre($vehiculo['nombre'] ?? '');
        $this->setPrecio($vehiculo['precio'] ?? 0.0);
        $this->setPorcentajeGanancia($vehiculo['porcentaje_ganancia'] ?? 0.0);
        $this->setStock($vehiculo['stock'] ?? 0);
        $this->setPlacaId($vehiculo['placa_id'] ?? 0);
        $this->setMarcaId($vehiculo['marca_id'] ?? 0);
        $this->setColoresId($vehiculo['colores_id'] ?? 0);
        $this->setVehiculoId($vehiculo['vehiculo_id'] ?? 0);
        $this->setEstado($vehiculo['estado'] ?? '');
        $this->setCreatedAt(!empty($vehiculo['created_at']) ? Carbon::parse($vehiculo['created_at']) : new Carbon());
        $this->setUpdatedAt(!empty($vehiculo['updated_at']) ? Carbon::parse($vehiculo['updated_at']) : new Carbon());
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
     * @return mixed|string
     */

    /**
     * @return float|mixed
     */
    public function getPrecio() : float
    {
        return $this->precio;
    }

    /**
     * @param float|mixed $precio
     */
    public function setPrecio(float $precio): void
    {
        $this->precio = $precio;
    }

    /**
     * @return float|mixed
     */
    public function getPorcentajeGanancia() : float
    {
        return $this->porcentaje_ganancia;
    }

    /**
     * @param float|mixed $porcentaje_ganancia
     */
    public function setPorcentajeGanancia(float $porcentaje_ganancia): void
    {
        $this->porcentaje_ganancia = $porcentaje_ganancia;
    }

    /**
     * @return int|mixed
     */
    public function getStock() : int
    {
        return $this->stock;
    }

    /**
     * @param int|mixed $stock
     */
    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }

    /**
     * @return int
     */
    public function getPlacaId(): int
    {
        return $this->placa_id;
    }

    /**
     * @param int $placa_id
     */
    public function setPlacaId(int $placa_id): void
    {
        $this->placa_id = $placa_id;
    }
     /**
     * @return int
     */
    public function getMarcaId(): int
    {
        return $this->marca_id;
    }

    /**
     * @param int $marca_id
     */
    public function setMarcaId(int $marca_id): void
    {
        $this->marca_id = $marca_id;
    }
      /**
     * @return int
     */
    public function getColoresId(): int
    {
        return $this->colores_id;
    }

    /**
     * @param int $colores_id
     */
    public function setColoresId(int $colores_id): void
    {
        $this->colores_id = $colores_id;
    }
      /**
     * @return int
     */
    public function getVehiculoId(): int
    {
        return $this->vehiculo_id;
    }

    /**
     * @param int $vehiculo_id
     */
    public function setVehiculoId(int $vehiculo_id): void
    {
        $this->vehiculo_id = $vehiculo_id;
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

    /* Relaciones */
    /**
     * @return Placas
     */
    public function getPlaca(): ?Placas
    {
        if(!empty($this->placa_id)){
            $this->placa = Placas::searchForId($this->placa_id) ?? new Placas();
            return $this->placa;
        }
        return NULL;
    }
     /* Relaciones */
    /**
     * @return Marcas
     */
    public function getMarca(): ?Marcas
    {
        if(!empty($this->marca_id)){
            $this->marca = Marcas::searchForId($this->marca_id) ?? new Marcas();
            return $this->marca;
        }
        return NULL;
    }
     /* Relaciones */
    /**
     * @return Coloress
     */
    public function getColores(): ?Coloress
    {
        if(!empty($this->colores_id)){
            $this->colores = Coloress::searchForId($this->colores_id) ?? new Coloress();
            return $this->colores;
        }
        return NULL;
    }
     /* Relaciones */
    /**
     * @return Vehiculos
     */
    public function getVehiculo(): ?Vehiculos
    {
        if(!empty($this->vehiculo_id)){
            $this->vehiculo = Vehiculos::searchForId($this->vehiculo_id) ?? new Vehiculos();
            return $this->vehiculo;
        }
        return NULL;
    }

    /**
     * retorna un array de fotos que pertenecen al producto
     * @return array
     */
    public function getFotosProducto(): ?array
    {
        $this->fotosProducto = Fotos::search("SELECT * FROM parqueadero.fotos WHERE producto_id = ".$this->id." and estado = 'Activo'");
        return $this->fotosProducto;
    }

    protected function save(string $query): ?bool
    {
        $arrData = [
            ':id' =>    $this->getId(),
            ':nombre' =>   $this->getNombre(),
            ':precio' =>   $this->getPrecio(),
            ':porcentaje_ganancia' =>  $this->getPorcentajeGanancia(),
            ':stock' =>   $this->getStock(),
            ':placa_id' =>   $this->getPlacaId(),
            ':marca_id' =>   $this->getMarcaId(),
            ':colores_id' =>   $this->getColoresId(),
            ':vehiculo_id' =>   $this->getVehiculoId(),
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
        $query = "INSERT INTO parqueadero.productos VALUES (:id,:nombre,:precio,:porcentaje_ganancia,:stock,:placa_id,:marca_id,:colores_id,:vehiculo_id,:estado,:created_at,:updated_at)";
        return $this->save($query);
    }

    /**
     * @return bool|null
     */
    public function update(): ?bool
    {
        $query = "UPDATE parqueadero.productos SET 
            nombre = :nombre, precio = :precio, porcentaje_ganancia = :porcentaje_ganancia, 
            stock = :stock, placa_id = :placa_id, marca_id = :marca_id, colores_id = :colores_id, vehiculo_id = :vehiculo_id, estado = :estado, created_at = :created_at, 
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
     * @return Productos|array
     * @throws Exception
     */
    public static function search($query) : ?array
    {
        try {
            $arrProductos = array();
            $tmp = new Productos();
            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            foreach ($getrows as $valor) {
                $Producto = new Productos($valor);
                array_push($arrProductos, $Producto);
                unset($Producto);
            }
            return $arrProductos;
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return null;
    }

    /**
     * @param $id
     * @return Productos
     * @throws Exception
     */
    public static function searchForId($id) : ?Productos
    {
        try {
            if ($id > 0) {
                $Producto = new Productos();
                $Producto->Connect();
                $getrow = $Producto->getRow("SELECT * FROM parqueadero.productos WHERE id =?", array($id));
                $Producto->Disconnect();
                return ($getrow) ? new Productos($getrow) : null;
            }else{
                throw new Exception('Id de producto Invalido');
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
        return Productos::search("SELECT * FROM parqueadero.productos");
    }

    /**
     * @param $nombre
     * @return bool
     * @throws Exception
     */
    public static function productoRegistrado($nombre): bool
    {
        $nombre = trim(strtolower($nombre));
        $result = Productos::search("SELECT id FROM parqueadero.productos where nombre = '" . $nombre. "'");
        if ( !empty($result) && count ($result) > 0 ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return float|mixed
     */
    public function getPrecioVenta() : float
    {
        return $this->precio + ($this->precio * ($this->porcentaje_ganancia / 100));
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return "Nombre: $this->nombre, Precio: $this->precio, Porcentaje: $this->porcentaje_ganancia, Stock: $this->stock, Estado: $this->estado";
    }

    public function substractStock(int $quantity)
    {
        $this->setStock( $this->getStock() - $quantity);
        $result = $this->update();
        if($result == false){
            GeneralFunctions::console('Stock no actualizado!');
        }
        return $result;
    }

    public function addStock(int $quantity)
    {
        $this->setStock( $this->getStock() + $quantity);
        $result = $this->update();
        if($result == false){
            GeneralFunctions::console('Stock no actualizado!');
        }
        return $result;
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
            'precio' => $this->getPrecio(),
            'porcentaje_ganancias' => $this->getPorcentajeGanancia(),
            'precio_venta' => $this->getPrecioVenta(),
            'stock' => $this->getStock(),
            'placa' => $this->getPlaca()->jsonSerialize(),
            'marca' => $this->getMarca()->jsonSerialize(),
            'colores' => $this->getColores()->jsonSerialize(),
            'vehiculo' => $this->getVehiculo()->jsonSerialize(),
            'estado' => $this->getEstado(),
        ];
    }
}