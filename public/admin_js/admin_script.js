$(document).ready(function () {
    $("#current_password").keyup(function () {
        var current_password = $(this).val();
        // alert(current_password);
        $.ajax({
            type: "POST",
            url: "/admin/check-current-pwd",
            data: {
                current_password: current_password,
            },
            success: function (resp) {
                // alert(resp);
                if (resp == "false") {
                    $("#chkpwd").html(
                        "<font color=red>Current Password is incorrect</font>"
                    );
                } else {
                    $("#chkpwd").html(
                        "<font color=green>Current Password is correct</font>"
                    );
                }
            },
            error: function () {
                alert("error");
            },
        });
    });
});
$(document).ready(function () {
    $(".inactive").click(function () {
        $(".active").prop("checked", false);
    });
    $(".active").click(function () {
        $(".inactive").prop("checked", false);
    });
});
var loadfile = function (event) {
    var output = document.getElementById("output");
    output.src = URL.createObjectURL(event.target.files[0]);
};
$(".updatesectionstatus").click(function () {
    var status = $(this).text();
    var section_id = $(this).attr("section_id");
    // alert(status);
    // alert(section_id);
    $.ajax({
        type: "POST",
        url: "/admin/update-section-status",
        data: {
            status: status,
            section_id: section_id,
        },
        success: function (resp) {
            // alert(resp['status']);
            if (resp["status"] == 1) {
                $("#section-" + section_id).html(
                    '<a class="updatesectionstatus text text-success">Active</a>'
                );
            } else {
                $("#section-" + section_id).html(
                    '<a class="updatesectionstatus text text-danger">Inactive</a>'
                );
            }
        },
        error: function () {
            alert("error");
        },
    });
});
$(".updatecategorystatus").click(function () {
    var status = $(this).text();
    var category_id = $(this).attr("category_id");
    // alert(status);
    // alert(category_id);
    $.ajax({
        type: "POST",
        url: "/admin/update-category-status",
        data: {
            status: status,
            category_id: category_id,
        },
        success: function (resp) {
            // alert(resp['status']);
            if (resp["status"] == 1) {
                $("#category-" + category_id).html(
                    '<a class="updatecategorystatus text text-success">Active</a>'
                );
            } else {
                $("#category-" + category_id).html(
                    '<a class="updatecategorystatus text text-danger">Inactive</a>'
                );
            }
        },
        error: function () {
            alert("error");
        },
    });
});
$(document).ready(function () {
    $("#category_section_id").change(function () {
        var section_id = $(this).val();
        $.ajax({
            type: "post",
            url: "/admin/append-category-categories-level",
            data: {
                section_id: section_id,
            },
            success: function (resp) {
                $("#appendcategorieslevel").html(resp);
            },
            error: function () {
                alert("Error");
            },
        });
    });
});
$(document).ready(function () {
    $("#product_section_id").change(function () {
        var section_id = $(this).val();
        $.ajax({
            type: "post",
            url: "/admin/append-product-categories-level",
            data: {
                section_id: section_id,
            },
            success: function (resp) {
                $("#appendproductslevel").html(resp);
            },
            error: function () {
                alert("Error");
            },
        });
    });
});
$(document).ready(function () {
    $(".confirmdelete").click(function () {
        var record = $(this).attr("record");
        var recordid = $(this).attr("recordid");
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href =
                    "/admin/delete-" + record + "/" + recordid;
            }
        });
    });
});
$(document).ready(function () {
    $(".updateproductstatus").click(function () {
        var status = $(this).text();
        var product_id = $(this).attr("product_id");
        // alert(status);
        $.ajax({
            type: "post",
            url: "/admin/update-product-status",
            data: {
                status: status,
                product_id: product_id,
            },
            success: function (resp) {
                if (resp["status"] == "Active") {
                    $("#product-" + product_id).html(
                        '<a class="updateproductstatus text text-danger">Inactive</a>'
                    );
                } else {
                    $("#product-" + product_id).html(
                        '<a class="updateproductstatus text text-success">Active</a>'
                    );
                }
            },
            error: function () {
                alert("Error");
            },
        });
    });
});
$(document).ready(function () {
    $(".updatecouponstatus").click(function () {
        // alert('hello');
        var status = $(this).text();
        var coupon_id = $(this).attr("coupon_id");
        // alert(status);
        $.ajax({
            type: "post",
            url: "/admin/update-coupon-status",
            data: {
                status: status,
                coupon_id: coupon_id,
            },
            success: function (resp) {
                if (resp["status"] == "Active") {
                    $("#coupon-" + coupon_id).html(
                        '<a class="updatecouponstatus text text-danger">Inactive</a>'
                    );
                } else {
                    $("#coupon-" + coupon_id).html(
                        '<a class="updatecouponstatus text text-success">Active</a>'
                    );
                }
            },
            error: function () {
                alert("Error");
            },
        });
    });
});
$(document).ready(function () {
    $(".updateproductimagestatus").click(function () {
        var status = $(this).text();
        var img_id = $(this).attr("img_id");
        // alert(status);
        $.ajax({
            type: "post",
            url: "/admin/update-product-image-status",
            data: {
                status: status,
                img_id: img_id,
            },
            success: function (resp) {
                if (resp["status"] == "Active") {
                    $("#img-" + img_id).html(
                        '<a class="updateproductstatus text text-danger">Inactive</a>'
                    );
                } else {
                    $("#img-" + img_id).html(
                        '<a class="updateproductstatus text text-success">Active</a>'
                    );
                }
            },
            error: function () {
                alert("Error");
            },
        });
    });
});
$(document).ready(function () {
    $(".add-attr").click(function () {
        // alert(id);
        $(".newRow").append(
            '<div class="row inputform">' +
                '<div class="col-md-2">' +
                '<div class="form-group">' +
                '<div class="form-group">' +
                '<label for="exampleInputEmail1">Size</label><br>' +
                '<select name="size[]" class="form-control" required>' +
                "<option>Small</option>" +
                "<option>Medium</option>" +
                "<option>Big</option>" +
                "</select>" +
                "</div>" +
                "</div>" +
                "</div>" +
                '<div class="col-md-2">' +
                '<div class="form-group">' +
                '<div class="form-group">' +
                '<label for="exampleInputEmail1">Price</label><br>' +
                '<input type="number" name="price[]" class="form-control" required>' +
                "</div>" +
                "</div>" +
                "</div>" +
                '<div class="col-md-2">' +
                '<div class="form-group">' +
                '<div class="form-group">' +
                '<label for="exampleInputEmail1">Stock</label><br>' +
                '<input type="number" name="stock[]" class="form-control" required>' +
                "</div>" +
                "</div>" +
                "</div>" +
                '<div class="col-md-2">' +
                '<div class="form-group">' +
                '<div class="form-group">' +
                '<label for="exampleInputEmail1">Sku</label><br>' +
                '<input type="text" name="sku[]" class="form-control" required>' +
                "</div>" +
                "</div>" +
                "</div>" +
                '<div class="col-md-4">' +
                '<div class="form-group">' +
                '<div class="form-group">' +
                '<a href="javascript:void(0)" class="delete-attr"><i class="fa fa-minus-circle" style="font-size: 30px; margin-top:35px"></i></a>' +
                "</div>" +
                "</div>" +
                "</div>"
        );
        $(".delete-attr").click(function () {
            $(this).closest(".inputform").remove();
        });
    });
});

$(document).ready(function () {
    $(".updateattributestatus").click(function () {
        var status = $(this).text();
        var attr_id = $(this).attr("attr_id");
        // alert(status);
        $.ajax({
            type: "post",
            url: "/admin/update-attribute-status",
            data: {
                status: status,
                attr_id: attr_id,
            },
            success: function (resp) {
                if (resp["status"] == "Active") {
                    $("#attr-" + attr_id).html(
                        '<a class="updateattributestatus text text-danger">Inactive</a>'
                    );
                } else {
                    $("#attr-" + attr_id).html(
                        '<a class="updateattributestatus text text-success">Active</a>'
                    );
                }
            },
            error: function () {
                alert("Error");
            },
        });
    });
});
$(document).ready(function () {
    $(".updatebrandstatus").click(function () {
        var status = $(this).text();
        var brand_id = $(this).attr("brand_id");
        // alert(status);
        $.ajax({
            type: "post",
            url: "/admin/update-brand-status",
            data: {
                status: status,
                brand_id: brand_id,
            },
            success: function (resp) {
                if (resp["status"] == "Active") {
                    $("#brand-" + brand_id).html(
                        '<a class="updatebrandstatus text text-danger">Inactive</a>'
                    );
                } else {
                    $("#brand-" + brand_id).html(
                        '<a class="updatebrandstatus text text-success">Active</a>'
                    );
                }
            },
            error: function () {
                alert("Error");
            },
        });
    });
});
$(document).ready(function () {
    $(".updatebannerstatus").click(function () {
        var status = $(this).text();
        var banner_id = $(this).attr("banner_id");
        // alert(status);
        $.ajax({
            type: "post",
            url: "/admin/update-banner-status",
            data: {
                status: status,
                banner_id: banner_id,
            },
            success: function (resp) {
                if (resp["status"] == "Active") {
                    $("#banner-" + banner_id).html(
                        '<a class="updatebannerstatus text text-danger">Inactive</a>'
                    );
                } else {
                    $("#banner-" + banner_id).html(
                        '<a class="updatebannerstatus text text-success">Active</a>'
                    );
                }
            },
            error: function () {
                alert("Error");
            },
        });
    });
});
$(document).ready(function () {
    $('.manual').click(function () {
        $('#coupon_code').show();
    });
    $('.automatic').click(function () {
        $('#coupon_code').hide();
    });
    $('#fixed').click(function () {
        $('#amount').html(

        '<div class="form-group">'+
            '<label for="recipient-name" class="col-form-label">Amount(VND):</label>'+
            '<input type="number" min="0" class="form-control" id="recipient-name" name="amount" required>'+
        '</div>'

        );
    });
    $('#percentage').click(function(e) {
        $('#amount').html(

            '<div class="form-group">'+
                '<label for="recipient-name" class="col-form-label">Amount(%):</label>'+
                '<input type="number" min="0" max="100" class="form-control" id="recipient-name" name="amount" required>'+
            '</div>'

            );
    });

});
