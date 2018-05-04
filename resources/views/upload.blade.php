<form action="/drive/upload" method="post" enctype="multipart/form-data">
    <input type="file" name="file">
    <input type="submit" value="Submit">
    {{csrf_field()}}
</form>