<?php

namespace App;

class Doctor
{
    //BASE DE DATOS
    protected static $db;
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'especialidad', 'hora_entrada', 'hora_salida', 'foto', 'telefono'];

    //errores
    protected static $errores = [];

    public $id;
    public $nombre;
    public $apellido;
    public $especialidad;
    public $hora_entrada;
    public $hora_salida;
    public $foto;
    public $telefono;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->especialidad = $args['especialidad'] ?? '';
        $this->hora_entrada = $args['hora_entrada'] ?? '';
        $this->hora_salida = $args['hora_salida'] ?? '';
        $this->foto = $args['foto'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
    }
    //DEFINIR LA CONEXION A LA BASE DE DATOS
    public static function setDB($database)
    {
        self::$db = $database;
    }

    public function guardar()
    {
        //Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        $query = "INSERT INTO tbl_doctores( ";
        $query .= join(', ', array_keys($atributos));
        $query .= ") VALUES(' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ')";

        $resultado = self::$db->query($query);
        return $resultado;
    }

    //Identificar los atributos de la base de datos
    public function atributos()
    {
        $atributos = [];
        foreach (self::$columnasDB as $columna) {
            if ($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    //SUBIDA DE ARCHIVOS
    public function setFoto($foto)
    {
        if ($foto) {
            $this->foto = $foto;
        }
    }

    public function sanitizarAtributos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }

        return $sanitizado;
    }

    //errores

    public static function getErrores()
    {
        return self::$errores;
    }

    public function validar()
    {
        if (!$this->nombre) {
            self::$errores[] = "El nombre es requerido";
        }

        if (!$this->apellido) {
            self::$errores[] = "El apellido es requerido";
        }

        if (!$this->especialidad) {
            self::$errores[] = "La especialidad es requerido";
        }
        if (!$this->hora_entrada) {
            self::$errores[] = "La hora de entrada es requerido";
        }

        if (!$this->hora_salida) {
            self::$errores[] = "La hora de salida es requerido";
        }

        if (!$this->foto) {
            self::$errores[] = "La foto es requerida";
        }

        if (!$this->telefono) {
            self::$errores[] = "El telefono es requerida";
        }

        return self::$errores;
    }

    //lista los doctores

    public static function all(){
        echo "Consultando todos los doctores";
        exit;
    }
}
