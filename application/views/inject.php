<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>

<script type="text/javascript">
  
    var data = <?php echo $upload_data; ?>;
  
    $(document).ready(function(){
  
        $(document, parent.window.document).receive(data);
  
        window.location = '<?php site_url() . 'upload/index'; ?>';
  
    });
</script>