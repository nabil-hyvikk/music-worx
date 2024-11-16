/*Search admin users***************************/
$("#searchadmin").click(function () {
	$("#adminuser_form").trigger('submit');
});

$("#adminuser_form").submit(function (event) {
	var search_val = $("#adminuser_form").serialize();
	if ($("#search_adminuser").val() == "") {
		$("#error_msg").html("Please enter somthing for Search");
		//alert("Please enter somthing for Search");
	}
	else {
		$("#error_msg").html('');
		var curl = $("#adminuser_path").val();
		console.log(curl);
		$.ajax({
			url: curl,
			type: "POST",
			data: search_val,
			dataType: "html",
			success: function (data) {
				//$("#tbl_pending_repair").remove();
				$("#adminuser_table").html(data);
				$('#overlay_cloud').hide();

			},
			error: function (error) {
				alert(error);
			}
		});

	}
	event.preventDefault();
});

/*Search all NL***************************/

$("#filterNL").change(function () {
	$("#NL_form").trigger('submit');
});
$("#promo_filter").change(function () {
	$("#NL_form").trigger('submit');
});


/*Search all users***************************/

$("#usertype").change(function () {
	$("#alluser_form").trigger('submit');
});

$("#generic").change(function () {
	$("#alluser_form").trigger('submit');
});

/*
$("#seach_all_user").click(function(){
	$("#alluser_form").trigger('submit');
});



$("#alluser_form").submit(function(event){	
var search_val=$("#alluser_form").serialize();

if($("#all_user_stext").val()=="")
{
	$("#error_msg").html("Please enter somthing for Search");
	//alert("Please enter somthing for Search");
}

$("#error_msg").html('');
 var curl = $("#adminuser_path").val();
 console.log(curl);
	$.ajax({
		url:curl,
		type:"POST",
		data:search_val,
		dataType:"html",
		success:function(data)
		{
			//$("#tbl_pending_repair").remove();
			$("#alluser_table").html(data);
			
		},
		error:function (error) {
			alert(error);
		}	
	});	 

event.preventDefault();
});*/

/*Search TopDJ***************************/
$("#searchtopdj").click(function () {
	$("#topdj_form").trigger('submit');
});

$("#topdj_form").submit(function (event) {
	var search_val = $("#topdj_form").serialize();
	if ($("#search_adminuser").val() == "") {
		$("#error_msg").html("Please enter somthing for Search");
		//alert("Please enter somthing for Search");
	}
	else {
		$("#error_msg").html('');
		var curl = $("#topdj_path").val();
		console.log(curl);
		$.ajax({
			url: curl,
			type: "POST",
			data: search_val,
			dataType: "html",
			success: function (data) {
				//$("#tbl_pending_repair").remove();
				$("#topdj_table").html(data);
				$('#overlay_cloud').hide();

			},
			error: function (error) {
				alert(error);
			}
		});

	}
	event.preventDefault();
});

/*Search weekly news***************************/
$("#searchwnews").click(function () {
	$("#wnews_form").trigger('submit');
});

$("#wnews_form").submit(function (event) {
	var search_val = $("#wnews_form").serialize();
	if ($("#search_wnews").val() == "") {
		$("#error_msg").html("Please enter somthing for Search");
		//alert("Please enter somthing for Search");
	}


	$("#error_msg").html('');
	var curl = $("#wnews_path").val();
	console.log(curl);
	$.ajax({
		url: curl,
		type: "POST",
		data: search_val,
		dataType: "html",
		success: function (data) {
			//$("#tbl_pending_repair").remove();
			$("#wnews_table").html(data);
			$('#overlay_cloud').hide();

		},
		error: function (error) {
			alert(error);
		}
	});


	event.preventDefault();
});

/*Search Release***************************/
$("#searchrel").click(function () {
	$("#release_form").trigger('submit');
});
$("#searchplaylist").click(function () {
	$("#playlists_form").trigger('submit');
});
$("#release_form select").change(function () {
	$("#release_form").trigger('submit');
});

/*$("#release_form").submit(function(event){	
var search_val=$("#release_form").serialize();
if($("#search_word").val()=="")
{
	$("#error_msg").html("Please enter somthing for Search");
	//alert("Please enter somthing for Search");
}


$("#error_msg").html('');
 var curl = $("#release_path").val();
 console.log(curl);
	$.ajax({
		url:curl,
		type:"POST",
		data:search_val,
		dataType:"html",
		success:function(data)
		{
			//$("#tbl_pending_repair").remove();
			$("#release_table").html(data);
			
		},
		error:function (error) {
			alert(error);
		}	
	});
	 

event.preventDefault();
});*/

/*Search chart Release***************************/
$("#searchrel_chart").click(function () {
	$("#chart_release_form").trigger('submit');
});

// $("#chart_release_form").submit(function(event){	
// 	var search_val=$("#chart_release_form").serialize();
// 	if($("#search_word").val()==""){
// 		$("#error_msg").html("Please enter somthing for Search");
// 		//alert("Please enter somthing for Search");
// 	}

// 	$("#error_msg").html('');
// 	var curl = $("#release_path").val();
// 	console.log(curl);
// 	$.ajax({
// 		url:curl,
// 		type:"POST",
// 		data:search_val,
// 		dataType:"html",
// 		success:function(data){
// 			//$("#tbl_pending_repair").remove();
// 			$("#vote_release_table").html(data);		
// 		},
// 		error:function (error) {}	
// 	});

// 	event.preventDefault();
// });

/*Search Membership Package***************************/
$("#searchpackage").click(function () {
	$("#mempackage_form").trigger('submit');
});

$("#mempackage_form").submit(function (event) {
	var search_val = $("#mempackage_form").serialize();
	if ($("#search_word").val() == "") {
		$("#error_msg").html("Please enter somthing for Search");
		//alert("Please enter somthing for Search");
	}


	$("#error_msg").html('');
	var curl = $("#package_path").val();
	console.log(curl);
	$.ajax({
		url: curl,
		type: "POST",
		data: search_val,
		dataType: "html",
		success: function (data) {
			//$("#tbl_pending_repair").remove();
			$("#package_table").html(data);
			$('#overlay_cloud').hide();

		},
		error: function (error) {
			alert(error);
		}
	});


	event.preventDefault();
});

/*Search banner promotion***************************/
$("#searchbanner").click(function () {
	$("#banner_form").trigger('submit');
});

$("#banner_form").submit(function (event) {
	var search_val = $("#banner_form").serialize();
	if ($("#search_word").val() == "") {
		$("#error_msg").html("Please enter somthing for Search");
		//alert("Please enter somthing for Search");
	}


	$("#error_msg").html('');
	var curl = $("#banner_path").val();
	console.log(curl);
	$.ajax({
		url: curl,
		type: "POST",
		data: search_val,
		dataType: "html",
		success: function (data) {
			//$("#tbl_pending_repair").remove();
			$("#search_banners").html(data);
			$('#overlay_cloud').hide();

		},
		error: function (error) {
			alert(error);
		}
	});


	event.preventDefault();
});

/*Search Custom newslatter***************************/
$("#searchcnl").click(function () {
	$("#cnl_form").trigger('submit');
});

$("#cnl_form").submit(function (event) {
	var search_val = $("#cnl_form").serialize();
	if ($("#search_cnl").val() == "") {
		$("#error_msg").html("Please enter somthing for Search");
		//alert("Please enter somthing for Search");
	}


	$("#error_msg").html('');
	var curl = $("#cnl_serch_path").val();
	console.log(curl);
	$.ajax({
		url: curl,
		type: "POST",
		data: search_val,
		dataType: "html",
		success: function (data) {
			//$("#tbl_pending_repair").remove();
			$("#cnl_content").html(data);
			$('#overlay_cloud').hide();

		},
		error: function (error) {
			alert(error);
		}
	});


	event.preventDefault();
});