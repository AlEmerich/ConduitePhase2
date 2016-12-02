$(function(){
    $('.event').on("dragstart", function (event) {
	var dt = event.originalEvent.dataTransfer;
	dt.setData('Text', $(this).attr('id'));
    });
    $('table td').on("dragenter dragover drop", function (event) {	
	event.preventDefault();
	if (event.type === 'drop') {
	    var data = event.originalEvent.dataTransfer.getData('Text',$(this).attr('id'));
	    de=$('#'+data).detach();
	    de.appendTo($(this));
	    $.post({
		type: "POST",
		url: "http://localhost:8000/php/movekanban.php",
		data:{
		    action:'refresh',which: data, target: $('#'+data).parent().attr('id')},
		success:function(html){
		    console.log(data);
		    var target = html;
		    de.attr("id",target);

		    de.parent().closest("tr").removeClass();
		    var state = target.split("_")[1];
		    var dev = target.split("_")[3];
		    
		    var array = ["", "danger", "success"];
		    de.parent().closest("tr").addClass(array[state]);
		    $("#devtask_"+target.split("_")[0]).html(dev);
		},
		error: function () {
		    alert('error on drag and drop kanban');
		}
		
	    });
	};
    });
});
