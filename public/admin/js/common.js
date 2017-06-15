$(function() {
	$(".admin_tab li a").click(function() {
		var liindex = $(".admin_tab li a").index(this);
		$(this).addClass("active").parent().siblings().find("a").removeClass("active");
		$(".admin_tab_cont").eq(liindex).fadeIn(150).siblings(".admin_tab_cont").hide();
	});

})
function confirm_delete() {
	if (!confirm("确认要删除？")) {
		window.event.returnValue = false;
	}
					}
function selectall(name) {
	if ($("#check_box").prop('checked') == true) {
		$("input[name='" + name + "']").each(function() {
			$(this).prop('checked', true);

		});
	} else {
		$("input[name='" + name + "']").each(function() {
			$(this).removeAttr("checked");
		});
	}
}

function delete_attachment(e){
		var $this = $(e);
		$this.parent('span').remove();
	}