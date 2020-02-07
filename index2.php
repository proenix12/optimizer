<?php
    
    ini_set('memory_limit', '-1');
    ini_set('max_execution_time', 0);
    
    try{
        $dir = $_POST[ 'dir' ];
        if(isset($_POST[ 'lastPath' ])){
            get_all_directory_and_files('C:\xampp\htdocs\3\img', $_POST[ 'lastPath' ]);
        }
        
    }catch (Exception $e){
        exit(
        json_encode(
            array (
                'status' => false,
                'error' => $e -> getMessage()
            )
        )
        );
    }
    
    
    function compressImage($source, $destination, $quality)
    {
        $info = getimagesize($source);
        
        if ($info[ 'mime' ] == 'image/jpeg') {
            $image = imagecreatefromjpeg($source);
        } elseif ($info[ 'mime' ] == 'image/gif') {
            $image = imagecreatefromgif($source);
        } elseif ($info[ 'mime' ] == 'image/png') {
            $image = imagecreatefrompng($source);
        }
        return imagejpeg($image, $destination, $quality);
    }
    
    function get_all_directory_and_files($dir, $pathLast = null)
    {
        $global_files = [];
        $dh = new DirectoryIterator($dir);
        foreach ($dh as $item) {
            if (!$item->isDot()) {
                if ($item->isDir()) {
                    get_all_directory_and_files("$dir/$item");
                }
                $global_files[] = $dir . '/' . $item->getFilename();
                //compressImage($dir . '/' . $item->getFilename(), $dir . '/' . $item->getFilename(), 40);
            }
        }
        foreach ($global_files as $files) {
            if (end($global_files) === $files) {
                continue;
            }
            if ($files === $pathLast) {
                continue;
            }
            echo json_encode(
                [
                    'status' => true,
                    'time' => time(),
                    'path'   => $files
                ]
            );
            sleep(1);
            exit();
        }
    }



    
