<?php
    class Movie {
        private $nombre;
        private $isan;
        private $anio;
        private $puntuacion;

        public function __construct($nombre, $isan, $anio, $puntuacion) {
            $this->nombre = $nombre;
            $this->isan = $isan;
            $this->anio = $anio;
            $this->puntuacion = $puntuacion;
        }

        public function get_nombre() {
            return $this->nombre;
        }

        public function get_isan() {
            return $this->isan;
        }

        public function get_anio() {
            return $this->anio;
        }

        public function get_puntuacion() {
            return $this->puntuacion;   
        }

        public function set_nombre($nombre) {
            $this->nombre = $nombre;
        }
        public function set_isan($isan) {
            $this->isan = $isan;
        }
        public function set_anio($anio) {
            $this->anio = $anio;
        }
        public function set_puntuacion($puntuacion) {
            $this->puntuacion = $puntuacion;
        }
    }  