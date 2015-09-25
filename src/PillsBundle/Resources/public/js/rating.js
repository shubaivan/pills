$(document).on('click', '.rating_add', function(e){
    var self = this;
    e.preventDefault();

    $.ajax({
        url: $(self).attr('href'),
        type: 'Post',
        data: $(self).data('slug'),
        success:function(data){
            $(self).html(data + '<span class="glyphicon glyphicon-heart"></span>');
        }

    });
});


$(document).on('click', '#delete_post', function(e){
    e.preventDefault();

    $.ajax({
        url: $(this).attr('href'),
        type: 'DELETE'
    }).done(function(data, status){
        document.location.href = "app_dev.php/";
    });
});