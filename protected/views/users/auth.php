<?if($_GET['reg']=='success' && $_SESSION['login']==1){?>
	<div id="main">
		<div class="order-warning register-success">
			<p>
				Благодарим за регистрацию!<br />
				Вы уже авторизованы и можете воспользоваться<br />
				каталогом для добавления товаров в корзину
			</p>
			<div class="back">
				<a href="/katalog/">перейти в каталог</a> <br />
				<a href="/cabinet/">редактировать личные данные</a>
			</div>
		</div>
	</div>
<?}else{?>

	<div id="main" class="form-holder">
		<?if(Yii::app()->user->isGuest){?>
			<?=$this->renderPartial('/users/_auth_form')?>
		<?}?>

		<?=$this->renderPartial('/users/_reg_form')?>
	</div>

<?}?>