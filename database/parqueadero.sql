-- MySQL Script generated by MySQL Workbench
-- Thu Jun 17 19:15:46 2021
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema parqueadero
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema parqueadero
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `parqueadero` DEFAULT CHARACTER SET utf8 ;
USE `parqueadero` ;

-- -----------------------------------------------------
-- Table `parqueadero`.`departamentos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `parqueadero`.`departamentos` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(150) NOT NULL,
  `region` ENUM('Caribe', 'Centro Oriente', 'Centro Sur', 'Eje Cafetero - Antioquia', 'Llano', 'Pacífico') NOT NULL,
  `estado` ENUM('Activo', 'Inactivo') NOT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  `deleted_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `parqueadero`.`municipios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `parqueadero`.`municipios` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(150) NOT NULL,
  `acortado` VARCHAR(60) NULL,
  `estado` ENUM('Activo', 'Inactivo') NOT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  `deleted_at` TIMESTAMP NULL,
  `departamento_id` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_municipios_departamentos1_idx` (`departamento_id` ASC) ,
  CONSTRAINT `fk_municipios_departamentos1`
    FOREIGN KEY (`departamento_id`)
    REFERENCES `parqueadero`.`departamentos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `parqueadero`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `parqueadero`.`usuarios` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombres` VARCHAR(200) NOT NULL,
  `apellidos` VARCHAR(200) NOT NULL,
  `tipo_documento` ENUM('C.C', 'C.E', 'T.I', 'R.C', 'Pasaporte') NOT NULL,
  `documento` BIGINT NOT NULL,
  `telefono` BIGINT NOT NULL,
  `direccion` VARCHAR(105) NOT NULL,
  `municipio_id` BIGINT UNSIGNED NOT NULL,
  `fecha_nacimiento` DATE NOT NULL,
  `user` VARCHAR(100) NULL,
  `password` VARCHAR(150) NULL,
  `foto` VARCHAR(105) NULL,
  `rol` ENUM('Administrador', 'Empleado', 'Cliente', 'Proveedor') NOT NULL,
  `estado` ENUM('Activo', 'Inactivo') NOT NULL,
  `created_at` TIMESTAMP NOT NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_usuarios_municipios1_idx` (`municipio_id` ASC) ,
  CONSTRAINT `fk_usuarios_municipios1`
    FOREIGN KEY (`municipio_id`)
    REFERENCES `parqueadero`.`municipios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `parqueadero`.`compras`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `parqueadero`.`compras` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `numero_serie` VARCHAR(100) NOT NULL,
  `empleado_id` INT UNSIGNED NOT NULL,
  `proveedor_id` INT UNSIGNED NOT NULL,
  `fecha_compra` DATETIME NOT NULL,
  `monto` DOUBLE NOT NULL,
  `estado` ENUM('En progreso', 'Cancelada', 'Finalizada') NOT NULL,
  `created_at` TIMESTAMP NOT NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_compras_usuarios1_idx` (`empleado_id` ASC) ,
  INDEX `fk_compras_usuarios2_idx` (`proveedor_id` ASC) ,
  CONSTRAINT `fk_compras_usuarios1`
    FOREIGN KEY (`empleado_id`)
    REFERENCES `parqueadero`.`usuarios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_compras_usuarios2`
    FOREIGN KEY (`proveedor_id`)
    REFERENCES `parqueadero`.`usuarios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `parqueadero`.`marcas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `parqueadero`.`marcas` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(150) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `estado` ENUM('Activo', 'Inactivo') NOT NULL,
  `created_at` TIMESTAMP NOT NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `parqueadero`.`placas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `parqueadero`.`placas` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(150) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `estado` ENUM('Activo', 'Inactivo') NOT NULL,
  `created_at` TIMESTAMP NOT NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `parqueadero`.`coloress`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `parqueadero`.`coloress` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(150) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `estado` ENUM('Activo', 'Inactivo') NOT NULL,
  `created_at` TIMESTAMP NOT NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `parqueadero`.`vehiculos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `parqueadero`.`vehiculos` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(150) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `estado` ENUM('Activo', 'Inactivo') NOT NULL,
  `created_at` TIMESTAMP NOT NULL,
  `updated_at` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `parqueadero`.`productos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `parqueadero`.`productos` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `precio` DECIMAL NOT NULL,
  `porcentaje_ganancia` FLOAT NOT NULL,
  `stock` MEDIUMINT NOT NULL,
  `placa_id` INT UNSIGNED NOT NULL,
  `marca_id` INT UNSIGNED NOT NULL,
  `colores_id` INT UNSIGNED NOT NULL,
  `vehiculo_id` INT UNSIGNED NOT NULL,
  `estado` ENUM('Activo', 'Inactivo') NOT NULL,
  `created_at` TIMESTAMP NOT NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_productos_marcas1_idx` (`marca_id` ASC) ,
  INDEX `fk_productos_placas1_idx` (`placa_id` ASC) ,
  INDEX `fk_productosYservicios_coloress1_idx` (`colores_id` ASC) ,
  INDEX `fk_productosYservicios_vehiculos1_idx` (`vehiculo_id` ASC) ,
  CONSTRAINT `fk_productos_marcas1`
    FOREIGN KEY (`marca_id`)
    REFERENCES `parqueadero`.`marcas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_productos_placas1`
    FOREIGN KEY (`placa_id`)
    REFERENCES `parqueadero`.`placas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_productosYservicios_coloress1`
    FOREIGN KEY (`colores_id`)
    REFERENCES `parqueadero`.`coloress` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_productosYservicios_vehiculos1`
    FOREIGN KEY (`vehiculo_id`)
    REFERENCES `parqueadero`.`vehiculos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `parqueadero`.`ventas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `parqueadero`.`ventas` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `numero_serie` VARCHAR(250) NOT NULL,
  `cliente_id` INT UNSIGNED NOT NULL,
  `empleado_id` INT UNSIGNED NOT NULL,
  `fecha_venta` DATETIME NOT NULL,
  `monto` DOUBLE NOT NULL,
  `estado` ENUM('En progreso', 'Cancelada', 'Finalizada') NOT NULL,
  `created_at` TIMESTAMP NOT NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_ventas_usuarios1_idx` (`cliente_id` ASC) ,
  INDEX `fk_ventas_usuarios2_idx` (`empleado_id` ASC) ,
  CONSTRAINT `fk_ventas_usuarios1`
    FOREIGN KEY (`cliente_id`)
    REFERENCES `parqueadero`.`usuarios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ventas_usuarios2`
    FOREIGN KEY (`empleado_id`)
    REFERENCES `parqueadero`.`usuarios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `parqueadero`.`detalle_ventas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `parqueadero`.`detalle_ventas` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `venta_id` INT UNSIGNED NOT NULL,
  `producto_id` INT UNSIGNED NOT NULL,
  `cantidad` INT NOT NULL,
  `precio_venta` DOUBLE NOT NULL,
  `created_at` TIMESTAMP NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_detalle_ventas_ventas1_idx` (`venta_id` ASC) ,
  INDEX `fk_detalle_ventas_productos1_idx` (`producto_id` ASC) ,
  CONSTRAINT `fk_detalle_ventas_ventas1`
    FOREIGN KEY (`venta_id`)
    REFERENCES `parqueadero`.`ventas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalle_ventas_productos1`
    FOREIGN KEY (`producto_id`)
    REFERENCES `parqueadero`.`productos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `parqueadero`.`fotos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `parqueadero`.`fotos` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(60) NULL,
  `descripcion` TEXT NULL,
  `producto_id` INT UNSIGNED NOT NULL,
  `ruta` VARCHAR(120) NOT NULL,
  `estado` ENUM('Activo', 'Inactivo') NOT NULL,
  `created_at` TIMESTAMP NOT NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_fotos_productos1_idx` (`producto_id` ASC) ,
  CONSTRAINT `fk_fotos_productos1`
    FOREIGN KEY (`producto_id`)
    REFERENCES `parqueadero`.`productos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `parqueadero`.`detalle_compras`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `parqueadero`.`detalle_compras` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `producto_id` INT UNSIGNED NOT NULL,
  `compra_id` INT UNSIGNED NOT NULL,
  `cantidad` INT NOT NULL,
  `precio_venta` DOUBLE NOT NULL,
  `created_at` TIMESTAMP NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_detalle_compras_productos1_idx` (`producto_id` ASC) ,
  INDEX `fk_detalle_compras_compras1_idx` (`compra_id` ASC) ,
  CONSTRAINT `fk_detalle_compras_productos1`
    FOREIGN KEY (`producto_id`)
    REFERENCES `parqueadero`.`productos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalle_compras_compras1`
    FOREIGN KEY (`compra_id`)
    REFERENCES `parqueadero`.`compras` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;