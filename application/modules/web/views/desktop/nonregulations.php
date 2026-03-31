<div class="text-white flex flex-col justify-end px-4 desktop:px-16 pt-4 desktop:pt-16 bg-cover bg-center desktop:rounded-b-[80px] container mx-auto"
    style='background-image:url("<?php echo site_url($this->config->item('site_hero')) ?>");background-size: cover; 
            background-repeat: no-repeat; 
            background-position: center;'>
    <h1 class="text-[32px] desktop:text-[48px] font-bold">Non Peraturan</h1>
    <nav class="my-4">
        <ol class="flex flex-wrap desktop:flex-row items-center  space-x-2">
            <li><a class="text-[#9D9D9D]  hover:underline" href="<?php echo site_url() ?>">Beranda</a></li>
            <li class="text-sm desktop:text-3xl text-[#9D9D9D]"><i data-feather="chevron-right"></i></li>
            <li><a class="text-[#9D9D9D]  hover:underline" href="<?php echo site_url('web/nonregulations/') ?>">Non
                    Peraturan</a>
            </li>
            <?php if ($currentgroups) { ?>
                <li class="text-sm desktop:text-3xl text-[#9D9D9D]"><i data-feather="chevron-right"></i></li>
                <li>
                    <a href="<?php echo site_url('web/nonregulations/category/' . $currentgroups) ?>"
                        class="text-white hover:underline">
                        <div class="relative inline-block gap-2">
                            <?php echo $groups[$currentgroups] ?>
                            <span class="absolute -bottom-[15.5px] left-0 w-full h-[8px] bg-white rounded-t-full"></span>
                        </div>
                    </a>
                </li>

            <?php } ?>
        </ol>
    </nav>
</div>

<div class="container mx-auto p-4 laptop:p-8">
    <?php if ($nonregulations) { ?>
        <div class="flex flex-col justify-center items-center">
            <div class="grid laptop:grid-cols-3 gap-4 laptop:gap-8 w-full ">
                <?php foreach ($nonregulations as $nondoc) { ?>
                    <div
                        class="flex flex-col items-start p-4 gap-2 bg-white border border-[#e5af4c] rounded-xl min-h-[120px] shadow-md">
                        <div class="w-full">
                            <div class="flex justify-between items-t gap-2 p-0">
                                <p class="px-2 py-1 bg-[#fff8ec] text-[#D48A00] text-[12px] rounded-md">
                                    <?php echo $nondoc->location; ?>
                                </p>
                                <p class="px-2 py-1 text-[#969696] text-[12px]">
                                    <?php echo $nondoc->assignmentplace ?> |  <?php echo $nondoc->year ?>
                            

                                </p>
                            </div>

                            <div class="flex flex-col p-1 mb-2">
                                <p class="text-[20px] font-medium py-2 text-[#010101] leading-snug ">
                                    <?php echo $nondoc->title ?>
                                </p>


                            </div>
                        </div>

                        <div class="w-full h-px bg-[#E6E3E3] mb-2 mt-auto"></div>

                        <div class="flex items-center justify-between w-full">
                            <div class="text-[12px] text-black flex gap-4">
                                <p class="flex items-center gap-1"><i data-feather="eye" class="h-4 w-4 text-[#CECECE]"></i>
                                    <?= $nondoc->viewed ?>
                                    dibaca</p>
                                <p class="flex items-center gap-1"><i data-feather="download"
                                        class="h-4 w-4 text-[#CECECE]"></i>
                                    <?= $nondoc->downloaded ?> diunduh</p>

                            </div>
                            <a href="<?php echo site_url('web/nonregulations/read/' . $nondoc->groups . '/' . $nondoc->id) ?>"
                                class="bg-[#F1F1F1] text-black rounded-full px-3 py-1 text-[12px] flex items-center gap-1 hover:text-secondary transition">
                                Baca <i data-feather="arrow-right" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>

                <?php } ?>
            </div>
            <?php echo $pagination ?>

        </div>

    <?php } else { ?>
        <div class="col-span-full">
            <div class="px-2 pt-3">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    Tidak dapat menemukan data
                </div>
            </div>
        </div>
    <?php } ?>

</div>
<?php $this->load->view('sidebar') ?>