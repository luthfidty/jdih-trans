<!doctype html>
<html>
<head>
    <title>harviacode.com - codeigniter crud generator</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6 bg-gray-50 text-gray-800">
    <h2 class="text-2xl font-semibold mb-4">Users Read</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto bg-white rounded shadow">
            <tbody>
                <tr class="border-t">
                    <td class="px-4 py-2 font-medium w-48">Username</td>
                    <td class="px-4 py-2"><?php echo $username; ?></td>
                </tr>
                <tr class="border-t">
                    <td class="px-4 py-2 font-medium">Password</td>
                    <td class="px-4 py-2"><?php echo $password; ?></td>
                </tr>
                <tr class="border-t">
                    <td class="px-4 py-2 font-medium">Role</td>
                    <td class="px-4 py-2"><?php echo $role; ?></td>
                </tr>
                <tr class="border-t">
                    <td class="px-4 py-2 font-medium">Resetkey</td>
                    <td class="px-4 py-2"><?php echo $resetkey; ?></td>
                </tr>
                <tr class="border-t">
                    <td class="px-4 py-2 font-medium">Createdat</td>
                    <td class="px-4 py-2"><?php echo $createdat; ?></td>
                </tr>
                <tr class="border-t">
                    <td class="px-4 py-2 font-medium">Createdby</td>
                    <td class="px-4 py-2"><?php echo $createdby; ?></td>
                </tr>
                <tr class="border-t">
                    <td class="px-4 py-2 font-medium">Updatedat</td>
                    <td class="px-4 py-2"><?php echo $updatedat; ?></td>
                </tr>
                <tr class="border-t">
                    <td class="px-4 py-2 font-medium">Updatedby</td>
                    <td class="px-4 py-2"><?php echo $updatedby; ?></td>
                </tr>
                <tr class="border-t">
                    <td></td>
                    <td class="px-4 py-4">
                        <a href="<?php echo site_url('users') ?>" class="inline-block bg-gray-600 hover:bg-gray-700 text-white text-sm px-4 py-2 rounded">
                            Cancel
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
