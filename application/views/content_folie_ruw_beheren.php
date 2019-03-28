<main role="main" class="container" id="content_folie_ruw_beheren">
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
                            <?php
                            if (isset($show_back_button)) {
                                if ($show_back_button) {
                                    echo "<p class='agricon-back-to-page-button'><a href='$redirect_url'><button type='button' class='btn btn-outline-secondary'>Terug</button></a></p>";
                                }
                            }
                            ?>
                        </h5>
                    </div>
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <?php
                            $dataOpen = array(
                                'id' => 'form_folie_ruw_beheren',
                                'name' => 'form_folie_ruw_beheren',
                                'data-toggle' => 'validator',
                                'role' => 'form');

                            $dataSubmit = array(
                                'id' => 'submit_folie_ruw_beheren',
                                'name' => 'submit_folie_ruw_beheren',
                                'type' => 'submit',
                                'value' => 'Opslaan',
                                'class' => 'btn btn-outline-success agricon-formsubmit-button');
                            ?>
                            <?php echo form_open('folie_ruw/insert', $dataOpen); ?>

                            <section>
                                <div class="form-row">
                                    <label for="folie_ruw_naam" class="form-text text-muted">Naam *</label>
                                    <?php echo form_input('folie_ruw_naam', $formData->folie_ruw_naam, 'autofocus id="folie_ruw_naam" class="form-control" required="required" aria-label="folie ruw naam"'); ?>
                                </div>

                                <div class="form-row agricon-formcolumn">
                                    <div class="col-11">
                                        <label for="folie_ruw_leverancierid"
                                               class="form-text text-muted">Leverancier</label>
                                        <?php echo form_dropdown('folie_ruw_leverancierid', $leveranciers_dropdownOptions, $formData->folie_ruw_leverancierid, 'id="folie_ruw_leverancierid" class="form-control" '); ?>
                                    </div>
                                    <div class="col-1">
                                        <?php echo anchor('leverancier/beheren/' . true, '<div class="agricon-fa-icon-plus" data-toggle="tooltip" data-placement="bottom" title="Nieuwe leverancier"><i class="fas fa-plus-circle"></i></div>', 'onclick="saveToSession()"'); ?>
                                    </div>
                                </div>

                                <div class="form-row agricon-formcolumn">
                                    <div class="col-6">
                                        <label for="folie_ruw_lmprijs"
                                               class="form-text text-muted">Prijs / LM *</label>
                                        <?php echo form_input('folie_ruw_lmprijs', $formData->folie_ruw_lmprijs, 'id="folie_ruw_lmprijs" type="number" 
                         step="0.01" pattern="' . customDecimalNumberPattern() . '" title="' . customDecimalNumberPatternMessage() . '" class="form-control" required="required" '); ?>
                                    </div>

                                    <div class="col-6">
                                        <label for="folie_ruw_lmeenheid"
                                               class="form-text text-muted">LM Eenheid *</label>
                                        <?php echo form_input('folie_ruw_lmeenheid', $formData->folie_ruw_lmeenheid, 'id="folie_ruw_lmeenheid" type="number" 
                         step="0.01" pattern="' . customDecimalNumberPattern() . '" title="' . customDecimalNumberPatternMessage() . '" class="form-control" required="required" '); ?>

                                    </div>
                                </div>

                                <div class="form-row">
                                    <label for="folie_ruw_micron" class="form-text text-muted">Micron (dikte) *</label>
                                    <?php echo form_input('folie_ruw_micron', $formData->folie_ruw_micron, 'autofocus id="folie_ruw_micron" type="number" pattern="' . customNumberPattern() . '" title="' . customNumberPatternMessage() . '" 
                                    class="form-control" required="required" placeholder="(bv 80)" aria-label="leverancier naam"'); ?>
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
                                <?php echo form_input(array('name' => 'zoeknaam', 'id' => 'zoeknaam', 'class' => 'form-control', 'placeholder' => '- Zoek -', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = '- Zoek -'"), $zoeknaam_folie_ruw_value); ?>
                            </div>
                            <section id="resultaat">

                            </section>
                        </div>
                    </div>
                </div>
                <section>
                    <div hidden>
                        <?php
                        $dataOpen = array(
                            'id' => 'form_folie_ruw_update',
                            'name' => 'form_folie_ruw_update',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_folie_ruw_update',
                            'name' => 'submit_folie_ruw_update',
                            'type' => 'submit');

                        echo form_open('folie_ruw/update', $dataOpen);
                        echo form_input('folie_ruw_id_update', '', 'id="folie_ruw_id_update" class="form-control" required="required" aria-label="folie ruw id"');
                        echo form_input('folie_ruw_naam_update', '', 'id="folie_ruw_naam_update" type="text" class="form-control" required="required" aria-label="folie ruw naam"');

                        echo form_input('folie_ruw_leverancierid_update', '', 'id="folie_ruw_leverancierid_update" type="number" class="form-control" required="required" aria-label="folie ruw leverancierid"');
                        echo form_input('folie_ruw_lmeenheid_update', '', 'id="folie_ruw_lmeenheid_update" type="number" step="0.01" class="form-control" aria-label="folie ruw lm_eenheid"');
                        echo form_input('folie_ruw_lmprijs_update', '', 'id="folie_ruw_lmprijs_update" type="number" step="0.01" class="form-control" aria-label="folie ruw lm_prijs"');
                        echo form_input('folie_ruw_micron_update', '', 'id="folie_ruw_micron_update" type="number" class="form-control" aria-label="folie ruw micron"');


                        echo form_submit($dataSubmit);
                        echo form_close();
                        ?>
                    </div>
                    <div hidden>
                        <?php
                        $dataOpen = array(
                            'id' => 'form_folie_ruw_delete',
                            'name' => 'form_folie_ruw_delete',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_folie_ruw_delete',
                            'name' => 'submit_folie_ruw_delete',
                            'type' => 'submit');

                        echo form_open('folie_ruw/delete', $dataOpen);
                        echo form_input('folie_ruw_id_delete', '', 'id="folie_ruw_id_delete" class="form-control" required="required" aria-label="leverancier id"');
                        echo form_input('folie_ruw_naam_delete', '', 'id="folie_ruw_naam_delete" class="form-control" required="required" aria-label="leverancier naam"');
                        echo form_submit($dataSubmit);
                        echo form_close();
                        ?>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <?php createBasicDeleteModal('Waarschuwing',
        'Deze ruwe folie heeft gesneden folies',
        'Wanneer je deze ruwe folie verwijderd, zullen alle gesneden folies mee verwijderd worden. Deze gesneden folies zijn gekoppeld aan een product. Het product zal naar "Geen" gelinkt worden en de prijs van dit product zal geüpdate worden. ',
        'Wil je deze ruwe folie verwijderen? ',
        "Verwijder"); ?>

</main>

<script>
    // AJAX
    function ajax_saveToSession(naam, leverancierid, lmeenheid, lmprijs, micron) {
        jQuery.ajax({
            type: "POST",
            url: site_url + "/folie_ruw/ajax_save_to_session",
            data: {
                naam: naam,
                leverancierid: leverancierid,
                lmeenheid: lmeenheid,
                lmprijs: lmprijs,
                micron: micron
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
        var naam = $("#folie_ruw_naam").val();
        var leverancierid = parseInt($("#folie_ruw_leverancierid").val());
        var lmeenheid = parseFloat($("#folie_ruw_lmeenheid").val());
        var lmprijs = parseFloat($("#folie_ruw_lmprijs").val());
        var micron = parseInt($("#folie_ruw_micron").val());

        ajax_saveToSession(naam, leverancierid, lmeenheid, lmprijs, micron);
    }

    function get_byZoekFunctie(deelvannaam) {
        $.ajax({
            type: "POST",
            url: site_url + "/folie_ruw/ajax_get_by_zoekfunctie",
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

    function formEditListener_vervangKommasDoorPunt() {
        // kommas vervangen door een punt
        var controlInput_lmeenheid = $("#folie_ruw_lmeenheid");
        var controlInput_lmprijs = $("#folie_ruw_lmprijs");
        controlInput_lmeenheid.keyup(function () {
            var eenheid = $(this).val();
            var correctValue;
            if (eenheid.includes(",")) {
                correctValue = eenheid.replace(",", ".");
                controlInput_lmeenheid.val(correctValue);
            }
        });
        controlInput_lmprijs.keyup(function () {
            var prijs = $(this).val();
            var correctValue;
            if (prijs.includes(",")) {
                correctValue = prijs.replace(",", ".");
                controlInput_lmprijs.val(correctValue);
            }
        });
    }

    // ajaxComplete functions ***************************************************************************************

    function formListener_zoekOpNaam() {
        $("#zoeknaam").keyup(function () {
            var deelvannaam = $(this).val();
            get_byZoekFunctie(deelvannaam);
        });
    }

    function ajaxTable_bewerkListener() {
        $(".trigger-bewerkrij").click(function () {
            //controls
            var clickedIconSVG = $(this).find('i');
            var clickedRow = $(this).parent().parent();
            var targetInputField_naam = clickedRow.find('input#editableInput_naam');
            var targetInputField_lmeenheid = clickedRow.find('input#editableInput_lmeenheid');
            var targetInputField_lmprijs = clickedRow.find('input#editableInput_lmprijs');
            var targetInputField_micron = clickedRow.find('input#editableInput_micron');
            var targetDropdownField_leverancierid = clickedRow.find('select#editableInput_leverancierid');

            //data
            var folieRuwId = $(this).data('id');

            targetInputField_naam.toggleClass('agricon-is-editable-input');

            //wanneer het "editable" is -> icoontje veranderen + autofocus op de input + een class toevoegen
            if (targetInputField_naam.hasClass('agricon-is-editable-input')) {
                clickedRow.addClass('trGlow');
                targetInputField_naam.focus();
                targetInputField_naam.removeAttr('readonly');
                targetInputField_lmeenheid.removeAttr('readonly');
                targetInputField_lmprijs.removeAttr('readonly');
                targetInputField_micron.removeAttr('readonly');
                targetDropdownField_leverancierid.removeAttr('disabled');

                clickedIconSVG.removeClass('fa-pencil-alt');
                clickedIconSVG.addClass('fa-save');
            } else {
                // anders alles terugzetten + gegevens updaten in de database
                clickedRow.removeClass('trGlow');
                targetInputField_naam.attr('readonly', 'readonly');
                targetInputField_lmeenheid.attr('readonly', 'readonly');
                targetInputField_lmprijs.attr('readonly', 'readonly');
                targetInputField_micron.attr('readonly', 'readonly');
                targetDropdownField_leverancierid.attr('disabled', 'disabled');

                clickedIconSVG.removeClass('fa-save');
                clickedIconSVG.addClass('fa-pencil-alt');

                //hidden form opvullen
                var folieRuwNaam = targetInputField_naam.val();
                var folieRuwLMeenheid = targetInputField_lmeenheid.val();
                var folieRuwLMprijs = targetInputField_lmprijs.val();
                var folieRuwMicron = targetInputField_micron.val();
                var folieRuwLeverancierId = targetDropdownField_leverancierid.val();
                if (folieRuwNaam != "" && folieRuwNaam != null && folieRuwId != 0 && folieRuwId != null) {
                    $("#form_folie_ruw_update input#folie_ruw_id_update").val(folieRuwId);
                    $("#form_folie_ruw_update input#folie_ruw_naam_update").val(folieRuwNaam);
                    $("#form_folie_ruw_update input#folie_ruw_lmeenheid_update").val(folieRuwLMeenheid);
                    $("#form_folie_ruw_update input#folie_ruw_lmprijs_update").val(folieRuwLMprijs);
                    $("#form_folie_ruw_update input#folie_ruw_micron_update").val(folieRuwMicron);
                    $("#form_folie_ruw_update input#folie_ruw_leverancierid_update").val(folieRuwLeverancierId);

                    $("#form_folie_ruw_update").submit();
                }
            }
        });
    }

    function ajaxTable_bewerkListener_vervangKommasDoorPunt() {
        // kommas vervangen door een punt
        var controlInput_lmeenheid = $("#editableInput_lmeenheid");
        var controlInput_lmprijs = $("#editableInput_lmprijs");
        controlInput_lmeenheid.keyup(function () {
            var eenheid = $(this).val();
            var correctValue;
            if (eenheid.includes(",")) {
                correctValue = eenheid.replace(",", ".");
                controlInput_lmeenheid.val(correctValue);
            }
        });
        controlInput_lmprijs.keyup(function () {
            var prijs = $(this).val();
            var correctValue;
            if (prijs.includes(",")) {
                correctValue = prijs.replace(",", ".");
                controlInput_lmprijs.val(correctValue);
            }
        });
    }

    function ajaxTable_verwijderListener_showModal() {
        $(".agricon-delete-icon").click(function () {
            // hidden form opvullen
            var folieRuwId = $(this).data('id');
            var folieRuwNaam = $(this).data('folieruwnaam');

            if (folieRuwId != 0 && folieRuwId != null) {
                $("#form_folie_ruw_delete input#folie_ruw_id_delete").val(folieRuwId);
                $("#form_folie_ruw_delete input#folie_ruw_naam_delete").val(folieRuwNaam);
            }
            $('#deleteModal').modal('show');
        });
    }

    function ajaxTable_verwijderModalListener() {
        $('#deleteAllData').click(function (e) {
            $('#deleteModal').modal('hide');
            $("#form_folie_ruw_delete").submit();
        });
    }

    $(document).ready(function () {
        get_byZoekFunctie($("#zoeknaam").val());
        formListener_zoekOpNaam();
        formEditListener_vervangKommasDoorPunt();
    });

    $(document).ajaxComplete(function () {
        ajaxTable_bewerkListener();
        ajaxTable_bewerkListener_vervangKommasDoorPunt();
        ajaxTable_verwijderListener_showModal();
        ajaxTable_verwijderModalListener();
    });
</script>
