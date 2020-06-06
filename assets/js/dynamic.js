function toggleTheme(isDark){
	if (isDark)
		document.cookie='dark=;expires='+new Date().toUTCString()+";sameSite=none;path=/;Secure";
	else
		document.cookie='dark=;sameSite=none;path=/;Secure';

	location.reload();
}