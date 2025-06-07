<?php 
    $file = fopen (ROOT.DS.'db'.DS. $filename, "rb" ); 
 
    Header ( "Content-type: application/octet-stream" ); 
    Header ( "Accept-Ranges: bytes" );   
    Header ( "Accept-Length: " . filesize ( ROOT.DS.'db'.DS. $filename ) );  

    Header ( "Content-Disposition: attachment; filename=" . $filename );    

    echo fread ( $file, filesize ( ROOT.DS.'db'.DS. $filename ) );    
    fclose ( $file );    
    exit ();
?>