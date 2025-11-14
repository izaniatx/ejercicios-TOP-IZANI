<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        require_once 'Movie.php';
        require_once 'Top.php';

        $string = "";
        $top = new Top();

        $inception = new Movie("Inception", "12345678", 2010, 5);
        $matrix = new Movie("The Matrix", "23456789", 1999, 5);
        $interstellar = new Movie("Interstellar", "34567890", 2014, 4);
        $superman = new Movie("Superman", "45678901", 1978, 4);
        $BatmanVsSuperman = new Movie("Batman vs Superman", "56789012", 2016, 3);

        $top->add_movie($inception);
        $top->add_movie($matrix);
        $top->add_movie($interstellar);
        $top->add_movie($superman);
        $top->add_movie($BatmanVsSuperman);

        $movies = $top->get_movies();
    ?>

    <?php 

        if (isset($_POST['aux']) && !empty($_POST['aux'])){
            $var = isset($_POST['aux']) ? $_POST['aux'] : "";
            $top = $top->stringToArray($var);
        }  


        if (isset($_POST['enviar'])) {
            $nombre = $_POST['nombre'];
            $isan = $_POST['isan'];
            $anio = $_POST['anio'];
            $puntuacion = $_POST['puntuacion'];
            $is_valid = true;


            if (empty($nombre) && empty($isan)) {
                echo "<p style='color:red;'>El nombre y el isan son obligatorios.</p>";
                $is_valid = false;
            } else if (empty($isan) && !empty($nombre)) {
                $html = "<ul>";
                $moviesName = $top->getByName($nombre);

                foreach ($moviesName as $movie) {
                    $html .= "<li>
                {$movie->get_nombre()} - ISAN: {$movie->get_isan()} - Año: {$movie->get_anio()} - Puntuación: {$movie->get_puntuacion()}
                    </li>";
                }
                $html .= "</ul>";
                $is_valid = false;
                echo $html;
            } else if (strlen($isan) != 8) {
                echo "<p style='color:red;'>El campo ISAN debe tener exactamente 8 caracteres.</p>";
                $is_valid = false;
            } else if ($top->comprobarIsan($isan) && !empty($nombre) && !empty($anio) && !empty($puntuacion)) {
                $top->updateMovie($nombre, $isan, $anio, $puntuacion);
                echo "<p style='color:green;'>Película actualizada correctamente.</p>";
                $is_valid = false;
            }

            if ($top->comprobarIsan($isan) && empty($nombre) && empty($anio) && empty($puntuacion)) {
                $top->deleteMovie($isan);
                echo "<p style='color:green;'>Película eliminada correctamente.</p>";
                $is_valid = false;
            }
            
            if ($is_valid) {
                $new_movie = new Movie($nombre, $isan, $anio, $puntuacion);
                $top->add_movie($new_movie);
                $movies = $top->get_movies();
                $string = $top->arrayToString($movies);
            }

            $movies = $top->get_movies();
        }
    ?>

    <h4>Inntroduce una película</h4>

    <form action="index.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre">
        <br>
        <label for="isan">ISAN:</label>
        <input type="text" id="isan" name="isan">
        <br>
        <label for="anio">Año:</label>
        <input type="text" id="anio" name="anio" >
        <br>
        <label for="puntuacion">Puntuacion:</label>
        <select id="puntuacion" name="puntuacion" class="form-select">
            <option value="">-- selecciona --</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        <br>
        <button type="submit" name="enviar">Enviar</button>
        <input type="hidden" name="aux" value="<?php echo $string?>">
    </form>

    <h2>Top de Películas</h2>
    <ul>
        <?php foreach ($movies as $movie): ?>
            <li>
                <strong>Nombre:</strong> <?php echo htmlspecialchars($movie->get_nombre()); ?>
            </li>
            <li>
                <strong>ISAN:</strong> <?php echo htmlspecialchars($movie->get_isan()); ?>
            </li>
            <li>
                <strong>Año:</strong> <?php echo htmlspecialchars($movie->get_anio()); ?>
            </li>
            <li>
                <strong>Puntuación:</strong> <?php echo htmlspecialchars($movie->get_puntuacion()); ?>
            </li>
            <hr>
        <?php endforeach; ?>
    </ul>

</body>
</html>