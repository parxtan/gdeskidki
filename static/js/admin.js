function getCategories(vl)
{
	$.ajax({
		url: '/admin/categories/getArray/',
		type: 'post',
		data: {'brand_id': vl},
		success: function(data){
			$('#categories_array').html(data);
		}
	});
}

function updateAddressesForm(mall_id)
{
	$.ajax({
		url: '/admin/malls/getData/',
		data: {'mall_id': mall_id},
		type: 'post',
		dataType: 'json',
		success: function(data){
			if(data.status=='success')
			{
				$('#Addresses_coords').val(data.coords);
				$('#Addresses_work').val(data.work);				
				$('#Addresses_address').val(data.address);				
			}
		}
	});
}

	$(function() {
		$("#data-grid table tbody tr").each(function(){
			var id = $(this).find('td').eq(1).text();
			$(this).attr('id','pos-'+id);
		});
	
		$("#data-grid table tbody").sortable({	
			handle: ".cursor-move",
			items: 'tr',
			axis: 'y',
			opacity: 0.5,
			tolerance: 'pointer',
			containment: 'parent', 
			cursorAt: true,
			update: function(event, ui){
				$('#data-grid').addClass('grid-view-loading');
				var pos = $("#data-grid table tbody").sortable('serialize');
				$.post(
					'?'+pos, 
					function(data) {
						if(data=='success')
							$('#data-grid').removeClass('grid-view-loading');
					}
				);
			}
		 });
		$("#data-grid table").disableSelection();
	});    
