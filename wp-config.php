<?php
/** 
 * Configuración básica de WordPress.
 *
 * Este archivo contiene las siguientes configuraciones: ajustes de MySQL, prefijo de tablas,
 * claves secretas, idioma de WordPress y ABSPATH. Para obtener más información,
 * visita la página del Codex{@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} . Los ajustes de MySQL te los proporcionará tu proveedor de alojamiento web.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** Ajustes de MySQL. Solicita estos datos a tu proveedor de alojamiento web. ** //
/** El nombre de tu base de datos de WordPress */
define('DB_NAME', 'zasca_new');

/** Tu nombre de usuario de MySQL */
define('DB_USER', 'root');

/** Tu contraseña de MySQL */
define('DB_PASSWORD', '');

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define('DB_HOST', 'localhost');

/** Codificación de caracteres para la base de datos. */
define('DB_CHARSET', 'utf8mb4');

/** Cotejamiento de la base de datos. No lo modifiques si tienes dudas. */
define('DB_COLLATE', '');

/**#@+
 * Claves únicas de autentificación.
 *
 * Define cada clave secreta con una frase aleatoria distinta.
 * Puedes generarlas usando el {@link https://api.wordpress.org/secret-key/1.1/salt/ servicio de claves secretas de WordPress}
 * Puedes cambiar las claves en cualquier momento para invalidar todas las cookies existentes. Esto forzará a todos los usuarios a volver a hacer login.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'j7MJQ]HR+)b32.loobc}~q/qSL.MI-EvsdCnqw@y_+]oQ6EPV@rzAEux7l+(j-=9');
define('SECURE_AUTH_KEY', '1mi6~Q$/M,E7*5cDCB&]]E=u~+!$A<D8G[N*8GeK+BOjFy[!l,/Yc``D|+_qUkK|');
define('LOGGED_IN_KEY', 'f7(2P?e?Ze(:wFr9sMQL*wkNPr:prH{?``XBe-[+V(Ri-UopEH+~I:zlCMZVbEYp');
define('NONCE_KEY', '-3h d(VdY2[s@($HEP=p(teq#Cl#kcTQdw|-<Q|>=7OMw3g]ZRYv:fldAy?U/W,5');
define('AUTH_SALT', '6g(uW5{8oDsAH%c0|vC5$p`DP,6+$~%W!?vo]>:O_uDmTS]Hz~o]@%^*DMm} &nR');
define('SECURE_AUTH_SALT', '7F<(4QX3V`q3tYfQ`zGfM;~FAo S/C}1w{D#6FC{<ls2lCZ_9iWT,#Yg-2P.me/)');
define('LOGGED_IN_SALT', 'E;?f(Ad8!/4qmbzVjU/8yU*bU4 P- f+Do,D_4Wc8)F4w!xTJMj`+c|uMtwY?|Z`');
define('NONCE_SALT', ',&;:nR:6zSHv=Q_eKk)mDB.KN/fug-TDG_xi*rBj+QSu_&)<KPN[ZHI6oA&6V~W:');

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix  = 'wp_';


/**
 * Para desarrolladores: modo debug de WordPress.
 *
 * Cambia esto a true para activar la muestra de avisos durante el desarrollo.
 * Se recomienda encarecidamente a los desarrolladores de temas y plugins que usen WP_DEBUG
 * en sus entornos de desarrollo.
 */
define('WP_DEBUG', false);

/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

