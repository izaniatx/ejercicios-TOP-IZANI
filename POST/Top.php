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
    }
?>