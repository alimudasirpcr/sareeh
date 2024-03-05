<?php
$pie_data = array();

$threshold = 0.01;
$colors = get_template_colors();

$total = 0;
foreach($data as $value)
{
	$total +=$value;	
}

$k=0;

$threshold_combined = 0;
$labels = array_keys($data);
$dataset = array();
$pallet = array();
foreach($data as $label=>$value)
{
	$dataset[] = (float)$value;
	$pallet[] = isset($colors[$k]) ? $colors[$k] : $colors[rand(0, count($colors) -1) ];
	$k++;
}

foreach($data as $label=>$value)
{
	if ($value/$total > $threshold)
	{
		$pie_data[] = array('color' => isset($colors[$k]) ? $colors[$k] : $colors[rand(0, count($colors) -1) ] , 'value' => (float)$value, 'label' => (string)$label);
		$k++;
	}
	else
	{
		$threshold_combined+=$value;
	}
}

if ($threshold_combined)
{
	$pie_data[] = array('value' => (float)$threshold_combined, 'label' => lang('reports_other'), 'color' => '#000000');
}
?>
console.log("pie",<?php echo json_encode($data); ?>);

var element = document.getElementById('chart');


colorPalette =  
                                [
                                    '#00E396' , '#00E396' , '#FEB019', "#FF0000", "#00FF00", "#0000FF", "#FFFF00", "#FF00FF","#00FFFF", "#FF4500", "#FF8C00", "#FFD700", "#ADFF2F","#32CD32", "#00FF7F", "#00FA9A", "#008B8B", "#000080","#4B0082", "#9400D3", "#8A2BE2", "#800080", "#7B68EE","#483D8B", "#000000", "#FFFFFF", "#FFA07A", "#FA8072","#E9967A", "#F08080", "#CD5C5C", "#DC143C", "#B22222","#FF6347", "#FF4500", "#FFD700", "#FF8C00", "#FFA500","#DAA520", "#B8860B", "#A52A2A", "#800000", "#808080","#696969", "#708090", "#2F4F4F", "#008080", "#006400","#556B2F", "#228B22", "#008000", "#32CD32", "#00FF00"
                                ];
var options = {
          series:<?php echo json_encode($dataset);?>,
          chart: {
          width: 580,
          type: 'pie',
        },
        labels: <?php echo json_encode($labels); ?>,
		colors: <?php echo json_encode($pallet); ?>,
        responsive: [{ 
          breakpoint: 480,
          options: {
            chart: {
              width: 200
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
        };



var chart = new ApexCharts(element, options);
chart.render();



