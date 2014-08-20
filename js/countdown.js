jQuery(document).ready(function () {
	$("[data-countdown]").each(function() {
		var $this = $(this);
		$this.countdown($this.data("countdown"), function(event)
		{
			if (event.offset.totalDays == 0)
				str = "%H:%M:%S";
			else
				str = "%-D "+declination("дней", "день", "дня", event.offset.totalDays)+" %H:%M:%S";

			$this.html(event.strftime(str));
		});
	});
});

function declination(a, b, c, s)
{
	var words = [a, b, c];
	var days = s % 100;

	if (days >=11 && days <= 14)
		days = 0;
	else
		days = (days %= 10) < 5 ? (days > 2 ? 2 : days): 0;

	return(words[days]);
}