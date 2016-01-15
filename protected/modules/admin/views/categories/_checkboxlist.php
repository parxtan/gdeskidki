
	<?=CHtml::checkBoxList(
		'Categories[]',
		$brand_categories,
		$array,
		array('separator'=>' ','template'=>'<span class="item">{input} {label}</span>')
	)?>