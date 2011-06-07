<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <h1>Wordpress</h1>
        <a href="<?php echo site_url(); ?>/wordpress/create">create</a>
        <table border="1">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Url</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($wordpresses as $wordpress): ?>
                    <tr>
                        <td><?php echo $wordpress['name']; ?></td>
                        <td><?php echo $wordpress['url']; ?></td>
                        <td><a href="<?php echo site_url() . '/wordpress/edit/' . $wordpress['wordpress_id']; ?>">edit</a></td>
                        <td><a href="<?php echo site_url() . '/wordpress/delete/' . $wordpress['wordpress_id']; ?>">delete</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </body>
</html>
