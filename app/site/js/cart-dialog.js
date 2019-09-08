$.updateGoodViews = function(id,count) {
    $(".good-count[data-id="+id+"]").html(count);
    console.log(count);
    if (count>0) {
        $(".add-to-cart[data-id=" + id + "]").hide();
        $(".add-remove-block[data-id=" + id + "]").show();
        $(".price-counter[data-id=" + id + "]").show();
        $(".item-count[data-id=" + id + "]").text(count);
        $(".price-block > .cart[data-id=" + id + "]").show();
        $(".name-good[data-id=" + id + "]").removeClass("removed-item");
    } else {
        $(".add-to-cart[data-id=" + id + "]").show();
        $(".add-remove-block[data-id=" + id + "]").hide();
        $(".price-counter[data-id=" + id + "]").hide();
        $(".price-block > .cart[data-id=" + id + "]").hide();
        $(".name-good[data-id=" + id + "]").addClass("removed-item");
    }

    $.get("/ajax/?action=count-product-in-cart",function (data) {
        data = JSON.parse(data);
        if (data.result=="success") {
            if (data.count>0) {
                $("#cart-counter").show().text(data.count);
            } else {
                $("#cart-counter").hide().text(data.count);
            }
            $(".summ-count").text(data.summ);
        }
    });
}

$.addGoodToCard = function(id) {
    $.get("/ajax/?action=add-product&id="+id, function(data) {
        data = JSON.parse(data);
        if (data.result!="success") return;
        $.updateGoodViews(data.good.id,data.count);
    });
}

$.removeGoodFromCard = function(id) {
    $.get("/ajax/?action=remove-product&id="+id, function(data) {
        console.log(data);
        data = JSON.parse(data);
        if (data.result!="success") return;
        $.updateGoodViews(data.good.id,data.count);
    });
}

$.deleteGoodFromCard = function(id) {
    $.get("/ajax/?action=remove-product&id="+id, function(data) {
        data = JSON.parse(data);
        if (data.result!="success") return;
        $.updateGoodViews(data.good.id,data.count);
    });
}

$(document).ready(function () {
    $(".dialog-show-action").click(function (e) {
        e.preventDefault();
        $.get("/ajax/?action=cart-list", function(data) {
            $("#dialog-body #dialog-wrap .items").html(data);
            $("#cart-dialog").show(0);
        });
    });

    $(".dialog-close-action").click(function (e) {
        e.preventDefault();
        $("#cart-dialog").hide(0);
    });

    $("body").on("click",".cart-dialog-add-action",function () {
        console.log($(this));
        $.addGoodToCard($(this).attr("data-id"));
    });

    $("body").on("click",".cart-dialog-remove-action",function () {
        console.log($(this));
        $.deleteGoodFromCard($(this).attr("data-id"));
    });

    $("body").on("click",".cart-dialog-delete-action",function () {
        console.log($(this));
        $.deleteGoodFromCard($(this).attr("data-id"));
    });

});