$(document).ready(function(){
	$("#loginForm").submit(function(event){
		event.preventDefault();
	});
});

$(document).keypress(function (e) {
	if (e.which == 13) {
		if ($("#login_btn").attr("disabled") == false) {
			doLogin();
		}
	}
});

function doSubmit(n) {
	n.disabled = true;
	$.ajax({
		url:"_action_" + n.value + ".php",
		type: "POST",
		data: $("#"+n.value+"Form").serialize(),
		dataType: "json",
		success:function(result){
		  if (result.status=="success") {
					if (result.url) {
					  location.href = result.url;
					} else {
					  location.reload();
					}
		  } else {
					alert(result.msg);
		  }
		  n.disabled = false;
		},
		error:function(XMLHttpRequest, textStatus, errorThrown){
		  alert(txtStatus);
		  n.disabled = false;
		}
  });
}

