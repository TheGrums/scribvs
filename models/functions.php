<?php

function authKey($key,$bdd){

	$req=$bdd->prepare("SELECT level FROM auth_keys WHERE akey=:akey ;");
	$req->execute(array("akey"=>$key));
	$data=$req->fetch();
	if($req->rowCount()==0)die("<div class='row yolo' style='font-family:Sniglet;color:red;font-size:12px;'>Cet identifiant n'existe pas ou à déjà été utilisé.<br /> Si vous pensez que c'est une erreur veuillez contacter les administrateurs du site.</div>");
	else{
		return $data["level"];
	}
}

function uploadFiles($var, $type="normal"){

						$images = array();
						if(isset($_FILES[$var])){
								for($a = 0; $a<count($_FILES[$var]['name']); $a++){
										$target = '../uploads/';
										if($type=="post_images"){$extensions = array('jpg','gif','png','jpeg');}
										else if($type=="normal"){$extensions = array('jpg','gif','png','jpeg','txt','rtf','docx','pdf','mov','xls','zip','rar','wav','cpgz','ppt','pptx','doc','psd','html','avi','svg');}
										$ext  = pathinfo($_FILES[$var]['name'][$a], PATHINFO_EXTENSION);
												if (in_array(strtolower($ext),$extensions)){
														if(isset($_FILES[$var]['error'][$a]) && UPLOAD_ERR_OK === $_FILES[$var]['error'][$a]){
																$img_name = md5(uniqid()) .'.'. $ext;



																if($type=="post_images"){
																switch (strtolower($ext)) {
																		case 'jpg':
																				$img = imagecreatefromjpeg($_FILES[$var]['tmp_name'][$a]);
																				break;
																		case 'jpeg':
																				$img = imagecreatefromjpeg($_FILES[$var]['tmp_name'][$a]);
																				break;
																		case 'png':
																				$img = imagecreatefrompng($_FILES[$var]['tmp_name'][$a]);
																				break;
																		case 'gif':
																				$img = imagecreatefromgif($_FILES[$var]['tmp_name'][$a]);
																		break;
																		default:
																				$img = imagecreatefromjpeg($_FILES[$var]['tmp_name'][$a]);
																	}


																$width = imagesx($img);
																$height = imagesy($img);

																$tmp_img = imagecreatetruecolor($width, $height);

																imageinterlace($tmp_img,true);

																imagecopyresized($tmp_img, $img, 0, 0, 0, 0, $width, $height, $width, $height);

															}
																$pathToImage = $target.$img_name;


																if($type=="post_images"){
																switch (strtolower($ext)) {
																		case 'jpg':
																				imagejpeg($tmp_img, $pathToImage);
																				break;
																		case 'jpeg':
																				imagejpeg($tmp_img, $pathToImage);
																				break;
																		case 'png':
																				imagepng($tmp_img, $pathToImage);
																				break;
																		case 'gif':
																				imagegif($tmp_img, $pathToImage);
																				break;
																		default:
																				imagejpeg($tmp_img, $pathToImage);
																	}
																		$result = $pathToImage;
																}

																else if($type=="normal"){move_uploaded_file($_FILES[$var]["tmp_name"][$a], $pathToImage);}

																if($result && $a>0 && $type=="post_images"){
																		$images[$a] = " <div class='mosaicflow_item'><img class='clickable-image' src = '".substr($pathToImage,1)."' /></div>";
																}
																else if($type=="post_images"){
																		$images[$a] = "<img class = 'clickable-image' src = '".substr($pathToImage,1)."' />";
																}
																else if($type=="normal"){
																		$images[$a]=$pathToImage;
																}
														}
												}
												else{
													return false;
												}
								}
								return (array)$images;
						}
						else{
								return false;
						}
}



?>
