<?php
require_once('configuracion.php');

class Connection {
    protected $isConn;
    protected $datab;
    protected $transaction;

    public function __construct($username = "root", $password = "", $host = "localhost", $options = []) {
        global $BD_name, $BD_pass; // Accede a las variables globales definidas en configuracion.php

        $this->isConn = TRUE;

        try {
            $this->datab = new PDO("mysql:host={$host};dbname={$BD_name};charset=utf8", $username, $BD_pass, $options);
            $this->datab->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->transaction = $this->datab;
            $this->datab->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            //echo "Conexion exitosa";
        } catch (PDOException $e) {
            //echo "Error de conexión: " . $e->getMessage();
            throw new Exception($e->getMessage());
        }
    }

    public function Disconnect() {
        $this->datab = NULL; // Cerrar la conexión en PDO
        $this->isConn = FALSE;
    }
}
?>
