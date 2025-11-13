<?php
    class Movie {
        private $name;
        private $isan;
        private $year;
        private $rating;

        public function __construct($name, $isan, $year, $rating) {
            $this->name = $name;
            $this->isan = $isan;
            $this->year = $year;
            $this->rating = $rating;
        }

        public function get_name() {
            return $this->name;
        }

        public function get_isan() {
            return $this->isan;
        }

        public function get_year() {
            return $this->year;
        }

        public function get_rating() {
            return $this->rating;   
        }
    }