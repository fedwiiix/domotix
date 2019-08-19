<?php require ('../parametre/security.php'); 

if(isset( $_GET["file"]))
{
    $file = urldecode($_GET["file"]);
	  $extension = pathinfo($file, PATHINFO_EXTENSION);
    $type = mime_content_type($file);
  
  $file= $_SESSION['cloudDir'].$file;
  
  if(isset( $_GET["img"]))
  {

    if(strtolower($extension)=="jpeg" || strtolower($extension)=="jpg" || strtolower($extension)=="gif" || strtolower($extension)=="png"){
      
      header('Content-Type:'.$type);
      $im = new Imagick($file);
      $im->scaleImage(150, 0);
      $im->cropThumbnailImage(150,100);
      echo $im->getImageBlob(); 

    }else if(strtolower($extension)=="pdf"){

      header('Content-type: image/png');
      $im = new Imagick();      
      $im->readimage($file."[0]" ); 
      $im->setImageFormat('png');  
      $im->scaleImage(150, 0);
            
      $im->setImageBackgroundColor('#ffffff');
      $im = $im->flattenImages();
      $im->cropImage(150, 100, 0, 0);
      echo $im->getImageBlob(); 
    }
    
  }else{

      if(strtolower($extension)=="jpeg" || strtolower($extension)=="jpg" || strtolower($extension)=="gif" || strtolower($extension)=="png"){

          header('Content-Type:'.$type);
          header('Content-Length: ' . filesize($file));
      readfile($file);

      //$data = file_get_contents( $file ); 
      //echo '<img src="data:image/png;base64,'.base64_encode($data).'" style="max-height:90%; max-width:96%; vertical-align:center;">';

  } else if(strtolower($extension)=="pdf"){
      header('Content-type:application/pdf');
      header('Content-disposition: inline; filename="'.$file.'"');
      header('content-Transfer-Encoding:binary');
      header('Accept-Ranges:bytes');
      readfile($file);

    } else if(strtolower($extension)=="webm" || strtolower($extension)=="ogg" || strtolower($extension)=="mp4" || strtolower($extension)=="avi" || strtolower($extension)=="flv"  || strtolower($extension)=="mp3"  || strtolower($extension)=="m4a" ){ 	

        /**
         * Description of VideoStream
         *
         * @author Rana
         * @link http://codesamplez.com/programming/php-html5-video-streaming-tutorial
         */
        class VideoStream
        {
          private $path = "";
          private $stream = "";
          private $buffer = 102400;
          private $start  = -1;
          private $end    = -1;
          private $size   = 0;

          function __construct($filePath) 
          {
            $this->path = $filePath;
          }
          /*** Open stream*/
          private function open()
          {
            if (!($this->stream = fopen($this->path, 'rb'))) {
              die('Could not open stream for reading');
            }
          }
          /*** Set proper header to serve the video content*/
          private function setHeader()
          {
            ob_get_clean();
            header("Content-Type: video/mp4");
            header("Cache-Control: max-age=2592000, public");
            header("Expires: ".gmdate('D, d M Y H:i:s', time()+2592000) . ' GMT');
            header("Last-Modified: ".gmdate('D, d M Y H:i:s', @filemtime($this->path)) . ' GMT' );
            $this->start = 0;
            $this->size  = filesize($this->path);
            $this->end   = $this->size - 1;
            header("Accept-Ranges: 0-".$this->end);

            if (isset($_SERVER['HTTP_RANGE'])) {

              $c_start = $this->start;
              $c_end = $this->end;

              list(, $range) = explode('=', $_SERVER['HTTP_RANGE'], 2);
              if (strpos($range, ',') !== false) {
                header('HTTP/1.1 416 Requested Range Not Satisfiable');
                header("Content-Range: bytes $this->start-$this->end/$this->size");
                exit;
              }
              if ($range == '-') {
                $c_start = $this->size - substr($range, 1);
              }else{
                $range = explode('-', $range);
                $c_start = $range[0];

                $c_end = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $c_end;
              }
              $c_end = ($c_end > $this->end) ? $this->end : $c_end;
              if ($c_start > $c_end || $c_start > $this->size - 1 || $c_end >= $this->size) {
                header('HTTP/1.1 416 Requested Range Not Satisfiable');
                header("Content-Range: bytes $this->start-$this->end/$this->size");
                exit;
              }
              $this->start = $c_start;
              $this->end = $c_end;
              $length = $this->end - $this->start + 1;
              fseek($this->stream, $this->start);
              header('HTTP/1.1 206 Partial Content');
              header("Content-Length: ".$length);
              header("Content-Range: bytes $this->start-$this->end/".$this->size);
            }
            else
            {
              header("Content-Length: ".$this->size);
            }  
          }
          /*** close curretly opened stream*/
          private function end()
          {
            fclose($this->stream);
            exit;
          }
          /*** perform the streaming of calculated range*/
          private function stream()
          {
            $i = $this->start;
            set_time_limit(0);
            while(!feof($this->stream) && $i <= $this->end) {
              $bytesToRead = $this->buffer;
              if(($i+$bytesToRead) > $this->end) {
                $bytesToRead = $this->end - $i + 1;
              }
              $data = fread($this->stream, $bytesToRead);
              echo $data;
              flush();
              $i += $bytesToRead;
            }
          }
          /*** Start streaming video content*/
          function start()
          {
            $this->open();
            $this->setHeader();
            $this->stream();
            $this->end();
          }
        }

        $stream = new VideoStream($file);
        $stream->start();
    }
  }
}
?>