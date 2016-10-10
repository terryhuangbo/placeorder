var sceond = 5;
setInterval(function () {
	if(sceond<=1){
		window.location.href = "http://rc.vsochina.com/";
	}else{
		sceond --;
		document.getElementById("red-sceond").innerText = sceond+" ";
	}
	
},1000);