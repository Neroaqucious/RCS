$(document).ready(function(){
  function filePreview(input){
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#showImg').empty();
        $('#showImg').html('<embed src="'+e.target.result+'" width="20%">');
      };
      reader.readAsDataURL(input.files[0]);
    }
  }

  $("#clickImg").change(function () {
    filePreview(this);
  });
}); 