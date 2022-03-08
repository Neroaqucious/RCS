<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
  var $subcategoryid = $("#subcategoryid");
  var $leveldata = $("#leveldata");

  $(document).ready(function(){
    $($subcategoryid).on("change", function(){
      var subcategory = $subcategoryid.val();
      if (subcategory != ''){    
        ajaxCall(subcategory, $leveldata);
      } else {
        $leveldata.html('<option value="">Select Level</option>');
      }
    });
  });

  function ajaxCall(sendid,$view) {
    $.ajax({
      url: "<?php echo base_url('admin/course/fetch_level'); ?>", 
      method: "POST", 
      data:{subcategory : sendid},
      success: function(data)
      {
        return $view.html(data);
      }
    });
  }
</script>