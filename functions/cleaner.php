<?php
function escape($string){
	return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function revertescape($string){
	return htmlspecialchars_decode($string, ENT_QUOTES);
}
?>