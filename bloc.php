<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <meta name="author" content="Oriol Esquena" />
    <meta
      name="description"
      content="Lloc web creat com a exercici de la PAC3 de l'assignatura Desenvolupament Back-End
      amb PHP del màster Desenvolupament de Llocs i Aplicacions Web de la UOC. 
      S'hi troben notícies sobre consciència ambiental."
    />
    <link rel="stylesheet" type="text/css" href="./css/styles.css" />
    <title>Consciència Ambiental</title>
  </head>
<body>
    <?php 
    session_start(); // Necessari per poder utilitzar la funció isset() més avall

    // Declarar variables
    $id = 0;
    $numwords = 120;
    if (isset($_GET["lang"])) {
        $lang = $_GET["lang"];
        $_SESSION["lang"] = $lang;
    } else if (isset($_SESSION["lang"])) {
        $lang = $_SESSION["lang"];
    } else {
        $lang = 'ca'; // Idioma per defecte
    }
    $order = 'DESC';
    $sortByTitle = false;
    $sortByDate = true;
    $arrayPosts = array();

    $jsonMenu = file_get_contents('./menu.json');
    $menu = json_decode($jsonMenu);
    ?>
    <nav>
        <ul class="primary-menu">
            <li><a href="bloc.php"><?php print_r($menu->home->$lang);?></a></li>
            <li><a href="activitat_1.php"><?php print_r($menu->act1->$lang);?></a></li>
            <li><a href=""><?php print_r($menu->api->$lang);?></a></li>
            <li><a href=""><?php print_r($menu->login->$lang);?></a></li>
            <li><a href=""><?php print_r($menu->profile->$lang);?></a></li>
            <li><a href=""><?php print_r($menu->logout->$lang);?></a></li>
        </ul>
        <ul class="lang-selector">
            <li class="language"><a href="?lang=ca"><img class="flag" src="./img/ca.png" alt="Català"></a></li>
            <li class="language"><a href="?lang=en"><img class="flag" src="./img/en.png" alt="Anglès"></a></li>
        </ul>
    </nav>
    <main>
        <?php

        function truncateWords($input, $numwords, $padding="") {
            $output = strtok($input, " \n");
            while(--$numwords > 0) $output .= " " . strtok(" \n");
            if($output != $input) $output .= $padding;
            return $output;
        }

        function cmp_titles($lang) {
            return function ($a, $b) use ($lang) {
                $titleA = $a->title->$lang;
                $titleB = $b->title->$lang;
                return strcmp($titleA, $titleB);
            };
        }

        function cmp_dates($a, $b) {
            $dateA = $a->date;
            $dateB = $b->date;
            if ($dateA == $dateB) {
                return 0;
            }
            return ($dateA < $dateB) ? -1 : 1;
        }

        $files = scandir('./posts/');
        foreach($files as $file) {

            /* S'afegeix el següent 'if' ja que sinó la funció scandir retorna 
            també '.' i '..' que són el mateix directori i el directori pare */
            if (substr($file, 0, 1) != '.') {
                $id = $id + 1;
                $jsonData = file_get_contents('./posts/' . $file);
                $data = json_decode($jsonData);
                $data->id = $id;
                $arrayPosts[] = $data;
            }
        }

        if ($sortByTitle) {
            usort($arrayPosts, cmp_titles($lang));
        } else if ($sortByDate) {
            usort($arrayPosts, "cmp_dates");
        }

        if ($order == 'DESC') {
            $arrayPosts = array_reverse($arrayPosts);
        }

        foreach($arrayPosts as $array) {
            
            $link = 'post.php?id=' . $array->id . '&lang=' . $lang;
            ?>
            <ul>
                <li class="post-home">
                    <h1><a href="<?php print $link ?>"><?php print_r($array->title->$lang);?></a></h1>
                    <p><?php print date("d/m/Y", $array->date);?></p>
                    <p><?php print truncateWords($array->description->$lang, $numwords, '...');?></p>
                    <img class="bloc" src="<?php print_r($array->image);?>">
                </li>
            </ul>
            <hr><?php
        }

        ?>
    </main>

</body>
</html>
