<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Istoriya – <?= isset($page) ? ucfirst($page) : 'Sahifa' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <header class="bg-primary text-white py-3 px-4 d-flex justify-content-between align-items-center">
    <h4 class="m-0">Ҳабархои омада</h4>
</header>
</head>
<body class="container mt-4">



<?php if(!empty($files)): ?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>№</th>
            <th>Номи файл</th>
            <th>Аз ки омад</th>
            <th>Ба кадом раёсат</th>
             <th>Омада шуд</th>
            <th>Сана</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($files as $i => $file): ?>
        <tr>
            <td><?= $i+1 ?></td>
            <td>
                <a href="<?= base_url('uploads/'.$file->destination.'/'.$file->file_name) ?>" target="_blank">
                    <?= $file->file_name ?>
                </a>
            </td>
            <td><?= isset($file->lastname) ? $file->lastname . ' ' . $file->firstname : $file->uploaded_by ?></td>
            <td><?= $file->uploaded_from ?></td>
             <td><?= $file->destination === 'all' ? 'Barcha sahifalar' : $file->destination ?></td>
            <td><?= date("d.m.Y H:i", strtotime($file->uploaded_at)) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php else: ?>
<div class="alert alert-info mt-3">📭Файл холо вобаста нашудаст</div>
<?php endif; ?>

<a href="javascript:history.back()" class="btn btn-secondary mt-3">⬅️ Ба қафо</a>


</body>
</html>
