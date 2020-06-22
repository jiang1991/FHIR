$(document).ready(function(){
	
	var q_error = $("#q_error");
	var q_result = $('#q_result');

	q_error.hide();
	q_result.hide();

	$("#sn_query").click(function(){
		var device = $("#query_device").find("option:selected").text().toLowerCase();

		var sn = $("#query_sn").val();
		q_error.hide();
		q_result.hide();


		if (sn < 1000000000 || sn > 9999999999) {
			q_error.text("invilid SN: " + sn);
			q_error.show();
			return false;
		}

		var p_json = {
			'deviceName': device,
			'sn': sn
		};

		$.ajax({
			type: 'post',
			url: '/update/o2s/query',
			data: JSON.stringify(p_json),
			dataType: 'json',
			success: function(data) {
				// console.log(data);
				q_result.text("btlVersion: " + data.Bootloader.version + " appVersion: " + data.Firmware.version);
				q_result.show();
			},
			error: function() {
				q_error.text("network error!");
				q_error.show();
			},
		});

	});
})