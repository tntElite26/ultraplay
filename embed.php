<!DOCTYPE html>
<html>
<head>
	<title>Archive Advanzado</title>
	<meta name="robots" content="noindex">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
	<script type="text/javascript" src="https://ssl.p.jwpcdn.com/player/v/8.23.1/jwplayer.js"></script>
	<script type="text/javascript">jwplayer.key="XSuP4qMl+9tK17QNb+4+th2Pm9AWgMO/cYH8CI0HGGr7bdjo";</script>
	<style type="text/css" media="screen">html,body{padding:0;margin:0;height:100%}#apicodes-player{width:100%!important;height:100%!important;overflow:hidden;background-color:#000}</style>
</head>
<body>

<?php 
		error_reporting(0);
		
		$data = (isset($_GET['data'])) ? $_GET['data'] : '';

		if ($data != '') {
			
			include_once 'config.php';

			$data = json_decode(decode($data));

			$link = (isset($data->link)) ? $data->link : '';

			$sub = (isset($data->sub)) ? $data->sub : '';

			$poster = (isset($data->poster)) ? $data->poster : '';

			$tracks = '';
			
			foreach ($sub as $key => $value) {
			    $tracks .= '{ 
						        file: "'.$value.'", 
						        label: "'.$key.'",
						        kind: "captions"
							   },';
			}
			
			$domainServer = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']);
      
			$link = $domainServer . '/stream/?data=' . encode($link);
      
			$sources = '[{"label":"HD","type":"mp4","file":"'.$link.'"}]';
			
			$result = '<div id="apicodes-player"></div>';

			$data = 'var player = jwplayer("apicodes-player");
						player.setup({
							sources: '.$sources.',
							aspectratio: "16:9",
							startparam: "start",
							primary: "html5",
							autostart: false,
							preload: "auto",
							image: "'.$poster.'",
							advertising: {
                                client: "vast",
                                tag: ""
                            },
						    captions: {
						        color: "#f3f368",
						        fontSize: 16,
						        backgroundOpacity: 0,
						        fontfamily: "Helvetica",
						        edgeStyle: "raised"
						    },
						    tracks: ['.$tracks.']
						});
			            player.on("setupError", function() {
			              swal("Server Error!", "Please contact us to fix it asap. Thank you!", "error");
			            });
						player.on("error" , function(){
							swal("Server Error!", "Please contact us to fix it asap. Thank you!", "error");
						});';
			
			$packer = new Packer($data, 'Normal', true, false, true);

			$packed = $packer->pack();

			$result .= '<script type="text/javascript">' . $packed . '</script>';

			echo $result;

		} else echo 'Empty link!';
?>

</body>
</html>