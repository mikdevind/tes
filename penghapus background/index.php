<?php
require 'guzzle/vendor/autoload.php';
$client = new GuzzleHttp\Client();
date_default_timezone_set("Asia/Jakarta");
$tanggal = date("Ymd");

if (isset($_POST["eraser"])) {
    $ekstension = ["png","jpg","jpeg"];
    $bytes = random_bytes(5);
    $namafile  = $_FILES["input"]["name"];
    $typefile = explode("/",$_FILES["input"]["type"]);
    $tmpname = $_FILES["input"]["tmp_name"];
    $sizefile = $_FILES["input"]["size"];
    $fileformat = end(explode(".",$namafile));
    $namafile = bin2hex($bytes);
    if($typefile[0] == "image"){
        if (in_array($fileformat, $ekstension)){
            if ($sizefile <= 50000000){
                if(is_dir("input/".$tanggal)){
                    move_uploaded_file($tmpname,"input/".$tanggal . "/".$namafile. "." . $fileformat);
                    $res = $client->request('POST','https://api.remove.bg/v1.0/removebg', [
                        'multipart' => [
                            [
                                'name'     => 'image_file',
                                'contents' => fopen('input/'.$tanggal . '/'.$namafile. "." . $fileformat, 'r')
                            ],
                            [
                                'name'     => 'size',
                                'contents' => 'auto'
                            ]
                        ],
                        'headers' => [
                            'X-Api-Key' => 'PtphNMKzr8dfePFuVB2UdDWs'
                        ]
                    ]);
                    $fp = fopen('output/'.$tanggal . '/'.$namafile.".png", "wb");
                    fwrite($fp, $res->getBody());
                    fclose($fp);
                }else{
                    mkdir("input/".$tanggal);
                    mkdir("output/".$tanggal);
                    move_uploaded_file($tmpname,"input/".$tanggal . "/".$namafile. "." . $fileformat);
                    $res = $client->post('https://api.remove.bg/v1.0/removebg', [
                        'multipart' => [
                            [
                                'name'     => 'image_file',
                                'contents' => fopen('input/'.$tanggal . '/'.$namafile. "." . $fileformat, 'r')
                            ],
                            [
                                'name'     => 'size',
                                'contents' => 'auto'
                            ]
                        ],
                        'headers' => [
                            'X-Api-Key' => 'PtphNMKzr8dfePFuVB2UdDWs'
                        ]
                    ]);
                    $fp = fopen('output/'.$tanggal . '/'.$namafile.".png", "wb");
                    fwrite($fp, $res->getBody());
                    fclose($fp);
                }
            }else{
                $error = "File Maximal 50MB";
            }
        }else{
            $error = "File Harus png, jpg, jpeg!";
        }
    }else{
        $error = "File Bukan Gambar!";
    }
}
              
if(isset($_POST["download"])){
    $path = 'output/'.$tanggal . '/';
    $filename = $_POST["download"];
    $file_path=$path.$filename;
    $ctype="application/octet-stream";

    if(!empty($file_path) && file_exists($file_path)){ //check keberadaan file
        header("Pragma:public");
        header("Expired:0");
        header("Cache-Control:must-revalidate");
        header("Content-Control:public");
        header("Content-Description: File Transfer");
        header("Content-Type: $ctype");
        header("Content-Disposition:attachment; filename=\"".basename($file_path)."\"");
        header("Content-Transfer-Encoding:binary");
        header("Content-Length:".filesize($file_path));
        flush();
        readfile($file_path);
        exit();
    }
}
?>

<form action="" method="post" enctype="multipart/form-data">
  <table>
    <tr>
      <td>Masukan Gambar</td>
      <td> : </td>
      <td>
        <input type="file" name="input" placeholder="upload file disini" required/>
      </td>
    </tr>
    <tr>
      <td colspan="3">
        <center>
          <button type="submit" name="eraser">Upload</button>
        </center>
      </td>
    </tr>
  </table>
</form>


<?php if (isset($_POST["convert"])){?>
  <form method="post" action="">
    <button type="submit" name="download" value="<?= $namafile . '.png'?>" id="buttonn">Download</button>
  </form>
<?php } ?>
