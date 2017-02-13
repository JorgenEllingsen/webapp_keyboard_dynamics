<?php
require('autoloader.php');
use classes\UserStatistics;

$user = new UserStatistics(1);
$entries = array_reverse($user->getEntries());
?>
<html>
<head>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
</head>
<body>
<div style="text-align: center;"><a href="/"">Back</a></div>
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
        text: 'Typing of `{$entry['string']}` by user {$entry['user']}'
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