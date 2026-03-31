<!doctype html>
<html>
<head>
    <title>harviacode.com - CodeIgniter CRUD Generator</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="p-6 bg-gray-100 text-gray-800">

    <h2 class="text-2xl font-semibold mb-6">Routings Read</h2>

    <div class="bg-white rounded shadow p-6">
        <table class="w-full table-auto text-sm">
            <tbody class="divide-y divide-gray-200">
                <tr>
                    <td class="py-2 font-medium w-1/3">Routename</td>
                    <td class="py-2"><?= $routename; ?></td>
                </tr>
                <tr>
                    <td class="py-2 font-medium">Functioname</td>
                    <td class="py-2"><?= $functioname; ?></td>
                </tr>
                <tr>
                    <td class="py-2 font-medium">Createdat</td>
                    <td class="py-2"><?= $createdat; ?></td>
                </tr>
                <tr>
                    <td class="py-2 font-medium">Createdby</td>
                    <td class="py-2"><?= $createdby; ?></td>
                </tr>
                <tr>
                    <td class="py-2 font-medium">Updatedat</td>
                    <td class="py-2"><?= $updatedat; ?></td>
                </tr>
                <tr>
                    <td class="py-2 font-medium">Updatedby</td>
                    <td class="py-2"><?= $updatedby; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="pt-4">
                        <a href="<?= site_url('routings') ?>" class="inline-block bg-gray-500 hover:bg-gray-600 text-white text-sm px-4 py-2 rounded">
                            Cancel
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</body>
</html>
