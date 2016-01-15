
<?if($pages>1){?>
    <a href="?page=<?=($page-1)?>"><i class="spriteLeftArr <?if($page>1){?>active<?}?>"></i></a>
	<span>
		<?for($i=1;$i<=$pages;$i++){?>
			<a class="<?if($i==$page){?>active<?}?>" href="?page=<?=$i?>"><?=$i?></a>
		<?}?>
    </span>
	<a href="?page=<?=($page+1)?>"><i class="spriteRightArr <?if($page<$pages){?>active<?}?>"></i></a>
	<a href="?all" class="grey">Открыть все</a>
<?}?>

