<?php
if (!isset($_SESSION)) {
  session_start();
}


switch ($pageType) {
	case 'admin':
		if ( ! isset($_SESSION['Admin']) &&  $_SESSION['Admin'] != true)
		{
			header("Location: ../login.php"  );
		}
		break;
	
	case 'player':
		if ( ! isset($_SESSION['Player']) &&  $_SESSION['Player'] != true)
		{
			header("Location: ../login.php" );
		}
		break;

	default:
		header("Location: ../404.php" );
		break;
}	
?>