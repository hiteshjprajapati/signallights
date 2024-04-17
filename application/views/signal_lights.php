<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Signal Lights</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<style>
		.signal
		{
			width: 100px;
			height: 100px;
			border-radius: 50%;
			background-color: red;
			margin: 20px;
			display: inline-flex;
			justify-content: center;
            align-items: center;
            color: white;
            font-size: 24px;
		}
	</style>
</head>
<body>
	<div class="container">
		<div id="signals" class="text-center">
			<div id="signal-A" class="signal">A</div>
			<div id="signal-B" class="signal">B</div>
			<div id="signal-C" class="signal">C</div>
			<div id="signal-D" class="signal">D</div>
		</div>
		<label for="greenInterval">Sequence (A,B,C,D):</label>
		<div class="row">
			<div class="form-group col-md-3">
				<input type="text" id="sequencea" class="form-control" placeholder="First" value="<?= !empty($last_record['seqa']) ? $last_record['seqa'] : '' ?>">
			</div>
			<div class="form-group col-md-3">
				<input type="text" id="sequenceb" class="form-control" placeholder="Second" value="<?= !empty($last_record['seqb']) ? $last_record['seqb'] : '' ?>">
			</div>
			<div class="form-group col-md-3">
				<input type="text" id="sequencec" class="form-control" placeholder="Third" value="<?= !empty($last_record['seqc']) ? $last_record['seqc'] : '' ?>">
			</div>
			<div class="form-group col-md-3">
				<input type="text" id="sequenced" class="form-control" placeholder="Fourth" value="<?= !empty($last_record['seqd']) ? $last_record['seqd'] : '' ?>">
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6">
				<label for="greenInterval">Green Interval (seconds):</label>
				<input type="number" id="greenInterval" class="form-control" placeholder="ex. 6" value="<?= !empty($last_record['green_interval']) ? $last_record['green_interval'] : '' ?>">
			</div>
			<div class="form-group col-md-6">
				<label for="yellowInterval">Yellow Interval (seconds):</label>
				<input type="number" id="yellowInterval" class="form-control" placeholder="ex. 2" value="<?= !empty($last_record['yellow_interval']) ? $last_record['yellow_interval'] : '' ?>">
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 text-center">
				<button id="startBtn" class="btn btn-primary btn-block">Start</button>
			</div>
			<div class="col-md-6 text-center">
				<button id="stopBtn" class="btn btn-danger btn-block" disabled>Stop</button>
			</div>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script>
		$(document).ready(function() {
			var sequence = [];
			var greenInterval = 0;
			var yellowInterval = 0;
			var currentIndex = 0;
			var timeouts = [];
			$("#startBtn").click(function() {
				// Get user inputs
				var sequenceA = $("#sequencea").val().toUpperCase();
				var sequenceB = $("#sequenceb").val().toUpperCase();
				var sequenceC = $("#sequencec").val().toUpperCase();
				var sequenceD = $("#sequenced").val().toUpperCase();
				var greenIntervalInput = parseInt($("#greenInterval").val());
				var yellowIntervalInput = parseInt($("#yellowInterval").val());

				// Validate inputs
				if (sequenceA === '' || sequenceB === '' || sequenceC === '' || sequenceD === '') {
					alert("All sequence fields are required.");
					return;
				}
				if (!/^[ABCD]+$/.test(sequenceA + sequenceB + sequenceC + sequenceD)) {
					alert("Sequence should only contain letters A, B, C, and D.");
					return;
				}
				if (hasDuplicates(sequenceA + sequenceB + sequenceC + sequenceD)) {
					alert("Sequence should not contain repeated letters.");
					return;
				}
				if (isNaN(greenIntervalInput) || isNaN(yellowIntervalInput) || greenIntervalInput <= 0 || yellowIntervalInput <= 0) {
					alert("Green interval and yellow interval must be positive numbers.");
					return;
				}
				
				// Store validated inputs
				sequence = [sequenceA, sequenceB, sequenceC, sequenceD];
				greenInterval = greenIntervalInput * 1000;
				yellowInterval = yellowIntervalInput * 1000;
				currentIndex = 0;						
				$("#startBtn").prop("disabled", true);
				$("#stopBtn").prop("disabled", false);
				$.ajax({
					url: '<?php echo base_url("SignalLights/save_settings"); ?>',
					type: 'POST',
					data: {
						seqa: sequenceA,
						seqb: sequenceB,
						seqc: sequenceC,
						seqd: sequenceD,
						greenInterval: greenIntervalInput,
						yellowInterval: yellowIntervalInput
					},
					success: function(response) {
						var data = JSON.parse(response);
						if (data.success) {	
							nextSignal();
						} else {
							alert(data.message);
						}
					},
					error: function(xhr, status, error) {
						// Handle error
					}
				});
			});
			function hasDuplicates(str) {
			var letters = {};
			for (var i = 0; i < str.length; i++) {
				var letter = str[i];
				if (letters[letter]) {
					return true; // Found a duplicate
				}
				letters[letter] = true;
			}
			return false;
		}
			$("#stopBtn").click(function() {
				timeouts.forEach(function(timeout) {
					clearTimeout(timeout);
				});
				timeouts = [];				
				resetSignals();				
				$("#startBtn").prop("disabled", false);
				$("#stopBtn").prop("disabled", true);
			});
			function nextSignal() {				
				displaySignal(sequence[currentIndex]);				
				currentIndex = (currentIndex + 1) % sequence.length;				
				var timeout = setTimeout(nextSignal, greenInterval + yellowInterval);
				timeouts.push(timeout);
			}
			function displaySignal(signal) {				
				resetSignals();				
				$("#signal-" + signal).css("background-color", "green");				
				var yellowTimeout = setTimeout(function() {
					$("#signal-" + signal).css("background-color", "yellow");
				}, greenInterval);
				timeouts.push(yellowTimeout);				
				var redTimeout = setTimeout(function() {
					$("#signal-" + signal).css("background-color", "red");
				}, greenInterval + yellowInterval);
				timeouts.push(redTimeout);
			}
			function resetSignals() {
				$(".signal").css("background-color", "red");
			}
		});
	</script>
</body>
</html>