<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Google Ads Transparency Explorer</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <!-- JQuery -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script src="assets/js/homeView.js"></script>

</head>

<body>
    <div class="container">
        <h1 class="mt-5">Google Ads Transparency Explorer</h1>

        <form action="ads" method="POST" class="mb-4" autocomplete="off" onsubmit="handleFormSubmit(event)">
            <label for="advertiser_id" class="mr-2">Select Advertiser:</label>
            <select name="advertiser_id" id="advertiser_id">
                <?php $this->showCompetitors() ?>
            </select>

            <label for="date_range" class="mr-2">Select Date Range:</label>
            <input type="text" id="date_range" name="date_range" placeholder="Anytime" autocomplete="none"></input>

            <input type="submit" value="Submit" class="btn btn-primary">
        </form>
    </div>

    <script>
        $(function() {
            $('#date_range').daterangepicker({
                ranges: {
                    'Today': [moment(), moment().add(1, 'days')],
                    'Yesterday': [moment().subtract(1, 'days'), moment()],
                    'Last 7 Days': [moment().subtract(7, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(30, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().add(1, 'days')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month').add(1, 'days')]
                },
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                },
                maxDate: moment().add(1, 'days'),
                alwaysShowCalendars: true
            });

            $('#date_range').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYYMMDD') + '-' + picker.endDate.format('YYYYMMDD'));
            });

            $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>

</body>

</html>