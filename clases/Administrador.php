<?php

require "Conexion.php";

class Administrador extends Conexion{
    protected $id;
    protected $nombre;
    protected $apellido;
    protected $carnet;
    protected $salario;
    protected $telefono;
    protected $correo;
    protected $password;
    protected $id_departamento;
    protected $id_rol;
    protected $id_estado;

    /** CRUD de Admis */
    //metodo para obtener todos los departamentos
    public function departamentos(){
        $this->conectar();
        $query = "SELECT * FROM departamento";
        //ejecutando la consulta => mysqli_query()
        $resultado = mysqli_query($this->conexion, $query);
        return $resultado;
    }

    public function roles(){
        $this->conectar();
        $query = "SELECT * FROM rol";
        //ejecutando la consulta => mysqli_query()
        $resultado2 = mysqli_query($this->conexion, $query);
        return $resultado2;
    }

    public function insertar(){
        //isset() => verifica si los campos del formulario no estan vacios
        if(isset($_POST['nombre'], $_POST['apellido'], $_POST['salario'], $_POST['carnet'],
        $_POST['telefono'], $_POST['correo'], $_POST['password'], $_POST['departamento'])){

            //asignando a las propiedades los campos del formulario
            $this->nombre = $_POST['nombre'];
            $this->apellido = $_POST['apellido'];
            $this->salario = $_POST['salario'];
            $this->carnet = $_POST['carnet'];
            $this->telefono = $_POST['telefono'];
            $this->correo = $_POST['correo'];
            $this->password = $_POST['password'];
            $this->id_departamento = $_POST['departamento'];
            $this->id_rol = 1;
            $this->id_estado = 1; //administrador activo

            //consulta para insertar en la base de datos
            $query = "INSERT INTO administrador (nombre, apellido, salario, carnet, telefono, correo, password, id_departamento, id_rol, id_estado) VALUES ('$this->nombre', '$this->apellido', $this->salario, '$this->carnet', $this->telefono, '$this->correo', '$this->password', $this->id_departamento, $this->id_rol, $this->id_estado)";

            $result = mysqli_query($this->conexion, $query);
            //validando que se haya guardado el registro y retorne a otra vista

            if(!empty($result)){
               
                header("location: administradores.php");
            }else{
                echo "Error al registrar el administrador";
            }
        }
    }

    //obteniendo todos los administradores
    public function getAdministrador(){
        $this->conectar();
        $query = "SELECT administrador.*, departamento.nombre AS departamento FROM administrador INNER JOIN departamento ON administrador.id_departamento = departamento.id WHERE administrador.id_estado = 1";
        $result = mysqli_query($this->conexion, $query);
        return $result;
    }

    //obteniendo un administrador en base a su id
    public function getAdministradorById(){
        if(isset($_POST['id_administrador'])){
            $this->id = $_POST['id_administrador'];
            $this->conectar();
            $query = "SELECT administrador.*, departamento.nombre AS departamento FROM administrador INNER JOIN departamento ON administrador.id_departamento = departamento.id WHERE administrador.id = $this->id";
            $result = mysqli_query($this->conexion, $query);
            return $result; //[]
        }
        
    }

    //actualizando el administrador
    public function actualizar(){
        if(isset($_POST['nombre'], $_POST['apellido'], $_POST['salario'], $_POST['carnet'], $_POST['telefono'], $_POST['correo'], $_POST['password'], $_POST['departamento'], $_POST['id_administrador'])){

            //asignando a las propiedades los campos del formulario
            $this->nombre = $_POST['nombre'];
            $this->apellido = $_POST['apellido'];
            $this->salario = $_POST['salario'];
            $this->carnet = $_POST['carnet'];
            $this->telefono = $_POST['telefono'];
            $this->correo = $_POST['correo'];
            $this->password = $_POST['password'];
            $this->id_departamento = $_POST['departamento'];
            $this->id = $_POST['id_administrador'];

            //consulta para actualizar un administrador por su id
            $query = "UPDATE administrador SET nombre = '$this->nombre', apellido = '$this->apellido', salario = $this->salario, carnet = '$this->carnet', telefono = $this->telefono, correo = '$this->correo', password = '$this->password', id_departamento = $this->id_departamento WHERE id = $this->id";

            $result = mysqli_query($this->conexion, $query);
            //validando que se haya guardado el registro y retorne a otra vista

            //empty => verifica si algo esta vacio o no
            if(!empty($result)){
                //redireccionando al index
                header("location: administradores.php");
            }else{
                echo "Error al actualizar el administrador";
            }
        }
    }

    //actualizando el estado del administrador en inactivo
    public function desactivar(){
        if(isset($_POST['id_administrador'])){
            $this->id = $_POST['id_administrador']; 
            $this->id_estado = 2; 
            $this->conectar();
            $query = "UPDATE administrador SET id_estado = $this->id_estado 
            WHERE id = $this->id";
            $result = mysqli_query($this->conexion, $query);
            if(!empty($result)){
                echo "";
            }else{
                echo "No se pudo desactivar el Administrador";
            }
        }
    }
}


?>