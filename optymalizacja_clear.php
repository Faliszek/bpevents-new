<?php
/*** 
W PRZYPADKU CZYTEJ INSTALACJI WORDPRESSA
W pliku header.php, w sekcji head wklejamy: @include('optymalizacja_clear.php'); 
Jeżeli w sekcji head istnieją już znaczniki: title, meta-description, czy meta-robots - należy je usunąć.
***/
global $t;
global $d;
global $r;
global $c;
global $brand;
global $tree;

$brand = 'BP Events'; // Brand ustawi się na końcu title
$isTree = '0'; // Title jako odwrócone drzewo kategorii sklepowych (1 - włącza, 0 - wyłącza)
$tree = '0'; // Nie modyfikować

/*** TUTAJ DOKONYWAĆ WSZELKICH ZMIAN 
$t - title strony (bez branda)
$d - description strony
$r - meta-robots (zdefiniować "content", np. noindex,follow)
$c - canonical (podać pełen URL wraz z protokołem i domeną)
***/

switch($_SERVER['REQUEST_URI']) {
  case '/':
    $t = 'Zespół muzyczny, DJ na wesele, konferansjer Kraków';
	$d = 'BP Events stanowi zgrany zespół profesjonalnych DJ-ów i konferansjerów. Zajmujemy się oprawą muzyczną wesel, studniówek oraz innych imprez okolicznościowych.';
  break;
  case '/galeria':
    $t = 'Galeria';
	$d = 'Nasz zespół brał udział w setkach wesel, spełniając najbardziej wymagające oczekiwania naszych Klientów. Zapraszamy do zapoznania się z galerią zrealizowanych imprez.';
  break;
  case '/polecamy':
    $t = 'Nasz team';
	$d = 'Pasją i nieodłączną częścią naszego życia jest muzyka, którą od ponad 10 lat dzielimy się z Wami podczas prowadzenia nawet najbardziej wymagających uroczystości.';
  break;
  case '/referencje':
    $t = 'Referencje naszych Klientów';
	$d = 'Jesteśmy po to, aby zagwarantować Wam oraz Waszym Gościom niezapomniane przeżycia. Pozytywne opinie oraz spełnione marzenia są dla nas wielkim wyróżnieniem.';
  break;
  case '/podstrona/':
    $c = '';
  break;
  case '/shallow/':
    $r = 'noindex,follow';
  break;
  default:
    $t = wp_title('',false,''); //w zalezności od konfiguracji $t może wymagać modyfikacji np. usunięcie stałego "Kategoria produktów" w WooCommerce - wtedy robimy jeszcze $t = str_replace...
    $tree = $isTree; 
  break;
}

/*** 
  Zmiana contentu (w uzasadnionych przypadkach)
  Zmienna $content przechowuje content podstrony, podobnie jak $buffer.
  Możena wykorzystwać str_replace / preg_replace
***/

function opt_the_content($content) {          

  /* Odkomentować w razie potrzeby. W przeciwnym razie usunąć. */
  //$content = preg_replace('#alt="[^"]*"#i', 'alt=""', $content); //usunięcie altów
  //$content = preg_replace('#title="[^"]*"#i', '', $content); //usunięcie title w body
   
  return $content;
}
add_filter('the_content', 'opt_the_content', 999); 

/*** PONIŻSZYCH FUNKCJI NIE EDYTOWAĆ JEŚLI NIE WYSTĄPI TAKA KONIECZNOŚĆ ***/

/*** Title ***/
remove_theme_support('title-tag');

function opt_wp_title() {
  global $t;	  
  global $tree;                
  global $brand;
  
  if (class_exists('WooCommerce') && $tree == '1') {
    $tc = '';	                         
    $cate = get_queried_object(); 
    $cateID = $cate->term_id;
    $sep = ' - ';
    $tc = get_category_parents($cateID, false, $sep);    
    $tc = explode($sep, trim($tc , $sep));
    $tc = array_reverse($tc);
    $tc = implode("$sep", $tc);
  	echo '<title>'.$tc.' - '.$brand.'</title>';
  } else {
    echo '<title>'.$t.' - '.$brand.'</title>';
  }
	
}
add_action('wp_head', 'opt_wp_title', 1);

/*** Description ***/
function wpseo_metadesc() {
	
  global $d;
  global $czysc_desc;
  
  if(isset($d)) {
    $description = $d;
  } else {
    $description = '';  
  }
  
	echo '<meta name="description" content="'.$description.'" />';
}

add_action('wp_head', 'wpseo_metadesc', 1);

/*** Nałożenie NOINDEX i usunięcie CANONICALA ***/
if((isset($r) && $r!='') || is_attachment()) { //is_attachment() - defaultowa funkcja sprawdzająca, czy dana podstrona jest tylko załącznikiem (czyt. shallow)
	echo '
	<meta name="robots" content="'.$r.'" />';
	remove_action('wp_head', 'rel_canonical');
}

/*** Ustawienie własnych Canonicali ***/
if(isset($c)) {
  remove_action('wp_head', 'rel_canonical');
  echo '
	<link rel="canonical" href="'.$c.'" />';
}

/*** Zmiana atrybutów w menu strony (choć starajmy się używać odpowiedni moduł :)) ***/

function opt_nav_menu_link_attributes( $atts, $item, $args ) {
	if($item -> title == 'Home') {  //Jeśli anchor == "Home", możemy odwołać się do pól: title, target, rel, href 
			//$atts['href'] = '/'; //zmieńmy mu hrefa na /, możemy się odwołać do pól jw.
	}
    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'opt_nav_menu_link_attributes', 10, 3 );