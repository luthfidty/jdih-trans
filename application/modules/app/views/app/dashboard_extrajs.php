<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"></script>
<script type="text/javascript">

    moment.locale('id'); // bahasa Indonesia
    document.addEventListener('DOMContentLoaded', function () {
        // Inisialisasi chart & show loading
        const chart1 = echarts.init(document.getElementById('barNumDocsYears'));
        chart1.showLoading();

        const chart2 = echarts.init(document.getElementById('barNumDocsCat'));
        chart2.showLoading();

        const donutChart = echarts.init(document.getElementById('graph-donut'));
        donutChart.showLoading();

        const chartVisitor = echarts.init(document.getElementById('graph-non-date'));
        chartVisitor.showLoading();

        // Simulasi proses loading (300ms)
        setTimeout(() => {
            // Dokumen Tahunan
            const yearlyDocsData = <?php echo json_encode($yearlydocs) ?>;
            const yearLabels = yearlyDocsData.map(d => d.years);
            const yearValues = yearlyDocsData.map(d => d.numdocs);
            chart1.setOption({
                title: { text: 'Dokumen Per Tahun', left: 'center' },
                tooltip: { trigger: 'axis' },
                xAxis: { type: 'category', data: yearLabels },
                yAxis: { type: 'value' },
                series: [{
                    data: yearValues,
                    type: 'bar',
                    itemStyle: { color: '#3b82f6' }
                }]
            });
            chart1.hideLoading();

            // Dokumen Per Kategori
            const catData = <?php echo json_encode($numdocscat) ?>;
            const catLabels = catData.map(d => d.acronym);
            const catValues = catData.map(d => d.numdocs);
            chart2.setOption({
                title: { text: 'Dokumen Per Kategori', left: 'center' },
                tooltip: { trigger: 'axis' },
                xAxis: { type: 'value' },
                yAxis: { type: 'category', data: catLabels },
                series: [{
                    data: catValues,
                    type: 'bar',
                    itemStyle: { color: '#10b981' }
                }]
            });
            chart2.hideLoading();

            const suka = <?php echo (int) $survey->suka ?>;
            const tidakSuka = <?php echo (int) $survey->tidakSuka ?>;
            const total = suka + tidakSuka || 1;

            // helper: buat variasi ringan pada lightness berdasarkan proporsi
            function shadeColor(hue, ratio) {
                // ratio di [0,1]; kita geser lightness +-10% dari 50%
                const lightness = 50 - Math.round((0.5 - ratio) * 20);
                return `hsl(${hue}, 70%, ${lightness}%)`;
            }

            // kalau salah satu nilainya nol, pakai abu-abu for that slice
            const sukaColor = '#15803d'; // hijau
            const tidakSukaColor =  '#ef4444'; // merah

            const donutData = [
                {
                    value: suka,
                    name: 'Suka',
                    itemStyle: { color: sukaColor }
                },
                {
                    value: tidakSuka,
                    name: 'Tidak Suka',
                    itemStyle: { color: tidakSukaColor }
                }
            ];

            donutChart.setOption({
                title: { text: 'Survey Kepuasan', left: 'center' },
                tooltip: { trigger: 'item' },
                legend: { bottom: 5 },
                series: [{
                    name: 'Responden',
                    type: 'pie',
                    radius: ['40%', '70%'],
                    avoidLabelOverlap: false,
                    data: donutData,
                    label: {
                        formatter: '{b}',
                        position: 'outside'
                    }
                }]
            });
            donutChart.hideLoading();


            // Grafik Pengunjung
            const visitorData = <?php echo json_encode($dvisitor) ?>;

            // X Axis labels
            const dates = visitorData.map(d => {
                const isToday = moment(d.visitdate).isSame(moment(), 'day');
                const label = moment(d.visitdate).format('dddd, D');
                return isToday ? `${label} 🔸` : label;
            });

            const values = visitorData.map(d => d.count);

            // Ambil info untuk subjudul (minggu ke-berapa, bulan, tahun)
            const currentMoment = moment();
            const monthYear = currentMoment.format('MMMM YYYY');
            const weekOfMonth = Math.ceil(currentMoment.date() / 7);
            const weekLabel = `Minggu ke-${weekOfMonth}, ${monthYear}`;

            // Set chart
            chartVisitor.setOption({
                title: {
                    text: 'Pengunjung Harian',
                    left: 'center',
                    subtext: weekLabel,
                    top: 0,
                    textStyle: {
                        fontSize: 18,
                        fontWeight: 600
                    },
                    subtextStyle: {
                        fontSize: 13,
                        color: '#64748b' // Tailwind slate-500
                    }
                },
                tooltip: {
                    trigger: 'axis',
                    formatter: function (params) {
                        const index = params[0].dataIndex;
                        const date = visitorData[index].visitdate;
                        const count = params[0].value;
                        const mDate = moment(date);
                        const formattedDate = mDate.format('dddd, D MMMM YYYY');
                        const isToday = mDate.isSame(moment(), 'day');
                        const labelToday = isToday ? ' <span class="text-xs text-green-600">(Hari Ini)</span>' : '';

                        return `
                <div class="text-primary space-y-1">
                    <div class="text-sm font-semibold text-secondary">
                        ${formattedDate}${labelToday}
                    </div>
                    <div class="text-sm">👥 <span class="font-medium">${count}</span> pengunjung</div>
                </div>
            `;
                    }
                },
                xAxis: {
                    type: 'category',
                    data: dates
                },
                yAxis: { type: 'value' },
                series: [{
                    data: values,
                    type: 'line',
                    smooth: true,
                    lineStyle: { color: '#f59e0b' }
                }]
            });


            chartVisitor.hideLoading();



            // Resize semua chart
            chart1.resize();
            chart2.resize();
            donutChart.resize();
            chartVisitor.resize();
        }, 300);

        // Responsive resize
        window.addEventListener('resize', function () {
            setTimeout(() => {
                chart1.resize();
                chart2.resize();
                donutChart.resize();
                chartVisitor.resize();
            }, 300);
        });
    });

</script>


<!-- <script type="text/javascript">

    function getRandomFloat(min, max, decimals) {
        const str = (Math.random() * (max - min) + min).toFixed(
                decimals,
                );

        return parseFloat(str);
    }

    const randomRgbColor = () => {
        let r = Math.floor(Math.random() * 256); // Random between 0-255
        let g = Math.floor(Math.random() * 256); // Random between 0-255
        let b = Math.floor(Math.random() * 256); // Random between 0-255
        return 'rgb(' + r + ',' + g + ',' + b + ',' + getRandomFloat(0, 1, 1) + ')';
    };


    loadScript(plugin_path + 'chart.chartjs/Chart.min.js', function () {

        //Dokumen Peraturan
        let data =<?php echo json_encode($yearlydocs) ?>;
        let years = [];
        let values = [];
        for (let i = 0; i < data.length; i++) {
            years.push(data[i].years);
            values.push(data[i].numdocs);
        }
        ;

        var barNumDocsYears = {
            labels: years,
            datasets: [
                {
                    fillColor: randomRgbColor(),
                    strokeColor: "rgba(220,220,220,0.8)",
                    highlightFill: randomRgbColor(),
                    highlightStroke: "rgba(220,220,220,1)",
                    data: values
                }
            ]
        };

        var ctx = document.getElementById("barNumDocsYears").getContext("2d");
        new Chart(ctx).Bar(barNumDocsYears);

        let data2 = <?php echo json_encode($numdocscat) ?>;

        let cats = [];
        let catval = [];
        for (let i = 0; i < data2.length; i++) {
            cats.push(data2[i].acronym);
            catval.push(data2[i].numdocs);
        }

        var barNumDocsCat = {
            labels: cats,
            datasets: [
                {
                    fillColor: randomRgbColor(),
                    strokeColor: "rgba(220,220,220,0.8)",
                    highlightFill: randomRgbColor(),
                    highlightStroke: "rgba(220,220,220,1)",
                    data: catval
                }
            ]
        };

        var ctx = document.getElementById("barNumDocsCat").getContext("2d");
        new Chart(ctx).Bar(barNumDocsCat);

    });

    loadScript(plugin_path + "raphael-min.js", function () {
        loadScript(plugin_path + "chart.morris/morris.min.js", function () {

            //survey
            if (jQuery('#graph-donut').length > 0) {
                Morris.Donut({
                    element: 'graph-donut',
                    data: [
                        {value: <?php echo $survey->count_1 ?>, label: 'Sangat Puas', color: randomRgbColor()},
                        {value: <?php echo $survey->count_2 ?>, label: 'Puas', color: randomRgbColor()},
                        {value: <?php echo $survey->count_3 ?>, label: 'Cukup', color: randomRgbColor()},
                        {value: <?php echo $survey->count_4 ?>, label: 'Tidak Puas', color: randomRgbColor()}
                    ]
                });
            }

            //visitor
            if (jQuery('#graph-non-date').length > 0) {
                var day_data = [];
                var visit =<?php echo json_encode($dvisitor) ?>;
                for (let i = 0; i < visit.length; i++) {
                    day_data.push({"elapsed": visit[i].visitdate, "value": visit[i].count});
                }
                console.log(day_data);
                Morris.Line({
                    element: 'graph-non-date',
                    data: day_data,
                    xkey: 'elapsed',
                    ykeys: ['value'],
                    labels: ['Visi'],
                    parseTime: false
                });
            }
        });
    });
</script> -->