<?php 

namespace Controllers;

use Classes\Paginacion;
use Model\Ponente;
use MVC\Router;
use Intervention\Image\ImageManagerStatic as Image;

class PonentesController {
    public static function index(Router $router) {
        $paginaActual = $_GET['page'];
        $paginaActual = filter_var($paginaActual, FILTER_VALIDATE_INT);
        if(!$paginaActual || $paginaActual < 1) header('Location: /admin/ponentes?page=1');

        $registros = 10;
        $total = Ponente::total();

        $paginacion = new Paginacion($paginaActual, $registros, $total);

        if($paginacion->totalPages() < $paginaActual) header('Location: /admin/ponentes?page=1');

        $ponente = Ponente::paginar($registros, $paginacion->offset());

        if(!is_Admin()) header('Location: /login');
        
        $router->render('admin/ponentes/index', [
            'titulo' => 'Ponentes / Conferencistas',
            'ponentes' => $ponente,
            'paginacion' => $paginacion->paginacion()
        ]);
    }

    public static function crear(Router $router) {
        if(!is_Admin()) header('Location: /login');
        $alertas = [];
        $ponente = new Ponente();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_Admin()) header('Location: /login');
            // Leer imagen
            if(!empty($_FILES['imagen']['tmp_name'])) {
                $carpeta_imagenes = '../public/img/speakers';
                
                // Crear la carpeta si no existe
                if(!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0755, true);
                }

                $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('png',80);
                $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('webp',80);

                $nombre_imagen = md5(uniqid(rand(), true));
                $_POST['imagen'] = $nombre_imagen;
            }

            $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);

            $ponente->sincronizar($_POST);
            $alertas = $ponente->validar();

            if(empty($alertas)) {
                // Guardar el registro
                $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . '.png');
                $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . '.webp');

                $resultado = $ponente->guardar();
                if($resultado) {
                    header('Location: /admin/ponentes');
                }
            }
        }

        $router->render('admin/ponentes/crear', [
            'titulo' => 'Registrar Ponente',
            'alertas' => $alertas,
            'ponente' => $ponente,
            'redes' => json_decode($ponente->redes)
        ]);
    }

    public static function editar(Router $router) {
        if(!is_Admin()) header('Location: /login');
        $alertas = [];

        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if(!$id) header('Location: /admin/ponentes');

        $ponente = Ponente::find($id);
        if(!$ponente) header('Location: /admin/ponentes');

        $ponente->imagen_actual = $ponente->imagen;

        $redes = json_decode($ponente->redes);

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_Admin()) header('Location: /login');
            // Leer imagen
            if(!empty($_FILES['imagen']['tmp_name'])) {
                $carpeta_imagenes = '../public/img/speakers';
                
                // Crear la carpeta si no existe
                if(!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0755, true);
                }

                $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('png',80);
                $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('webp',80);

                $nombre_imagen = md5(uniqid(rand(), true));
                $_POST['imagen'] = $nombre_imagen;
            } else {
                $_POST['imagen'] = $ponente->imagen_actual;
            }
            $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);
            $ponente->sincronizar($_POST);
            $alertas = $ponente->validar();

            if(empty($alertas)) {
                if(isset($nombre_imagen)) {
                    $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . '.png');
                    $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . '.webp');
                }
                $resultado = $ponente->guardar();
                if($resultado) {
                    header('Location: /admin/ponentes');
                }
            }
        }

        $router->render('admin/ponentes/editar', [
            'titulo' => 'Actualizar Ponente',
            'alertas' => $alertas,
            'ponente' => $ponente,
            'redes' => $redes
        ]);
    }

    public static function eliminar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_Admin()) header('Location: /login');
            $id = $_POST['id'];
            $ponente = Ponente::find($id);
            if(!isset($ponente)) {
                header('Location: /admin/ponentes');
            }
            $resultado = $ponente->eliminar();
            if($resultado) {
                header('Location: /admin/ponentes');
            }
        }
    }
}

?>