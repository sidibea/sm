var baseurl = 'localhost:8000/';

function addToCart(id)
{
    var url = baseurl + 'vente/ajouter-panier';


    post_ajax(url, id);

   //console.log(result);
}

function post_ajax(url, data) {
    var result = '';
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: function(response) {
            result = response;
        },
        error: function(response) {
            result = 'error';
        },
        async: false
    });

    return result;
}
