// File: public/js/dashboard-charts.js

// Pastikan script dijalankan setelah halaman dimuat
document.addEventListener("DOMContentLoaded", function () {

    // Cek apakah data dari Laravel tersedia
    if (typeof chartData === 'undefined') {
        console.error("Data chart tidak ditemukan. Pastikan variabel chartData didefinisikan di Blade.");
        return;
    }

    // Set font family standar Bootstrap
    Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#292b2c';

    // --- 1. GRAFIK AREA (TREN PENJUALAN) ---
    var ctxArea = document.getElementById("myAreaChart");
    if (ctxArea) {
        new Chart(ctxArea, {
            type: 'line',
            data: {
                labels: chartData.tglArea, // Ambil dari variabel global
                datasets: [{
                    label: "Pendapatan",
                    lineTension: 0.3,
                    backgroundColor: "rgba(2,117,216,0.2)",
                    borderColor: "rgba(2,117,216,1)",
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(2,117,216,1)",
                    pointBorderColor: "rgba(255,255,255,0.8)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(2,117,216,1)",
                    pointHitRadius: 50,
                    pointBorderWidth: 2,
                    data: chartData.dataArea, // Ambil dari variabel global
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: { unit: 'date' },
                        gridLines: { display: false },
                        ticks: { maxTicksLimit: 7 }
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            maxTicksLimit: 5,
                            callback: function (value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        },
                        gridLines: { color: "rgba(0, 0, 0, .125)" }
                    }],
                },
                legend: { display: false },
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem) {
                            return 'Rp ' + tooltipItem.yLabel.toLocaleString('id-ID');
                        }
                    }
                }
            }
        });
    }

    // --- 2. GRAFIK BAR (PENJUALAN PRODUK) ---
    var ctxBar = document.getElementById("myBarChart");
    if (ctxBar) {
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: chartData.labelBar, // Ambil dari variabel global
                datasets: [{
                    label: "Jumlah Terjual (Qty)",
                    backgroundColor: "rgba(2,117,216,1)",
                    borderColor: "rgba(2,117,216,1)",
                    data: chartData.dataBar, // Ambil dari variabel global
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        gridLines: { display: false },
                        ticks: { maxTicksLimit: 6 }
                    }],
                    yAxes: [{
                        ticks: { min: 0, maxTicksLimit: 5 },
                        gridLines: { display: true }
                    }],
                },
                legend: { display: false }
            }
        });
    }
});