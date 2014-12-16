<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>

<title>Dinero</title>
<meta charset="UTF-8" />

<!-- Include CSS files -->
<link rel="stylesheet" href="include/css/tema.css" type="text/css">
<link rel="stylesheet" href="include/css/customtweet.css" type="text/css">

<!-- Include JS files -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

<?php
require_once('src/Basho/Riak/Riak.php');
require_once('src/Basho/Riak/Bucket.php');
require_once('src/Basho/Riak/Exception.php');
require_once('src/Basho/Riak/Link.php');
require_once('src/Basho/Riak/MapReduce.php');
require_once('src/Basho/Riak/Object.php');
require_once('src/Basho/Riak/StringIO.php');
require_once('src/Basho/Riak/Utils.php');
require_once('src/Basho/Riak/Link/Phase.php');
require_once('src/Basho/Riak/MapReduce/Phase.php');

$client = new Basho\Riak\Riak('172.31.32.109',10018);				
?>

</head>

<body>

<?php include 'sidebar.php'; ?>

<div id="wrap">