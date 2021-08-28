//Validasi Form
$(document).on('submit','.form-validate',function(e){
    var error = ""
    $('.field-validate').each(function (){
        if(this.value == ''){
            $(this).closest(".form-group").addClass('has-error')
            error = "has error"
        }   
        else
            $(this).closest(".form-group").removeClass('has-error')
    })

    $(".required_one").each(function() {
		var checked = $('.required_one:checked').length;
		if(!checked) {
			$(this).closest(".form-group").addClass('has-error')
			error = "has error";
		}else{
			$(this).closest(".form-group").removeClass('has-error')
		}
	})

    if(error=="has error")
    	return false
})

$(document).on('keyup change', '.field-validate',function (e){
    if(this.value == '')
        $(this).closest(".form-group").addClass('has-error')
    else
        $(this).closest(".form-group").removeClass('has-error')
})

$(document).on('click', '.required_one', function(e){

	var checked = $('.required_one:checked').length;
	if(!checked) {
		$(this).closest(".form-group").addClass('has-error');
	}else{
		$(this).closest(".form-group").removeClass('has-error');
	}

})

//validate image and set value form
$(document).on('click','#select-image',function (){
    var image_src = $('.thumbnail.selected').children('img').attr('src');
    var image_id = $('.thumbnail.selected').children('img').attr('alt');
    if(image_src != undefined){
        $('#selectedthumbnailIcon').html('<img src="'+image_src+'" class = "thumbnail" style="max-height: 100px; margin-top: 20px; ">');
        $('#image_id').val(image_id);
        $('#selectedthumbnailIcon').show();
        $('#imageIcone').removeClass('has-error');
        $('#image_id').removeClass('field-validate');
    }
})

function propchecked(parents_id){
	$('#categories_'+parents_id).prop('checked', true);
	var parent_id = $('#categories_'+parents_id).attr('parents_id');
	if(parents_id !== undefined)
		propchecked(parent_id);
}
function propunchecked(parents_id){
	$('.sub_categories_'+parents_id).prop('checked', false);
	$('.sub_categories_'+parents_id).each(function() {
		var subparents_id = $(this).attr('id');
		var subparents_id = subparents_id.replace("categories_", "");
		propunchecked(subparents_id);
	});
}

//check sub_categories
$(document).on('click', '.sub_categories', function(){

	if($(this).is(':checked')){
		var parents_id = $(this).attr('parents_id');
		if(parents_id !== undefined)
			propchecked(parents_id);
	}else{
		var parents_id = $(this).attr('id');
		if(parents_id !== undefined){
			var parents_id = parents_id.replace("categories_", "");
			propunchecked(parents_id);
		}
	}
})

//validasi penawaran harga
$(document).on('change','#deal',function(){
	if($(this).val() == '0'){
		$(".flash-container").hide();
		$(".flash-container #deal_price").removeClass("field-validate")
		$(".flash-container #reservationtime").removeClass("field-validate")
	}
	else{
		$(".flash-container").show()
		$(".flash-container #deal_price").addClass("field-validate")
		$(".flash-container #reservationtime").addClass("field-validate")
	}
})

//validasi atribut produk
$(document).on('change','#attribute',function(){
	if($(this).val() == '0'){
		$(".container-attribute").hide();
		$(".container-attribute #value-attribute").removeClass("field-validate")
	}
	else{
		$(".container-attribute").show();
		$(".container-attribute #value-attribute").addClass("field-validate")
	}
})

//cek jenis kupon
$('#type').on('change',function(){
	if($(this).val() == 'percent'){
		$(".maks-amount").show();
		document.getElementById("help-amount").innerHTML="Input berupa bilangan bulat dalam persen";
	}
	else{
		$(".maks-amount").hide();
		document.getElementById("help-amount").innerHTML="Input berupa bilangan bulat dalam rupiah";
	}
})

//validasi batasan jumlah kupon tiap pengguna
$('#limit').on('change',function(){
	if($(this).val() == '1'){
		$(".user-limit").show();
		$(".user-limit #user_limit").addClass("field-validate")   
	}
	else{
		$(".user-limit").hide();
		$(".user-limit #user_limit").removeClass("field-validate")      
	}
})