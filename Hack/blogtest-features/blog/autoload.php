<?hh

/** 
 * Use default autoload implementation, written in C
 * quicker as __autoload() or defining own autoload function
 * http://at1.php.net/manual/de/function.spl-autoload.php#92767
 *
 * Warning: Can cause errors on case sensitive file systems
 * http://www.php.net/manual/en/function.spl-autoload-register.php#96804
 */
// spl_autoload_extensions('.php');
// spl_autoload_register();

function __autoload(string $className) {
	$className = str_replace('\\', '/', $className);
	require_once $className . '.php';
}