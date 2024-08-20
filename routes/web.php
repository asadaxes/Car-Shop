<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

$moduleRouteFiles = File::glob(__DIR__.'/modules/*.php');
foreach ($moduleRouteFiles as $routeFile) {
    include $routeFile;
}