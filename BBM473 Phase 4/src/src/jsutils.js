function loginForm() {
    $('#login-form').on('submit', function () {
        var that = $(this),
            url = that.attr('action'),
            method = that.attr('method'),
            data = {};

        that.find('[name]').each(function (index, value) {
            var that = $(this),
                name = that.attr('name'),
                val = that.val();

            data[name] = val;
        });

        $.ajax({
            url: url,
            type: method,
            data: data,
            success: function (response) {
                if (response === 'login:success') {
                    document.location.href = "main.php";
                } else if (response === 'login:error1') {
                    $("#error-message").text("Username and password cannot be empty");
                    $("#login-error").show();
                } else if (response === 'login:error2') {
                    $("#error-message").text("Username and password are incorrect");
                    $("#login-error").show();
                } else {
                    $("#error-message").html(response);
                    $("#login-error").show();
                }
            }
        });

        return false;
    });
}


$(document).ready(function () {
    $("#create-account").click(function () {
        $("#personal-info-form").submit();
    });
});


$('#personal-info-form').submit(function () {
    var action = $(this).attr('action');
    $.ajax({
        url: action,
        type: 'POST',
        data: $('#personal-info-form, #shipping-info-form').serialize(),
        success: function (response) {
            alert(response);
        }
    });
    return false;
});


function createAccountModal() {
    $('.ui.modal')
        .modal('show')
    ;
}


function hideErrorMessage() {
    $("#login-error").hide();
}

function showBookContent(id, actions) {
    $.ajax({
        url: 'templates/bookTemplate.php',
        type: 'POST',
        data: {book_id: id, actions: actions},
        success: function (response) {
            var bookContent = $('#modal-content');
            $('body .modals').remove();
            bookContent.append(response);
            $('.ui.modal')
                .modal('show')
            ;
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('bohac');
        }
    });

}


function showAuthorContent(id) {
    $.ajax({
        url: 'templates/authorTemplate.php',
        type: 'POST',
        data: {author_id: id},
        success: function (response) {
            var bookContent = $('#modal-content');
            $('body .modals').remove();
            bookContent.append(response);
            $('.ui.modal')
                .modal('show')
            ;
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('bohac');
        }
    });
}


$(document).ready(function () {
    $('.ui.cards').slick({
        slidesToShow: 4,
        infinite: true,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        variableWidth: true,
        arrows: true
    });
});


function userAddEbookModal(id) {
    $.ajax({
        url: 'templates/userAddFileTemplate.php',
        type: 'POST',
        data: {book_id: id, mode: 'ebook'},
        success: function (response) {
            var modal = $('.ui.modal');
            modal.empty();
            modal.html(response);
            $('.ui.dropdown').dropdown();

            $('.ui.dropdown .remove.icon').on('click', function (e) {
                $(this).parent('.dropdown').dropdown('clear');
                console.log('clear');
                e.stopPropagation();
            });
        }
    });
}

function userAddAudiobookModal(id) {
    $.ajax({
        url: 'templates/userAddFileTemplate.php',
        type: 'POST',
        data: {book_id: id, mode: 'audiobook'},
        success: function (response) {
            var modal = $('.ui.modal');
            modal.empty();
            modal.html(response);
            $('.ui.dropdown').dropdown();

            $('.ui.dropdown .remove.icon').on('click', function (e) {
                $(this).parent('.dropdown').dropdown('clear');
                console.log('clear');
                e.stopPropagation();
            });
        }
    });
}

function userAddFile(type) {
    var table = $("#add-file-table");

    data = [];
    table.find('tr').each(function () {
        var cell = $(this).find('td.book-add-cell')[0];
        if (cell !== undefined) {
            var dropdown = $(cell).find('.dropdown');
            var shelf = dropdown.dropdown('get value')[0];
            var ebook = $($(cell).find('.file-id')[0]).val();
            if (shelf !== '') {
                data.push({file: ebook, shelf: shelf});
            }
        }
    });


    $.ajax({
        url: 'userAddFile.php',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({data: data, type: type}),
        success: function (response) {
            if (response.length === 0) {
                alertify.error('Please select ' + type + 's you want to add');
            } else {
                response.forEach(function (entry) {
                    if (entry['res'] === true)
                        alertify.success(entry['text']);
                    else
                        alertify.error(entry['text']);
                });
                $('.ui.modal')
                    .modal('hide')
                ;
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

}

$(document).ready(function () {
    $('#filter-button').on('click', function () {
        var category = [];
        var author = [];
        var publisher = [];
        var container = $('#filter-container');
        container.find('.ui.checkbox').each(function () {
            var checked = $(this).find('input').is(':checked');
            if (checked === true) {
                var div_id = $(this).attr('id');
                var type = div_id.split('-')[0];
                var id = div_id.split('-')[1];
                if (type === 'category')
                    category.push(id);
                else if (type === 'author')
                    author.push(id);
                else if (type === 'publisher')
                    publisher.push(id);
            }
        });

        var param = "category=" + category.join() + "&" + "author=" + author.join() + "&" + "publisher=" + publisher.join();
        document.location.href = "filter.php?" + param;

    });
});


$(document).ready(function () {
    $('.ui.dropdown')
        .dropdown()
    ;
});

$(document).ready(function () {
    $('.ui.accordion').accordion();
});


// ben ekledim!!!
$(document).ready(function () {
    $('#user-library').slick({
        slidesToShow: 3,
        infinite: true,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        variableWidth: true,
        arrows: true
    });
});

/*
 $(document).ready(function () {
 $('#user-shelf').slick({
 slidesToShow: 3,
 infinite: true,
 slidesToScroll: 1,
 autoplay: true,
 autoplaySpeed: 2000,
 variableWidth: true,
 arrows: true
 });
 });
 */
/*
 // ben ekledim!!!
 $(document).ready(function () {
 $('#user-shelf-info').slick({
 slidesToShow: 3,
 infinite: true,
 slidesToScroll: 1,
 autoplay: true,
 autoplaySpeed: 2000,
 variableWidth: true,
 arrows: true
 });
 });
 */

//$('#user-shelf-id').dropdown();

function getSelectedTextValue() {
    var shelf_id = $('.ui.dropdown').dropdown('get value');
    $.ajax({
        url: 'shelfContent.php',
        type: 'POST',
        data: {shelf: shelf_id},
        success: function (response) {
            var cards = $('#user-shelf');
            cards.empty();
            if (cards.hasClass('slick-initialized')) {
                cards.slick("unslick");
            }
            cards.html(response);
            cards.slick({
                slidesToShow: 3,
                infinite: true,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
                variableWidth: true,
                arrows: true
            });
        }
    });
}


/*
 var shelf_name = $('#user-shelf-id')
 .dropdown('get text');

 document.write("docu.wri");
 document.write("2    ");
 document.write(shelf_name);
 $.post('userProfile.php', {varvar: shelf_name});
 */

$(document).ready(function () {
    $('#logout-button').on('click', function () {
        $.ajax({
            url: 'logout.php',
            type: 'POST',
            success: function (response) {
                if (response === "1")
                    window.location.href = "index.php";
            }
        });
    });
});


$(document).ready(function () {
    $('.menu .ui.dropdown')
        .dropdown({
            on: 'hover'
        })
    ;
});


$('#library-page-content').ready(function () {
    libraryContent(-1);
});


$(document).ready(function () {
    $('#library-menu').on('click', function () {
        libraryContent(-1);
    });
});

$(document).ready(function () {
    $('#shelves-menu').bind('click', function (event) {
        var shelfid = event.target.id.split('-')[2];
        if (shelfid != null)
            libraryContent(shelfid);
        else
            listShelves();
    });
});

function libraryContent(shelfid) {
    $.ajax({
        url: 'templates/libraryTemplate.php',
        type: 'POST',
        data: {id: shelfid},
        success: function (response) {
            $('#library-page-content').html(JSON.parse(response)['content']);
            $('.demo.menu .item').tab({history: false});

            $('#user-library-title').html('<div class="black big ui label"><i class="book icon"></i>' + JSON.parse(response)['title'] + '</div>');
        }
    });
}

function userRemoveFile() {
    var dom_object = event.target;
    var divid = dom_object.id === "" ? dom_object.parentElement.id : dom_object.id;
    var temp = divid.split('-');
    var fileid = temp[1];
    var shelfid = temp.length === 4 ? temp[3] : -1;

    alertify.dialog('confirm').set({
            transition: 'fade',
            title: 'Remove book',
            message: 'Are you sure to remove this book?',
            labels: {ok: 'Remove', cancel: 'Cancel'},
            resizable: true,
            onok: function (closeEvent) {
                $.ajax({
                    url: 'userDeleteFile.php',
                    type: 'POST',
                    data: {fileid: fileid, shelfid: shelfid},
                    success: function (response) {
                        if (response.split('-')[0] === '0') {
                            alertify.error(response.split('-')[1]);
                        } else {
                            alertify.success(response.split('-')[1]);
                            findParentClass(dom_object, "item").remove();
                        }
                    }
                });
            }
        }
    ).resizeTo('100', '200').show();
}

function findParentClass(dom_object, class_name) {
    if (dom_object.className === class_name) {
        return dom_object;
    }
    return findParentClass(dom_object.parentElement, class_name);
}

function listShelves() {
    $.ajax({
        url: 'templates/shelfListTemplate.php',
        type: 'POST',
        success: function (response) {
            $('#library-page-content').html(response);
            $('.demo.menu .item').tab({history: false});
            $('#user-library-title').empty();
            $(document).ready(function () {
                $(".ui.table tr").click(function () {
                    var rows = $('tr').not(':first');
                    var row = $(this);
                    rows.removeClass('highlight');
                    row.addClass('highlight');
                });
            });
        }
    });
}


function shelfCRUD(mode) {
    var shelfid = -1;
    var selectedRow = $('tr.highlight').attr('id');
    if (mode != 0 && selectedRow !== null) {
        shelfid = selectedRow.split('-')[1];
    }
    $.ajax({
        url: 'forms/shelfForm.php',
        type: 'POST',
        data: {mode: mode, shelfid: shelfid},
        success: function (response) {
            var json = JSON.parse(response);
            $('.modal .header').html(json['header']);
            $('.modal .container').html(json['content']);
            $('.modal .actions').html(json['button']);
            $('.ui.modal')
                .modal('show')
            ;
            shelfController();
        }
    });
}

function shelfController() {
    $("#shelf-form-button").on('click', function () {
        $("#shelf-form").submit();
    });

    $("#shelf-form").submit(function () {
        var action = $(this).attr('action');
        $.ajax({
            url: 'formControllers/shelfController.php',
            type: 'POST',
            data: $('#shelf-form').serialize(),
            success: function (response) {
                var modes = ['New', 'Edit', 'Delete'];
                var json = JSON.parse(response);
                if (json['status'] === true) {
                    alertify.success('Success: ' + modes[json['mode']]);
                } else {
                    alertify.error('Error: ' + modes[json['mode']]);
                }
                $('body .modals').remove();
                listShelves();
            }
        });
        return false;
    });
}


$(document).ready(function () {
    $('.admin-menu')
        .on('click', function () {
            if (!$(this).hasClass('dropdown browse')) {
                $(this)
                    .addClass('active')
                    .closest('.ui.menu')
                    .find('.item')
                    .not($(this))
                    .removeClass('active')
                ;
            }
        });
});

function listTable(url) {
    $.ajax({
        url: url,
        type: 'POST',
        success: function (response) {
            $('body').removeClass('dimmable dimmed');
            var table = $('#admin-middle-content');
            table.empty();
            table.html(response);
            $(document).ready(function () {
                $(".ui.table tr").click(function () {
                    var rows = $('tr').not(':first');
                    var row = $(this);
                    rows.removeClass('highlight');
                    row.addClass('highlight');
                });
            });
        }
    });
}

function crud(mode, tablename) {
    var id = -1;
    var selectedRow = $('tr.highlight').attr('id');
    if (mode != 0 && selectedRow !== null) {
        id = selectedRow.split('-')[1];
    }
    $.ajax({
        url: 'forms/' + tablename + 'Form.php',
        type: 'POST',
        data: {mode: mode, id: id},
        success: function (response) {
            var json = JSON.parse(response);
            $('.modal .header').html(json['header']);
            $('.modal .container').html(json['content']);
            $('.modal .actions').html(json['button']);
            $('.ui.modal')
                .modal('show')
            ;
            crudController(tablename);
        }
    });
}


function crudController(tablename) {

    var formdiv = '#' + tablename + "-form";
    $(formdiv + "-button").on('click', function (event) {
        $(formdiv).submit();
    });

}


function formControllerOnFinish(response, tablename) {
    var modes = ['New', 'Edit', 'Delete'];
    var json = JSON.parse(response);
    if (json['status'] === true) {
        alertify.success('Success: ' + modes[json['mode']]);
    } else {
        alertify.error('Error: ' + modes[json['mode']]);
    }
    $('body .modals').remove();
    $('#admin-middle-content').find('.modal').remove();
    listTable('tables/' + tablename + 'table.php');
}

function closeIFrame() {
    $('#iframe-form').remove();
}

function exportFile(mode) {
    if (mode === 2) {
        exportPDF();
        return;
    }

    var pom = document.createElement('a');
    if (mode === 0) {
        pom.setAttribute('href', 'data:text/plain;charset=utf-8,' + document.getElementById('admin-middle-content').innerText);
        pom.setAttribute('download', 'table.txt');
    } else {
        pom.setAttribute('href', 'data:text/html,' + document.getElementById('admin-middle-content').innerHTML);
        pom.setAttribute('download', "table.html");
    }

    if (document.createEvent) {
        var event = document.createEvent('MouseEvents');
        event.initEvent('click', true, true);
        pom.dispatchEvent(event);
    }
    else {
        pom.click();
    }
}


function exportPDF() {
    var pdf = new jsPDF('p', 'pt', 'letter');
    // source can be HTML-formatted string, or a reference
    // to an actual DOM element from which the text will be scraped.
    source = $('#admin-middle-content')[0];

    // we support special element handlers. Register them with jQuery-style
    // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
    // There is no support for any other type of selectors
    // (class, of compound) at this time.
    specialElementHandlers = {
        // element with id of "bypass" - jQuery style selector
        '#bypassme': function (element, renderer) {
            // true = "handled elsewhere, bypass text extraction"
            return true
        }
    };
    margins = {
        top: 80,
        bottom: 60,
        left: 40,
        width: 522
    };
    // all coords and widths are in jsPDF instance's declared units
    // 'inches' in this case
    pdf.fromHTML(
        source, // HTML string or DOM elem ref.
        margins.left, // x coord
        margins.top, { // y coord
            'width': margins.width, // max width of content on PDF
            'elementHandlers': specialElementHandlers
        },

        function (dispose) {
            // dispose: object with X, Y of the last line add to the PDF
            //          this allow the insertion of new lines after html
            pdf.save('table.pdf');
        }, margins
    );
}