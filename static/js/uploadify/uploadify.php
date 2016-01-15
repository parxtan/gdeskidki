<?
/*
Uploadify v2.1.0
Release Date: August 24, 2009

Copyright (c) 2009 Ronnie Garcia, Travis Nickels

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/
Define("IN_SITE",1);
include $_SERVER['DOCUMENT_ROOT']."/sql.php";
include $_SERVER['DOCUMENT_ROOT']."/func_lib/resizer_f.php";

if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
	$targetFile =  str_replace('//','/',$targetPath);
	
	// $fileTypes  = str_replace('*.','',$_REQUEST['fileext']);
	// $fileTypes  = str_replace(';','|',$fileTypes);
	// $typesArray = split('\|',$fileTypes);
	// $fileParts  = pathinfo($_FILES['Filedata']['name']);
	
	// if (in_array($fileParts['extension'],$typesArray)) {
		// Uncomment the following line if you want to make the directory if it doesn't exist
		// mkdir(str_replace('//','/',$targetPath), 0755, true);


		/* pos */
		$pos = mysql_result(mysql_query("select max(pos) from photos where razdel='".$_POST["razdel"]."'"),0,0);
		if(is_numeric($pos) and $pos>0) $pos++;
		else $pos = 1;

		mysql_query("insert into ".$_POST["table"]."(razdel,pos) values('".$_POST["razdel"]."','".$pos."')");
		$ins_id = mysql_insert_id();

		/* name file */
      	ereg("\.([^\.]*)$",$_FILES['Filedata']['name'],$t);
   	    	$ext = $t[1];
   		$fname = "photo_".$ins_id.".".$ext;
		
		move_uploaded_file($tempFile,$targetFile.$fname);

		
		mysql_query("update ".$_POST["table"]." set photo='".$fname."' where id='".$ins_id."'");

		/* create preview */
		$bigImg=ResizeAndSaveImage($_SERVER['DOCUMENT_ROOT']."/img/".$_POST["table"]."/".$fname,900,1500);
		$smallImg=ResizeAndSaveImage($_SERVER['DOCUMENT_ROOT']."/img/".$_POST["table"]."/".$fname,250,150);
		imagejpeg($bigImg, $_SERVER['DOCUMENT_ROOT']."/img/".$_POST["table"]."/".$fname, 100);
		imagejpeg($smallImg, $_SERVER['DOCUMENT_ROOT']."/img/".$_POST["table"]."/preview/".$fname, 100);

		/* response */
		echo '
				<li id="'.$ins_id.'">
					<input type="hidden" name="pos['.$ins_id.']" value="'.$pos.'" />
					<div class="moving"><textarea name="opisanie" title="'.$ins_id.'" class="photos_opisanie absolute none" onblur="hidePhotoOpisanie(this);"></textarea><img src="../func_lib/resize.php?method=1&image='.$fname.'&width=130&height=130&type=photo" /></div>
					<div align="center" class="photos_icon">
						<a title="Описание фотографии" onclick="showPhotoOpisanie(this);"><img src="i/buble.gif" /></a>&nbsp;
						<a title="Удалить фотографию" onclick="if(confirm(\'Удалить фотографию?\'))delPhoto(\'photos\','.$ins_id.',this);return false;"><img src="i/del.gif" /></a>
					</div>
				</li>
		';
	// } else {
	// 	echo 'Invalid file type.';
	// }
}
?>
