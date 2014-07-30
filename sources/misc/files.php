<?
defined("WERUA") or die('<div style="margin:0 0 auto;width:200px">Ошибка запуска. Contact rdx.dnipro@gmail.com</div>');
class cropImage{
	var $imgSrc,$myImage,$cropHeight,$cropWidth,$x,$y;  
function setImage($image,$width,$height)
{
		$cropPercent = 1;
   $this->imgSrc = $image; 
                     
       if($width < $height) $biggestSide = $width;
       else $biggestSide = $height; 
                     
   $this->cropWidth   = $biggestSide*$cropPercent; 
   $this->cropHeight  = $biggestSide*$cropPercent; 
                     

   $this->x = ($width-$this->cropWidth)/2;
   $this->y = ($height-$this->cropHeight)/2;
             
}  
function createThumb($thumb)
{
                    
		$thumbSize = $thumb;
		$this->myImage = imagecreatetruecolor($thumbSize, $thumbSize); 
		imagecopyresampled($this->myImage, $this->imgSrc, 0, 0,$this->x, $this->y, $thumbSize, $thumbSize, $this->cropWidth, $this->cropHeight); 
}  
}  
class resizeImage{
	var $imgSrc,$myImage,$newWidth,$newHeight; 
	var $dirName, $baseName, $thumbName; 
	function setImage($image){
	   	$this->imgSrc = $image;
	   	// $this->imgSrc = basename($this->imgSrc);
	   	// $this->imgSrc = basename($this->imgSrc);
	   	$info = pathinfo($image);
	   	$this->dirName = $info['dirname'];
	   	$this->baseName = $info['basename'];
	} 
	function createThumb($width=0,$height=0,$thumbDir=''){
		$size = getimagesize($this->imgSrc);
		$imagewidth=$size[0];
		$imageheight=$size[1];
		$image_type = $size[2];

		if ($width!=0){
			$this->newWidth = $width; 
		} else {
			$this->newWidth = ($imagewidth/$imageheight)*$height;
		}
		if ($height!=0){
			$this->newHeight = $height;
		} else {
			$this->newHeight = ($imageheight/$imagewidth)*$width;
		}
		$this->thumbName = 'tmb_'.$this->newWidth.$this->newHeight.$this->baseName;

		$image="";
		if( $image_type == IMAGETYPE_JPEG ) {
			$image = imagecreatefromjpeg($this->imgSrc);
		} elseif( $this->image_type == IMAGETYPE_GIF ) {
			$image = imagecreatefromgif($this->imgSrc);
		} elseif( $this->image_type == IMAGETYPE_PNG ) {
			$image = imagecreatefrompng($this->imgSrc);
		}
		$thumb = imagecreatetruecolor($this->newWidth, $this->newHeight);
		imagecopyresampled($thumb, $image, 0, 0, 0, 0, $this->newWidth, $this->newHeight, $imagewidth, $imageheight);

		if (empty($thumbDir)) $thumbDir = $this->dirName;
		// WRA::debug($thumbDir.'/'.$this->thumbName);
		
		if( $image_type == IMAGETYPE_JPEG ) {
			imagejpeg($thumb,$thumbDir.'/'.$this->thumbName,80);
		} elseif( $image_type == IMAGETYPE_GIF ) {
			imagegif($thumb,$thumbDir.'/'.$this->thumbName);         
		} elseif( $image_type == IMAGETYPE_PNG ) {
			imagepng($thumb,$thumbDir.'/'.$this->thumbName);
		}
	}
}  
class wra_upfile extends wfbaseclass{
	var $id;
	var $title;
	var $description;
	var $filename;
    
    static function adminit($wfadmin){
        $wfadmin->table='upfiles';
        $wfadmin->multilanguages=false;
        $wfadmin->columns[]=new admincolumn("String", "title", "Название", admincolumntype::text, admincolumntype::text, 2);
        $wfadmin->columns[]=new admincolumn("String", "description", "Описание", admincolumntype::text, admincolumntype::bigtext, 2);
        $wfadmin->columns[]=new admincolumn("String", "filename", "Файл (only *.zip)", admincolumntype::none, admincolumntype::file, 2);       
        $wfadmin->order = " order by id asc";
    }

    static function get_drop($lang='') {
        $result = array();
        $wd=new wra_db();
        $wd->query = "SELECT 
        p.id,p.title
        FROM `".WRA_CONF::$db_prefix."upfiles".$lang."` AS p
        ORDER by p.id asc";   
        $wd->executereader();
        while($u0=$wd->read()){
            $result[$u0[0]]= $u0[1];;            
        }
        $wd->close();
        unset($wd);
        
        return $result;
    }

    function load($id) {
        $wd = new wra_db();
        $this->id = $id;
        $wd->query = 'SELECT 
			 `id`,
			 `title`,
			 `description`,
			 `filename`
 		FROM `' . WRA_CONF::$db_prefix . "upfiles`  where `id`='$this->id'";       
        $wd->executereader();
        if ($u0 = $wd->read()) {
            $this->id = $u0[0];
            $this->title = $u0[1];
            $this->description = $u0[2];
            $this->filename = $u0[3];
        }
        $wd->close();
        unset($wd);
    }

}


class wra_uploadedfile{
	var $realname='';
	var $path="";
	var $uploaddir = 'upload';
	var $filename="";
	var $tmbfilename="";
	var $filetype="";
	var $fileext="";
	var $error="";
	var $tmbwidth=100;
        var $tmbheight=100;
	var $tmbcompr=80;
	var $imagewidth=0;
	var $imageheight=0;
	var $validtypes=array();
	
	var $maxsize=0;
	
	function addvalidtype($type){
		
		$this->validtypes[count($this->validtypes)]=$type;
	}
	function wra_uploadedfile($basedir){
		$this->uploaddir=$basedir."/upload/";
		$this->maxsize=250*1024*1024;
	}
        function createcropedavatarfull(){

		if($this->error!="") return;
		$this->tmbfilename="tmb_".$this->filename;
		$this->getimageinfo();
		if($this->imageheight>=$this->imagewidth){
			
			$image_info = getimagesize($this->uploaddir.$this->filename);
			$image_type = $image_info[2];
			$image="";
			if( $image_type == IMAGETYPE_JPEG ) {
				$image = imagecreatefromjpeg($this->uploaddir.$this->filename);
			} elseif( $this->image_type == IMAGETYPE_GIF ) {
				$image = imagecreatefromgif($this->uploaddir.$this->filename);
			} elseif( $this->image_type == IMAGETYPE_PNG ) {
				$image = imagecreatefrompng($this->uploaddir.$this->filename);
			}
			
			
			$new_image = imagecreatetruecolor($this->tmbwidth, $this->tmbheight);
			imagecopyresampled($new_image, $image, 0, 0, 0, 0, $this->tmbwidth, $this->tmbheight, $this->imagewidth, $this->imageheight);
			$image = $new_image;   
			$cc = new cropImage();
			$cc->setImage($new_image,$this->tmbwidth,$this->tmbheight);
                        $cc->y=0;
                       
			$cc->createThumb($this->tmbwidth);
			
			$image=$cc->myImage;
			
			if( $image_type == IMAGETYPE_JPEG ) {
				imagejpeg($image,$this->uploaddir.$this->tmbfilename,$this->tmbcompr);
			} elseif( $image_type == IMAGETYPE_GIF ) {
				imagegif($image,$this->uploaddir.$this->tmbfilename);         
			} elseif( $image_type == IMAGETYPE_PNG ) {
				imagepng($image,$this->uploaddir.$this->tmbfilename);
			}   
		}elseif($this->imageheight<$this->imagewidth){
			
			$image_info = getimagesize($this->uploaddir.$this->filename);
			$image_type = $image_info[2];
			$image="";
			if( $image_type == IMAGETYPE_JPEG ) {
				$image = imagecreatefromjpeg($this->uploaddir.$this->filename);
			} elseif( $this->image_type == IMAGETYPE_GIF ) {
				$image = imagecreatefromgif($this->uploaddir.$this->filename);
			} elseif( $this->image_type == IMAGETYPE_PNG ) {
				$image = imagecreatefrompng($this->uploaddir.$this->filename);
			}
			

			$new_image = imagecreatetruecolor($this->tmbwidth,$this->tmbheight);
			imagecopyresampled($new_image, $image, 0, 0, 0, 0,  $this->tmbwidth,$this->tmbheight,  $this->imagewidth,$this->imageheight);
			$image = $new_image;   
			$cc = new cropImage();
			$cc->setImage($new_image,$this->tmbwidth,$this->tmbheight);
                        $cc->y=0;
			$cc->createThumb($this->tmbwidth);
			
			$image=$cc->myImage;
			
			if( $image_type == IMAGETYPE_JPEG ) {
				imagejpeg($image,$this->uploaddir.$this->tmbfilename,$this->tmbcompr);
			} elseif( $image_type == IMAGETYPE_GIF ) {
				imagegif($image,$this->uploaddir.$this->tmbfilename);         
			} elseif( $image_type == IMAGETYPE_PNG ) {
				imagepng($image,$this->uploaddir.$this->tmbfilename);
			}   
		}else{
			copy($this->uploaddir.$this->filename,$this->uploaddir.$this->tmbfilename);
			
		}
		
	}
	function createcropedavatar(){
		//require_once WRA_Path."/modules/cropcanvas/class.cropcanvas.php";//обрезка изображений
		//require_once WRA_Path."/modules/cropcanvas/class.cropinterface.php";//обрезка изображений
		if($this->error!="") return;
		$this->tmbfilename="tmb_".$this->filename;
		$this->getimageinfo();
		if($this->imageheight>=$this->imagewidth){
			
			$image_info = getimagesize($this->uploaddir.$this->filename);
			$image_type = $image_info[2];
			$image="";
			if( $image_type == IMAGETYPE_JPEG ) {
				$image = imagecreatefromjpeg($this->uploaddir.$this->filename);
			} elseif( $this->image_type == IMAGETYPE_GIF ) {
				$image = imagecreatefromgif($this->uploaddir.$this->filename);
			} elseif( $this->image_type == IMAGETYPE_PNG ) {
				$image = imagecreatefrompng($this->uploaddir.$this->filename);
			}
			
			$newheight=$this->imageheight/$this->imagewidth*$this->tmbwidth;
			$new_image = imagecreatetruecolor($this->tmbwidth, $newheight);
			imagecopyresampled($new_image, $image, 0, 0, 0, 0, $this->tmbwidth, $newheight, $this->imagewidth, $this->imageheight);
			$image = $new_image;   
			$cc = new cropImage();
			$cc->setImage($new_image,$this->tmbwidth,$newheight);
			$cc->createThumb($this->tmbwidth);
			
			$image=$cc->myImage;
			
			if( $image_type == IMAGETYPE_JPEG ) {
				imagejpeg($image,$this->uploaddir.$this->tmbfilename,$this->tmbcompr);
			} elseif( $image_type == IMAGETYPE_GIF ) {
				imagegif($image,$this->uploaddir.$this->tmbfilename);         
			} elseif( $image_type == IMAGETYPE_PNG ) {
				imagepng($image,$this->uploaddir.$this->tmbfilename);
			}   
		}elseif($this->imageheight<$this->imagewidth){
			
			$image_info = getimagesize($this->uploaddir.$this->filename);
			$image_type = $image_info[2];
			$image="";
			if( $image_type == IMAGETYPE_JPEG ) {
				$image = imagecreatefromjpeg($this->uploaddir.$this->filename);
			} elseif( $this->image_type == IMAGETYPE_GIF ) {
				$image = imagecreatefromgif($this->uploaddir.$this->filename);
			} elseif( $this->image_type == IMAGETYPE_PNG ) {
				$image = imagecreatefrompng($this->uploaddir.$this->filename);
			}
			
			$newheight=$this->imagewidth/$this->imageheight*$this->tmbwidth;
			$new_image = imagecreatetruecolor( $newheight,$this->tmbwidth);
			imagecopyresampled($new_image, $image, 0, 0, 0, 0,  $newheight,$this->tmbwidth,  $this->imagewidth,$this->imageheight);
			$image = $new_image;   
			$cc = new cropImage();
			$cc->setImage($new_image,$newheight,$this->tmbwidth);
			$cc->createThumb($this->tmbwidth);
			
			$image=$cc->myImage;
			
			if( $image_type == IMAGETYPE_JPEG ) {
				imagejpeg($image,$this->uploaddir.$this->tmbfilename,$this->tmbcompr);
			} elseif( $image_type == IMAGETYPE_GIF ) {
				imagegif($image,$this->uploaddir.$this->tmbfilename);         
			} elseif( $image_type == IMAGETYPE_PNG ) {
				imagepng($image,$this->uploaddir.$this->tmbfilename);
			}   
		}else{
			copy($this->uploaddir.$this->filename,$this->uploaddir.$this->tmbfilename);
			
		}
		
	}
	function createavatar(){
		if($this->error!="") return;
		$this->tmbfilename="tmb_".$this->filename;
		$this->getimageinfo();
		if($this->imagewidth>tmbwidth){

			$image_info = getimagesize($this->uploaddir.$this->filename);
			$image_type = $image_info[2];
			// $image_type = exif_imagetype($this->uploaddir.$this->filename);
			// WRA::debug($image_type);
			// die();
			$image='';
			if( $image_type == IMAGETYPE_JPEG ) {
				$image = imagecreatefromjpeg($this->uploaddir.$this->filename);
			} elseif( $image_type == IMAGETYPE_GIF ) {
				$image = imagecreatefromgif($this->uploaddir.$this->filename);
			} elseif( $image_type == IMAGETYPE_PNG ) {
				$image = imagecreatefrompng($this->uploaddir.$this->filename);
			}else{
				$image = imagecreatefromstring($this->uploaddir.$this->filename);
			}
			
			$newheight=$this->imageheight/$this->imagewidth*$this->tmbwidth;
			$new_image = imagecreatetruecolor($this->tmbwidth, $newheight);
			imagecopyresampled($new_image, $image, 0, 0, 0, 0, $this->tmbwidth, $newheight, $this->imagewidth, $this->imageheight);
			$image = $new_image;   
			
			if( $image_type == IMAGETYPE_JPEG ) {
				imagejpeg($image,$this->uploaddir.$this->tmbfilename,$this->tmbcompr);
			} elseif( $image_type == IMAGETYPE_GIF ) {
				imagegif($image,$this->uploaddir.$this->tmbfilename);         
			} elseif( $image_type == IMAGETYPE_PNG ) {
				imagepng($image,$this->uploaddir.$this->tmbfilename);
			}   
		}else{
			copy($this->uploaddir.$this->filename,$this->uploaddir.$this->tmbfilename);			
		}		
	}
	function getimageinfo(){
		if($this->error!="") return;
		$size = getimagesize($this->uploaddir.$this->filename);
		$this->imagewidth=$size[0];
		$this->imageheight=$size[1];
		if($this->imageheight>$this->imagewidth*10){
			$this->error="sizeimage";
		}
		if($this->imagewidth>$this->imageheight*20){
			$this->error="sizeimage";
		}
	}
	function upload($userfile,$usehashname=false,$xhr=false){
        if(!$xhr){                
		if (isset($_FILES[$userfile])) {
			if (is_uploaded_file($_FILES[$userfile]['tmp_name'])) {				
				$this->path = $_FILES[$userfile]['tmp_name'];
				$this->filename=strtolower ($_FILES[$userfile]['name']);                                
				$this->fileext = strtolower (substr($_FILES[$userfile]['name'], 1 + strrpos($_FILES[$userfile]['name'], ".")));
				$this->realname=$this->filename.".".$this->fileext;
                if($usehashname){					
					$this->filename=md5($this->filename.WRA::getcurtime()).".".$this->fileext;
				}
				if (filesize($this->path) > $this->maxsize) {
					$this->error="maxsize";
				} elseif (!in_array($this->fileext , $this->validtypes)) {					
					$this->error="fileext ".$this->fileext;
				} else {
					if (move_uploaded_file($this->path, $this->uploaddir.$this->filename)) {
						$this->error="";
					} else {
						$this->error="nomove";
					}

				}
			} else {
				$this->error="nofile";
			}
		} 
            }else{
                
             
                        $this->path = $_GET[$userfile];
                        $this->filename=strtolower ($_GET[$userfile]);

                        $this->fileext = strtolower (substr($_GET[$userfile], 1 + strrpos($_GET[$userfile], ".")));
                       $this->realname=$this->filename.'.'.$this->fileext;
                        if($usehashname){

                                $this->filename=md5($this->filename.WRA::getcurtime()).".".$this->fileext;
                        }
                    

                        $input = fopen("php://input", "r");
                        $temp = tmpfile();
                        $realSize = stream_copy_to_stream($input, $temp);
                        fclose($input);

                        if ($realSize != (int)$_SERVER["CONTENT_LENGTH"]){            
                            return false;
                        }

                        $target = fopen($this->uploaddir.$this->filename, "w");        
                        fseek($temp, 0, SEEK_SET);
                        stream_copy_to_stream($temp, $target);
                        fclose($target);
                        $this->error="";

            }
	}
	function uploadnovalid($userfile,$usehashname=false){
		if (isset($_FILES[$userfile])) {
			if (is_uploaded_file($_FILES[$userfile]['tmp_name'])) {
				
				$this->path = $_FILES[$userfile]['tmp_name'];
				$this->filename=strtolower ($_FILES[$userfile]['name']);
				
				$this->fileext = strtolower (substr($_FILES[$userfile]['name'], 1 + strrpos($_FILES[$userfile]['name'], ".")));
				if($usehashname){
					
					$this->filename=md5($this->filename.WRA::getcurtime()).".".$this->fileext;
				}
				if (filesize($this->path) > $this->maxsize) {
					$this->error="maxsize";
				} elseif (in_array($this->fileext , $this->validtypes)) {
					
					$this->error="fileext";
				} else {
					if (move_uploaded_file($this->path, $this->uploaddir.$this->filename)) {
						$this->error="";
					} else {
						$this->error="nomove";
					}
					
				}
			} else {
				$this->error="nofile";
			}
		} 
		
	}
	
	
	
	}

class wra_dir{
	var $path;
	var $dir_content=array();
	var $error="";
	var $from;
	var $to;
	var $usesystem=false;
        
        static function destroy($dir) {
            $mydir = opendir($dir);
            while(false !== ($file = readdir($mydir))) {
                if($file != "." && $file != "..") {
                    chmod($dir.$file, 0777);
                    if(is_dir($dir.$file)) {
                        chdir('.');
                        wra_dir::destroy($dir.$file.'/');
                      //  rmdir($dir.$file) or DIE("не могу удалить $dir$file<br />");
                    }
                    else
                        unlink($dir.$file) or DIE("не могу удалить $dir$file<br />");
                }
            }
            closedir($mydir);
        }
	function isexist($path){
	    return file_exists(WRA_Path.wra_dir::slash().$path);
	}
	function slash(){
		if(isset($_SERVER['OS'])) 
			return "\\";
		else 
			return "/";
	}
	function create($path){
	    $path=str_replace("-1/","",$path);

		if(wra_dir::isystems(WRA_Path.wra_dir::slash().$path)) return false;
		if(!file_exists(WRA_Path.wra_dir::slash().$path))
		mkdir(WRA_Path.wra_dir::slash().$path);
		
		$languages=wra_lang::getlist();
	
		foreach($languages as $l0){
			$l0->createdir();
			if(!file_exists(WRA_Path.wra_dir::slash()."_lang".wra_dir::slash().$l0->alias.wra_dir::slash().$path))
				mkdir(WRA_Path.wra_dir::slash()."_lang".wra_dir::slash().$l0->alias.wra_dir::slash().$path);
			
			
		}
		return true;
	}
	function isystems($path){
		$denieddirs=array();
		$slash = "\\";

		if(in_array(strtolower($path),$denieddirs)){
			
			return true;
		}else{
			return false;
		}
		
		
		
	}
	function wra_dir($path){

		
		if (!is_dir($path)){
			$this->error=3;
			return ;	
		}
		
				$this->path = realpath($path);
		
				if(!$this->usesystem)
				if(wra_dir::isystems($this->path)){
			
					$this->path="";
					return;
				}



		$from = "";
		$to="";

		$slash = wra_dir::slash();
		$d0=opendir ($path);
		while ($file = readdir ($d0)) {
			if ($file != "." && $file != "..") {
				$tmp = $this->path.$slash.$file;
				if (is_dir($tmp)) 
					
					if($this->usesystem){
					$this->dir_content[] = new wra_dir($tmp);}else{
						if(!wra_dir::isystems($this->path)){
							$this->dir_content[] = new wra_dir($tmp);
						}
						
				}
				else {
					if($this->usesystem){
					$this->dir_content[] = $tmp;}else{
						if(!wra_dir::isystems($this->path)){
							$this->dir_content[] = $tmp;
						}
						
				}}
			}  
		} 
		closedir($d0);
	}
	function delete(){
		$this->delete_files();

		$t0 = new wra_dir($this->path);
		$t0->delete_tree();
		return true;
	}
	function delete_tree() {

		if (count($this->dir_content)) {
			while (count($this->dir_content)) {
				$this->dir_content[0]->delete_tree();
				array_shift($this->dir_content);
			}
		}
		if (!rmdir($this->path)) {
			$this->error = 1;

		}
		return;
	}  
	function move($newLocation) {

		if(wra_dir::isystems($newLocation)) return false;
		$perm = fileperms($this->path);
		$this->copy($newLocation,$perm); 
		$this->delete();
		chmod($newLocation,$perm);
		return true;
	}
	function copy($path, $mode, $from = "") {
		$this->copy_tree($path, $mode, $from = "");
		$this->copy_files($path, $mode, $from = "");
	}
	
	function copy_tree($path, $mode, $from = "") {
		if (!mkdir($path, $mode))
			{$this->error=5;return;}
		chmod($path,$mode);

		$this->from = $this->path;
		$this->to = $path;
		

		for ($i=0; $i < count($this->dir_content); $i++) {
			if (is_object($this->dir_content[$i])) {
				$pattern = "^".$this->from."^";
				$replace = $this->to;
				$dirToCreate = preg_replace($pattern,$replace, $this->dir_content[$i]->path );

				$this->dir_content[$i]->copy_tree($dirToCreate, $mode,$this->from);
			} 
			
		}   
		clearstatcache();
		
	} 
	
	function copy_files ($path, $mode, $from = "") {
		for ($i=0; $i < count($this->dir_content); $i++) {
			if (is_object($this->dir_content[$i])) {
				$pattern = "^".$this->from."^";
				$replace = $this->to;
				$newpath = preg_replace($pattern,$replace, $this->dir_content[$i]->path );
				$this->dir_content[$i]->copy_files($newpath, $mode,$this->from);
			} 
			else {
				$perms = fileperms($this->dir_content[$i]);
				$src = $this->dir_content[$i];
				$pattern = "^".$this->from."^";
				$replace = $this->to;
				$dest = preg_replace($pattern,$replace, $this->dir_content[$i] );
				copy($src,$dest);
				chmod($dest,$perms);
			}
		} 
		clearstatcache();
		
	} 
	function delete_files() {
		for ($i=0; $i < count($this->dir_content); $i++) {

			if (is_object($this->dir_content[$i])) {
				$pattern = "^".$this->from."^";
				$replace = $this->to;
				$newpath = preg_replace($pattern,$replace, $this->dir_content[$i]->path );
				
				$this->dir_content[$i]->delete_files($newpath, $mode,$this->from);
			} 
			else {
				if (!@unlink( $this->dir_content[$i] ))  {
					$this->error=2;
				}

			}
		} 
		clearstatcache();
	}  
	//идея части класса взята у dirtool  (c) Nov 2005  Uwe Stein
}


?>