<?php

include ('../library/config.php');
class conexion {
    public $conexion;
    private static $instancia;

    public function __construct() {
        try {
            $this->conexion = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            exit;
        }
    }

    public function __destruct() {
        $this->conexion = null;
    }

    public static function getInstancia() {
        if (!self::$instancia) {
            self::$instancia = new conexion();
        }
        return self::$instancia;
    }

    static function consulta($sql, $parametros = []) {
        $c = self::getInstancia();
        $stmt = $c->conexion->prepare($sql);
        $stmt->execute($parametros);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    static function exec($sql, $parametros = []) {
        $c = self::getInstancia();
        $stmt = $c->conexion->prepare($sql);
        $stmt->execute($parametros);
        return $stmt->rowCount();
    }

    static function lastInsertId() {
        $c = self::getInstancia();
        return $c->conexion->lastInsertId();
    }
}

?>