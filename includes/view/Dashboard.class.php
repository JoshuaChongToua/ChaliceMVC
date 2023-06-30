<?php

namespace view;

use controller\ImagesProfile as ImageProfileController;
use controller\Images as ImageController;
use controller\News as NewsController;

class Dashboard
{
    public function __construct()
    {
    }

    public function getLandingPage(): string
    {
        $imageProfileController = new ImageProfileController();
        $imageController = new ImageController();
        $newsController = new NewsController();
        $newsData = $newsController->getNewsCountByDate();
        $return = '
        <div class="content-wrap">
            <div class="main">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-title">
                                    <h4>Pie Chart</h4>
                                </div>
                                <div class="flot-container">
                                    <canvas id="camembertChart" ></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-title">
                                    <h4>Nombre de news </h4>
                                </div>
                                <div class="flot-container">
                                    <canvas id="lineChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/admin/includes/assets/js/chart.js"></script>
        <script>
            var ctx = document.getElementById("camembertChart").getContext("2d");
            var camembertChart = new Chart(ctx, {
                type: "pie", 
                data: {
                    labels: ["Upload", "Profile"], 
                    datasets: [{
                        data: [' . $imageController->getCount() . ', ' . $imageProfileController->getCount() . '], 
                        backgroundColor: ["#ff6384", "#ffce56"] 
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        </script>
        <script>
            var ctx = document.getElementById("lineChart").getContext("2d");
            var lineChart = new Chart(ctx, {
                type: "line",
                data: {
                    labels: ' . json_encode($newsData["date"]) . ',
                    datasets: [{
                        label: "Nombre de news créées",
                        data: ' . json_encode($newsData["count"]) . ',
                        backgroundColor: "rgba(75, 192, 192, 0.2)",
                        borderColor: "rgba(75, 192, 192, 1)",
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            precision: 0
                        }
                    }
                }
            });
        </script>
        ';

        return $return;
    }
}
