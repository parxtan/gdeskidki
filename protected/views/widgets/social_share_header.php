<table id="social_share">
<tr>
	<td>
		<div class="vk_share">
			<!-- Put this script tag to the <head> of your page -->
			<script type="text/javascript" src="http://vk.com/js/api/openapi.js?105"></script>
			<script type="text/javascript">
				VK.init({apiId: 4181968, onlyWidgets: true});
			</script>
			<div id="vk_like">
				<div id="vk_like_<?=time()?>"></div>
				<script type="text/javascript">
					VK.Widgets.Like("vk_like_"+<?=time()?>, {type: "mini", height: 20, width: 90, pageUrl: "<?=Yii::app()->request->hostinfo.$pageUrl?>"});
				</script>
			</div>
		</div>
	</td>
	<td width="110">
		<div id="fb-root"></div>
		<script>
			(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s); 
				js.id = id;
				js.src = "https://connect.facebook.net/ru_RU/all.js#xfbml=1&appId=232186773572080";
				fjs.parentNode.insertBefore(js, fjs);
			}
			(document, 'script', 'facebook-jssdk'));
		</script>
		<div class="fb-like" data-href="<?=Yii::app()->request->hostinfo.$pageUrl?>" data-width="135" data-layout="button_count" data-show-faces="true" data-send="false"></div>
	</td>
	<td>
		<a target="_blank" class="mrc__plugin_uber_like_button" href="http://connect.mail.ru/share?share_url=<?=urlencode(Yii::app()->request->hostinfo.$pageUrl)?>" data-mrc-config="{'nt':1, 'cm' : '1', 'ck' : '1', 'sz' : '22', 'st' : '2', 'tp' : 'combo', 'width':120}">Нравится</a>
		<script src="http://cdn.connect.mail.ru/js/loader.js" type="text/javascript" charset="UTF-8"></script>	
	</td>
	<td>
		<div class="gpluse_share">
			<div class="g-plusone" data-size="medium" data-href="<?=Yii::app()->request->hostinfo.$pageUrl?>"></div>
			<!-- Place this tag after the last +1 button tag. -->
			<script type="text/javascript">
				window.___gcfg = {lang: 'ru'};
				(function() {
					var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
					po.src = 'https://apis.google.com/js/platform.js';
					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
				})();
			</script>	
		</div>
	</td>
	<td>
		<div class="twitter_share">
			<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?=Yii::app()->request->hostinfo.$pageUrl?>" data-lang="ru">Твитнуть</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>		
		</div>
	</td>
</tr>
</table>