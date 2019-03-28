<main role="main" class="container" id="content_product_bekijken">
    <div class="row agricon-content-title">
        <h3 style="position: relative"><?php echo $title; ?></h3>

        <div id="agricon_alert_container">
            <div class="alert agricon-alert alert-dismissible fade <?php echo $alert->class ?>" role="alert">
                <?php echo $alert->message ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="container">
            <div class="card">
                <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body agricon-card-body-table">
                        <div class="row" style="margin-bottom: 25px">
                            <div class="col-6 agricon-wijzigbestaande-zoekveld">
                                <?php echo form_input(array('name' => 'zoekcode', 'id' => 'zoekcode', 'class' => 'form-control', 'placeholder' => '- Zoek op artikelcode -', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = '- Zoek op artikelcode-'"), $zoeknaam_product_bekijkenviacode_value); ?>
                            </div>
                            <div class="col-6 agricon-wijzigbestaande-zoekveld" style="margin-left:-15px ">
                                <?php echo form_input(array('name' => 'zoeknaam', 'id' => 'zoeknaam', 'class' => 'form-control', 'placeholder' => '- Zoek op naam-', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = '- Zoek op naam -'"), $zoeknaam_product_bekijken_value); ?>
                            </div>
                        </div>
                        <section id="resultaat"></section>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="productBerekeningModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Terug</button>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    // AJAX ----------------------------------------------------------------------------------------------------------
    function ajax_getCalulationMessage_product(productnaam, productid, productiekostid) {
        jQuery.ajax({
            type: "POST",
            url: site_url + "/home/ajax_getCalulationMessage_product",
            data: {
                productnaam: productnaam,
                productid: productid,
                productiekostid: productiekostid
            },
            success: function (result) {
                $('#productBerekeningModal h5.modal-title').html(productnaam);
                $('#productBerekeningModal div.modal-body').html(result);
                $('#productBerekeningModal').modal('show');
            },
            error: function (xhr, status, error) {
//                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }

    function get_byZoekFunctie(deelvannaam, codeofnaam) {
        $.ajax({
            type: "POST",
            url: site_url + "/home/ajax_get_by_zoekfunctie",
            data: {
                zoeknaam: deelvannaam,
                codeofnaam: codeofnaam
            },
            success: function (result) {
                $("#resultaat").html(result);
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText + error);
            }
        });
    }

    function formListener_zoekOpNaamOfCode() {
        $("#zoekcode").keyup(function () {
            $("#zoeknaam").val('');
            var deelvannaam = $(this).val();
            get_byZoekFunctie(deelvannaam, "code");
        });
        $("#zoeknaam").keyup(function () {
            $("#zoekcode").val('');
            var deelvannaam = $(this).val();
            get_byZoekFunctie(deelvannaam, "naam");
        });
    }

    function ajaxTable_show_berekeningenListener() {
        $('div.trigger-show-berekeningen').click(function (e) {
            var productId = $(this).data('productid');
            var productieKostId = $(this).data('productiekostid');
            var productNaam = $(this).data('productnaam');
            ajax_getCalulationMessage_product(productNaam, productId, productieKostId);
        });
    }

    function ajaxTable_show_grondstoffenListener() {
        $('div.trigger-show-grondstoffen').click(function (e) {
            e.stopImmediatePropagation();
            var productid = $(this).data('productid');
            var productnaam = $(this).data('productnaam');
            window.location.href = site_url + "/home/product_grondstoffenBekijken/" + productid;
        });
    }

    function ajaxTable_show_productiekostenListener() {
        $('div.trigger-show-productiekosten').click(function (e) {
            e.stopImmediatePropagation();
            var productid = $(this).data('productid');
            var productnaam = $(this).data('productnaam');
            window.location.href = site_url + "/home/product_productiekostenBekijken/" + productid;

        });
    }

    $(document).ready(function () {
        //eerste producten al ophalen (zoekopdrachten (op naam of code) wordt geset in session)
        var zoeknaam = $("#zoeknaam").val();
        var zoekcode = $("#zoekcode").val();
        if (zoeknaam == '' && zoekcode == '') {
            get_byZoekFunctie('', "alles");
        } else {
            if (zoeknaam != '') {
                get_byZoekFunctie($("#zoeknaam").val(), "naam");
            }
            if (zoekcode != '') {
                get_byZoekFunctie($("#zoeknaam").val(), "code");
            }
        }
        formListener_zoekOpNaamOfCode();
    });

    $(document).ajaxComplete(function () {
        ajaxTable_show_berekeningenListener();
        ajaxTable_show_productiekostenListener();
        ajaxTable_show_grondstoffenListener();
    });
</script>
