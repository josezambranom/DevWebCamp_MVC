<?php 

namespace Classes;

class Paginacion {
    public $paginaActual, $registrosxPagina, $totalRegistros;

    public function __construct($paginaActual = 1, $registrosxPagina = 10, $totalRegistros = 0)
    {   
        $this->paginaActual = (int) $paginaActual;
        $this->registrosxPagina = (int) $registrosxPagina;
        $this->totalRegistros = (int) $totalRegistros;
    }

    public function offset() {
        return $this->registrosxPagina * ($this->paginaActual - 1);
    }

    public function totalPages() {
        return ceil($this->totalRegistros / $this->registrosxPagina);
    }

    public function paginaAnterior() {
        $anterior = $this->paginaActual - 1;
        return ($anterior > 0) ? $anterior : false;
    }

    public function paginaSiguiente() {
        $siguiente = $this->paginaActual + 1;
        return ($siguiente <= $this->totalPages()) ? $siguiente : false;
    }

    public function enlaceAnterior() {
        $html = '';
        if($this->paginaAnterior()) {
            $html .= "<a class=\"paginacion__enlace paginacion__enlace--texto\" href=\"?page={$this->paginaAnterior()}\">&laquo; Anterior</a>";
        }
        return $html;
    }

    public function enlaceSiguiente() {
        $html = '';
        if($this->paginaSiguiente()) {
            $html .= "<a class=\"paginacion__enlace paginacion__enlace--texto\" href=\"?page={$this->paginaSiguiente()}\">Siguiente &raquo;</a>";
        }
        return $html;
    }

    public function numPages() {
        $html = '';
        for($i = 1; $i <= $this->totalPages(); $i++) {
            if($i === $this->paginaActual) {
                $html .= "<span class=\"paginacion__enlace paginacion__enlace--actual\">{$i}</span>";
            } else {
                $html .= "<a class=\"paginacion__enlace paginacion__enlace--numero\" href=\"?page={$i}\">{$i}</a>";
            }
        }
        return $html;
    }

    public function paginacion() {
        $html = '';
        if($this->totalRegistros > 1) {
            $html .= '<div class="paginacion">';
            $html .= $this->enlaceAnterior();
            $html .= $this->numPages();
            $html .= $this->enlaceSiguiente();
            $html .= '</div>';
        }
        return $html;
    }
}

?>