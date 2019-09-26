<div id="container">
    <?php echo  form_open_multipart('upload/uploadImage')?>
    <input type="file" name="userfile" />
    <p><input type="submit" name="submit" value="submit" /></p>
    <div class="row">
        <div class="col-xs-4">
            <h3>Date</h3>
            <div class="form-group">
                <div class="input-group datepicker">
                    <input type="text" class="form-control" readonly>
                    <span class="input-group-addon">
						<span class="fa fa-calendar"></span>
					</span>
                </div>
            </div>
        </div>
        <div class="col-xs-4">
            <h3>Time</h3>
            <div class="form-group">
                <div class="input-group timepicker">
                    <input type="text" class="form-control" readonly>
                    <span class="input-group-addon">
						<span class="fa fa-clock-o"></span>
					</span>
                </div>
            </div>
        </div>
        <div class="col-xs-4">
            <h3>Date & Time</h3>
            <div class="form-group">
                <div class="input-group datetimepicker">
                    <input type="text" class="form-control" readonly>
                    <span class="input-group-addon">
						<span class="fa fa-calendar"></span>
						+
						<span class="fa fa-clock-o"></span>
					</span>
                </div>
            </div>
        </div>
    </div>
    <?php echo form_close();?>
</div>
