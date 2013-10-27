$(function(){

	/* -- ▽ヘッダーの友人アイコンホバーしたら＆押したらなんか出る --*/
	/*
	$("#header_friends").mouseenter(
		function () {
			$("#header_friends img").attr("src","img/header_icon_friends_on.png");
		}).mouseleave(function () {
			$("#header_friends img").attr("src","img/header_icon_friends.png");
	});
	*/

	/*
	$(".header_overlay").mouseenter(
		function () {
			$("#header_friends img").attr("src","img/header_icon_friends_on.png");
		}
	)
	*/

	/*
	$("#header_friends").click(function(){
		$(".header_overlay").show();
		$("#header_friends_box").fadeToggle("fast");
	})
	$(".header_overlay").click(function(){
		$("#header_friends_box").fadeToggle("fast");
		$(".header_overlay").hide();
		//$("#header_friends img").attr("src","img/header_icon_friends.png");
	})
	*/

	/* -- ▽followerの文字数に応じて位置を変える --*/
	var name_width = $('#follower_info').width();
	$("#follower_info").css("margin-left","-"+name_width/2+"px");


	/* -- ▽モーダルウィンドウ --*/
	$("#overlay").click(function(){
		$("#modal").fadeOut(300);
		$("#overlay").fadeOut(300);
		$(".modal_close").fadeOut(300);
	})
	$(".modal_close").click(function(){
		$("#modal").fadeOut(300);
		$("#overlay").fadeOut(300);
		$(".modal_close").fadeOut(300);
	})

	$(".post-modal").click(function(){
		$("#form-zone").css("display", "block");
		$("#layer").css("display", "block");
	})

	$("#layer").click(function(){
		$("#form-zone").css("display", "none");
		$("#layer").css("display", "none");
	})


	/*-----サムネイル処理-----*/

	var file = document.getElementById("FbPostPhotoPass");
	var sumbnail = document.getElementById("sumbnail");

	function isImage(file){
		return file.type.match("image.*") ? true : false;
	}

	function loadDataURL(file, callback){
		var reader = new FileReader();

		reader.onload = function(){
			callback(this.result);
		}

		reader.readAsDataURL(file);
	}

	function appendDataURLImage(elem, dataURL){
		var div = document.createElement("div");
		var img = document.createElement("img");
		img.setAttribute("src", dataURL);

		div.appendChild(img);
		elem.appendChild(div);
	}

	if(file !== null){
		file.onchange = function(){
			sumbnail.innerHTML = "";
			sumbnail.style.display = "block";

			var file = this.files[0]; //一枚だけに限定

			if(isImage(file)){
				loadDataURL(file, function(dataURL){
					appendDataURLImage(sumbnail, dataURL);
				});
			}
		}
	}


	/* -- ▽ドロップダウン --*/
	$("#user_info").mouseenter(function() {
		$("ul#user_list").show();
		$("#user_icon").animate({"opacity":"0.5"},50);
		//$("#triangle").attr("src","img/triangle_on.png");
		$("li#user_list1").animate({"margin-top": "10px"},100);
		$("li#user_list2").animate({"margin-top": "0px"},100);
		$("li#user_list3").animate({"margin-top": "0px"},100);
	});
	$("#user_info").mouseleave(function() {
		//$("#triangle").attr("src","img/triangle.png");
		$("#user_icon").animate({"opacity":"1.0"},50);
		$("li#user_list1").animate({"margin-top": "0px"},100);
		$("li#user_list2").animate({"margin-top": "-30px"},100);
		$("li#user_list3").animate({"margin-top": "-30px"},100);
		$("ul#user_list").hide("fast");
	});
	$("li#user_list1").mouseenter(function() {
		$("li#user_list1").css("background","#1B4F51");
	});
	$("li#user_list1").mouseleave(function() {
		$("li#user_list1").css("background","#009E9F");
	});
	$("li#user_list2").mouseenter(function() {
		$("li#user_list2").css("background","#1B4F51");
	});
	$("li#user_list2").mouseleave(function() {
		$("li#user_list2").css("background","#009E9F");
	});
	$("li#user_list3").mouseenter(function() {
		$("li#user_list3").css("background","#1B4F51");
	});
	$("li#user_list3").mouseleave(function() {
		$("li#user_list3").css("background","#009E9F");
	});
/* -- △ドロップダウン --*/
})

