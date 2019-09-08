$.catalogAddGoodToCard = function(event,id) {

    var imgtodrag = $(event.target).parent().parent().parent().parent().find(".item-image");
    if (imgtodrag) {
        console.log(imgtodrag.css("background-image"));
        var imgclone = imgtodrag.clone()
            .offset({
                top: imgtodrag.offset().top,
                left: imgtodrag.offset().left
            })
            .css({
                'background-size': 'contain',
                'background-repeat': 'no-repeat',
                'background-position': 'center',
                'background-color': 'white',
                'background-image': imgtodrag.css("background-image"),
                'opacity': '0.8',
                'position': 'absolute',
                'height': '150px',
                'width': '150px',
                'z-index': '10000',
                'border':'solid 1px gray'
            })
            .appendTo($('body'))
            .animate({
                'top': $(".img-cart").offset().top + 10,
                'left': $(".img-cart").offset().left + 10,
                'width': 75,
                'height': 75
            },function () {
                imgclone.animate({
                    'width': 0,
                    'height': 0
                }, function () {
                    $(this).detach();
                });
            });
    }

    $.get("/ajax/?action=add-product&id="+id, function(data) {
        console.log(data);
        data = JSON.parse(data);
        if (data.result!="success") return;
        $.updateGoodViews(data.good.id,data.count);
    });
}

$.catalogRemoveGoodFromCard = function(id) {
    $.get("/ajax/?action=remove-product&id="+id, function(data) {
        console.log(data);
        data = JSON.parse(data);
        if (data.result!="success") return;
        $.updateGoodViews(data.good.id,data.count);
    });
}

$(document).ready(function () {
    $(".add-to-cart-action").on("click",function (event) {
        $.catalogAddGoodToCard(event, $(this).attr("data-id"));
    });

    $(".remove-from-cart-action").on("click",function () {
        $.catalogRemoveGoodFromCard($(this).attr("data-id"));
    });
});