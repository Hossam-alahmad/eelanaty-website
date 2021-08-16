<!-- Start About Me -->
<div class="col-md-8">
    <form method="POST" enctype="multipart/form-data" onsubmit="return check();">
        <div class="form-group">
            <label>نبذة عني:</label>
            <textarea name='about-me' class="form-control" rows="10" id='about-me'><?php echo $user_about; ?></textarea>
            <span></span>
        </div>
        <input type="submit" class="btn btn-primary pull-left" name="save_change" id="save-change" value="حفظ التغييرات">
    </form>
</div>
<!-- Finished About Me -->
