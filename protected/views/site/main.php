
	<!--div class="crumbs">
		Сортировать:
		<a href="">по дате</a>
		<a href="">по популярности</a>
		<a href="">по размеру скидки</a>
	</div-->
	
	<?=$this->renderPartial('/widgets/banners_middle')?>
	
<?if($sales){?>
	<?=$this->renderPartial('/sales/rubric',array('data'=>$sales,'title'=>'Акции и скидки'))?>
<?}?>

<?if($new){?>
	<?=$this->renderPartial('/sales/rubric',array('data'=>$new,'title'=>'Новые поступления'))?>
<?}?>