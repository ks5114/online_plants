/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () { 

    $(".admin-box").delegate(".submit-filters", "click", function (e) {
        submitForm();
    });

    $(".admin-box").delegate(".search-field-dropdown", "change", function (e) {
        var rel = $(this).attr('rel');
        var value = $(this).val();
        $("input[rel_id=" + rel + "]").attr("name", 'search[' + value + ']');
    });

    $(".admin-box").delegate(".category-dropdown", "change", function (e) {
        $("#sortby").attr("value", "");
        $("#order").attr("value", "");
        submitForm();
    });

    $(".admin-box").delegate(".sort", "click", function (e) {
        var sortby = $(this).attr("for");
        var order = $(this).attr("rel");
        $("#sortby").attr("value", sortby);
        $("#order").attr("value", order);
        submitForm();
    });

    $(".admin-box").delegate(".search-dropdown", "change", function (e) {
        submitForm();
    });

    $(".admin-box").delegate(".pagination_link", "click", function (e) {
        var page = $(this).attr("data-page");
        paginationCall(page); 
    });
    

    $(".admin-box").delegate("#page", "focusout", function (e) {
        var page = $(this).attr("data-page");
        paginationCall(page);
    });

    $(".admin-box").delegate("#per_page", "change", function (e) { 
        $("#page").attr("data-page", 1);
        submitForm();
    });

    $(".admin-box").delegate(".delete-selected", "click", function(e) {
        var checkedBoxes = $('input[name="checked[]"]:checked').length;
        if (checkedBoxes > 0) {
            Swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $("#action").attr("value", "deleteSelected");
                    submitForm();

                    swal(
                        'Deleted!',
                        'Your record has been deleted.',
                        'success'
                    )
                }
            })
        } else {
            Swal({
                type: 'error',
                title: 'Oops...',
                text: 'No record selected. Please select record first.',
            })
        }
    });

    $(".admin-box").delegate(".soft_delete-selected", "click", function(e) {
        var checkedBoxes = $('input[name="checked[]"]:checked').length;
        if (checkedBoxes > 0) {
            Swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $("#action").attr("value", "soft_deleteSelected");
                    submitForm();

                    swal(
                        'Deleted!',
                        'Your record has been deleted.',
                        'success'
                    )
                }
            })
        } else {
            Swal({
                type: 'error',
                title: 'Oops...',
                text: 'No record selected. Please select record first.',
            })
        }
    });

    $(".admin-box").delegate(".delete", "click", function(e) {
        Swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {

                $("#action").attr("value", "delete");
                var data = $("#admin_listing_form").serializeArray();
                data.push({ name: "delete_id", value: $(this).attr("rel") });
                var url = $("#admin_listing_form").attr("action");
                ajax(url, data, setResponse);

                swal(
                    'Deleted!',
                    'Your record has been deleted.',
                    'success'
                )
            }
        })
    });

    $(".admin-box").delegate(".soft_delete", "click", function(e) {
        Swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $("#action").attr("value", "soft_delete");
                var data = $("#admin_listing_form").serializeArray();
                data.push({ name: "delete_id", value: $(this).attr("rel") });
                var url = $("#admin_listing_form").attr("action");
                ajax(url, data, setResponse);

                swal(
                    'Deleted!',
                    'Your record has been deleted.',
                    'success'
                )
            }
        })
    });

    $(".admin-box").delegate(".toggle_status", "click", function (e) {
        $("#action").attr("value", "toggleStatus");
        var data = $("#admin_listing_form").serializeArray();
        data.push({name: "id", value: $(this).attr("rel_id")});
        var url = $("#admin_listing_form").attr("action");
        ajax(url, data, setResponse);
    });

    $(".admin-box").delegate(".check-all", "click", function () {
        if ($(this).is(':checked')) {
            $('table input[type=checkbox]').prop('checked', true);
        } else {
            $('table input[type=checkbox]').prop('checked', false);
        }
    });

    $(".admin-box").delegate(".icon-chevron-down, .icon-chevron-up", "click", function (e) {
        $("#action").val('changePosition');
        var data = $("#admin_listing_form").serializeArray();
        var url = $("#admin_listing_form").attr("action");

        data.push({name: "state", value: $(this).attr("state")});
        data.push({name: "position", value: $(this).attr("position")});
        data.push({name: "id", value: $(this).attr("rel_id")});

        ajax(url, data, setResponse);
        $("#action").val('');
    });
    

    $(".admin-box").delegate(".reset-filters", "click", function () {
        $('.reset-input').val("");
        $('.reset-dropdown').find('option:first').attr('selected', 'selected');
        
    });

    $(".admin-box").delegate("input", "keypress", function (event) {
        if (event.which == 13) {
            event.preventDefault();
            submitForm();
        }
    });

    $(".admin-box").delegate('body [effect=tooltip]', 'mouseenter mouseleave', function (event) {
        if (event.type == 'mouseenter') {
            $(this).tooltip('show');
        } else {
            $(this).tooltip('hide');
        }
    });

    $('body [effect=tooltip]').tooltip();
});

function ajax(url, data, callback) { 
    hideTooltip();
    ajaxLoaderOverlay($(".admin-box"));
    $.ajax({
        url: url + "/" + $.now(),
        type: "POST",
        data: data,
        success: callback,
        complete: function(data) {
            $('.selectpicker').selectpicker('refresh');
            $('#ajax_loader').hide();
        }
    }).fail(function () {
        console.log('failed to retrieve data from server.');
    });
}

function setResponse(response) { 
    removeOverlay();
    $("#action").val('');
    $("#table_content").hide().html(response).fadeIn("slow");
    $('.search-field-dropdown').trigger('change');
    attachTooltip();
}

function paginationCall(page) {
    if (page > 0) {
        $("#page").attr("value", page);
        submitForm();
    }
}

function submitForm() {
    var data = $("#admin_listing_form").serializeArray();
    var url = $("#admin_listing_form").attr("action");
    ajax(url, data, setResponse);
}

function attachTooltip() {
    $('body [effect=tooltip]').tooltip();
}

function hideTooltip() {
    $('body [effect=tooltip]').tooltip('hide');
}

function ajaxLoaderOverlay(el) { 
    $("#ajax_loader").css('display','block');
//    $("#ajax_loader").addClass("ajax_loader");
    var height = el.height();
    var width = el.width();
    var position = el.position();
    position.left;
    position.top;
    var overlay = $('#ajax_loader').css({
        'transition': 'z-index 1s step-end, opacity .8s ease-in-out',
        'position': 'fixed',
        'top': '50%',
        'left': '50%',
        'z-index': 99,
    });
}

function removeOverlay() {
    $("#ajax_loader").removeAttr('style');
}
