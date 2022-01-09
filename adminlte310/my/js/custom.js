function document_ready(){

	$.validator.setDefaults({
		errorElement: 'span',
		errorPlacement: function (error, element) {
		  error.addClass('invalid-feedback');
		  element.closest('.input-group').append(error);
		},
		highlight: function (element, errorClass, validClass) {
		  $(element).addClass('is-invalid');
		},
		unhighlight: function (element, errorClass, validClass) {
		  $(element).removeClass('is-invalid');
		}
	});
	
	$('#fpwd').validate({
    rules: {
      opwd: {
        required: true
      },
      npwd: {
        required: true
      },
      rpwd: {
        required: true,
		equalTo: "#npwd" 
      },
    },
    messages: {
      opwd: {
        required: "Please enter your Old Password",
        email: "Please enter a vaild email address"
      },
      npwd: {
        required: "Please provide a new password",
        minlength: "Your password must be at least 5 characters long"
      },
      rpwd: {
		  required: "Please retype your new password",
		  equalTo: "Your new password is different with your retype password"
	  }
    }
	});

	if(menuc!='.') $(menuc).addClass("active");
	if(pmenuc!='.') $(pmenuc).addClass("menu-open");

}

function log(s){
	console.log(s);
}

function alrt(content,type='info',head='',){
	Swal.fire({icon: type, text: content, title: head});
}

function resetForm(frmid){
	$(frmid).trigger('reset');
	$(".is-invalid").removeClass("is-invalid");
	$(".is-valid").removeClass("is-valid");
}
function saveForm(frmid,url,overlay='',del=false,modal=''){
	if(del){
		Swal.fire({
		  text: 'Delete permanently?',
		  icon: 'question',
		  //showDenyButton: true,
		  showCancelButton: true,
		  confirmButtonText: 'Yes',
		  //denyButtonText: `Don't save`,
		}).then((result) => {
		  /* Read more about isConfirmed, isDenied below */
		  if (result.isConfirmed) {
			//Swal.fire('Saved!', '', 'success')
			sendDataFile(frmid,bu+url,overlay);
			if(modal!='') $(modal).modal('hide');
		  } else if (result.isDenied) {
			//Swal.fire('Changes are not saved', '', 'info')
		  }
		})
	}else{
		if($(frmid).valid()){
			//log("valid");
			if(overlay!='') $(overlay).show();
			
			sendDataFile(frmid,bu+url,overlay);
		}
	}
}
function sendDataFile(f,url,o){	
	
	var frmdata=new FormData($(f)[0]);
	
	//alert(frmdata);
	
	$.ajax({
		type: 'POST',
		url: url,
		data: frmdata,
		cache: false,
		contentType: false,
		processData: false,
		success: function(data){
			afterSend(f,o,data);
		},
		error: function(xhr){
			//log(xhr);
			afterSend(f,o,xhr.statusText);
		}
	});
	
}
function afterSend(frm,overlay='',data=''){
	if(typeof(sendDataCallback)=='function') {
		sendDataCallback(frm,overlay,data);
	}else{
		if(overlay!='') $(overlay).hide();
		try{
			var json = JSON.parse(data);
			alrt(json['msgs'],json['type']);
		}catch(e){
			alrt(data,'error');
			log(data);
		}
		if(typeof(reloadTable)=='function') reloadTable(frm);
	}
}

function openForm(frmid,modal,url,overlay='',id=0,t='',c=''){
	resetForm(frmid);
	$(modal).modal('show');
	$("#btndel").hide();
	if(id!=0){
		if(overlay!='') $(overlay).show();
		$.ajax({
			type: 'POST',
			url: bu+url,
			data: {t:t,id:id,c:c},
			success: function(data){
				$("#btndel").show();
				afterOpenForm(frmid,modal,overlay,data);
			},
			error: function(xhr){
				//log(xhr);
				alrt(xhr.statusText,'error');
				if(overlay!='') $(overlay).hide();
			}
		});
	}else{
		if(typeof(formLoaded)=='function'){
			formLoaded(frmid,modal,overlay);
		}
	}
}
function afterOpenForm(frm,modal,overlay='',data=''){
	if(typeof(openFormCallback)=='function') {
		openFormCallback(frm,modal,overlay,data);
	}else{
		if(overlay!='') $(overlay).hide();
		try{
			var json = JSON.parse(data);
			$.each(json['data'][0],function (key,val){
				$('#'+key).val(val);
			});
			if(typeof(formLoaded)=='function'){
				formLoaded(frm,modal,overlay,json['data'][0]);
			}
		}catch(e){
			alrt(data,'error');
			log(data);
		}
	}
}

function getCombo(u,t,c,w,tgt,dv='',blnk=''){
	var url=bu+u;
	var mtd='POST';
	var frmdata={t:t,c:c,w:w};
	
	//alert(frmdata);
	
	$.ajax({
		type: mtd,
		url: url,
		data: frmdata,
		success: function(data){
			var json=JSON.parse(data);
			//console.log(json);
			$(tgt).find('option').remove();
			var s='<option value="">'+blnk+'</option>';
			for(i=0;i<json['data'].length;i++){
				v="";t="";
				$.each(json['data'][i],function (key,val){
					if(key=='v'){v=val;}
					if(key=='t'){t=val;}
				});
				if(v==dv){
					s+='<option selected value="'+v+'">'+t+'</option>';
				}else{
					s+='<option value="'+v+'">'+t+'</option>';
				}
			}
			//log(s);
			$(tgt).append(s);
		},
		error: function(xhr){
			console.log("Error:"+xhr);
		}
	});
}
function initDatePicker(arr){
	for(var i=0;i<arr.length;i++){
		$(arr[i]).datetimepicker({
			format: 'YYYY-MM-DD'
		});
	}
}