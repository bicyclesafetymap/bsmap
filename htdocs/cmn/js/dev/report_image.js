function image_up_create(){
  $("#js-btn-container").on('change', '.js-images', function(evt) {

    var files = evt.target.files;
    var file = files[0];
    var size = file.size; // ファイル容量（byte）
    var limit = 5242880; // byte, 5MB
    var btnNo = $(this).attr('data-btn');

    if(files.length == 0) return;

    if( ! file.type.match(/image/)) {
      alert('画像ファイルを選んでください');
      return;
    }

    if ( limit < size ) {
      alert('5MBを超えています。5MB以下のファイルを選択してください。');
      return;
    }

    $(this).parent().hide();

    var reader = new FileReader();
    reader.onload = function(evt) {
    $("#js-image-Box").append('<div class="reportUpcontainer_picBox-delBtn"><img src="'+reader.result+'"><span class="js-del" data-btn="'+btnNo+'">▲この画像を削除する</span></div>');
    }
    reader.readAsDataURL(file);
  });
}

function delete_image(){
  $("#js-image-Box").on('click', '.js-del', function() {
    var btnNo  = $(this).attr('data-btn');
    var target = $(".reportUpcontainer_btnBox").eq(parseInt(btnNo) - 1);
    $(this).parent().remove();
    target.show();
    target.find('input[type="file"]').remove();
    target.prepend('<input type="file" name="image[]" class="js-images reportUpcontainer_btnBox-file" data-btn="'+btnNo+'">');
    });
}

$(function() {
  image_up_create();
  delete_image();
});
