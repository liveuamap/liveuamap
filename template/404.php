<?php defined('WERUA') or include('../bad.php'); ?>
<?include 'parts/_header.php'; ?>
<div align='center'>
    <div class="dotted inked"></div>
    <img src="<?WRA::e(WRA::base_url());?>images/404_bg.png" id="all404"/>
    <table class='table_all_width' align='center' id="table404over">
        <tr>
            <td>
                <div class='style_404'>
                    <h1>404</h1>
                    <h2>Page not found</h2><br/>
                    <a href="<?WRA::e(WRA::base_url());?>">To map</a>
                </div>



            </td>
        </tr></table>


</div>
<script type="text/javascript">
    $(document).ready(function(){
        if($(document).height()>$(document).width()){
            $("#all404").css("width",'auto');
            $("#all404").css('height','100%');
        }
    }) ;

</script>

<?include 'parts/_footer.php'; ?>