<?php
require('autoloader.php');
use classes\UserStatistics;

$user = new UserStatistics(1);
$entries = $user->getUserEntries()
?>
<html>
<head>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
</head>
<body>
    <?php
    $scripts = '';
    foreach ($entries as $entry)
    {
        $cats = [];
        $ser = [];
        foreach ($entry['datapoints'] as $datapoint)
        {
            $cats[] = $datapoint['key'];
            $ser[] = "[{$datapoint['down']}, {$datapoint['up']}]";
        }
        $categories = implode("', '", $cats);
        $series = implode(',', $ser);
        echo '<div id="container-'.$entry['id'].'" style="min-width: 310px; height: 400px; margin: 0 auto"></div>';
        $scripts = $scripts."
        Highcharts.chart('container-{$entry['id']}', {

            chart: {
                type: 'columnrange',
                inverted: true,
                animation: false
            },

            title: {
        text: 'Typing of `{$entry['string']}` by user {$entry['user_id']}'
            },

            subtitle: {
        text: 'Typed on keyboard {$entry['keyboard']} using {$entry['browser']}'
            },

            xAxis: {
        categories: ['{$categories}']
            },

            yAxis: {
        title: {
            text: 'Time ( ms )'
                }
    },

            tooltip: {
        valueSuffix: ' ms'
            },

            plotOptions: {
        columnrange: {
            dataLabels: {
                enabled: true,
                        formatter: function () {
                    return this.y + ' ms';
                }
                    }
        }
    },

            legend: {
        enabled: false
            },

            series: [{
        name: 'Press and release time',
                data: [
            {$series}
        ]
            }]

        });";
    }
    ?>
    <script type="application/javascript">
    <?= $scripts ?>
    </script>
</body>
</html>