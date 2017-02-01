if ($(window).width() > 767) {
    var left_side_width = $('.left-side').width();
    $("#brand").css("width", left_side_width - 1);
}
$(window).resize(function () {
    if ($(window).width() > 767) {
        var left_side_width = $('.left-side').width();
        $("#brand").css("width", left_side_width - 1);
    }
});
$(document).ready(function () {
    $(".h-settings").click(function () {
        $(".settings").toggle("slow", function () {
            $("i.fa.fa-cogs").addClass('fa-spin');
            if ($(".settings").is(':visible')) {
                $("i.fa.fa-cogs").addClass('fa-spin');
            } else {
                $("i.fa.fa-cogs").removeClass('fa-spin');
            }
        });
    });
});
function changePass() {
    var new_pass = $('[name="new_pass"]').val();
    if (jQuery.trim(new_pass).length > 3) {
        $.ajax({
            type: "POST",
            url: urls.changePass,
            data: {new_pass: new_pass}
        }).done(function (data) {
            if (data == '1') {
                $("#pass_result").fadeIn(500).delay(2000).fadeOut(500);
            } else {
                alert('Password cant change!');
            }
        });
    } else {
        alert('Too short pass!');
    }
}
$("#dev-zone").click(function () {
    $(".toggle-dev").slideToggle("slow");
});

$("a.confirm-delete").click(function (e) {
    e.preventDefault();
    var lHref = $(this).attr('href');
    bootbox.confirm({
        message: "Are you sure want to delete?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            if (result) {
                window.location.href = lHref;
            }
        }
    });
});
$("a.confirm-save").click(function (e) {
    e.preventDefault();
    var formId = $(this).data('form-id');
    bootbox.confirm({
        message: "Are you sure want to save?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            if (result) {
                document.getElementById(formId).submit();
            }
        }
    });
});
$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

// Password strenght starts here
$(document).ready(function () {
    //PassStrength 
    checkPass();
    $(".new-pass-field").on('keyup', function () {
        checkPass();
    });

    //PassGenerator
    $('.generate-pwd').pGenerator({
        'bind': 'click',
        'passwordLength': 9,
        'uppercase': true,
        'lowercase': true,
        'numbers': true,
        'specialChars': false,
        'onPasswordGenerated': function (generatedPassword) {
            $(".new-pass-field").val(generatedPassword);
            checkPass();
        }
    });
});

//Edit Categories
var indicEditCategorie;
var forIdEditCategorie;
var abbrEditCategorie;
$('.editCategorie').click(function () {
    indicEditCategorie = $(this).data('indic');
    forIdEditCategorie = $(this).data('for-id');
    abbrEditCategorie = $(this).data('abbr');
    var position = $(this).position();
    $('#categorieEditor').css({top: position.top, left: position.left, display: 'block'});
    $('#categorieEditor input').val($('#indic-' + indicEditCategorie).text());
});
$('.closeEditCategorie').click(function () {
    $('#categorieEditor').hide();
});
$('.saveEditCategorie').click(function () {
    $('#categorieEditor .noSaveEdit').hide();
    $('#categorieEditor .yesSaveEdit').css({display: 'inline-block'});
    var newValueFromEdit = $('[name="new_value"]').val();
    $.ajax({
        type: "POST",
        url: urls.editCategorie,
        data: {for_id: forIdEditCategorie, abbr: abbrEditCategorie, type: 'categorie', name: newValueFromEdit}
    }).done(function (data) {
        $('#categorieEditor .noSaveEdit').show();
        $('#categorieEditor .yesSaveEdit').hide();
        $('#categorieEditor').hide();
        $('#indic-' + indicEditCategorie).text(newValueFromEdit);
    });
});
$('.editCategorieSub').click(function () {
    var position = $(this).position();
    var subForId = $(this).data('sub-for-id');
    $('[name="editSubId"]').val(subForId);
    $('#categorieSubEdit').css({top: position.top, left: position.left, display: 'block'});
});
$('[name="newSubIs"]').change(function () {
    $('#categorieEditSubChanger').submit();
});

// Change nav status categories
$(function () {
    $('.changeNavVisibility').change(function () {
        var id = $(this).data('update-id');
        var changeTo;
        if ($(this).prop('checked') == true) {
            changeTo = 1;
        } else {
            changeTo = 0;
        }
        $.ajax({
            type: "POST",
            url: urls.changeNavVisibility,
            data: {nav: changeTo, id: id}
        }).done(function (data) {

        });
    });

    $('.showInNavOnAdd').change(function () {
        if ($(this).prop('checked') == true) {
            $('[name="nav"]').val('1');
        } else {
            $('[name="nav"]').val('0');
        }
    });
});

