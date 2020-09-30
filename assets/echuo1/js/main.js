// hide and display advanced search
function display_adv(){

    document.getElementById('hideForm').style.display = 'block';
    document.getElementById('More').style.display = 'none';
    document.getElementById('Less').style.display = 'block';

}

function hide_adv(){

    document.getElementById('hideForm').style.display = 'none';
    document.getElementById('More').style.display = 'block';
    document.getElementById('Less').style.display = 'none';

}

// school query years
function db_portal(req, link='', object=null){

    let response = null;

    $.ajax({
        type: "GET",
        url: link + "cogs.php?" + req,
        contentType: 'application/json;charset=UTF-8',
        data: object,
        async: false,
        success: function(data){
            response = data;
        },
        error: function(data){
            console.log(JSON.stringify(data));
        }
    });

    return response;

}

function search_school(){

    let div = '';

    var query = document.getElementById("inputValue").value;

    let value = JSON.parse(db_portal('search_school='+query));

    if (value != false) {

        // align div

        div = '<ul class="my-list rounded border-theme">'

        for (const i in value) {

            div += '<li class="p-1" onclick="return add_to_input(\'' + value[i].name + '\')">' + value[i].name + '</li>'
        
        }

        div += '</ul>'
        
    } else {

        div = '';

    }

    document.getElementById('schoolSearch').innerHTML = div;

    return false;

}


function add_to_input(value){

    document.getElementById('inputValue').value = value;

    document.getElementById('schoolSearch').innerHTML = '';

}

$( document ).ready(function() {
    //custom button for homepage
     $( ".share-btn" ).click(function(e) {
         $('.networks-5').not($(this).next( ".networks-5" )).each(function(){
            $(this).removeClass("active");
         });
     
            $(this).next( ".networks-5" ).toggleClass( "active" );
    });   
});