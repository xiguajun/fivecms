<?php
$_root  =   rtrim(dirname(rtrim($_SERVER['SCRIPT_NAME'],'/')),'/');
define('__ROOT__',  (($_root=='/' || $_root=='\\')?'':$_root));