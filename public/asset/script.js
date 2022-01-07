// document.getElementById('image_form_name').addEventListener('change', function() {
//   if (this.files[0]) // если выбрали файл
//     document.getElementById('image_form_name')[0].innerHTML = this.files[0].name;
// });
$('input[type=file]').change(function () {
      document.getElementById('image_form_name')[0].innerHTML = document.getElementById('image_form_name').files[0].name;
      console.log(document.getElementById('image_form_name').files[0].name);
})