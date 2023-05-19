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
    <div>
        <ul>
            <li class="language">Selector d'idioma</li>
            <li class="language"><a href="?lang=ca"><img class="flag" src="./img/ca.png" alt="Català"></a></li>
            <li class="language"><a href="?lang=en"><img class="flag" src="./img/en.png" alt="Anglès"></a></li>
        </ul>
    </div>
    <main>
        <?php

        $id = 0;
        $numwords = 120;
        $lang = $_GET["lang"];;
        $order = 'DESC';
        $sortByTitle = false;
        $sortByDate = true;
        $arrayPosts = array();

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
                $link = 'post.php?id=' . $id;
                $jsonData = file_get_contents('./posts/' . $file);
                $data = json_decode($jsonData);
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
            $id = $id + 1;
            $link = 'post.php?id=' . $id;
            ?>
            <ul>
                <li>
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
