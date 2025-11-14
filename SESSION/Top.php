<?php
    class Top {
        private $movies;

        public function __construct() {
            $this->movies = array();
        }

        public function add_movie(Movie $movie) {
            $this->movies[] = $movie;
        }

        public function get_movies() {
            return $this->movies;
        }

        public function arrayToString($array) {
            $string = "";
            foreach ($array as $c => $v) {
                $string .= $c . ":";
                $string .= $v->get_nombre() . 
                    "," . $v->get_isan() . "," . $v->get_anio() . 
                    "," . $v->get_puntuacion() . "&";
            }
            return $string;
        }

        public function stringToArray($string) {
            $top = new Top(); 
            $records = explode("&", trim($string, "&")); 

            foreach ($records as $r) {
                $values = explode(":", $r, 2); 
                $key = $values[0];
                $attributes = explode(",", $values[1]);

                list($nombre, $isan, $anio, $puntuacion) = $attributes;
                $movie = new Movie($nombre, $isan, $anio, $puntuacion);

                $top->add_movie($movie);
            }
            return $top;
        }

        public function comprobarIsan($isan) {
            foreach ($this->movies as $movie) {
                if ($movie->get_isan() === $isan) {
                    return true;
                }
            }
            return false;
        }

        public function getByName($name) {
            $pattern = "/$name/i";
            $matched_movies = [];
            foreach ($this->movies as $movie) {
                if (preg_match($pattern, $movie->get_nombre())) {
                    $matched_movies[] = $movie;
                }
            }
            return $matched_movies;
        }

        public function updateMovie($nombre, $isan, $anio, $puntuacion) {
            foreach ($this->movies as $movie) {
                if ($movie->get_isan() === $isan) {
                    $movie->set_nombre($nombre);
                    $movie->set_anio($anio);
                    $movie->set_puntuacion($puntuacion);
                    return true;
                }
            }
            return false;
        }

        public function deleteMovie($isan) {
            $this->movies = array_filter($this->movies, function($movie) use ($isan) {
                return $movie->get_isan() !== $isan;
            });
        }
    }
?>