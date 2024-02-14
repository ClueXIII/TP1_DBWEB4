<?php
session_start();

// identifiants, mots de passe et accréditations
$utilisateurs = [
    "garnier" => ["Garnier", "cisco", "propriétaire"],
    "lefevre" => ["Lefevre", "class", "ami"],
    "buren" => ["Buren", "ciscoclass", "ami"],
];

$selected_theme = 'indigo';

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['identifiant']) && isset($_POST['motdepasse'])) {
      $identifiant = $_POST['identifiant'];
      $motDePasse = $_POST['motdepasse'];
      if (array_key_exists($identifiant, $utilisateurs) && $utilisateurs[$identifiant][1] === $motDePasse) {
          $_SESSION['utilisateur'] = $utilisateurs[$identifiant];
      } else {
          echo "Identifiant ou mot de passe incorrect.";
      }
    }
    if (isset($_POST['theme'])) {
      $selected_theme = $_POST['theme'];
      $expire = time() + 60 * 60 * 24 * 365;
      setcookie('site_theme', $selected_theme, $expire);
    } else {
      if(isset($_COOKIE['site_theme'])) {
          $selected_theme = $_COOKIE['site_theme'];
      }
    }
}

$themes = array(
  'indigo' => 'Indigo',
  'blue' => 'Bleu',
  'green' => 'Vert',
  'red' => 'Rouge'
);

function generateThemeOptions($themes, $selected_theme) {
  $options = '';
  foreach($themes as $theme_key => $theme_name) {
      $selected = ($theme_key == $selected_theme) ? 'selected' : '';
      $options .= "<option value=\"$theme_key\" $selected>$theme_name</option>";
  }
  return $options;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Basket</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link id="theme" rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-<?php echo $selected_theme; ?>.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
<style>
body,h1,h2,h3,h4,h5 {font-family: "Poppins", sans-serif}
body {font-size:16px;}
.w3-half img{margin-bottom:-6px;margin-top:16px;opacity:0.8;cursor:pointer}
.w3-half img:hover{opacity:1}
</style>
</head>
<body>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-theme w3-collapse w3-top w3-large w3-padding" style="z-index:3;width:300px;font-weight:bold;" id="mySidebar"><br>
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft w3-padding" style="width:10%;font-size:22px;background-color:transparent;">x</a>
  <?php     
  if (isset($_SESSION['utilisateur'])) {
      $utilisateurConnecte = $_SESSION['utilisateur'];
      echo "<span class=\"w3-medium w3-margin-top\">Vous êtes connecté en tant que : $utilisateurConnecte[0]</span>";
    } else {
      echo '<button onclick="document.getElementById(\'id01\').style.display=\'block\'" class="w3-button w3-theme-l3 w3-round-large w3-medium w3-hover-white">Se connecter</button>';
    } ?>
  <div class="w3-container">
    <h3 class="w3-padding-64 w3-xxlarge"><b>Basketball</b></h3>
  </div>
  <div class="w3-bar-block">
    <a href="#" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Accueil</a> 
    <a href="#showcase" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Images</a> 
    <a href="#services" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">C'est quoi le basket</a> 
    <a href="#designers" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Légendes du Basket</a>
  </div>
</nav>

<!-- Top menu on small screens -->
<header class="w3-container w3-top w3-hide-large w3-theme w3-xlarge w3-padding">
  <a href="javascript:void(0)" class="w3-button w3-theme w3-margin-right" onclick="w3_open()">☰</a>
  <?php 
    if (isset($_SESSION['utilisateur'])) {
      $utilisateurConnecte = $_SESSION['utilisateur'];
      echo "<span class=\"w3-medium\">Vous êtes connecté en tant que : $utilisateurConnecte[0]</span>";
    } else {
      echo '<button onclick="document.getElementById(\'id01\').style.display=\'block\'" class="w3-button w3-theme-l3 w3-round-large w3-medium w3-hover-white">Se connecter</button>';
    }
  ?>
</header>

<div id="id01" class="w3-modal">
  <div class="w3-modal-content">
    <div class="w3-container w3-padding-16 w3-text-theme">
      <h2>Connexion</h2>
        <form method="post" action="">
          <label for="identifiant">Identifiant :</label><br>
          <input class="w3-input" type="text" id="identifiant" name="identifiant"><br>
          <label for="motdepasse">Mot de passe :</label><br>
          <input class="w3-input" type="password" id="motdepasse" name="motdepasse"><br>
          <input class="w3-input w3-theme-l3 w3-round-large" type="submit" value="Se connecter">
      </form>
    </div>
  </div>
</div>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">

  <!-- Header -->

  <div class="w3-container" style="margin-top:80px" id="showcase">
    <h1 class="w3-jumbo w3-text-theme"><b>Découvrez le basket</b></h1>
    <h1 class="w3-xxxlarge w3-text-theme"><b>Images</b></h1>
  </div>

  <?php 
    if (isset($_SESSION['utilisateur'])) {
      if($_SESSION['utilisateur'][2] === "propriétaire") {
        echo '<p class="w3-container w3-xlarge w3-text-theme">Bonjour Admin</p>';
      } else {
        echo '<p class="w3-container w3-xlarge w3-text-theme">Bonjour '.$utilisateurConnecte[0].'</p>';
      }
    }
  ?>
  
  <!-- Photo grid (modal) -->
  <?php
    if (isset($_SESSION['utilisateur']) && $_SESSION['utilisateur'][2] === "propriétaire") {
      ?>
    <div class="w3-row-padding">
    <div class="w3-half">
      <img src="https://conseils.casalsport.com/wp-content/uploads/2019/04/reglement-de-basket.jpg" style="width:100%" onclick="onClick(this)" alt="Concrete meets bricks">
      <img src="https://media.lesechos.com/api/v1/images/view/63c81fc10bff86439d057a62/1280x720/0703221780511-web-tete.jpg" style="width:100%" onclick="onClick(this)" alt="Light, white and tight scandinavian design">
      <img src="https://w.forfun.com/fetch/0b/0bcae9fa4278f60b6908c87c0092f057.jpeg" style="width:100%" onclick="onClick(this)" alt="White walls with designer chairs">
    </div>

    <div class="w3-half">
      <img src="https://www.lecarreaudutemple.eu/wp-content/uploads/2021/12/Basket-Paris-Basket-Centre-3.jpg" style="width:100%" onclick="onClick(this)" alt="Windows for the atrium">
      <img src="https://www.lexpress.fr/resizer/20Uh0ycx4j9bpFjwRrhXGVuMmKc=/arc-photo-lexpress/eu-central-1-prod/public/5IYXLUO77JHXPOKT3DE64NYGJA.jpg" style="width:100%" onclick="onClick(this)" alt="Bedroom and office in one space">
      <img src="https://information.tv5monde.com/sites/tv5-info/files/styles/entete/public/2023-05/joel%20embiid.jpg?itok=VgT39MV2" style="width:100%" onclick="onClick(this)" alt="Scandinavian design">
    </div>
  </div>
   <?php
    } else {
      echo '<p class="w3-container w3-xlarge w3-text-red">Vous devez être connecté en tant que propriétaire pour voir les images.</p>';
    }
    ?>

  <!-- Modal for full size images on click-->
  <div id="modal01" class="w3-modal w3-black" style="padding-top:0" onclick="this.style.display='none'">
    <span class="w3-button w3-black w3-xxlarge w3-display-topright">×</span>
    <div class="w3-modal-content w3-animate-zoom w3-center w3-transparent w3-padding-64">
      <img id="img01" class="w3-image">
      <p id="caption"></p>
    </div>
  </div>

  <!-- Services -->
  <div class="w3-container" id="services" style="margin-top:30px">
    <h1 class="w3-xxxlarge w3-text-theme"><b>C'est quoi le basket ?</b></h1>
    <p>Le basketball est un sport collectif qui se joue principalement en salle, opposant deux équipes de cinq joueurs chacune. Le but du jeu est de marquer des points en lançant un ballon dans le panier adverse, qui est placé à une certaine hauteur sur un panneau rectangulaire appelé "cercle" ou "panier".</p>
    <p>Les équipes marquent des points en faisant entrer le ballon dans le panier de l'adversaire. Un tir réussi depuis l'extérieur de la ligne des trois points vaut trois points, tandis qu'un tir réussi depuis l'intérieur de cette ligne vaut deux points. Les points peuvent également être marqués en convertissant des lancers francs après une faute.</p>
    <p>Le basketball est un sport rapide et dynamique, caractérisé par le dribble, le passage, le tir et la défense. Il nécessite des compétences techniques telles que le dribble, le tir, le rebond, ainsi que des qualités physiques comme l'endurance, la vitesse et l'agilité.</p>
  </div>
  
  <!-- Designers -->
  <div class="w3-container" id="designers" style="margin-top:75px">
    <h1 class="w3-xxxlarge w3-text-theme"><b>Légendes du basket</b></h1>
    <p>Les légendes du basketball sont des joueurs qui ont marqué l'histoire de ce sport par leur talent exceptionnel, leur influence sur le jeu et leur impact durable sur la culture du basketball. Parmi ces légendes, on retrouve des noms emblématiques tels que Michael Jordan, considéré par beaucoup comme le plus grand joueur de tous les temps, grâce à ses six titres de champion NBA et à sa domination sur le terrain. Magic Johnson et Larry Bird ont également marqué les années 1980 par leur rivalité intense et leur jeu spectaculaire, contribuant à populariser le basketball dans le monde entier. D'autres légendes incluent Kareem Abdul-Jabbar, le meilleur marqueur de l'histoire de la NBA, ainsi que Kobe Bryant, Shaquille O'Neal, LeBron James et bien d'autres, dont les exploits et la personnalité ont façonné le basketball moderne et inspiré des générations de joueurs.
    </p>
  </div>

  <!-- The Team -->
  <div class="w3-row-padding w3-grayscale">
    <div class="w3-col m4 w3-margin-bottom">
      <div class="w3-light-grey">
        <img src="https://www.basketusa.com/wp-content/uploads/2020/05/jordan-dur.jpg" alt="John" style="width:100%">
        <div class="w3-container">
          <h3>Michael Jordan</h3>
          <ul>
             <li>6 fois champion NBA avec les Chicago Bulls (1991, 1992, 1993, 1996, 1997, 1998)</li>
             <li>5 fois MVP (Most Valuable Player) de la saison régulière</li>
             <li>14 sélections au All-Star Game</li>
          </ul>
        </div>
      </div>
    </div>
    <div class="w3-col m4 w3-margin-bottom">
      <div class="w3-light-grey">
        <img src="https://img-4.linternaute.com/2LvXSzwn6ZjNkdRcTx2m792_Cx4=/1500x/smart/78273c08efdd4279b9e5a6429c0947d5/ccmcms-linternaute/41695733.jpg" alt="Jane" style="width:100%">
        <div class="w3-container">
          <h3>LeBron James</h3>
          <ul>
             <li>4 fois champion NBA (2012, 2013, 2016, 2020)</li>
             <li>4 fois MVP de la saison régulière</li>
             <li>17 sélections au All-Star Game</li>
          </ul>
        </div>
      </div>
    </div>
    <div class="w3-col m4 w3-margin-bottom">
      <div class="w3-light-grey">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/56/Kobe_Bryant_2014.jpg/640px-Kobe_Bryant_2014.jpg" alt="Mike" style="width:100%">
        <div class="w3-container">
          <h3>Kobe Bryant :</h3>
          <ul>
             <li>5 fois champion NBA avec les Los Angeles Lakers (2000, 2001, 2002, 2009, 2010)</li>
             <li>2 fois MVP des finales NBA</li>
             <li>18 sélections au All-Star Game</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

<div class="w3-container w3-margin">
  <h4 class="w3-text-theme">Changer le thème du site</h4>
  <form method="post">
      <select name="theme" id="theme" class="w3-select">
          <?php echo generateThemeOptions($themes, $selected_theme); ?>
      </select>
      <button type="submit" class="w3-button">Appliquer</button>
  </form>
</div>
 
  
<!-- End page content -->
</div>

<!-- W3.CSS Container -->
<div class="w3-light-grey w3-container w3-padding-32" style="margin-top:75px;padding-right:58px"><p class="w3-right">Powered by <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-opacity">w3.css</a></p></div>

<script>
// Script to open and close sidebar
function w3_open() {
  document.getElementById("mySidebar").style.display = "block";
  document.getElementById("myOverlay").style.display = "block";
}
 
function w3_close() {
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("myOverlay").style.display = "none";
}

// Modal Image Gallery
function onClick(element) {
  document.getElementById("img01").src = element.src;
  document.getElementById("modal01").style.display = "block";
  var captionText = document.getElementById("caption");
  captionText.innerHTML = element.alt;
}
</script>

</body>
</html>
