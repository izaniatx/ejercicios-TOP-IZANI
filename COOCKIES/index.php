<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        session_start();

        require_once 'Movie.php';
        require_once 'Top.php';

        $top = new Top();

        if (isset($_SESSION['aux'])) {
            $top = $top->stringToArray($_SESSION['aux']);
        } else {
            $top->add_movie(new Movie("Inception", "12345678", 2010, 5));
            $top->add_movie(new Movie("The Matrix", "23456789", 1999, 5));
            $top->add_movie(new Movie("Interstellar", "34567890", 2014, 4));
            $top->add_movie(new Movie("Superman", "45678901", 1978, 4));
            $top->add_movie(new Movie("Batman vs Superman", "56789012", 2016, 3));
        }

        $movies = $top->get_movies();

        if (isset($_POST['enviar'])) {

            $nombre = $_POST['nombre'] ?? "";
            $isan = $_POST['isan'] ?? "";
            $anio = $_POST['anio'] ?? "";
            $puntuacion = $_POST['puntuacion'] ?? "";
            $is_valid = true;

            if (empty($nombre) && empty($isan)) {
                echo "<p style='color:red;'>Nombre e ISAN obligatorios.</p>";
                $is_valid = false;
            }
            else if (empty($isan) && !empty($nombre)) {
                $moviesName = $top->getByName($nombre);
                echo "<ul>";
                foreach ($moviesName as $movie) {
                    echo "<li>{$movie->get_nombre()} - ISAN: {$movie->get_isan()} - Año: {$movie->get_anio()} - Puntuación: {$movie->get_puntuacion()}</li>";
                }
                echo "</ul>";
                $is_valid = false;
            }
            else if (strlen($isan) != 8) {
                echo "<p style='color:red;'>El ISAN debe tener 8 caracteres.</p>";
                $is_valid = false;
            }
            else if ($top->comprobarIsan($isan) && !empty($nombre) && !empty($anio) && !empty($puntuacion)) {
                $top->updateMovie($nombre, $isan, $anio, $puntuacion);
                echo "<p style='color:green;'>Película actualizada.</p>";
                $is_valid = false;
            }

            if ($top->comprobarIsan($isan) && empty($nombre) && empty($anio) && empty($puntuacion)) {
                $top->deleteMovie($isan);
                echo "<p style='color:green;'>Película eliminada.</p>";
                $is_valid = false;
            }

            if ($is_valid) {
                $top->add_movie(new Movie($nombre, $isan, $anio, $puntuacion));
            }

            $_SESSION['aux'] = $top->arrayToString($top->get_movies());

            header("Location: index.php");
            exit();
        }
    ?>



    <h4>Inntroduce una película</h4>

    <form action="index.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre"><br>

        <label for="isan">ISAN:</label>
        <input type="text" id="isan" name="isan"><br>

        <label for="anio">Año:</label>
        <input type="text" id="anio" name="anio"><br>

        <label for="puntuacion">Puntuación:</label>
        <select id="puntuacion" name="puntuacion">
            <option value="">-- selecciona --</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select><br>

        <button type="submit" name="enviar">Enviar</button>
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