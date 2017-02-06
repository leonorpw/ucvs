function cps_hide()
{
	var cps_wrapper = document.getElementById('cps_wrapper');
	
	if(cps_wrapper.style.display != "none")
	{
		cps_wrapper.style.display = "none";
	}
}

function cps_show()
{
	var cps_wrapper = document.getElementById('cps_wrapper');
	
	if(cps_wrapper.style.display != "inline")
	{
		cps_wrapper.style.display = "inline";
	}
}