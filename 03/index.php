<?php
	include dirname(__FILE__) . "/../inc/auth.php"; 
	include dirname(__FILE__) . "/../inc/vote.php"; 

	$user = @$_POST["user"]; 
	$pass = @$_POST["pass"]; 

	$user_info = getUserData($user, $pass); 

	if($user_info == False){
		header("HTTP/1.1 303 See Other");
		header( 'Location: /01/?fail=authfail' );
		die("Please direct your browser to /01/?fail=authfail"); 
	}

	if(has_voted($user)){
		header("HTTP/1.1 303 See Other");
		header( 'Location: /01/?fail=hasvoted' );
		die("Please direct your browser to /01/?fail=hasvoted"); 
	}

	if(!can_vote($user_info)){
		header("HTTP/1.1 303 See Other");
		header( 'Location: /01/?fail=cantvote' );
		die("Please direct your browser to /01/?fail=hasvoted"); 
	}

  $vote = @$_POST["vote"]; 

  if(!array_key_exists($vote, get_voting_options())){
    header("HTTP/1.1 303 See Other");
    header( 'Location: /01/?fail=illegalvote' );
    die("Please direct your browser to /01/?fail=illegalvote"); 
  }

 if(!vote($user, $vote)){
    header("HTTP/1.1 303 See Other");
    header( 'Location: /01/?fail=votefail' );
    die("Please direct your browser to /01/?fail=votefail"); 
 }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>USG Voting Platform</title>

    <!-- Bootstrap core CSS -->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/bootstrap/custom/custom.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

      <form class="form-signin">
        <h2 class="form-signin-heading">Finished. </h2>
        <div class="alert alert-success">
        Congrats, <strong><?php echo $user_info["username"]; ?></strong>. You have successfully voted. <br />
        You may now return to your academic work. 
        </div>
      </form>

    </div> <!-- /container -->
  </body>
</html> c