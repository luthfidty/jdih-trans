<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Roles Detail</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 p-6">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-4">Roles Detail</h2>
        <table class="w-full table-auto text-sm">
            <tbody>
                <tr class="border-b">
                    <td class="font-medium py-2 w-1/3">Rolename</td>
                    <td class="py-2"><?php echo $rolename; ?></td>
                </tr>
                <tr class="border-b">
                    <td class="font-medium py-2">Moduleroute</td>
                    <td class="py-2"><?php echo $moduleroute; ?></td>
                </tr>
                <tr class="border-b">
                    <td class="font-medium py-2">Rolelist</td>
                    <td class="py-2"><?php echo $rolelist; ?></td>
                </tr>
                <tr class="border-b">
                    <td class="font-medium py-2">Roleaction</td>
                    <td class="py-2"><?php echo $roleaction; ?></td>
                </tr>
                <tr class="border-b">
                    <td class="font-medium py-2">Created At</td>
                    <td class="py-2"><?php echo $createdat; ?></td>
                </tr>
                <tr class="border-b">
                    <td class="font-medium py-2">Created By</td>
                    <td class="py-2"><?php echo $createdby; ?></td>
                </tr>
                <tr class="border-b">
                    <td class="font-medium py-2">Updated At</td>
                    <td class="py-2"><?php echo $updatedat; ?></td>
                </tr>
                <tr class="border-b">
                    <td class="font-medium py-2">Updated By</td>
                    <td class="py-2"><?php echo $updatedby; ?></td>
                </tr>
            </tbody>
        </table>
        <div class="mt-6">
            <a href="<?php echo site_url('roles') ?>" class="inline-block px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Cancel</a>
        </div>
    </div>
</body>
</html>
