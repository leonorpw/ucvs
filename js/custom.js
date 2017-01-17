function cps_switch()
{
	var cps_wrapper = document.getElementById('cps_wrapper');
	
	if(cps_wrapper.style.display == "none")
	{
		cps_wrapper.style.display = "inline";
	}
	else
	{
		cps_wrapper.style.display = "none";
	}
}