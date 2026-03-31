<!doctype html>
<html>
<head>
    <title>Detail Postingan</title>
    <meta charset="utf-8">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6 bg-gray-50 text-gray-800 font-sans">
    <div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Detail Postingan</h2>
        <table class="w-full table-auto text-sm">
            <tbody class="divide-y divide-gray-200">
                <tr><td class="font-medium w-40">Guuid</td><td><?php echo $guuid; ?></td></tr>
                <tr><td class="font-medium">Title</td><td><?php echo $title; ?></td></tr>
                <tr><td class="font-medium">Slug</td><td><?php echo $slug; ?></td></tr>
                <tr><td class="font-medium">Content</td><td><?php echo $content; ?></td></tr>
                <tr><td class="font-medium">Category</td><td><?php echo $category; ?></td></tr>
                <tr><td class="font-medium">Postimage</td>
                    <td>
                        <?php if (!empty($postimage)): ?>
                            <a href="<?= site_url($postimage) ?>" target="_blank">
                                <img src="<?= site_url($postimage) ?>" class="h-32 rounded shadow border" alt="Postimage">
                            </a>
                        <?php else: ?>
                            <span class="text-gray-400 italic">Tidak ada gambar</span>
                        <?php endif ?>
                    </td>
                </tr>
                <tr><td class="font-medium">Postimagethumb</td>
                    <td>
                        <?php if (!empty($postimagethumb)): ?>
                            <a href="<?= site_url($postimagethumb) ?>" target="_blank">
                                <img src="<?= site_url($postimagethumb) ?>" class="h-24 rounded shadow border" alt="Postimagethumb">
                            </a>
                        <?php else: ?>
                            <span class="text-gray-400 italic">Tidak ada thumbnail</span>
                        <?php endif ?>
                    </td>
                </tr>
                <tr><td class="font-medium">Type</td><td><?php echo $type; ?></td></tr>
                <tr><td class="font-medium">Meta</td><td><?php echo $metapost; ?></td></tr>
                <tr><td class="font-medium">Keywords</td><td><?php echo $keywords; ?></td></tr>
                <tr><td class="font-medium">Comment Status</td><td><?php echo $commentstatus; ?></td></tr>
                <tr><td class="font-medium">Post Status</td><td><?php echo $poststatus; ?></td></tr>
                <tr><td class="font-medium">Created At</td><td><?php echo $createdat; ?></td></tr>
                <tr><td class="font-medium">Created By</td><td><?php echo $createdby; ?></td></tr>
                <tr><td class="font-medium">Updated At</td><td><?php echo $updatedat; ?></td></tr>
                <tr><td class="font-medium">Updated By</td><td><?php echo $updatedby; ?></td></tr>
            </tbody>
        </table>
        <div class="mt-6">
            <a href="<?php echo site_url('posts') ?>" class="inline-flex items-center px-4 py-2 text-sm text-white bg-gray-600 hover:bg-gray-700 rounded">
                ← Kembali
            </a>
        </div>
    </div>
</body>
</html>
