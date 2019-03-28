<main role="main" class="container" id="content_kost_gebouwen_beheren">
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
            <div id="accordion">
                <div class="card agricon-card-firstaccordioncard">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link " data-toggle="collapse" data-target="#collapseOne"
                                    aria-expanded="true" aria-controls="collapseOne">
                                NIEUW
                            </button>
                        </h5>
                    </div>
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <?php
                            $dataOpen = array(
                                'id' => 'form_kost_gebouwen_beheren',
                                'name' => 'form_kost_gebouwen_beheren',
                                'data-toggle' => 'validator',
                                'role' => 'form');

                            $dataSubmit = array(
                                'id' => 'submit_kost_gebouwen_beheren',
                                'name' => 'submit_kost_gebouwen_beheren',
                                'type' => 'submit',
                                'value' => 'Opslaan',
                                'class' => 'btn btn-outline-success agricon-formsubmit-button');
                            ?>
                            <?php echo form_open('kost_gebouwen/insert', $dataOpen); ?>

                            <section>
                                <div class="form-row">
                                    <label for="kost_gebouwen_naam" class="form-text text-muted">Naam *</label>
                                    <?php echo form_input('kost_gebouwen_naam', '', 'autofocus id="kost_gebouwen_naam" class="form-control" 
                                    type="text" required="required" placeholder="bv Blok 3, Opslagplaats 2" aria-label="kost gebouwen naam"'); ?>
                                </div>
                                <div class="form-row">
                                    <label for="kost_gebouwen_aankoopPrijs"
                                           class="form-text text-muted">Aankoopprijs *</label>
                                    <?php echo form_input('kost_gebouwen_aankoopPrijs', '', 'autofocus id="kost_gebouwen_aankoopPrijs" class="form-control" 
                                    type="number" step="0.01" pattern="' . customDecimalNumberPattern() . '" title="' . customDecimalNumberPatternMessage() . '" required="required" aria-label="kost gebouwen aankoopprijs"'); ?>
                                </div>
                                <div class="form-row">
                                    <label for="kost_gebouwen_afschrijfperiodePerJaar" class="form-text text-muted">Afschrijfperiode
                                        (aantal jaar) *</label>
                                    <?php echo form_input('kost_gebouwen_afschrijfperiodePerJaar', '', 'id="kost_gebouwen_afschrijfperiodePerJaar" type="number" 
                         step="0.01" pattern="' . customDecimalNumberPattern() . '" title="' . customDecimalNumberPatternMessage() . '" class="form-control" required="required" '); ?>
                                </div>


                                <div class="form-row agricon-formsubmit-container">
                                    <?php
                                    echo form_submit($dataSubmit);
                                    ?>
                                </div>
                            </section>

                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo"
                                    aria-expanded="false" aria-controls="collapseTwo">
                                BESTAANDE WIJZIGEN
                            </button>
                        </h5>
                    </div>
                    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body agricon-card-body-table">
                            <div class="form-group agricon-wijzigbestaande-zoekveld">
                                <?php echo form_input(array('name' => 'zoeknaam', 'id' => 'zoeknaam', 'class' => 'form-control', 'placeholder' => '- Zoek -', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = '- Zoek -'"), $zoeknaam_kost_gebouwen_value); ?>
                            </div>
                            <section id="resultaat" style="position: relative">

                            </section>
                        </div>
                    </div>
                </div>

                <section>
                    <div hidden>
                        <?php
                        $dataOpen = array(
                            'id' => 'form_kost_gebouwen_update',
                            'name' => 'form_kost_gebouwen_update',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_kost_gebouwen_update',
                            'name' => 'submit_kost_gebouwen_update',
                            'type' => 'submit');

                        echo form_open('kost_gebouwen/update', $dataOpen);
                        echo form_input('kost_gebouwen_id_update', '', 'id="kost_gebouwen_id_update" class="form-control" required="required" aria-label="kost gebouwen id"');
                        echo form_input('kost_gebouwen_naam_update', '', 'id="kost_gebouwen_naam_update" class="form-control" required="required" aria-label="kost gebouwen naam"');
                        echo form_input('kost_gebouwen_aankoopPrijs_update', '', 'id="kost_gebouwen_aankoopPrijs_update" type="number" step="0.01" class="form-control" aria-label="kost gebouwen aankoopprijs" required="required"');
                        echo form_input('kost_gebouwen_afschrijfperiodePerJaar_update', '', 'id="kost_gebouwen_afschrijfperiodePerJaar_update" type="number" step="0.01" class="form-control" aria-label="kost gebouwen afschrijfperiode per jaar" required="required"');
                        echo form_submit($dataSubmit);
                        echo form_close();
                        ?>
                    </div>
                    <div hidden>
                        <?php
                        $dataOpen = array(
                            'id' => 'form_kost_gebouwen_delete',
                            'name' => 'form_kost_gebouwen_delete',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_kost_gebouwen_delete',
                            'name' => 'submit_kost_gebouwen_delete',
                            'type' => 'submit');

                        echo form_open('kost_gebouwen/delete', $dataOpen);
                        echo form_input('kost_gebouwen_id_delete', '', 'id="kost_gebouwen_id_delete" class="form-control" required="required" aria-label="kost gebouwen id"');
                        echo form_input('kost_gebouwen_naam_delete', '', 'id="kost_gebouwen_naam_delete" class="form-control" required="required" aria-label="kost gebouwen naam"');

                        //                        echo form_input('kost_gebouwen_aankoopPrijs_delete', '', 'id="kost_gebouwen_aankoopPrijs_delete" type="number" step="0.01" class="form-control" aria-label="kost gebouwen aankoopPrijs" required="required"');
                        //                        echo form_input('kost_gebouwen_afschrijfperiodePerJaar_delete', '', 'id="kost_gebouwen_afschrijfperiodePerJaar_delete" type="number" step="0.01" class="form-control" aria-label="kost gebouwen afschrijfperiode per jaar" required="required"');

                        echo form_submit($dataSubmit);
                        echo form_close();
                        ?>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <?php createBasicDeleteModal('Waarschuwing',
        'Deze gebouwen kost is gekoppeld aan productiekost.',
        'Deze verwijdering is momenteel nog in ontwikkeling',
        'Wil je deze gebouwen kost verwijderen? ',
        "Verwijder"); ?>

</main>

<script>
    // AJAX
    function ajax_saveToSession(naam, aankoopPrijs, afschrijfperiodePerJaar) {
        jQuery.ajax({
            type: "POST",
            url: site_url + "/kost_gebouwen/ajax_save_to_session",
            data: {
                naam: naam,
                aankoopPrijs: aankoopPrijs,
                afschrijfperiodePerJaar: afschrijfperiodePerJaar
            },
            success: function (result) {
            },
            error: function (xhr, status, error) {
//                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }

    // AJAX TRIGGER (post de form om in session op te slaan)
    function saveToSession() {
        var naam = $("#kost_gebouwen_naam").val();
        var aankoopPrijs = parseFloat($("#kost_gebouwen_aankoopPrijs").val());
        var afschrijfperiodePerJaar = parseFloat($("#kost_gebouwen_afschrijfperiodePerJaar").val());
        ajax_saveToSession(naam, aankoopPrijs, afschrijfperiodePerJaar);
    }


    function get_byZoekFunctie(deelvannaam) {
        $.ajax({
            type: "POST",
            url: site_url + "/kost_gebouwen/ajax_get_by_zoekfunctie",
            data: {
                zoeknaam: deelvannaam
            },
            success: function (result) {
                $("#resultaat").html(result);
            },
            error: function (xhr, status, error) {
//                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText + error);
            }
        });
    }

    function formListener_zoekOpNaam() {
        $("#zoeknaam").keyup(function () {
            var deelvannaam = $(this).val();
            get_byZoekFunctie(deelvannaam);
        });
    }

    function formEditListener_vervangKommasDoorPunt() {
        var controlInput_aankoopPrijs = $("#kost_gebouwen_aankoopPrijs");
        var controlInput_afschrijfperiodePerJaar = $("#kost_gebouwen_afschrijfperiodePerJaar");
        controlInput_aankoopPrijs.add(controlInput_afschrijfperiodePerJaar).keyup(function () {
            var currentValue = $(this).val();
            var correctValue;
            if (currentValue.includes(",")) {
                correctValue = currentValue.replace(",", ".");
                $(this).val(correctValue);
            }
        });
    }

    // ajaxComplete functions ***************************************************************************************

    function ajaxTable_bewerkListener() {
        $(".trigger-bewerkrij").click(function () {
            //controls
            var clickedIconSVG = $(this).find('i');
            var clickedRow = $(this).parent().parent();
            var targetInputField_aankoopNaam = clickedRow.find('input#editableInput_naam');
            var targetInputField_aankoopPrijs = clickedRow.find('input#editableInput_aankoopPrijs');
            var targetInputField_afschrijfperiodePerJaar = clickedRow.find('input#editableInput_afschrijfperiodePerJaar');

            //data
            var kostGebouwenId = $(this).data('id');

            targetInputField_aankoopNaam.toggleClass('agricon-is-editable-input');

            //wanneer het "editable" is -> icoontje veranderen + autofocus op de input + een class toevoegen
            if (targetInputField_aankoopNaam.hasClass('agricon-is-editable-input')) {
                clickedRow.addClass('trGlow');
                targetInputField_aankoopNaam.focus();
                targetInputField_aankoopNaam.removeAttr('readonly');
                targetInputField_aankoopPrijs.removeAttr('readonly');
                targetInputField_afschrijfperiodePerJaar.removeAttr('readonly');

                clickedIconSVG.removeClass('fa-pencil-alt');
                clickedIconSVG.addClass('fa-save');
            } else {
                // anders alles terugzetten + gegevens updaten in de database
                clickedRow.removeClass('trGlow');
                targetInputField_aankoopNaam.attr('readonly', 'readonly');
                targetInputField_aankoopPrijs.attr('readonly', 'readonly');
                targetInputField_afschrijfperiodePerJaar.attr('readonly', 'readonly');

                clickedIconSVG.removeClass('fa-save');
                clickedIconSVG.addClass('fa-pencil-alt');

                //hidden form opvullen
                var kostGebouwenAankoopNaam = targetInputField_aankoopNaam.val();
                var kostGebouwenAankoopPrijs = targetInputField_aankoopPrijs.val();
                var kostGebouwenAfschrijfperiodePerJaar = targetInputField_afschrijfperiodePerJaar.val();
                if (kostGebouwenAankoopNaam != "" && kostGebouwenAankoopNaam != null && kostGebouwenId != 0 && kostGebouwenId != null) {
                    $("#form_kost_gebouwen_update input#kost_gebouwen_id_update").val(kostGebouwenId);
                    $("#form_kost_gebouwen_update input#kost_gebouwen_naam_update").val(kostGebouwenAankoopNaam);
                    $("#form_kost_gebouwen_update input#kost_gebouwen_aankoopPrijs_update").val(kostGebouwenAankoopPrijs);
                    $("#form_kost_gebouwen_update input#kost_gebouwen_afschrijfperiodePerJaar_update").val(kostGebouwenAfschrijfperiodePerJaar);

                    $("#form_kost_gebouwen_update").submit();
                }
            }
        });
    }

    function ajaxTable_bewerkListener_vervangKommasDoorPunt() {
        // kommas vervangen door een punt
        var controlInput_aankoopPrijs = $("#editableInput_aankoopPrijs");
        var controlInput_afschrijfperiodePerJaar = $("#editableInput_afschrijfperiodePerJaar");
        controlInput_aankoopPrijs.add(controlInput_afschrijfperiodePerJaar).keyup(function () {
            var currentValue = $(this).val();
            var correctValue;
            if (currentValue.includes(",")) {
                correctValue = currentValue.replace(",", ".");
                $(this).val(correctValue);
            }
        });
    }

    function ajaxTable_verwijderListener_showModal() {
        $(".agricon-delete-icon").click(function () {
            var kostGebouwenId = $(this).data('id');
            var kostGebouwenAankoopNaam = $(this).data('kostgebouwennaam');
            if (kostGebouwenId != 0 && kostGebouwenId != null) {
                $("#form_kost_gebouwen_delete input#kost_gebouwen_id_delete").val(kostGebouwenId);
                $("#form_kost_gebouwen_delete input#kost_gebouwen_naam_delete").val(kostGebouwenAankoopNaam);
            }
            $('#deleteModal').modal('show');
        });
    }

    function ajaxTable_verwijderModalListener() {
        $('#deleteAllData').click(function (e) {
            $('#deleteModal').modal('hide');
            $("#form_kost_gebouwen_delete").submit();
        });
    }

    $(document).ready(function () {
        get_byZoekFunctie($("#zoeknaam").val());
        formEditListener_vervangKommasDoorPunt();
    });

    $(document).ajaxComplete(function () {
        ajaxTable_bewerkListener_vervangKommasDoorPunt();
        ajaxTable_bewerkListener();
        ajaxTable_verwijderListener_showModal();
        ajaxTable_verwijderModalListener();
    });
</script>
