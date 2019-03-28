<main role="main" class="container" id="content_folie_gesneden_beheren">
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
                                'id' => 'form_folie_gesneden_beheren',
                                'name' => 'form_folie_gesneden_beheren',
                                'data-toggle' => 'validator',
                                'role' => 'form');

                            $dataSubmit = array(
                                'id' => 'submit_folie_gesneden_beheren',
                                'name' => 'submit_folie_gesneden_beheren',
                                'type' => 'submit',
                                'value' => 'Opslaan',
                                'class' => 'btn btn-outline-success agricon-formsubmit-button');
                            ?>
                            <?php echo form_open('folie_gesneden/insert', $dataOpen); ?>

                            <section>
                                <div class="form-row">
                                    <label for="folie_gesneden_naam" class="form-text text-muted">Naam *</label>
                                    <?php echo form_input('folie_gesneden_naam', $formData->folie_gesneden_naam, 'autofocus id="folie_gesneden_naam" type="text" class="form-control" required="required" aria-label="folie gesneden naam"'); ?>
                                </div>

                                <div class="form-row agricon-formcolumn">
                                    <div class="col-11">
                                        <label for="folie_gesneden_folieruwid"
                                               class="form-text text-muted">Ruwe Folie *</label>
                                        <?php echo form_dropdown('folie_gesneden_folieruwid', $folies_dropdownOptions, $formData->folie_gesneden_folieruwid, 'id="folie_gesneden_folieruwid" required="required" class="form-control" '); ?>
                                    </div>
                                    <div class="col-1">
                                        <?php echo anchor('folie_ruw/beheren/' . true, '<div class="agricon-fa-icon-plus" data-toggle="tooltip" data-placement="bottom" title="Nieuwe ruwe folie"><i class="fas fa-plus-circle"></i></div>', 'onclick="saveToSession()"'); ?>
                                    </div>
                                </div>

                                <div class="form-row agricon-formcolumn">
                                    <div class="col-6">
                                        <label for="folie_gesneden_lengte"
                                               class="form-text text-muted">Lengte (afslag) *</label>
                                        <?php echo form_input('folie_gesneden_lengte', $formData->folie_gesneden_lengte, 'id="folie_gesneden_lengte" type="number" 
                         step="0.01" pattern="' . customDecimalNumberPattern() . '" title="' . customDecimalNumberPatternMessage() . '" class="form-control" required="required" '); ?>
                                    </div>

                                    <div class="col-6">
                                        <label for="folie_gesneden_breedte"
                                               class="form-text text-muted">Breedte *</label>
                                        <?php echo form_input('folie_gesneden_breedte', $formData->folie_gesneden_breedte, 'id="folie_gesneden_breedte" type="number" 
                         step="0.01" pattern="' . customDecimalNumberPattern() . '" title="' . customDecimalNumberPatternMessage() . '" class="form-control" required="required" '); ?>

                                    </div>
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
                                <?php echo form_input(array('name' => 'zoeknaam', 'id' => 'zoeknaam', 'class' => 'form-control', 'placeholder' => '- Zoek -', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = '- Zoek -'"), $zoeknaam_folie_gesneden_value); ?>
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
                            'id' => 'form_folie_gesneden_update',
                            'name' => 'form_folie_gesneden_update',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_folie_gesneden_update',
                            'name' => 'submit_folie_gesneden_update',
                            'type' => 'submit');

                        echo form_open('folie_gesneden/update', $dataOpen);
                        echo form_input('folie_gesneden_id_update', '', 'id="folie_gesneden_id_update" class="form-control" required="required" aria-label="folie gesneden id"');
                        echo form_input('folie_gesneden_naam_update', '', 'id="folie_gesneden_naam_update" type="text" class="form-control" required="required" aria-label="folie gesneden naam"');

                        echo form_input('folie_gesneden_folieruwid_update', '', 'id="folie_gesneden_folieruwid_update" type="number" class="form-control" required="required" aria-label="folie gesneden leverancierid"');
                        echo form_input('folie_gesneden_lengte_update', '', 'id="folie_gesneden_lengte_update" type="number" step="0.01" class="form-control" aria-label="folie gesneden lm_eenheid"');
                        echo form_input('folie_gesneden_breedte_update', '', 'id="folie_gesneden_breedte_update" type="number" step="0.01" class="form-control" aria-label="folie gesneden lm_eenheid"');

                        echo form_submit($dataSubmit);
                        echo form_close();
                        ?>
                    </div>
                    <div hidden>
                        <?php
                        $dataOpen = array(
                            'id' => 'form_folie_gesneden_delete',
                            'name' => 'form_folie_gesneden_delete',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_folie_gesneden_delete',
                            'name' => 'submit_folie_gesneden_delete',
                            'type' => 'submit');

                        echo form_open('folie_gesneden/delete', $dataOpen);
                        echo form_input('folie_gesneden_id_delete', '', 'id="folie_gesneden_id_delete" class="form-control" required="required" aria-label="leverancier id"');
                        echo form_input('folie_gesneden_naam_delete', '', 'id="folie_gesneden_naam_delete" class="form-control" required="required" aria-label="leverancier naam"');
                        echo form_submit($dataSubmit);
                        echo form_close();
                        ?>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <?php createBasicDeleteModal('Waarschuwing',
        'Deze folie is gekoppeld aan producten',
        'Wanneer je deze folie verwijderd, zullen alle producten die hieraan gekoppeld zijn naar "Geen" gelinkt worden en de prijzen van deze producten zullen geüpdate worden. ',
        'Wil je deze folie verwijderen? ',
        "Verwijder"); ?>

</main>

<script>
    // AJAX
    function ajax_saveToSession(naam, folieruwid, lengte, breedte) {
        jQuery.ajax({
            type: "POST",
            url: site_url + "/folie_gesneden/ajax_save_to_session",
            data: {
                naam: naam,
                folieruwid: folieruwid,
                lengte: lengte,
                breedte: breedte
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
        var naam = $("#folie_gesneden_naam").val();
        var folieruwid = parseInt($("#folie_gesneden_folieruwid").val());
        var lengte = parseFloat($("#folie_gesneden_lengte").val());
        var breedte = parseFloat($("#folie_gesneden_breedte").val());
        ajax_saveToSession(naam, folieruwid, lengte, breedte);
    }

    function get_byZoekFunctie(deelvannaam) {
        $.ajax({
            type: "POST",
            url: site_url + "/folie_gesneden/ajax_get_by_zoekfunctie",
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
        var controlInput_lengte = $("#folie_gesneden_lengte");
        var controlInput_breedte = $("#folie_gesneden_breedte");
        controlInput_lengte.keyup(function () {
            var lengte = $(this).val();
            var correctValue;
            if (lengte.includes(",")) {
                correctValue = lengte.replace(",", ".");
                controlInput_lengte.val(correctValue);
            }
        });
        controlInput_breedte.keyup(function () {
            var breedte = $(this).val();
            var correctValue;
            if (breedte.includes(",")) {
                correctValue = breedte.replace(",", ".");
                controlInput_breedte.val(correctValue);
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
            var targetInputField_lengte = clickedRow.find('input#editableInput_lengte');
            var targetInputField_breedte = clickedRow.find('input#editableInput_breedte');
            var targetDropdownField_folieruwid = clickedRow.find('select#editableInput_folieruwid');

            //data
            var folieGesnedenId = $(this).data('id');

            targetInputField_naam.toggleClass('agricon-is-editable-input');

            //wanneer het "editable" is -> icoontje veranderen + autofocus op de input + een class toevoegen
            if (targetInputField_naam.hasClass('agricon-is-editable-input')) {
                clickedRow.addClass('trGlow');
                targetInputField_naam.focus();
                targetInputField_naam.removeAttr('readonly');
                targetInputField_lengte.removeAttr('readonly');
                targetInputField_breedte.removeAttr('readonly');
                targetDropdownField_folieruwid.removeAttr('disabled');

                clickedIconSVG.removeClass('fa-pencil-alt');
                clickedIconSVG.addClass('fa-save');
            } else {
                // anders alles terugzetten + gegevens updaten in de database
                clickedRow.removeClass('trGlow');
                targetInputField_naam.attr('readonly', 'readonly');
                targetInputField_lengte.attr('readonly', 'readonly');
                targetInputField_breedte.attr('readonly', 'readonly');
                targetDropdownField_folieruwid.attr('disabled', 'disabled');

                clickedIconSVG.removeClass('fa-save');
                clickedIconSVG.addClass('fa-pencil-alt');

                //hidden form opvullen
                var folieGesnedenNaam = targetInputField_naam.val();
                var folieGesnedenLengte = targetInputField_lengte.val();
                var folieGesnedenBreedte = targetInputField_breedte.val();
                var folieGesnedenFolieRuwId = targetDropdownField_folieruwid.val();
                if (folieGesnedenNaam != "" && folieGesnedenNaam != null && folieGesnedenId != 0 && folieGesnedenId != null) {
                    $("#form_folie_gesneden_update input#folie_gesneden_id_update").val(folieGesnedenId);
                    $("#form_folie_gesneden_update input#folie_gesneden_naam_update").val(folieGesnedenNaam);
                    $("#form_folie_gesneden_update input#folie_gesneden_lengte_update").val(folieGesnedenLengte);
                    $("#form_folie_gesneden_update input#folie_gesneden_breedte_update").val(folieGesnedenBreedte);
                    $("#form_folie_gesneden_update input#folie_gesneden_folieruwid_update").val(folieGesnedenFolieRuwId);

                    $("#form_folie_gesneden_update").submit();
                }
            }
        });
    }

    function ajaxTable_bewerkListener_vervangKommasDoorPunt() {
        // kommas vervangen door een punt
        var controlInput_lengte = $("#folie_gesneden_lengte");
        var controlInput_breedte = $("#folie_gesneden_breedte");
        controlInput_lengte.keyup(function () {
            var lengte = $(this).val();
            var correctValue;
            if (lengte.includes(",")) {
                correctValue = lengte.replace(",", ".");
                controlInput_lengte.val(correctValue);
            }
        });
        controlInput_breedte.keyup(function () {
            var breedte = $(this).val();
            var correctValue;
            if (breedte.includes(",")) {
                correctValue = breedte.replace(",", ".");
                controlInput_breedte.val(correctValue);
            }
        });
    }

    function ajaxTable_verwijderListener_showModal() {
        $(".agricon-delete-icon").click(function () {
            // hidden form opvullen
            var folieGesnedenId = $(this).data('id');
            var folieGesnedenNaam = $(this).data('folieruwnaam');

            if (folieGesnedenId != 0 && folieGesnedenId != null) {
                $("#form_folie_gesneden_delete input#folie_gesneden_id_delete").val(folieGesnedenId);
                $("#form_folie_gesneden_delete input#folie_gesneden_naam_delete").val(folieGesnedenNaam);
            }
            $('#deleteModal').modal('show');
        });
    }

    function ajaxTable_verwijderModalListener() {
        $('#deleteAllData').click(function (e) {
            $('#deleteModal').modal('hide');
            $("#form_folie_gesneden_delete").submit();
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
