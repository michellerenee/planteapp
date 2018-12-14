
<figure class="scan-figure">
  <img id="ditimg" src="#" alt="your image" />
</figure>

<form id="form1" runat="server">

  <div class="input-knap-rund-box">
    <input type="file" accept="image/*" capture="camera" class="input-knap-rund" id="imgInp">
  </div>

</form>



<script>
  // hentet jQuery function, så det tagede billede på scan siden vises i firkanten
    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#ditimg').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp").change(function() {
        readURL(this);
    });
</script>




