<?php
require_once 'vendor/autoload.php';

use Spatie\ImageOptimizer\OptimizerChainFactory;
use Spatie\ImageOptimizer\OptimizerChain;
use Spatie\ImageOptimizer\Optimizers\Jpegoptim;
use Spatie\ImageOptimizer\Optimizers\Pngquant;

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);

$dir = $_POST['dir'];
$dir = explode("\n", $dir);
print_r($dir);

function compressImage($source, $destination, $quality) {

    $info = getimagesize($source);
  
    if ($info['mime'] == 'image/jpeg') 
      $image = imagecreatefromjpeg($source);
  
    elseif ($info['mime'] == 'image/gif') 
      $image = imagecreatefromgif($source);
  
    elseif ($info['mime'] == 'image/png') 
      $image = imagecreatefrompng($source);
  
    return imagejpeg($image, $destination, $quality);
  
  }


function get_all_directory_and_files($dir){
 $optimizerChain = OptimizerChainFactory::create();
    $dh = new DirectoryIterator($dir);   
    // Dirctary object 
    foreach ($dh as $item) {
        if (!$item->isDot()) {
           if ($item->isDir()) {
               get_all_directory_and_files("$dir/$item");
           } else {
               echo compressImage($dir . "/" . $item->getFilename(), $dir . "/" . $item->getFilename(), 40);
               //$optimizerChain->optimize($dir . "/" . $item->getFilename(), $dir . "/" . $item->getFilename());
           }
        }
     }
  }

 # Call function 

 foreach($dir as $dirs){
  get_all_directory_and_files($dirs);
 }

 






