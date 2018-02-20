/* GG Comments
1. #main - Add Layout Options
2. Style Skin Selection
*/
$("#main").append('<div class="demo"><span id="demo-setting"><i class="fa fa-cogs fa-spin txt-color-blueDark"></i></span> 
	<form><legend class="no-padding margin-bottom-10">Layout Options</legend><section>
	<label><input name="subscription" id="smart-fixed-header" type="checkbox" class="checkbox style-0"><span>Fixed Header</span></label>
	<label><input type="checkbox" name="terms" id="smart-fixed-navigation" class="checkbox style-0"><span>Fixed Navigation</span></label>
	<label><input type="checkbox" name="terms" id="smart-fixed-ribbon" class="checkbox style-0"><span>Fixed Ribbon</span></label>
	<label><input type="checkbox" name="terms" id="smart-fixed-footer" class="checkbox style-0"><span>Fixed Footer</span></label>
	<label><input type="checkbox" name="terms" id="smart-fixed-container" class="checkbox style-0"><span>Inside <b>.container</b></span></label>
	<label style="display:block;"><input type="checkbox" name="terms" id="smart-rtl" class="checkbox style-0"><span>RTL Support</span></label>
	<label style="display:block;"><input type="checkbox" id="smart-topmenu" class="checkbox style-0"><span>Menu on <b>top</b></span></label> 
	<label style="display:block;"><input type="checkbox" id="colorblind-friendly" class="checkbox style-0"><span>For Colorblind <div class="font-xs text-right">(experimental)</div></span></label><span id="smart-bgimages"></span></section>
	<section><h6 class="margin-top-10 semi-bold margin-bottom-5">Clear Localstorage</h6><a href="javascript:void(0);" class="btn btn-xs btn-block btn-primary" id="reset-smart-widget"><i class="fa fa-refresh"></i> Factory Reset</a></section> 
	<h6 class="margin-top-10 semi-bold margin-bottom-5">SmartAdmin Skins</h6>
	<section id="smart-styles">
	<a href="javascript:void(0);" id="smart-style-0" data-skinlogo="img/logo.png" class="btn btn-xs txt-color-white margin-right-5" style="background-color:#4E463F;"><i class="fa fa-check fa-fw" id="skin-checked"></i>S0</a>
	<a href="javascript:void(0);" id="smart-style-1" data-skinlogo="img/logo-white.png" class="btn btn-xs txt-color-white" style="background:#3A4558;">S1</a> 
	<a href="javascript:void(0);" id="smart-style-2" data-skinlogo="img/logo-blue.png" class="btn btn-xs txt-color-darken margin-top-5" style="background:#fff;">S2</a> 
	<a href="javascript:void(0);" id="smart-style-3" data-skinlogo="img/logo-pale.png" class="btn btn-xs txt-color-white margin-top-5" style="background:#f78c40">S3</a> 
	<a href="javascript:void(0);" id="smart-style-4" data-skinlogo="img/logo-pale.png" class="btn btn-xs txt-color-white margin-top-5" style="background: #bbc0cf; border: 1px solid #59779E; color: #17273D !important;">S4</a> 
	<a href="javascript:void(0);" id="smart-style-5" data-skinlogo="img/logo-pale.png" class="btn btn-xs txt-color-white margin-top-5" style="background: rgba(153, 179, 204, 0.2); border: 1px solid rgba(121, 161, 221, 0.8); color: #17273D !important;">S5</a> 
	<a href="javascript:void(0);" id="smart-style-6" data-skinlogo="img/logo-pale.png" class="btn btn-xs txt-color-white margin-top-5" style="background: #2196F3; border: 1px solid rgba(0, 0, 0, 0.3); color: #FFF !important;">S6</a> 
	<br><hr>
	<a href="javascript:void(0);" id="smart-style-11" data-skinlogo="img/logo-pale.png" class="btn btn-xs txt-color-white margin-top-5" style="background: #2196F3; border: 1px solid rgba(0, 0, 0, 0.3); color: #FFF !important;">S11</a> 
	<a href="javascript:void(0);" id="smart-style-12" data-skinlogo="img/logo-pale.png" class="btn btn-xs txt-color-white margin-top-5" style="background: #2196F3; border: 1px solid rgba(0, 0, 0, 0.3); color: #FFF !important;">S12</a> 
	<a href="javascript:void(0);" id="smart-style-13" data-skinlogo="img/logo-pale.png" class="btn btn-xs txt-color-white margin-top-5" style="background: #2196F3; border: 1px solid rgba(0, 0, 0, 0.3); color: #FFF !important;">S13</a> 
	</section></form> </div>');

/*  2. Smart bg images for inside .container */
var smartbgimage = "<h6 class='margin-top-10 semi-bold'>Background</h6><img src='img/pattern/graphy-xs.png' data-htmlbg-url='img/pattern/graphy.png' width='22' height='22' class='margin-right-5 bordered cursor-pointer'><img src='img/pattern/tileable_wood_texture-xs.png' width='22' height='22' data-htmlbg-url='img/pattern/tileable_wood_texture.png' class='margin-right-5 bordered cursor-pointer'><img src='img/pattern/sneaker_mesh_fabric-xs.png' width='22' height='22' data-htmlbg-url='img/pattern/sneaker_mesh_fabric.png' class='margin-right-5 bordered cursor-pointer'><img src='img/pattern/nistri-xs.png' data-htmlbg-url='img/pattern/nistri.png' width='22' height='22' class='margin-right-5 bordered cursor-pointer'><img src='img/pattern/paper-xs.png' data-htmlbg-url='img/pattern/paper.png' width='22' height='22' class='bordered cursor-pointer'>";
$("#smart-bgimages").fadeOut(),
/*  3. Toggle demo window */
$("#demo-setting").click(function() {
    $(".demo").toggleClass("activate")
}),
/* 4 Fixed Header (no header = no nav, no ribbon) */
$('input[type="checkbox"]#smart-fixed-header').click(function() {
    $(this).is(":checked") ? $.root_.addClass("fixed-header") : ($('input[type="checkbox"]#smart-fixed-ribbon').prop("checked", !1),
        $('input[type="checkbox"]#smart-fixed-navigation').prop("checked", !1), 
        $.root_.removeClass("fixed-header"), 
        $.root_.removeClass("fixed-navigation"), 
        $.root_.removeClass("fixed-ribbon"))
}), 
/* 5 Fixed navigation (Need fixed header, fixed container. no nav = no ribbon */
$('input[type="checkbox"]#smart-fixed-navigation').click(function() { 
		$(this).is(":checked") ? ($('input[type="checkbox"]#smart-fixed-header').prop("checked", !0), 
			$.root_.addClass("fixed-header"), $.root_.addClass("fixed-navigation"), 
			$('input[type="checkbox"]#smart-fixed-container').prop("checked", !1), 
			$.root_.removeClass("container")) : ($('input[type="checkbox"]#smart-fixed-ribbon').prop("checked", !1), 
			$.root_.removeClass("fixed-navigation"), 
			$.root_.removeClass("fixed-ribbon")) 
}),
/* 6 Fixed ribbon = header, nav, ribbon & no container */ 
$('input[type="checkbox"]#smart-fixed-ribbon').click(function() { 
	$(this).is(":checked") ? ($('input[type="checkbox"]#smart-fixed-header').prop("checked", !0), 
		$('input[type="checkbox"]#smart-fixed-navigation').prop("checked", !0), 
		$('input[type="checkbox"]#smart-fixed-ribbon').prop("checked", !0), 
		$.root_.addClass("fixed-header"), 
		$.root_.addClass("fixed-navigation"), 
		$.root_.addClass("fixed-ribbon"), 
		$('input[type="checkbox"]#smart-fixed-container').prop("checked", !1), 
		$.root_.removeClass("container")) : $.root_.removeClass("fixed-ribbon") 
}), 
/* 7 Fixed Footer (stand alone */
$('input[type="checkbox"]#smart-fixed-footer').click(function() { 
	$(this).is(":checked") ? $.root_.addClass("fixed-page-footer") : $.root_.removeClass("fixed-page-footer") 
}), 
/* 8 rtl */
$('input[type="checkbox"]#smart-rtl').click(function() { 
	$(this).is(":checked") ? $.root_.addClass("smart-rtl") : $.root_.removeClass("smart-rtl") 
}), 
/* 9 Top menu = menu left or top toggle */
$("#smart-topmenu").on("change", function(a) { 
	$(this).prop("checked") ? (localStorage.setItem("sm-setmenu", "top"), location.reload()) : (localStorage.setItem("sm-setmenu", "left"), location.reload()) 
}), 
"top" == localStorage.getItem("sm-setmenu") ? $("#smart-topmenu").prop("checked", !0) : $("#smart-topmenu").prop("checked", !1),
/* 10 Color blind friendly */
$('input[type="checkbox"]#colorblind-friendly').click(function() { 
	$(this).is(":checked") ? $.root_.addClass("colorblind-friendly") : $.root_.removeClass("colorblind-friendly") 
}), 
/* 11 Fixed container (ribbon & nav off) */
$('input[type="checkbox"]#smart-fixed-container').click(function() {
	$(this).is(":checked") ? ($.root_.addClass("container"), 
	$('input[type="checkbox"]#smart-fixed-ribbon').prop("checked", !1), 
	$.root_.removeClass("fixed-ribbon"),
  $('input[type="checkbox"]#smart-fixed-navigation').prop("checked", !1),
  $.root_.removeClass("fixed-navigation"),
  smartbgimage ? ($("#smart-bgimages").append(smartbgimage).fadeIn(1e3),
  $("#smart-bgimages img").bind("click", function() {
      var a = $(this),
          b = $("html");
      bgurl = a.data("htmlbg-url"), b.css("background-image", "url(" + bgurl + ")")
  }), smartbgimage = null) : $("#smart-bgimages").fadeIn(1e3)) : ($.root_.removeClass("container"), $("#smart-bgimages").fadeOut())
}), 
/* 12 Reset storage */
$("#reset-smart-widget").bind("click", function() { 
	return $("#refresh").click(), !1 
}), 
/* 13 Style Activation */
$("#smart-styles > a").on("click", function() {
    var a = $(this),
        b = $("#logo img");
    $.root_.removeClassPrefix("smart-style").addClass(a.attr("id")), 
    $("html").removeClassPrefix("smart-style").addClass(a.attr("id")), b.attr("src", a.data("skinlogo")), 
    $("#smart-styles > a #skin-checked").remove(), 
    a.prepend("<i class='fa fa-check fa-fw' id='skin-checked'></i>")
});