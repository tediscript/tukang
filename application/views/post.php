<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <h1>Post</h1>
        <a href="<?php echo site_url(); ?>/post/add">Add Post</a>
        <table border="1">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Status</th>
<!--                    <th>Edit</th>-->
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post): ?>
                    <tr>
                        <td><?php echo $post['title']; ?></td>
                        <td><?php echo $post['category']; ?></td>
                        <td><?php echo $post['status']; ?></td>
<!--                        <td><a href="<?php echo site_url() . '/post/edit/' . $post['post_id']; ?>">edit</a></td>-->
                        <td><a href="<?php echo site_url() . '/post/delete/' . $post['post_id']; ?>">delete</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </body>
</html>
