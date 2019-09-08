
$(document).ready(function () {

    console.log(template);
    console.log(objects);

    objects.forEach(function (object) {
        $('#object-item').tmpl({"stemplate":template,"sobject":object}).appendTo('#object-table');
    })

    $(".image-file").hover(function(e) {
        $("#image-preview").css("display","block");
        $("#image-preview").css("top",e.pageY+10);
        $("#image-preview").css("left",e.pageX);
        $("#image-preview").css("background-image","url('"+$(this).attr("href")+"')");
    }, function(e) {
        $("#image-preview").css("display","none");
    });

    $(".object-item").hover(function(e) {
        var template = $(this).attr("data-template");
        var object = $(this).attr("data-object");
        $("#object-preview").css("display","block");
        $("#object-preview").css("top",e.pageY+10);
        $("#object-preview").css("left",e.pageX);
        $.get("/index.php", {"page":"ajax", "method":"getObjectById", "template":template,"object":object}, function(data) {
            data = JSON.parse(data);
            if (data.result=="ok") {
                data = data.data.data;
            }
            $("#object-table-preview").empty();
            for (var key in data) {
                console.log(key+" "+data[key]);
                $("#object-table-preview").append("<tr><td>"+key+"</td><td>"+data[key]+"</td></tr>");
            }

        });
    }, function(e) {
        $("#object-table-preview").empty();
        $("#object-preview").css("display","none");
    });

})