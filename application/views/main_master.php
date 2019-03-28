<!doctype html>
<html lang="en">
<head>
    <?php header('Access-Control-Allow-Origin: *'); ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Axel Pauwels">
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>/agriconLeafLogoIcon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Agricon</title>
    <!--CSS-->
    <?php echo stylesheet("bootstrap.css"); ?>
    <?php echo stylesheet("heroic-features.css"); ?>
    <?php echo stylesheet("buttons.css"); ?>
    <?php echo stylesheet("my.css"); ?>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!--    JQUERY SLIM DOESN'T SUPPORT AJAX ($.ajax)-->
    <script
            src="https://code.jquery.com/jquery-3.3.1.js"
            integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
            crossorigin="anonymous">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
            integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
            crossorigin="anonymous"></script>
    <?php echo javascript("bootstrap.min.js"); ?>

    <script>
        function goBack() {
            window.history.back();
        }

        function goBackTwice() {
            window.history.go(-2);
        }

        $(function () {
            // stel de tablesorter in (gebruik ook de juiste klassen in HTML)
            $(".agricon-table").tablesorter({
                dateFormat: "ddmmyyy"
            });
        });

        function tooltipListener() {
            $('[data-toggle="tooltip"]').tooltip();
            // calculationIcon tooltip
            $('.trigger_showCalculation').parent().hover(function () {
                $(this).find('[data-toggle="tooltip"]').tooltip();
            });
        }

        function hideAlert() {
            // wanneer de div in de container de klasse "show" heeft, de container verbergen (anders kan men op die plaats geen form invullen door de z-index)
            if ($("div#agricon_alert_container > div").first().hasClass('show')) {
                $("div#agricon_alert_container").show();
            } else {
                $("div#agricon_alert_container").hide();
            }
        }

        function alertListener() {
            // modal wordt automatisch verborgen in document.ready
            // autoclose alertMessage
            window.setTimeout(function () {
                $("div.alert").alert('close');
            }, 4000);

            // indien zelf gesloten door kruisje of via de autoclose-trigger hierboven
            $('.agricon-alert').on('close.bs.alert', function () {
                $("div#agricon_alert_container").hide();
            });
        }

        function useTableSorter() {
            $(function () {
                // EERST tablesorter disablen bij de eerste th's, deze kan een calculation-icon bevatten om berekeningen te tonen/verbergen
                $("table thead th:first-of-type").data("sorter", false);

                // stel de tablesorter in (gebruik ook de juiste klassen in HTML)
                $(".agricon-table").tablesorter({
                    dateFormat: "ddmmyyy" // set the default date format
//                    ,
//                theme: 'blue',
//                // or to change the format for specific columns, add the dateFormat to the headers option:
//                  headers: {
//                  3: { sorter: "shortDate"}, // dateFormat will parsed as the default above
//                  3: { sorter: "shortDate", dateFormat: "ddmmyyyy" }, // set day first format; set using class names
//                  5: { sorter: "shortDate", dateFormat: "ddmmyyyy" } // set day first format; set using class names
//                  6: { sorter: "shortDate", dateFormat: "yyyymmdd" }  // set year first format; set using data attributes (jQuery data)
//                }
                });
            });
        }

        function navigationDropdownListener() {
            $('.dropdown-menu a.dropdown-toggle').on('click', function (e) {
                if (!$(this).next().hasClass('show')) {
                    $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
                }
                var $subMenu = $(this).next(".dropdown-menu");
                $subMenu.toggleClass('show');

                $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function (e) {
                    $('.dropdown-submenu .show').removeClass("show");
                });
                return false;
            });
        }

        function showCalculationListener() {
            // SHOW CALCULATION TRIGGER-LISTENER
            $('.trigger_showCalculation').parent().click(function (e) {
                $(this).toggleClass("set-color-red");
                $("#cal_kostperjaar").toggleClass("agricon-hide-this");

//                als de hoogte groter is dan 145px(omdat de css min-height:145px heeft), het resize-icoon verbergen
                var divHeight = $('.agricon-calculation-message-container').height();
                if (divHeight <= 145) {
                    $('span#bekijkGrootOfKlein').hide();
                } else {
                    $('span#bekijkGrootOfKlein').show();
                }
            });
        }

        function calculationMessage_ResizeListener() {
            $('.agricon-calculation-message-container').on('click', 'span#bekijkGrootOfKlein', function () {
                var parentDiv = $(this).parent().parent();
                parentDiv.toggleClass('agricon-c-m-c-large');
                parentDiv.toggleClass('agricon-c-m-c-default');

                if (parentDiv.hasClass('agricon-c-m-c-large')) {
                    $(this).find('#inner-span').text(' Verklein');
                } else {
                    $(this).find('#inner-span').text(' Vergroot');
                }
            });
        }
        function calculationMessage_CloseListener() {
            $('.agricon-calculation-message-container').on('click', 'span#closeThis', function () {
                $("table").find('.trigger_showCalculation').click();
            });
        }

        $(document).ready(function () {
            navigationDropdownListener();
            tooltipListener();
            showCalculationListener();
            hideAlert();
            alertListener();
        });

        $(document).ajaxComplete(function () {
            tooltipListener();
            showCalculationListener();
            useTableSorter();
            calculationMessage_ResizeListener();
            calculationMessage_CloseListener();
        });
    </script>
</head>


<body>
<?php
echo $myHeader;
echo $myContent;
echo $myFooter;
?>


<!--JS-->
<!--<script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js"-->
<!--        integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+"-->
<!--        crossorigin="anonymous"></script>-->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css"
      integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.30.1/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript">
    var site_url = '<?php echo site_url(); ?>';
    var base_url = '<?php echo base_url(); ?>';
</script>
</body>
</html>
