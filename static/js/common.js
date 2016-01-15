$(function(){	
	//setMaxWidthSales();
	setContentBlockHeight();
	initCaruselHeight();
	
	$(window).resize(function(){
		//setMaxWidthSales();
		setContentBlockHeight();
		initCaruselHeight();
	});
	
	var l_h = $('#hr').position().top;
	
	$(window).scroll(function(){
		var h = $('body').height();
		var w_h = $(this).height();
		var w_st = $(this).scrollTop();
		
		console.log(w_h+'-'+w_st+'-'+l_h);
		
		if(w_st + w_h < l_h)
			$('#content .left_block').css({top: 0});
		else
		if(w_st + w_h >= l_h + 85 && w_st + w_h <= h - 60)
			$('#content .left_block').css({top: w_st - l_h + w_h - 85});
		else
		if(w_st + w_h > h - 60)
			$('#content .left_block').css({top: h - 60 - l_h - 85});
	});	
	
	$('a[href^="http"]').not('[href^="http://gdeskidki"]').attr('target', '_blank');	
});

function setMaxWidthSales()
{
	if($('#content .middle_block').width()>=950)
		$('.sales .item').css({maxWidth: 272});
	else
		$('.sales .item').css({maxWidth: '100%'});
}

function setContentBlockHeight()
{
	var lh = $('#content .left_block').height();
	var mh = $('#content .middle_block').height();
	
	if(lh > mh)
		$('#content .middle_block').css({minHeight: lh+70 });
}

function initCaruselHeight()
{
	$('.carusel').each(function(){
		var w = $(this).parent().width();
		$(this).css({width: w});
	});
}

function scrollCarusel(obj,action)
{
	var active = $(obj).find('a.active');
	var index = $(obj).find('a.active').index(obj+' a');

	if(active.is(':animated')==false)
	{
		if(isNaN(action)==false && $('.carusel_pages .dot').eq(action).hasClass('active')==false){
			if(index>action){
				index = action+1;
				action = 'prev';
			}
			else{
				index = action-1;
				action = 'next';
			}
		}	
	
		if(action=='prev'){
			index--;		
			var prev = $(obj).find('a').eq(index);
			if(prev.length<1){
				prev = $(obj).find('a').last();
				index = $(obj).find('a').length;
			}
				
			prev.addClass('prev').css({left:'-100%'});
			
			active.animate({left: '100%'},function(){ $(this).removeClass('active'); });
			prev.animate({left: '0%'},function(){ $(this).removeClass('prev').addClass('active'); });
			
			$('.carusel_pages .dot.active').removeClass('active');
			$('.carusel_pages .dot').eq(index).addClass('active');
		}
		else
		if(action=='next'){
			index++;
			var next = $(obj).find('a').eq(index);			
			
			if(next.length<1){
				next = $(obj).find('a').first();
				index = 0;
			}
				
			next.addClass('next').css({left:'100%'});
			
			active.animate({left: '-100%'},function(){ $(this).removeClass('active'); });
			next.animate({left: '0%'},function(){ $(this).removeClass('next').addClass('active'); });
			
			$('.carusel_pages .dot.active').removeClass('active');
			$('.carusel_pages .dot').eq(index).addClass('active');				
		}
	}
}