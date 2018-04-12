<?php 
unset($_COOKIE['post_favs']);

setCookie("post_favs", "", -1);

header("Location: favourites.php");
?>