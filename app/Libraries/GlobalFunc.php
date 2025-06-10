<?php
/**
 *
 * @link       https://www.codekop.com/
 * @version    1.0.2
 * @copyright  Codekop Datatables Library (c) 2022
 *
 * File      : Datatables.php
 * author    : Fauzan Falah
 * E-mail    : fauzancodekop@gmail.com / fauzan1892@codekop.com
 *
 *
**/

namespace App\Libraries;

class Globalfunc
{
		function upload_picture_not_resize($path,$fileHigh,$fileTumb,$lastfile=null){
		$result = "";
		$filename = date('Ymdhis')."_".$this->rand(10).".png";
		
		if(!empty($fileHigh)){
			$imageHigh 		= str_replace('data:image/png;base64,', '', $fileHigh);
			$imageHigh 		= str_replace(' ', '+', $imageHigh);
			$imageHigh 		= base64_decode($imageHigh);
			$filePathHigh 	= $path.$filename;
			$uploadHigh 	= file_put_contents($filePathHigh, $imageHigh);
				
			if($uploadHigh){
				if(!empty($fileTumb)){
					$imageTumb 		= str_replace('data:image/png;base64,', '', $fileTumb);
					$imageTumb 		= str_replace(' ', '+', $imageTumb);
					$imageTumb 		= base64_decode($imageTumb);
					$filePathTumb 	= $path."resize/".$filename;
					$uploadTumb 	= file_put_contents($filePathTumb, $imageTumb);
				}
				
				if($lastfile != null){
					@unlink($path.$lastfile);
					@unlink($path."resize/".$lastfile);
				}
				
				$result = $filename;
			}else{
				$result = 'error';
			}
		}
		
        return $result;
    }

	function rand($length){
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));
        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }
        return $key;
    }


}

?>