$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $("#sort").change(function () {
        this.form.submit();
    });
    $("#getPrice").change(function () {
        var size = $(this).val();
        var product_id = $(this).attr("product-id");
        if (size == "") {
            alert("Please select size");
            return;
        }
        $.ajax({
            url: "/get-product-price",
            type: "POST",
            data: {
                size: size,
                product_id: product_id,
            },
            success: function (resp) {
                if (resp["discounted_price"] > 0) {
                    $(".getAttrPrice").html(
                        "<del>Rs." +
                            resp["product_price"] +
                            "</del> " +
                            " " +
                            "Rs." +
                            resp["discounted_price"]
                    );
                } else {
                    $(".getAttrPrice").html("Rs." + resp["product_price"]);
                }
            },
            error: function () {
                alert("ERROR");
            },
        });
    });
    $(".btnItemUpdate").click(function () {
        if ($(this).hasClass("qtyMinus")) {
            var quantity = $(this).prev().val();
            if (quantity < 1) {
                alert("Item quantity must be 1 or greater");
                return false;
            } else {
                new_qty = parseInt(quantity) - 1;
                // alert(new_qty);
                // $('#appendedInputButtons').html(new_qty);
            }
        }
        if ($(this).hasClass("qtyPlus")) {
            var quantity = $(this).prev().prev().val();
            new_qty = parseInt(quantity) + 1;
            // $('#appendedInputButtons').html(new_qty);
        }
        // alert(new_qty);

        var cartid = $(this).data("cartid");
        // alert(cartid);
        $.ajax({
            type: "POST",
            url: "update-cart-item-qty",
            data: {
                cartid: cartid,
                new_qty: new_qty,
            },
            success: function (resp) {
                if (resp["status"] == false) {
                    alert(resp["message"]);
                }
                $("#AppendCartItems").html(resp["view"]);
            },
            error: function () {
                alert("ERROR");
            },
        });
    });
    $(".btnItemDelete").click(function () {
        var cartid = $(this).data("cartid");
        var result = confirm("Do you want delete Cart Item?");
        if (result) {
            $.ajax({
                type: "get",
                url: "delete-cart-item",
                data: {
                    cartid: cartid,
                },
                success: function (resp) {
                    $("#AppendCartItems").html(resp["view"]);
                },
                error: function () {
                    alert("ERROR");
                },
            });
        }
    });
    var dem = 0;
    $("#ApplyVoucher").submit(function () {
        var user = $(this).attr("user");
        // alert(user);
        if (user == 1) {
        } else {
            alert("Please login to apply coupon code");
            return false;
        }
        var code = $("#voucher_code").val();
        dem += 1;
        $.ajax({
            url: "/apply-coupon",
            type: "POST",
            data: {
                code: code,
                dem: dem,
            },
            success: function (resp) {
                if (resp["message"] != "" && resp["status"] == false) {
                    alert(resp["message"]);
                } else {
                    if (resp["itemcartqty"] == 0) {
                        alert("Your item cart quantity is empty");
                        return false;
                    } else {
                        $("#AppendCartItems").html(resp["view"]);
                        if (resp["couponAmount"] >= 0) {
                            $(".couponAmount").text(
                                "Rs." + resp["couponAmount"] + ".00"
                            );
                        } else {
                            $(".couponAmount").text("Rs." + 0 + ".00");
                        }
                        if (resp["grand_total"] >= 0) {
                            $(".grand_total").text(
                                "Rs." + resp["grand_total"] + ".00"
                            );
                        }
                    }
                }
            },
            error: function () {
                alert("ERROR");
            },
        });
    });
    $(".placeorder").click(function () {
        var result = confirm("Do you want order this items");
        if (result) {
            $.ajax({
                type: "post",
                url: "order",
                data: {},
                success: function (resp) {
                    if (resp["status"]) {
                        $(".success_message").html(
                            '<div class="alert alert-success" role="alert">' +
                                "<strong>Your order has been created successfully</strong>" +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                                '<span aria-hidden="true">&times;</span>' +
                                "</button>" +
                                "</div>"
                        );
                    }
                },
                error: function () {
                    alert("ERROR");
                },
            });
        }
    });
});
