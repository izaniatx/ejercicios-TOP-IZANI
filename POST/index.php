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


        $top = new Top();

        $inception = new Movie("Inception", "0000-0001-2345-6789-A", 2010, 5);
        $matrix = new Movie("The Matrix", "0000-0002-3456-7890-B", 1999, 5);
        $interstellar = new Movie("Interstellar", "0000-0003-4567-8901-C", 2014, 4);

        if (isset($_POST['aux']) && !empty($_POST['aux'])){
            $var = isset($_POST['aux']) ? $_POST['aux'] : "";
            $top = $top->stringToArray($var);
        }  

        $top->add_movie($inception);
        $top->add_movie($matrix);
        $top->add_movie($interstellar);

        $movies = $top->get_movies();
    ?>

    <?php 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $ISAN = $_POST['ISAN'];
            $anio = $_POST['anio'];
            $puntuacion = $_POST['puntuacion'];

            $nueva_pelicula = new Movie($nombre, $ISAN, $anio, $puntuacion);

            $top->add_movie($nueva_pelicula);
            $movies = $top->get_movies();
        }
    ?>

    <h4>Inntroduce una película</h4>

    <form action="index.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <br>
        <label for="ISAN">ISAN:</label>
        <input type="text" id="ISAN" name="ISAN" required>
        <br>
        <label for="anio">Año:</label>
        <input type="text" id="anio" name="anio" required>
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
        <input type="submit" value="Enviar">
        <input type="hidden" name="aux" value="<?php echo $string?>">
    </form>

    <h2>Top de Películas</h2>
    <ul>
        <?php foreach ($movies as $movie): ?>
            <li>
                <strong>Nombre:</strong> <?php echo htmlspecialchars($movie->get_name()); ?>
            </li>
            <li>
                <strong>ISAN:</strong> <?php echo htmlspecialchars($movie->get_isan()); ?>
            </li>
            <li>
                <strong>Año:</strong> <?php echo htmlspecialchars($movie->get_year()); ?>
            </li>
            <li>
                <strong>Puntuación:</strong> <?php echo htmlspecialchars($movie->get_rating()); ?>
            </li>
            <hr>
        <?php endforeach; ?>
    </ul>

</body>
</html>