
<?=$this->renderPartial('/widgets/crumbs')?>
	
<div class="single_brand">
	<img src="<?=$this->getImageUrl($brand,'m','logo')?>" class="logo" />

	<h2>О компании</h2>
	<div class="text"><?=$brand->text?></div>
	<br />

  <?if($sales){?>
	<?=$this->renderPartial('/sales/rubric',array('data'=>$sales,'title'=>'Акции и скидки'))?>
	<br />
  <?}?>
	
  <?if($brand->addresses){?>
	<h2>Адреса</h2>
	<div id="map" style="width:100%;height:400px;"></div>
	
	<link rel="stylesheet" type="text/css" href="/static/js/gmaps/infobubble/infobubble.css" />
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript" src="/static/js/gmaps/infobubble/infobubble-compiled.js"></script>
	
	<script type="text/javascript">
		var map, infoBubble;
		function initialize() {     
			var myLatlng = new google.maps.LatLng(43.244452,76.879867);
			var myOptions = {
				zoom: 12,
				center: myLatlng,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			}
			var map = new google.maps.Map(document.getElementById("map"), myOptions); 
			
			<?foreach($brand->addresses as $k=>$v){?>
				<?if($v->coords){?>
					var contentString<?=$k?> = '';
					<?if($v->showcase){?>
						contentString<?=$k?> += '<a href="<?=$this->getImageUrl($v,'orig','showcase')?>" target="_blank"><img src="<?=$this->getImageUrl($v,'b','showcase')?>" class="showcase" /></a>';
					<?}?>
					contentString<?=$k?> += '<img src="<?=$this->getImageUrl($brand,'s','logo')?>" class="brand_logo" />';
					contentString<?=$k?> += '<p>';
					contentString<?=$k?> += '<?=str_replace("\r\n",'',nl2br($v->address))?>';
					<?if($v->mall_id){?>
						contentString<?=$k?> += '<br /><?=$v->mall->name?>';
					<?}?>
					contentString<?=$k?> += '</p>';					
					contentString<?=$k?> += '<div class="contact">тел.: <?=$v->phone?></div>';
					<?if($v->fax){?>
						contentString<?=$k?> += '<div class="contact">факс: <?=$v->fax?></div>';
					<?}?>
					<?if($v->email){?>
						contentString<?=$k?> += '<div class="contact">e-mail: <a href="mailto:<?=$v->email?>" target="_blank"><?=$v->email?></a></div>';
					<?}?>
					<?if($v->work){?>
						contentString<?=$k?> += '<div class="contact">график работы: <?=$v->work?></div>';
					<?}?>
				
					infoBubble<?=$k?> = new InfoBubble({
						map: map,
						content: contentString<?=$k?>,
						//maxWidth:350,
						maxHeight:200,
						minWidth:350,
						minHeight:170,
						borderRadius: 4,
						arrowSize: 10,
						padding: 0,
						arrowPosition: 20,
						//disableAutoPan: true,
						backgroundClassName: 'infobubble',
						borderColor: '#f0f0f0',
						//disableAnimation: true
					});				
				
					var marker<?=$k?> = new google.maps.Marker({
						position: new google.maps.LatLng(<?=$v->coords?>),
						map: map,
						icon: '<?=$brand->getMarker()?>',
						title: '<?=addslashes($brand->name)?>'
					});
					google.maps.event.addListener(marker<?=$k?>, 'click', function() {
						infoBubble<?=$k?>.open(map, marker<?=$k?>);
						//infowindow<?=$k?>.open(map,marker<?=$k?>);
					});			
				<?}?>
			<?}?>
		}	
		initialize();
	</script>
  <?}?>
</div>