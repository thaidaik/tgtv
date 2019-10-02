<!DOCTYPE html>
<html>
<head>
    <title>codeigniter ajax request - itsolutionstuff.com</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2></h2>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-8">
            <strong>stock:</strong>
            <input type="text" name="stock" class="form-control" placeholder="stock">
        </div>
        <div class="col-lg-8">
            <strong>Description:</strong>
            <textarea name="description" class="form-control" placeholder="Description"></textarea>
        </div>
        <div class="col-lg-8">
            <br/>
            <button class="btn btn-success">Submit</button>
        </div>
    </div>


    <table class="table table-bordered" style="margin-top:20px">


        <thead>
        <tr>
            <th>stock</th>
            <th>Description</th>
        </tr>
        </thead>


        <tbody>
        <?php foreach ($data as $item) { ?>
            <tr>
                <td><?php echo $item->stock; ?></td>
                <td><?php echo $item->description; ?></td>
            </tr>
        <?php } ?>
        </tbody>


    </table>
    <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="right" id="right" title="" data-original-title="Tooltip on right">Tooltip on right</button>
</div>


<script type="text/javascript">
    $(function(){
        $('#right').tooltip();
    });
    $("button").click(function(){


        var stock = $("input[name='stock']").val();
        var description = $("textarea[name='description']").val();


        $.ajax({
            url: '<?php echo base_url(); ?>/ajax-requestPost-test',
            type: 'POST',
            data: {stock: stock, description: description},
            error: function() {
                alert('Something is wrong');
            },
            success: function(data) {
                $("tbody").append("<tr><td>"+stock+"</td><td>"+description+"</td></tr>");
                alert("Record added successfully");
            }
        });


    });


</script>
<script>
    //jQuery('#button').click(function(){
    //    var username = jQuery('#username').val();
    //    jQuery.ajax({
    //        type:'POST',
    //        dataType: "html",
    //        url:"<?php //echo base_url(); ?>//tour/info/get_view_ajax/",
    //        data: "username="+username,
    //        success:function(msg){
    //            jQuery("#div_result").html(msg);
    //        },
    //        error: function(result){
    //            jQuery("#div_result").html("Error");
    //        },
    //        fail:(function(status) {
    //            jQuery("#div_result").html("Fail");
    //        }),
    //        beforeSend:function(d){
    //            jQuery('#div_result').html("<center><strong style='color:red'>Please Wait...<br><img height='25' width='120' src='<?php //echo base_url();?>//assets/img/giphy.gif' /></strong></center>");
    //        }
    //
    //    });
    //});
</script>

</body>
</html>