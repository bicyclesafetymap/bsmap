// メイン処理
$(function(){
    $('.sortable').sortable({
        axis: 'y',
        opacity : 0.8,
        cursor: "move",
        update: function(e, ui){
            // 優先順位の並び替え
            target = $(this).find('input[name^="sort"]');
            for (var i = 0; target.length > i; i++) {
                $(target[i]).val(i+1);
            }
        }
    }).disableSelection();
});