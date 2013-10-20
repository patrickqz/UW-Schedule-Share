(function() {
	var counter = 1;
	window.onload = function() {
		$('#add').click(addThings);
	};
	
	function addThings() {
		counter++;
		var div = $('<div/>', {
						id: 'class' + counter
					});
		div.append('<p>Class' + counter + '</p>');
		div.append('Department: <input type="text" name="department' + counter + '"><br />');
		div.append('Coursenumber:<input type="text" name="coursenumber' + counter + '"/><br />');
		div.append('Section:<input type="text" name="section' + counter + '"/><br />');
		$('#classes').append(div);
		$('#count').attr('value', counter);
	}
}());