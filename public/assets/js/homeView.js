function handleFormSubmit(event) {
	event.preventDefault(); // This will prevent the default form submission

	// Get the form elements
	var advertiserIdElement = document.getElementById("advertiser_id");
	var dateRangeElement = document.getElementById("date_range");

	// Get the form values
	var advertiserId = advertiserIdElement.value;
	var dateRange = dateRangeElement.value;

	// Prepare the data to be sent
	var data = {
		advertiser_id: advertiserId,
	};

	// If dateRange is not null, split it and add start_date and end_date to the data
	if (dateRange) {
		var dates = dateRange.split("-");
		data["start_date"] = dates[0].trim();
		data["end_date"] = dates[1].trim();
	}

	// Do the form submission here with the data
	fetch("ads", {
		method: "POST",
		headers: {
			"Content-Type": "application/json",
		},
		body: JSON.stringify(data),
	})
		.then(response => response.json())
		.then(data => {
			console.log("Success:", data);
		})
		.catch(error => {
			console.error("Error:", error);
		});
}
