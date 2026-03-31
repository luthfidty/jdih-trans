<!doctype html>
<html>

<head>
	<title>Detail Postingan</title>
	<meta charset="utf-8">
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="p-6 bg-gray-50 text-gray-800 font-sans">
	<div class="max-w-4xl mx-auto bg-white shadow rounded-lg p-6">
		<h2 class="text-2xl font-bold mb-6">Detail Postingan</h2>
		<table class="w-full table-auto text-sm">
			<tbody class="divide-y divide-gray-200">
				<tr>
					<td class="font-semibold w-40">Guuid</td>
					<td><?php echo $guuid; ?></td>
				</tr>
				<tr>
					<td class="font-semibold">Title</td>
					<td><?php echo $title; ?></td>
				</tr>
				<tr>
					<td class="font-semibold">Slug</td>
					<td><?php echo $slug; ?></td>
				</tr>
				<tr>
					<td class="font-semibold">Content</td>
					<td><?php echo $content; ?></td>
				</tr>
				<tr>
					<td class="font-semibold">Category</td>
					<td><?php echo $category; ?></td>
				</tr>
				<tr>
					<td class="font-semibold">Postimage</td>
					<td>
						<a href="<?php echo site_url($postimage ?: 'assets/app/images/noimage.jpg'); ?>"
							target="_blank">
							<img src="<?php echo site_url($postimage ?: 'assets/app/images/noimage.jpg'); ?>"
								class="h-32 object-contain rounded shadow" alt="Postimage">
						</a>
					</td>
				</tr>
				<tr>
					<td class="font-semibold">Postimagethumb</td>
					<td>
						<a href="<?php echo site_url($postimagethumb ?: 'assets/app/images/noimage.jpg'); ?>"
							target="_blank">
							<img src="<?php echo site_url($postimagethumb ?: 'assets/app/images/noimage.jpg'); ?>"
								class="h-24 object-contain rounded shadow" alt="Postimagethumb">
						</a>
					</td>
				</tr>
				<tr>
					<td class="font-semibold">Type</td>
					<td><?php echo $type; ?></td>
				</tr>
				<tr>
					<td class="font-semibold">Meta</td>
					<td><?php echo $metapost; ?></td>
				</tr>
				<tr>
					<td class="font-semibold">Keywords</td>
					<td><?php echo $keywords; ?></td>
				</tr>
				<tr>
					<td class="font-semibold">Comment Status</td>
					<td><?php echo $commentstatus; ?></td>
				</tr>
				<tr>
					<td class="font-semibold">Post Status</td>
					<td><?php echo $poststatus; ?></td>
				</tr>
				<tr>
					<td class="font-semibold">Created At</td>
					<td><?php echo $createdat; ?></td>
				</tr>
				<tr>
					<td class="font-semibold">Created By</td>
					<td><?php echo $createdby; ?></td>
				</tr>
				<tr>
					<td class="font-semibold">Updated At</td>
					<td><?php echo $updatedat; ?></td>
				</tr>
				<tr>
					<td class="font-semibold">Updated By</td>
					<td><?php echo $updatedby; ?></td>
				</tr>
			</tbody>
		</table>
		<div class="mt-6">
			<a href="<?php echo site_url('posts') ?>"
				class="inline-flex items-center px-4 py-2 text-sm text-white bg-gray-600 hover:bg-gray-700 rounded">
				<i class="fas fa-arrow-left mr-2"></i> Kembali
			</a>
		</div>
	</div>
</body>

</html>