<?hh

phpinfo();

if (defined('HHVM_VERSION')) {
	echo 'Using HHVM';
} else {
	echo 'Not using HHVM';
}