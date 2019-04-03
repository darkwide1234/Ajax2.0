$(document).ready(function() {
    $('#adherent, #auteur, #theme').hide();
    $('#formSearchMember').on('submit', function(e) {
        e.preventDefault();
    });
    $('#formSearchBook').on('submit', function(e) {
        e.preventDefault();
    });
});


$('.nav-link').click(function () {
    $('#accueil, #auteur, #theme, #adherent').hide();
    $('#'+ $(this).attr('data-section')).show();
});

function autoComplete(input, type) {
    if (checkTxtContent($(input).val())) {
        getDatas(createAutoCompleteList, $(input).val(), type);
    }
}

function createAutoCompleteItem(inputElement, anchor, inputLength, idResult, stringResult) {
    $(anchor).append(
        "<div id=\'"  + idResult + "\' onclick=\"setInputVal(\'" + inputElement + "\', \'" + idResult + "\', \'" + stringResult + "\')\">" +
            "<span><strong>" + stringResult.substr(0, inputLength.length) + "</strong></span><span>" + stringResult.substr(inputLength.length) + "</span>" +
            "<input type=\'hidden\' value=\'" + stringResult + "\' name=\'" + stringResult + "\'/ >" +
        "</div>"
    );
}

function createAutoCompleteList(json) {
    if (json[0].hasOwnProperty("nom_adherent")) {
        $('#autocompleteListAdherent').empty();
        for (let a = 0; a < json.length; a++) {
            createAutoCompleteItem('#txtSearchAdherent', '#autocompleteListAdherent', $('#txtSearchAdherent').val(), json[a].id_adherent, json[a].nom_adherent);
        }
    }
    else {
        $('#autocompleteListBook').empty();
        for (let a = 0; a < json.length; a++) {
            createAutoCompleteItem('#txtSearchBook', '#autocompleteListBook', $('#txtSearchBook').val(), json[a].id_oeuvre, json[a].titre);
        }
    }
}

function checkTxtContent(input) {
    let result = false;
    if (input.length > 0) {
        result = true;
    }

    return result;
}

function getDataAuthor(id) {
    let type = "author";
    setTitle(id, type);
    getDatas(printFormatedBooks, id, type);
}

function getDataBook(id) {
    let type = "book";
    setTitle(id, type);
    getDatas(printFormatedBooks, id, type);
}

function getDataEditor(id) {
    let type = "editor";
    setTitle(id, type);
    getDatas(printFormatedBooks, id, type);
}

function getDataMember(id) {
    let type = "member";
    setTitle(id, type);
    getDatas(printFormatedBooks, id, type);
}

/*
    Ajax method used to get datas from the DBReader.php file,

    @callback : Method to call if the ajax request succed.
    @identificator : Id used to find specific datas on the DB, it can be an ID or a name.
    @type : Type used on DBReader to use the good request on the DB.
*/
function getDatas(callback, identificator, type) {
    $.ajax({
        type: "post",
        url: "./RUD/DBReader.php",
        data: {id:identificator, type:type},
        dataType: 'json',
        success: function (json) {
            callback(json);
        },
        error: function(json, status, error) {
            console.log("Error ajax");
            if ((typeof json !== 'undefined') || (json.length === 0)) {
                $('#listBook').empty();
                $('#listBook').append(
                    "<li><h3>Néant</h3></li>"
                );

                if (type.includes("title")) {
                    $('#displayAreaTitle').empty();
                };
            }
            else {
                $('#listBook').empty();
            }
        },
        always: function() {
            console.log("AJAX");
        }
    });
}

/*
    Set the title's type and call the ajax method to change it.
*/
function setTitle(identificator, type) {
    switch (type) {
        case 'author':
            type = "titleAuthor";
            break;
        case 'book':
            type = "titleBook";
            break;
        case 'editor':
            type = "titleEditor";
            break;
        case 'member':
            type = "titleMember";
            break;
        default:
            console.log("Type error.");
            return;
    }

    getDatas(printFormatedTitle, identificator, type);
}

/*
    Print a different title on #displayAreaTitle for each category.
*/
function printFormatedTitle(json) {
    let obj = json[0];
    $('#displayAreaTitle').empty();
    if (obj.hasOwnProperty("id_auteur")) {
        $('#displayAreaTitle').text("Auteur : " + obj['prenom_auteur'] + " " + obj['nom_auteur']);
    }
    else if (obj.hasOwnProperty("id_oeuvre")) {
        $('#displayAreaTitle').text("Oeuvre : " + obj['titre']);
    }
    else if (obj.hasOwnProperty("id_editeur")) {
        $('#displayAreaTitle').text("Editeur : " + obj['nom_editeur']);
    }
    else if (obj.hasOwnProperty("id_adherent")) {
        $('#displayAreaTitle').text("Membre : " + obj['prenom_adherent'] + " " + obj['nom_adherent']);
    }
    else {
        console.log("Erreur du titre.");
    }

    $('select').val("");
}

/*
    Add each books to the #listBook ul
*/
function printFormatedBooks(json) {
    $('#listBook').empty();
    $(json).each(function() {
        $('#listBook').append(
            "<li>" +
                "<div class=\'bookTitle\'><img src=\'./img/book.svg\' class=\'imgBook\'/><h3 name=\'" + this.id_livre + "\'>" + this.titre + "</h3></div>" +
                "<div class=\'bookDetails\' id=\'" + this.id_livre + "\'><span class=\'bookAuthorName\'>" + this.prenom_auteur + " " + this.nom_auteur + "</span><span class=\'bookEditor\'>" + this.nom_editeur + "</span></div>" +
            "</li>"
        );
    });
}

/*
    Change de input element value and get datas from de DB.
*/
function setInputVal(elementID, id, stringValue) {
    $(elementID).val(stringValue);
    if (elementID === "#txtSearchAdherent") {
        getDataMember(id);
        $("#autocompleteListAdherent").empty();
        $(elementID).val("");
    }
    else {
        getDataBook(id);
        $("#autocompleteListBook").empty();
        $(elementID).val("");
    }
}
