<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clés secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur
 * {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
 * wp-config.php}. C’est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('DB_NAME', 'galibeluwbroot');

/** Utilisateur de la base de données MySQL. */
define('DB_USER', 'galibeluwbroot');

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', 'Galibelum59');

/** Adresse de l’hébergement MySQL. */
define('DB_HOST', 'galibeluwbroot.mysql.db');

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8mb4');

/** Type de collation de la base de données.
  * N’y touchez que si vous savez ce que vous faites.
  */
define('DB_COLLATE', '');

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'JfYud,?gac,zBRSZ;(dEaX$xp3>YScrg|_d5hKH^(K &$_.9|]+V?6*hr :/pg{+');
define('SECURE_AUTH_KEY',  'TfotgY:#m=|IaChKbyvT=qsu>pqa Rfhk(t*3$<*r 3/FE,P!}Ow<!OcMT!782M|');
define('LOGGED_IN_KEY',    'UKRo?Dj6jd6T&$ ${yoAPy1gSj4%$|~Mn&!R?kR[&{&65l:pT&:X/2>XGpBh$0FA');
define('NONCE_KEY',        'HYQukuFVbdKco0hG`-MEX?s84i`iPR(aq,C7?3THwIinK(W5ok9RzX)d].AnmGgG');
define('AUTH_SALT',        'LMKYw*:+SE{2CJIyUo2=piJC!,G bUg.,0ns_Ly-FEvJ)|PPG9;@N*#X@s}hS,b}');
define('SECURE_AUTH_SALT', 'k@;i>t~^DP8(?9,=E~j+*of71Q0_7?J>vIJd4|<oU91aYyIIq/Nv`39,a+;!~b<7');
define('LOGGED_IN_SALT',   'dUT-;8i*#[ZnUbXwQp8]lzHc!j`pwdd^l:9T!+P=t5s=2~#.#XhW&,_p:K.^CSy)');
define('NONCE_SALT',       'AE!wr|Ks~r_eu[n>^V/;E]hkd0H+aW4f./R]EDANi*3[HD8pB{bMfla$ _do7S>!');
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix  = 'wp_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortemment recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* C’est tout, ne touchez pas à ce qui suit ! */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');