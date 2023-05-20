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
    <title>Notícia de Consciència Ambiental</title>
  </head>
<body>

  <?php 
  session_start(); // Necessari per poder utilitzar la funció isset() més avall

  if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $_SESSION["id"] = $id;
  } else {
    $id = $_SESSION['id']; // Últim ID guardat
  }

  if (isset($_GET["lang"])) {
    $lang = $_GET["lang"];
    $_SESSION["lang"] = $lang;
  } else if (isset($_SESSION["lang"])) {
    $lang = $_SESSION["lang"];
  } else {
    $lang = 'ca';
  }

  $jsonMenu = file_get_contents('./menu.json');
  $menu = json_decode($jsonMenu);
  ?>
  <nav>
      <ul class="primary-menu">
          <li><a href="bloc.php"><?php print_r($menu->home->$lang);?></a></li>
          <li><a href="activitat_1.php"><?php print_r($menu->act1->$lang);?></a></li>
          <li><a href=""><?php print_r($menu->api->$lang);?></a></li>
          <li><a href="login.php"><?php print_r($menu->login->$lang);?></a></li>
          <li><a href=""><?php print_r($menu->profile->$lang);?></a></li>
          <li><a href=""><?php print_r($menu->logout->$lang);?></a></li>
      </ul>
      <ul class="lang-selector">
          <li class="language"><a href="?lang=ca"><img class="flag" src="./img/ca.png" alt="Català"></a></li>
          <li class="language"><a href="?lang=en"><img class="flag" src="./img/en.png" alt="Anglès"></a></li>
      </ul>
  </nav>
  <?php

  $jsonData = file_get_contents('./posts/post_' . $id . '.json');
  $data = json_decode($jsonData);
  ?>
  <ul>
      <li>
          <h1><?php print_r($data->title->$lang);?></h1>
          <p><?php print date("d/m/Y", $data->date);?></p>
          <p><?php print_r($data->description->$lang);?></p>
          <img class="post" src="<?php print_r($data->image);?>">
      </li>
  </ul><?php

  ?>

</body>
</html>