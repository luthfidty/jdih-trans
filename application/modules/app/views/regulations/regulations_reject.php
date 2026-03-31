<?php
// contoh di controller/view tertentu
$this->load->view('base/headercontent'); // atau: include APPPATH.'views/includes/header.php';
?>

<div id="content" class="max-w-4xl mx-auto bg-white shadow rounded p-6">
    <form method="post" action="<?php echo $action ?>" autocomplete="off" enctype="multipart/form-data"
        class="space-y-6">
        <div>
            <h2 class="text-lg font-semibold mb-4">
                <?php echo ucfirst($this->uri->segment(2) . ' ' . $this->uri->segment(3)) ?>
            </h2>

            <div class="space-y-4">
                <div>
                    <label for="title" class="block font-medium text-gray-700 mb-1">Judul
                        <?php echo form_error('title') ?></label>
                    <input type="text" name="title" id="title" value="<?php echo $title; ?>"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-500"
                        placeholder="Judul" />
                </div>

                <div>
                    <label for="documentcategory" class="block font-medium text-gray-700 mb-1">Kategori Dokumen
                        <?php echo form_error('documentcategory') ?></label>
                    <select name="documentcategory" id="documentcategory"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-500">
                        <?php
                        foreach ($dcdata ?? [] as $dc) {
                            if ($dc->id == $documentcategory) {
                                echo '<option value="' . $dc->id . '" selected>' . $dc->category . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div>
                    <label for="doctype" class="block font-medium text-gray-700 mb-1">Tipe Dokumen
                        <?php echo form_error('doctype') ?></label>
                    <select name="doctype" id="doctype"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-500">
                        <?php
                        foreach ($docstype ?? [] as $dt) {
                            echo '<option value="' . $dt->id . '" ' . ($dt->id == $doctype ? 'selected' : '') . '>' . $dt->documenttype . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <!-- Abstrak file preview + input -->
                <div x-data="{ showModal: false }">
                    <label for="abstractfile" class="block font-medium mb-1">Abstrak Dokumen
                        <?php echo form_error('abstractfile') ?>
                    </label>

                    <?php if ($abstractfile) { ?>
                        <button type="button" @click="showModal = true"
                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-3 py-1 rounded">
                            Abstrak Dokumen Saat Ini
                        </button>

                        <!-- Modal -->
                        <div x-show="showModal"
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                            style="display: none;">
                            <div class="bg-white rounded-lg overflow-hidden shadow-lg max-w-4xl w-full">
                                <div class="flex justify-between items-center px-4 py-2 border-b">
                                    <h4 class="text-lg font-semibold">Abstrak Dokumen - <?php echo $title ?></h4>
                                    <button type="button" @click="showModal = false"
                                        class="text-gray-500 hover:text-gray-700 text-2xl leading-none">&times;</button>
                                </div>
                                <div class="p-4">
                                    <?php
                                    if ($abstractfile->fullpath) {
                                        echo '<embed src="' . site_url($abstractfile->fullpath) . '" frameborder="0" width="100%" height="600px">';
                                    } else {
                                        echo '<div class="bg-red-100 text-red-700 p-3 rounded">ERROR: File tidak ditemukan!</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <input type="file" name="abstractfile" id="abstractfile"
                        class="mt-2 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500" />
                </div>

                <div x-data="{ showAttachmentModal: false }">
                    <label for="attachment" class="block font-medium mb-1">Dokumen
                        <?php echo form_error('attachment') ?>
                    </label>

                    <?php if ($attachment) { ?>
                        <button type="button" @click="showAttachmentModal = true"
                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-3 py-1 rounded">
                            Dokumen Saat Ini
                        </button>

                        <!-- Modal -->
                        <div x-show="showAttachmentModal"
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                            style="display: none;">
                            <div class="bg-white rounded-lg overflow-hidden shadow-lg max-w-4xl w-full">
                                <div class="flex justify-between items-center px-4 py-2 border-b">
                                    <h4 class="text-lg font-semibold">Dokumen - <?php echo $title ?></h4>
                                    <button type="button" @click="showAttachmentModal = false"
                                        class="text-gray-500 hover:text-gray-700 text-2xl leading-none">
                                        &times;</button>
                                </div>
                                <div class="p-4">
                                    <embed src="<?php echo site_url($attachment->fullpath) ?>" frameborder="0" width="100%"
                                        height="600px">
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <input type="file" name="attachment" id="attachment"
                        class="mt-2 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500" />
                </div>
                <div>
                    <label for="published" class="block font-medium text-gray-700 mb-1">Status Publikasi
                        <?php echo form_error('published') ?></label>
                    <select name="published" id="published"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-500">
                        <?php
                        foreach ($isPublished ?? [] as $v) {
                            if ($v == 'Publish') {
                                if ($session['id'] == 1 || $session['id'] == $this->config->item('approval_user')) {
                                    echo '<option value="' . $v . '" ' . ($v == $published ? 'selected' : '') . '>' . $v . '</option>';
                                }
                            } else {
                                echo '<option value="' . $v . '" ' . ($v == $published ? 'selected' : '') . '>' . $v . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div>
                    <label for="reason" class="block font-medium text-gray-700">Reason
                        <?php echo form_error('reason') ?></label>
                    <input type="hidden" name="reason" id="reason" value="<?php echo htmlspecialchars($reason); ?>" />
                    <div class="quill-editor mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500 min-h-[300px]"
                        data-name="reason">
                        <?php echo $reason; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-between items-center pt-6 border-t mt-6">
            <div>
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                <input type="hidden" name="curAbstractfile" value="<?php echo $curAbstractfile; ?>" />
                <input type="hidden" name="curAttachment" value="<?php echo $curAttachment; ?>" />
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
                    value="<?= $this->security->get_csrf_hash() ?>">
            </div>
            <div class="flex gap-2">
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700"><?php echo $button ?></button>
                <a href="<?php echo site_url('app/regulations') ?>"
                    class="px-4 py-2 bg-gray-300 text-gray-800 text-sm rounded hover:bg-gray-400">Batal</a>
            </div>
        </div>
    </form>
</div>