<html>
<head>
  <title>Sign-Up: Phorum</title>
  <base href="../../"></base>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script><![endif]-->
  <script src="js/jquery.min.js"></script>
  <script src="js/jquery.dropotron.min.js"></script>
  <script src="js/skel.min.js"></script>
  <script src="js/skel-layers.min.js"></script>
  <script src="js/init.js"></script>
  <noscript>
    <link rel="stylesheet" href="css/skel.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/style-wide.css" />
  </noscript>
  <!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
</head>
<body>
  <div class="wrapper style1">

    <!-- Header -->
      <div id="header" class="skel-panels-fixed">
        <div id="logo">
          <h1><a href="index.html">Phorum: Sign-Up</a></h1>
          <span class="tag">One stop for your pharmaceutical problems</span>
        </div>
        <nav id="nav">
          <ul>
            <li class="active"><a href="index.html">Homepage</a></li>
            <li class="button special"><a href="Sign-up.html">Sign-Up</a></li>
          </ul>
        </nav>
      </div>

    <!-- Banner -->
      <div id="banner" class="container">
        <section>
          <p>Phorum: <strong></strong>A forum where you can report issues you faced after consumption of drugs, and report possible drug defects.</a>.</p>

          <a href="#" class="button small">Are you a doctor? Sign up here!</a>
        </section>
      </div>

      <!-- Main -->
        <div id="main">
          <div class="container">
            <div class="row">

<form action="php/usignup.php" method="post">
      Full Name:<br>
      <input type="text" name="fullname"><br>
      Email-id:<br>
      <input type="text" name="emailid"><br>
      Password:<br>
      <input type="text" name="password"><br>
      Re-type Password:<br>
      <input type="text" name="repassword"><br>
      <input type="submit" class="button medium">
    </form>

    <div class="6u">
      <section>
        <ul class="style">
          <li class="fa fa-wrench">
            <h3>Doctors</h3>
            <span>Today, many side-effects of drugs go unnoticed. As a doctor on this forum you can validate queries and take them to a formal forum for review.</span> </li>
          <li class="fa fa-leaf">
            <h3>Users</h3>
            <span>As users, you can create forums to report issues you face, or upvote other issues if you have faced a similar problem. You will be put in touch with doctors who can help you overcome your problems.</span> </li>
        </ul>
      </section>
    </div>
    <div class="6u">
      <section>
        <ul class="style">
          <li class="fa fa-cogs">
            <h3>Pharmacies</h3>
            <span>Pharmacies release drugs after running clinical trials. The patients groups never are an accurate predictor of the much larger general population, and thus this website is a tool that will report any further issues in their products.</span> </li>
      </section>
    </div>
  </div>
</div>
</div>

</div>

<!-- Footer -->


<!-- Copyright -->
<div id="copyright">
<div class="container">
<div class="copyright">

<ul class="icons">
<li><a href="#" class="fa fa-facebook"><span>Facebook</span></a></li>
<li><a href="#" class="fa fa-twitter"><span>Twitter</span></a></li>
<li><a href="#" class="fa fa-google-plus"><span>Google+</span></a></li>
</ul>
</div>
</div>
</div>

  </body>
<?php

$action = array();
$action['result'] = null;
$text = array();

$username = mysql_real_escape_string($_POST['fullname']);
$password = mysql_real_escape_string($_POST['password']);
$email = mysql_real_escape_string($_POST['emailid']);

if(empty($fullnamename)){
  $action['result'] = 'error';
array_push($text,'You forgot your username');
}

if(empty($password)){
  $action['result'] = 'error';
  array_push($text,'You forgot your password');
 }

if(empty($emailid)){
  $action['result'] = 'error';
  array_push($text,'You forgot your email');
 }

 if($action['result'] != 'error'){
     //no errors, continue signup
        $password = md5($password);
 }

 $action['text'] = $text;

 if($action['result'] == 'error'){
   //add to the database
$add = mysql_query("INSERT INTO `users` VALUES(NULL,'$username','$password','$email',0)");
if($add){
    //the user was added to the database
}else{
    $action['result'] = 'error';
    array_push($text,'User could not be added to the database. Reason: ' . mysql_error());
}
 }

 //get the new user id
$userid = mysql_insert_id();

//create a random key
$key = $username . $email . date('mY');
$key = md5($key);

//add confirm row
$confirm = mysql_query("INSERT INTO `confirm` VALUES(NULL,'$userid','$key','$email')");

if($confirm){

    //let's send the email

}else{

    $action['result'] = 'error';
    array_push($text,'Confirm row was not added to the database. Reason: ' . mysql_error());

}

//check if the form has been submitted
if(isset($_POST['signup'])){

}

function format_email($info, $format){

    //set the root
    $root = $_SERVER['DOCUMENT_ROOT'].'/dev/tutorials/email_signup';

    //grab the template content
    $template = file_get_contents($root.'/signup_template.'.$format);

    //replace all the tags
    $template = ereg_replace('{USERNAME}', $info['username'], $template);
    $template = ereg_replace('{EMAIL}', $info['email'], $template);
    $template = ereg_replace('{KEY}', $info['key'], $template);
    $template = ereg_replace('{SITEPATH}','http://site-path.com', $template);

    //return the html of the template
    return $template;

}

function send_email($info){

    //format each email
    $body = format_email($info,'html');
    $body_plain_txt = format_email($info,'txt');

    //setup the mailer
    $transport = Swift_MailTransport::newInstance();
    $mailer = Swift_Mailer::newInstance($transport);
    $message = Swift_Message::newInstance();
    $message ->setSubject('Welcome to Site Name');
    $message ->setFrom(array('noreply@sitename.com' => 'Site Name'));
    $message ->setTo(array($info['email'] => $info['username']));

    $message ->setBody($body_plain_txt);
    $message ->addPart($body, 'text/html');

    $result = $mailer->send($message);

    return $result;

}
 ?>
</html>
