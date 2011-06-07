<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <h1>Add Post</h1>
        <form action="<?php echo site_url(); ?>/post/add/" method="post">
            Category:<br/>
            <input type="text" value="" name="category"/><br/>
            Titles:<br/>
            <textarea name="source" cols="100" rows="20"></textarea><br/>
            <input type="submit" value="submit"/>
        </form>
    </body>
</html>
