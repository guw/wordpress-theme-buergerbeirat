<?php

 /*
  * GitHub Auto-Deploy Script
  * (https://gist.github.com/3491416)
  */
  
  // verify secret
  $secret = file_get_contents("/srv/webs/ausapolda.de/.deploysecret");
  if(!isset($_REQUEST['secret']) || !strcmp($_REQUEST['secret'], $secret)) {
       die('Bad Request');
  }

  // The repo/site to deploy
  /*
  $clientIp = '';
  if ( isset($_SERVER["REMOTE_ADDR"]) )    { 
    $clientIp = '' . $_SERVER["REMOTE_ADDR"]; 
  } else if ( isset($_SERVER["HTTP_X_FORWARDED_FOR"]) )    { 
    $clientIp = '' . $_SERVER["HTTP_X_FORWARDED_FOR"]; 
  } else if ( isset($_SERVER["HTTP_CLIENT_IP"]) )    { 
    $clientIp = '' . $_SERVER["HTTP_CLIENT_IP"]; 
  } 
  */

  // The commands
  $commands = array(
    'echo $PWD',
    'whoami',
    'git reset --hard HEAD',
    'git pull',
    'git status',
    'git submodule sync',
    'git submodule update',
    'git submodule status',
  );

  // Run the commands for output
  $output = '';
  foreach($commands AS $command){
    // Run it
    $tmp = shell_exec($command);
    // Output
    $output .= "<span style=\"color: #6BE234;\">\$</span> <span style=\"color: #729FCF;\">{$command}\n</span>";
    $output .= htmlentities(trim($tmp)) . "\n";
  }

  // Make it pretty for manual user access (and why not?)

?>

<!DOCTYPE HTML>
<html lang="en-US">
<head>
  <meta charset="UTF-8">
  <title>Git Deployment Script</title>
</head>
<body style="background-color: #000000; color: #FFFFFF; font-weight: bold; padding: 0 10px;">
<pre>
<?php echo $output; ?>
</pre>
</body>
</html>