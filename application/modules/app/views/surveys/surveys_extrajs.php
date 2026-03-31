<script type="text/javascript">
    function getRandomFloat(min, max, decimals) {
        const str = (Math.random() * (max - min) + min).toFixed(decimals);
        return parseFloat(str);
    }

    const randomRgbaColor = () => {
        const r = Math.floor(Math.random() * 256);
        const g = Math.floor(Math.random() * 256);
        const b = Math.floor(Math.random() * 256);
        return `rgba(${r},${g},${b},${getRandomFloat(0.3, 0.8, 1)})`;
    };

    const values = <?php echo json_encode($surveycount) ?>;

    document.addEventListener("DOMContentLoaded", function () {
        const suka = parseInt(values.suka ?? 0);
        const tidakSuka = parseInt(values.tidakSuka ?? 0);

        const chartDom = document.getElementById('barSurvey');
        const myChart = echarts.init(chartDom);

        // Show loading spinner sebelum chart selesai di-set
        myChart.showLoading({
            text: 'Memuat data survey...',
            color: '#6366f1', // Tailwind indigo-500
            textColor: '#333',
            maskColor: 'rgba(255, 255, 255, 0.8)'
        });

        // Simulasi delay singkat untuk memastikan layout stabil
        setTimeout(() => {
            const option = {
                title: {
                    text: 'Hasil Survey',
                    left: 'center'
                },
                tooltip: {
                    trigger: 'axis',
                    axisPointer: { type: 'shadow' }
                },
                xAxis: {
                    type: 'category',
                    data: ['Suka', 'Tidak Suka'],
                    axisTick: { alignWithLabel: true },
                    axisLabel: { fontWeight: 'bold' }
                },
                yAxis: {
                    type: 'value',
                    minInterval: 1,
                    min: 0
                },
                series: [{
                    name: 'Jumlah Responden',
                    type: 'bar',
                    barWidth: '50%',
                    data: [
                        { value: suka, itemStyle: { color: "#15803d" } },
                        { value: tidakSuka, itemStyle: { color: "#ef4444" } }
                    ],
                    emphasis: {
                        focus: 'series'
                    }
                }]
            };

            myChart.setOption(option);
            myChart.hideLoading(); // Sembunyikan loading

            myChart.resize(); // Pastikan sesuai ukuran container

        }, 300);

        // Resize on window resize
        window.addEventListener('resize', function () {
            setTimeout(() => {
                myChart.resize();
            }, 300);
        });

        // Inisialisasi DataTable setelah plugin dimuat
        loadScript(plugin_path + "datatables/datatables/js/jquery.dataTables.min.js", function () {
            loadScript(plugin_path + "datatables/datatables/js/dataTables.bootstrap.min.js", function () {
                $('#datatable_sample').DataTable({
                    lengthChange: false,
                    searching: false,
                    pageLength: 5,
                    bSortable: true
                });
            });
        });
    });

</script>