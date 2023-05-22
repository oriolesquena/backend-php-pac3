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
    if (isset($_GET["lang"])) {
        $lang = $_GET["lang"];
        $_SESSION["lang"] = $lang;
    } else if (isset($_SESSION["lang"])) {
        $lang = $_SESSION["lang"];
    } else {
        $lang = 'ca'; // Idioma per defecte
    }

    if (isset($_SESSION["login"])) {
        $login = $_SESSION["login"];
    } else {
        $login = false;
    }

    $jsonMenu = file_get_contents('./menu.json');
    $menu = json_decode($jsonMenu);

    $jsonUsers = file_get_contents('./users.json');
    $users = json_decode($jsonUsers);
    ?>
    <nav>
        <ul class="primary-menu">
            <li><a href="bloc.php"><?php print_r($menu->home->$lang);?></a></li>
            <li><a href="activitat_1.php"><?php print_r($menu->act1->$lang);?></a></li>
            <li><a href=""><?php print_r($menu->api->$lang);?></a></li>
            <?php if ($login == false) {
                ?>
                <li><a href="login.php"><?php print_r($menu->login->$lang);?></a></li>
                <?php
            } else if ($login == true) {
                ?>
                <li><strong><a href="perfil.php"><?php print_r($menu->profile->$lang);?></a></strong></li>
                <li><a href="logout.php"><?php print_r($menu->logout->$lang);?></a></li>
                <?php
            }
            ?>
        </ul>
        <ul class="lang-selector">
            <li class="language"><a href="?lang=ca"><img class="flag" src="./img/ca.png" alt="Català"></a></li>
            <li class="language"><a href="?lang=en"><img class="flag" src="./img/en.png" alt="Anglès"></a></li>
        </ul>
    </nav>

    <main>
        <ul>
            <li><?php if ($lang=='ca') {
                    print "Usuari: " . $users->username;
                } else {
                    print "User: " . $users->username;
                }
                ?>
            </li>
            <li><?php if ($lang=='ca') {
                    print "Contrasenya: " . $users->password;
                } else {
                    print "Password: " . $users->password;
                }
                ?>
            </li>
        </ul>
    </main>


</body>
</html>