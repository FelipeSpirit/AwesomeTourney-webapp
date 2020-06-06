var f;
function consultDB(consult){
	return $.ajax({
		type:'post',
		url: consult[0]+'.php',
		data:consult[1],
		error:function(ans){
			f=ans;
			console.log("ERROR");
		}
	});
}

function startTourney(button,id,c){
	button.disabled="true";
	new Promise(function(resolve){
		resolve(function(){
			button.disabled="true";
		});
	}).then(function(){
		if(c===undefined)
			c='';

		$.ajax({
			type:'post',
			url: c + 'start_tourney.php',
			data:'id='+id
		}).then(function(ans){
			if(ans=='OK')
				location.href='/tourney?id=' + id;
		});
	});
	
}