<?php
// contoh di controller/view tertentu
$this->load->view('base/headercontent'); // atau: include APPPATH.'views/includes/header.php';
?>
<!-- /Page Title -->


<div id="content" class="p-5 bg-gray-100 min-h-screen fade-in">
  <div class="bg-white shadow-2xl rounded-xl">
    <div class="bg-secondary text-white px-6 py-3 rounded-t-xl flex items-center">
      <div class="text-lg font-semibold">Survey</div>
    </div>
    <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-6">

      <!-- Chart panel -->
      <div class="border border-blue-200 rounded-xl overflow-hidden">
        <div class="text-gray-700 px-6 py-3 rounded-t-xl font-semibold">Hasil
          Survey</div>
        <div class="p-6">
          <div id="barSurvey" class="w-full h-[500px]"></div>
        </div>
      </div>

      <!-- Data panel -->
      <div class="border border-blue-200 rounded-xl flex flex-col">
        <div
          class="text-gray-700 px-6 py-3 rounded-t-xl flex justify-between items-center font-semibold">
          <div>Data Survey</div>
          <a href="<?php echo site_url('app/surveys/export_surveys') ?>"
            class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg transition duration-300 flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
              </path>
            </svg>
            <span>Export Excel</span>
          </a>
        </div>
        <div class="p-6 overflow-auto flex-grow">

          <table id="surveyTable" class="w-full table-auto border-collapse">
            <thead>
              <tr class="bg-gray-50 text-left text-sm text-gray-700">
                <th class="border border-gray-200 px-4 py-2">IP Address</th>
                <th class="border border-gray-200 px-4 py-2">Nilai</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($survey)) {
                foreach ($survey as $s) {
                  echo '<tr class="hover:bg-blue-50 transition duration-200 text-sm text-gray-900">
                    <td class="border border-gray-200 px-4 py-2">' . $s->ipaddress . '</td>
                    <td class="border border-gray-200 px-4 py-2">' . $svaluetext[$s->svalue] . '</td>
                  </tr>';
                }
              } ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</div>