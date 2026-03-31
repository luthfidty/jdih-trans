<?php
// contoh di controller/view tertentu
$this->load->view('base/headercontent'); // atau: include APPPATH.'views/includes/header.php';
?>
<!-- /Page Title -->

<div id="content" class="py-6">
    <form method="post" action="<?php echo $action ?>" autocomplete="off" enctype="multipart/form-data">
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="border-b border-gray-200 px-4 py-2">
                <ul class="flex space-x-4 text-sm font-medium text-gray-600" role="tablist">
                    <li>
                        <a href="#general" data-tab-target="general"
                            class="tab-button inline-flex items-center px-3 py-2 border-b-2 border-blue-600 text-blue-600 focus:outline-none"
                            role="tab"><i class="fa fa-cog mr-2"></i> Pengaturan Umum</a>
                    </li>
                    <li>
                        <a href="#mail" data-tab-target="mail"
                            class="tab-button inline-flex items-center px-3 py-2 hover:text-blue-600 hover:border-blue-600 border-b-2 border-transparent focus:outline-none"
                            role="tab"><i class="fa fa-envelope mr-2"></i> Email</a>
                    </li>

                    <li>
                        <a href="#socialmedia" data-tab-target="socialmedia"
                            class="tab-button inline-flex items-center px-3 py-2 hover:text-blue-600 hover:border-blue-600 border-b-2 border-transparent focus:outline-none"
                            role="tab"><i class="fa fa-info-circle mr-2"></i> Sosial Media</a>
                    </li>
                    <li>
                        <a href="#filemanager" data-tab-target="filemanager"
                            class="tab-button inline-flex items-center px-3 py-2 hover:text-blue-600 hover:border-blue-600 border-b-2 border-transparent focus:outline-none"
                            role="tab"><i class="fa fa-info-circle mr-2"></i> File Manager API</a>
                    </li>
                    <li>
                        <a href="#mobileapps" data-tab-target="mobileapps"
                            class="tab-button inline-flex items-center px-3 py-2 hover:text-blue-600 hover:border-blue-600 border-b-2 border-transparent focus:outline-none"
                            role="tab"><i class="fa fa-info-circle mr-2"></i> Mobile Apps</a>
                    </li>
                </ul>
            </div>
            <div id="general" class="tab-content p-4">
                <div class="space-y-6">
                    <div>
                        <label for="site_name" class="block text-sm font-medium text-gray-700">Site Name</label>
                        <input type="text" name="site_name" id="site_name" value="<?php echo $site_name; ?>"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" />
                    </div>

                    <div>
                        <label for="site_url" class="block text-sm font-medium text-gray-700">Site URL</label>
                        <input type="url" name="site_url" id="site_url" value="<?php echo $site_url; ?>"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" />
                    </div>

                    <div>
                        <label for="site_title" class="block text-sm font-medium text-gray-700">Site Title</label>
                        <input type="text" name="site_title" id="site_title" value="<?php echo $site_title; ?>"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" />
                    </div>

                    <div>
                        <label for="site_description" class="block text-sm font-medium text-gray-700">Site
                            Description</label>
                        <input type="text" name="site_description" id="site_description"
                            value="<?php echo $site_description; ?>"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" />
                    </div>

                    <div>
                        <label for="site_email" class="block text-sm font-medium text-gray-700">Site Email</label>
                        <input type="email" name="site_email" id="site_email" value="<?php echo $site_email; ?>"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" />
                    </div>

                    <!-- Gambar & Upload -->
                    <?php if (!empty($site_hero)) { ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Hero</label>
                            <img class="mt-2 max-h-60 rounded border" src="<?php echo site_url($site_hero) ?>" />
                        </div>
                    <?php } ?>
                    <input type="file" name="filehero" id="filehero"
                        class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-700" />

                    <!-- Logo 1 -->
                    <?php if (!empty($site_logo1)) { ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Site Logo 1</label>
                            <img class="mt-2 max-h-60 rounded border" src="<?php echo site_url($site_logo1) ?>" />
                        </div>
                    <?php } ?>
                    <input type="file" name="filelogo1" id="filelogo1"
                        class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-700" />

                    <!-- Logo 2 -->
                    <?php if (!empty($site_logo2)) { ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Site Logo 2</label>
                            <img class="mt-2 max-h-60 rounded border" src="<?php echo site_url($site_logo2) ?>" />
                        </div>
                    <?php } ?>
                    <!-- Favicon -->
                    <?php if (!empty($site_icon)) { ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Site Favicon</label>
                            <img class="mt-2 max-h-60 rounded border" src="<?php echo site_url($site_icon) ?>" />
                        </div>
                    <?php } ?>
                    <input type="file" name="filefavicon" id="filefavicon"
                        class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-700" />

                    <!-- Logo Mobile -->
                    <!-- <?php if (!empty($site_logo_mobile)) { ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Site Logo Mobile</label>
                            <img class="mt-2 max-h-60 rounded border" src="<?php echo site_url($site_logo_mobile) ?>" />
                        </div>
                    <?php } ?>
                    <input type="file" name="filelogomobile" id="filelogomobile"
                        class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-700" /> -->

                    <!-- Icon -->
                    <!-- <?php if (!empty($site_icon)) { ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Site Icon</label>
                            <img class="mt-2 max-h-60 rounded border" src="<?php echo site_url($site_icon) ?>" />
                        </div>
                    <?php } ?>
                    <input type="file" name="fileicon" id="fileicon"
                        class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-700" /> -->

                    <div>
                        <label for="site_address" class="block text-sm font-medium text-gray-700">Site Address</label>
                        <input type="text" name="site_address" id="site_address" value="<?php echo $site_address; ?>"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" />
                    </div>

                    <div>
                        <label for="site_phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="text" name="site_phone" id="site_phone" value="<?php echo $site_phone; ?>"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" />
                    </div>
                </div>
            </div>
            <div id="mail" class="tab-content hidden p-4">
                <div class="space-y-6">
                    <div>
                        <label for="system_mailer" class="block text-sm font-medium text-gray-700">System Mailer</label>
                        <select name="system_mailer" id="system_mailer"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            <option value="phpmail" <?php echo $system_mailer == "phpmail" ? 'selected' : '' ?>>PHPMail()
                            </option>
                            <option value="smtp" <?php echo $system_mailer == "smtp" ? 'selected' : '' ?>>SMTP</option>
                        </select>
                    </div>

                    <div>
                        <label for="smtp_host" class="block text-sm font-medium text-gray-700">SMTP Host</label>
                        <input type="text" name="smtp_host" id="smtp_host" value="<?php echo $smtp_host; ?>"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" />
                    </div>

                    <div>
                        <label for="smtp_user" class="block text-sm font-medium text-gray-700">SMTP User</label>
                        <input type="email" name="smtp_user" id="smtp_user" value="<?php echo $smtp_user; ?>"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" />
                    </div>

                    <div>
                        <label for="smtp_pass" class="block text-sm font-medium text-gray-700">SMTP Password</label>
                        <input type="password" name="smtp_pass" id="smtp_pass"
                            value="<?php echo base64_decode($smtp_pass); ?>"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" />
                    </div>

                    <div>
                        <label for="smtp_port" class="block text-sm font-medium text-gray-700">SMTP Port</label>
                        <input type="text" name="smtp_port" id="smtp_port" value="<?php echo $smtp_port; ?>"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" />
                    </div>

                    <div>
                        <label for="smtp_secure" class="block text-sm font-medium text-gray-700">SMTP Secure</label>
                        <select name="smtp_secure" id="smtp_secure"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            <option value="tls" <?php echo $smtp_secure == "tls" ? 'selected' : '' ?>>TLS</option>
                            <option value="ssl" <?php echo $smtp_secure == "ssl" ? 'selected' : '' ?>>SSL</option>
                        </select>
                    </div>

                    <div>
                        <label for="reply_to" class="block text-sm font-medium text-gray-700">Reply To</label>
                        <input type="text" name="reply_to" id="reply_to" value="<?php echo $reply_to; ?>"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" />
                    </div>

                    <div>
                        <label for="email_from" class="block text-sm font-medium text-gray-700">Mail From</label>
                        <input type="text" name="email_from" id="email_from" value="<?php echo $email_from; ?>"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" />
                    </div>

                    <div>
                        <label for="email_from_name" class="block text-sm font-medium text-gray-700">Mail From
                            Name</label>
                        <input type="text" name="email_from_name" id="email_from_name"
                            value="<?php echo $email_from_name; ?>"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" />
                    </div>
                </div>
            </div>
            <div id="post" class="tab-content hidden p-4">
                <div class="space-y-6">
                    <div>
                        <label for="approval_user" class="block text-sm font-medium text-gray-700">Approval User</label>
                        <select id="approval_user" name="approval_user"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            <?php foreach ($users as $u) {
                                echo '<option value="' . $u->id . '" ' . ($u->id == $approval_user ? 'selected' : '') . '>' . ($u->fullname ? $u->fullname : $u->username) . '</option>';
                            } ?>
                        </select>
                    </div>

                    <div>
                        <label for="site_limit_post" class="block text-sm font-medium text-gray-700">Limit Posts per
                            Page</label>
                        <input type="text" name="site_limit_post" id="site_limit_post"
                            value="<?php echo $site_limit_post; ?>"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" />
                    </div>

                    <div>
                        <label for="site_enable_popular" class="block text-sm font-medium text-gray-700">Enable Popular
                            Post</label>
                        <select name="site_enable_popular" id="site_enable_popular"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            <option value="1" <?php echo $site_enable_popular == 1 ? 'selected' : ''; ?>>Yes</option>
                            <option value="0" <?php echo $site_enable_popular == 0 ? 'selected' : ''; ?>>No</option>
                        </select>
                    </div>

                    <div>
                        <label for="site_enable_recent" class="block text-sm font-medium text-gray-700">Enable Recent
                            Post</label>
                        <select name="site_enable_recent" id="site_enable_recent"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            <option value="1" <?php echo $site_enable_recent == 1 ? 'selected' : ''; ?>>Yes</option>
                            <option value="0" <?php echo $site_enable_recent == 0 ? 'selected' : ''; ?>>No</option>
                        </select>
                    </div>

                    <!-- Gambar & Textarea Sambutan -->
                    <?php if (!empty($site_greeting_pic1)) { ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kata Sambutan Photo 1</label>
                            <img class="mt-2 max-h-60 rounded border" src="<?php echo site_url($site_greeting_pic1) ?>" />
                        </div>
                    <?php } ?>
                    <input type="file" name="site_greeting_pic1" id="site_greeting_pic1"
                        class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-700" />

                    <div>
                        <label for="site_greeting1" class="block text-sm font-medium text-gray-700">Kata Sambutan
                            1</label>
                        <textarea name="site_greeting1" id="site_greeting1" rows="6"
                            class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:border-blue-500"><?php echo $site_greeting1 ?></textarea>
                    </div>

                    <div>
                        <label for="site_greeting_name1" class="block text-sm font-medium text-gray-700">Kata Sambutan 1
                            Dari</label>
                        <input type="text" name="site_greeting_name1" id="site_greeting_name1"
                            value="<?php echo $site_greeting_name1; ?>" placeholder="Contoh: Ir. Budi;Sekjen"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" />
                    </div>

                    <?php if (!empty($site_greeting_pic2)) { ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kata Sambutan Photo 2</label>
                            <img class="mt-2 max-h-60 rounded border" src="<?php echo site_url($site_greeting_pic2) ?>" />
                        </div>
                    <?php } ?>
                    <input type="file" name="site_greeting_pic2" id="site_greeting_pic2"
                        class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-700" />

                    <div>
                        <label for="site_greeting2" class="block text-sm font-medium text-gray-700">Kata Sambutan
                            2</label>

                        <textarea name="site_greeting2" id="site_greeting2" rows="6"
                            class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:border-blue-500"><?php echo $site_greeting2 ?></textarea>
                    </div>

                    <div>
                        <label for="site_greeting_name2" class="block text-sm font-medium text-gray-700">Kata Sambutan 2
                            Dari</label>
                        <input type="text" name="site_greeting_name2" id="site_greeting_name2"
                            value="<?php echo $site_greeting_name2; ?>" placeholder="Contoh: Ir. Budi;Sekjen"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" />
                    </div>
                </div>
            </div>
            <div id="socialmedia" class="tab-content hidden p-4">
                <div class="space-y-6">
                    <?php
                    $socials = [
                        "facebook" => "Facebook",
                        "twitter" => "Twitter",
                        "instagram" => "Instagram",
                        "youtube" => "Youtube",
                        "linkedin" => "Linkedin",
                        "tiktok" => "Tiktok",
                        "pinterest" => "Pinterest"
                    ];
                    foreach ($socials as $key => $label) { ?>
                        <div>
                            <label for="social_<?php echo $key; ?>"
                                class="block text-sm font-medium text-gray-700"><?php echo $label; ?></label>
                            <input type="text" name="social_<?php echo $key; ?>" id="social_<?php echo $key; ?>"
                                value="<?php echo ${"social_" . $key}; ?>"
                                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" />
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div id="filemanager" class="tab-content hidden p-4">
                <div class="space-y-6">
                    <div>
                        <label for="flmngr_api" class="block text-sm font-medium text-gray-700">flmngr.com API
                            KEY</label>
                        <input type="text" name="flmngr_api" id="flmngr_api" value="<?php echo $flmngr_api; ?>"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" />
                    </div>

                    <div>
                        <label for="folder_upload" class="block text-sm font-medium text-gray-700">Folder Upload</label>
                        <input type="text" name="folder_upload" id="folder_upload" value="<?php echo $folder_upload; ?>"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" />
                    </div>
                </div>
            </div>
            <div id="mobileapps" class="tab-content hidden p-4">
                <div class="space-y-6">
                    <div>
                        <label for="playstoreurl" class="block text-sm font-medium text-gray-700">Playstore Link</label>
                        <input type="url" name="playstoreurl" id="playstoreurl" value="<?php echo $playstoreurl; ?>"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" />
                    </div>

                    <div>
                        <label for="appstoreurl" class="block text-sm font-medium text-gray-700">App Store Link</label>
                        <input type="url" name="appstoreurl" id="appstoreurl" value="<?php echo $appstoreurl; ?>"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" />
                    </div>
                </div>
            </div>


            <div class="bg-gray-50 border-t px-4 py-4 mt-6 rounded-b-lg">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
                        value="<?= $this->security->get_csrf_hash() ?>">
                    <div class="flex gap-3">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <?= $button ?>
                        </button>
                        <a href="<?= site_url('app/') ?>"
                            class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Batal
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </form>
</div>