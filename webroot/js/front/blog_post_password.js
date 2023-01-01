$(function(){
    let $BlogPostPasswordArchivesForm = $("#BlogPostPasswordArchivesForm");
    $BlogPostPasswordArchivesForm.submit(function(e){
        e.preventDefault();
        $.ajax({
            url: $BlogPostPasswordArchivesForm.attr('action'),
            type: 'POST',
            data: $BlogPostPasswordArchivesForm.serialize(),
            success: function () {
                location.reload();   
            },
            error: function (xhr, textStatus, errorThrown) {
                if(xhr.status == 400){
                    alert("トークンの有効期限が切れました。もう一度ご入力ください。");
                }else if(xhr.status == 403){
                    alert(xhr.responseText);
                }else{
                    alert("エラー：" + textStatus);
                }
                location.reload();
            }
        });
    });
});