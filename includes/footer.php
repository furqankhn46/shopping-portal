</div><br><br>
<div class="col-md-12 text-center">&copy; copyright 2013-2017 AlbilalchickenPoint</div>
<div id="details-modal-div"></div>

<script>
    jQuery(window).scroll(function () {
        var vscroll = jQuery(this).scrollTop();
        jQuery('#logotext').css({
            "transform": "translate(0px, " + vscroll / 2 + "px)"
        });
        jQuery('#back-flower').css({
            "transform": "translate(" + vscroll / 5 + "px, " + vscroll / 12 + "px)"
        });
        jQuery('#fore-flower').css({
            "transform": "translate(0px, -" + vscroll / 2 + "px)"
        });
    });
    function detailsmodal(id){
        var data ={"id":id};
    jQuery.ajax({
        url: "<?php print WEBURL; ?>/includes/detailsmodal.php",
        method:"post",
        data:data,
        headers: { "cache-control": "no-cache" },
        success: function(data){
            jQuery('#details-modal-div').html(data);
            jQuery('#details-modal').modal('toggle');
        },
        error: function(){

        }
    });
    }
</script>
</body>
</html>
