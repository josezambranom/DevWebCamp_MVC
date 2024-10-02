<?php 

namespace Controllers;

use Model\Paquete;
use Model\Registro;
use Model\Usuario;
use MVC\Router;

class RegistroController {
    public static function crear(Router $router) {

        if(!is_Auth()) {
            header('Location: /');
        }

        // Verificar si el usuario esta registrado (eligio un plan)
        $registro = Registro::where('usuario_id', $_SESSION['id']);
        if(isset($registro) && $registro->paquete_id === "3") {
            header('Location: /boleto?id=' . urlencode($registro->token));
        }

        $router->render('registro/crear', [
            'titulo' => 'Finalizar Registro'
        ]);
    }

    public static function gratis() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_Auth()) {
                header('Location: /login');
            }

            // Verificar si el usuario esta registrado (eligio un plan)
            $registro = Registro::where('usuario_id', $_SESSION['id']);
            if(isset($registro) && $registro->paquete_id === "3") {
                header('Location: /boleto?id=' . urlencode($registro->token));
            }

            $token = substr(md5(uniqid(rand(), true)), 0, 8);  // Se corta el token a 8 caracteres
            
            // Crear registro
            $datos = array(
                'paquete_id' => 3,
                'pago_id' => '',
                'token' => $token,
                'usuario_id' => $_SESSION['id']
            );

            $registro = new Registro($datos);
            $resultado = $registro->guardar();

            if($resultado) {
                header('Location: /boleto?id=' . urlencode($registro->token)); // Se redirige a la página de boleto 
            }
        }
    }

    public static function boleto(Router $router) {
        // Validar url
        $id = $_GET['id'];
        if(!$id || !strlen($id) === 8) {
            header('Location: /'); 
        }

        // Buscar en DB
        $registro = Registro::where('token', $id);
        if(!$registro) {
            header('Location: /');
        }

        // LLenar las tablas de referencia
        $registro->usuario = Usuario::find($registro->usuario_id);
        $registro->paquete = Paquete::find($registro->paquete_id);
        
        $router->render('registro/boleto', [
            'titulo' => 'Asistencia a DevWebCamp',
            'registro' => $registro
        ]);
    }

    public static function pagar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_Auth()) {
                header('Location: /login');
            }

            // Validar que POST no este vacio
            if(empty($_POST)) {
                echo json_encode([]);
                return;
            }

            // Crear registro
            $datos = $_POST;
            $datos['token'] = substr(md5(uniqid(rand(), true)), 0, 8);  // Se corta el token a 8 caracteres
            $datos['usuario_id'] = $_SESSION['id'];

            try {
                $registro = new Registro($datos);
                $resultado = $registro->guardar();
                echo json_encode([
                    $resultado
                ]);
            } catch (\Throwable $th) {
                echo json_encode([
                    'resultado' => 'error'
                ]);
            }

        }
    }
}

?>