<main role="main" class="container" id="content_leverancier_beheren">
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
                                'id' => 'form_leverancier_beheren',
                                'name' => 'form_leverancier_beheren',
                                'data-toggle' => 'validator',
                                'role' => 'form');

                            $dataSubmit = array(
                                'id' => 'submit_leverancier_beheren',
                                'name' => 'submit_leverancier_beheren',
                                'type' => 'submit',
                                'value' => 'Opslaan',
                                'class' => 'btn btn-outline-success agricon-formsubmit-button');
                            ?>
                            <?php echo form_open('leverancier/insert', $dataOpen); ?>

                            <section>
                                <div class="form-row">
                                    <label for="leverancier_naam" class="form-text text-muted">Naam *</label>
                                    <?php echo form_input('leverancier_naam', $formData->leverancier_naam, 'autofocus id="leverancier_naam" type="text" class="form-control" required="required" placeholder="bv RVC, COR" aria-label="leverancier naam"'); ?>
                                </div>

                                <div class="form-row agricon-formcolumn">
                                    <div class="col-10 ">
                                        <label for="leverancier_straat"
                                               class="form-text text-muted">Straat</label>
                                        <?php echo form_input('leverancier_straat', $formData->leverancier_straat, 'autofocus id="leverancier_straat" type="text" class="form-control" type="text" aria-label="leverancier straat"'); ?>
                                    </div>
                                    <div class="col-2">
                                        <label for="leverancier_huisnummer"
                                               class="form-text text-muted">Nummer</label>
                                        <?php echo form_input('leverancier_huisnummer', $formData->leverancier_huisnummer, 'autofocus id="leverancier_huisnummer" type="text" class="form-control" type="text" aria-label="leverancier huisnummer"'); ?>
                                    </div>
                                </div>

                                <div class="form-row agricon-formcolumn">
                                    <div class="col-11">
                                        <label for="leverancier_stadgemeenteid" class="form-text text-muted">Stad/gemeente
                                            *</label>
                                        <?php echo form_dropdown('leverancier_stadgemeenteid', $steden_dropdownOptions, $formData->leverancier_stadgemeenteid, 'id="leverancier_stadgemeenteid" required="required" class="form-control" '); ?>
                                    </div>
                                    <div class="col-1">
                                        <?php echo anchor('stadgemeente/beheren/' . true, '<div class="agricon-fa-icon-plus" data-toggle="tooltip" data-placement="bottom" title="Nieuwe stad/gemeente"><i class="fas fa-plus-circle"></i></div>', 'onclick="saveToSession()"'); ?>
                                    </div>
                                </div>

                                <div class="form-row agricon-formcolumn">
                                    <div class="col-11">
                                        <label for="leverancier_leveranciersoortid" class="form-text text-muted">Soort
                                            leverancier *</label>
                                        <?php echo form_dropdown('leverancier_leveranciersoortid', $leveranciersoorten_dropdownOptions, $formData->leverancier_leveranciersoortid, 'id="leverancier_leveranciersoortid" required="required" class="form-control"  '); ?>
                                    </div>
                                    <div class="col-1">
                                        <?php echo anchor('leverancier_soort/beheren/' . true, '<div class="agricon-fa-icon-plus" data-toggle="tooltip" data-placement="bottom" title="Nieuwe leveranciersoort"><i class="fas fa-plus-circle"></i></div>', 'onclick="saveToSession()"'); ?>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <label for="leverancier_btwnummer" class="form-text text-muted">BTW nummer</label>
                                    <?php echo form_input('leverancier_btwnummer', $formData->leverancier_btwnummer, 'autofocus id="leverancier_btwnummer" type="text" class="form-control" aria-label="leverancier btwnummer"'); ?>
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
                                <?php echo form_input(array('name' => 'zoeknaam', 'id' => 'zoeknaam', 'class' => 'form-control', 'placeholder' => '- Zoek -', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = '- Zoek -'"), $zoeknaam_leverancier_value); ?>
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
                            'id' => 'form_leverancier_update',
                            'name' => 'form_leverancier_update',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_leverancier_update',
                            'name' => 'submit_leverancier_update',
                            'type' => 'submit');

                        echo form_open('leverancier/update', $dataOpen);
                        echo form_input('leverancier_id_update', '', 'id="leverancier_id_update" class="form-control" required="required" aria-label="leverancier id"');
                        echo form_input('leverancier_naam_update', '', 'id="leverancier_naam_update" class="form-control" required="required" placeholder="naam" aria-label="leverancier naam"');

                        echo form_input('leverancier_straat_update', '', 'id="leverancier_straat_update" class="form-control"  placeholder="naam" aria-label="leverancier straat"');
                        echo form_input('leverancier_huisnummer_update', '', 'id="leverancier_huisnummer_update" class="form-control"  placeholder="naam" aria-label="leverancier huisnummer"');
                        echo form_input('leverancier_stadgemeenteid_update', '', 'id="leverancier_stadgemeenteid_update" class="form-control"  placeholder="naam" aria-label="leverancier stadgemeenteid"');
                        echo form_input('leverancier_leveranciersoortid_update', '', 'id="leverancier_leveranciersoortid_update" class="form-control"  placeholder="naam" aria-label="leverancier leveranciersoortid"');
                        echo form_input('leverancier_btwnummer_update', '', 'id="leverancier_btwnummer_update" class="form-control"  placeholder="naam" aria-label="leverancier btwnummer"');


                        echo form_submit($dataSubmit);
                        echo form_close();
                        ?>
                    </div>
                    <div hidden>
                        <?php
                        $dataOpen = array(
                            'id' => 'form_leverancier_delete',
                            'name' => 'form_leverancier_delete',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_leverancier_delete',
                            'name' => 'submit_leverancier_delete',
                            'type' => 'submit');

                        echo form_open('leverancier/delete', $dataOpen);
                        echo form_input('leverancier_id_delete', '', 'id="leverancier_id_delete" class="form-control" required="required" aria-label="leverancier id"');
                        echo form_input('leverancier_naam_delete', '', 'id="leverancier_naam_delete" class="form-control" required="required" placeholder="naam" aria-label="leverancier naam"');
                        echo form_submit($dataSubmit);
                        echo form_close();
                        ?>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <?php createBasicDeleteModal('Waarschuwing',
        'Deze leverancier is gekoppeld aan ruwe folie.',
        'Wanneer je deze leverancier verwijderd, zullen alle ruwe folies die hieraan gekoppeld zijn naar "Geen" gelinkt worden',
        'Wil je deze leverancier verwijderen? ',
        "Verwijder"); ?>

</main>

<script>
    // AJAX
    function ajax_saveToSession(naam, straat, huisnummer, stadgemeenteid, leveranciersoortid, btwnummer) {
        jQuery.ajax({
            type: "POST",
            url: site_url + "/leverancier/ajax_save_to_session",
            data: {
                naam: naam,
                straat: straat,
                huisnummer: huisnummer,
                stadgemeenteid: stadgemeenteid,
                leveranciersoortid: leveranciersoortid,
                btwnummer: btwnummer
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
        var naam = $("#leverancier_naam").val();
        var straat = $("#leverancier_straat").val();
        var huisnummer = $("#leverancier_huisnummer").val();
        var stadgemeenteid = parseInt($("#leverancier_stadgemeenteid").val());
        var leveranciersoortid = parseInt($("#leverancier_leveranciersoortid").val());
        var btwnummer = $("#leverancier_btwnummer").val();

        ajax_saveToSession(naam, straat, huisnummer, stadgemeenteid, leveranciersoortid, btwnummer);
    }

    function get_byZoekFunctie(deelvannaam) {
        $.ajax({
            type: "POST",
            url: site_url + "/leverancier/ajax_get_by_zoekfunctie",
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

    // ajaxComplete functions ***************************************************************************************

    function ajaxTable_bewerkListener() {
        $(".trigger-bewerkrij").click(function () {
            //controls
            var clickedIconSVG = $(this).find('i');
            var clickedRow = $(this).parent().parent();
            var targetInputField_Name = clickedRow.find('input#editableInput_naam');
            var targetInputField_Straat = clickedRow.find('input#editableInput_straat');
            var targetInputField_Huisnummer = clickedRow.find('input#editableInput_huisnummer');
            var targetDropdownField_StadGemeente = clickedRow.find('select#editableInput_stadgemeente');
            var targetDropdownField_LeverancierSoort = clickedRow.find('select#editableInput_leveranciersoort');
            var targetInputField_BTWnummer = clickedRow.find('input#editableInput_btwnummer');
            //data
            var leverancierId = $(this).data('id');

            targetInputField_Name.toggleClass('agricon-is-editable-input');

            //wanneer het "editable" is -> icoontje veranderen + autofocus op de input + een class toevoegen
            if (targetInputField_Name.hasClass('agricon-is-editable-input')) {
                clickedRow.addClass('trGlow');
                targetInputField_Name.focus();
                targetInputField_Name.removeAttr('readonly');
                targetInputField_Straat.removeAttr('readonly');
                targetInputField_Huisnummer.removeAttr('readonly');
                targetInputField_BTWnummer.removeAttr('readonly');
                targetDropdownField_StadGemeente.removeAttr('disabled');
                targetDropdownField_LeverancierSoort.removeAttr('disabled');

                clickedIconSVG.removeClass('fa-pencil-alt');
                clickedIconSVG.addClass('fa-save');
            } else {
                // anders alles terugzetten + gegevens updaten in de database
                clickedRow.removeClass('trGlow');
                targetInputField_Name.attr('readonly', 'readonly');
                targetInputField_Straat.attr('readonly', 'readonly');
                targetInputField_Huisnummer.attr('readonly', 'readonly');
                targetInputField_BTWnummer.attr('readonly', 'readonly');
                targetDropdownField_StadGemeente.attr('disabled', 'disabled');
                targetDropdownField_LeverancierSoort.attr('disabled', 'disabled');

                clickedIconSVG.removeClass('fa-save');
                clickedIconSVG.addClass('fa-pencil-alt');

                //hidden form opvullen
                var leverancierNaam = targetInputField_Name.val();
                var leverancierStraat = targetInputField_Straat.val();
                var leverancierHuisnummer = targetInputField_Huisnummer.val();
                var leverancierStadGemeenteId = targetDropdownField_StadGemeente.val();
                var leverancierLeverancierSoortId = targetDropdownField_LeverancierSoort.val();
                var leverancierBTWnummer = targetInputField_BTWnummer.val();
                if (leverancierNaam != "" && leverancierNaam != null && leverancierId != 0 && leverancierId != null) {
                    $("#form_leverancier_update input#leverancier_id_update").val(leverancierId);
                    $("#form_leverancier_update input#leverancier_naam_update").val(leverancierNaam);
                    $("#form_leverancier_update input#leverancier_straat_update").val(leverancierStraat);
                    $("#form_leverancier_update input#leverancier_huisnummer_update").val(leverancierHuisnummer);
                    $("#form_leverancier_update input#leverancier_stadgemeenteid_update").val(leverancierStadGemeenteId);
                    $("#form_leverancier_update input#leverancier_leveranciersoortid_update").val(leverancierLeverancierSoortId);
                    $("#form_leverancier_update input#leverancier_btwnummer_update").val(leverancierBTWnummer);
                    $("#form_leverancier_update").submit();
                }
            }
        });
    }

    function ajaxTable_verwijderListener_showModal() {
        $(".agricon-delete-icon").click(function () {
            // hidden form opvullen
            var leverancierId = $(this).data('id');
            var leverancierNaam = $(this).data('leveranciernaam');

            if (leverancierId != 0 && leverancierId != null) {
                $("#form_leverancier_delete input#leverancier_id_delete").val(leverancierId);
                $("#form_leverancier_delete input#leverancier_naam_delete").val(leverancierNaam);
            }
            $('#deleteModal').modal('show');
        });
    }

    function ajaxTable_verwijderModalListener() {
        $('#deleteAllData').click(function (e) {
            $('#deleteModal').modal('hide');
            $("#form_leverancier_delete").submit();
        });
    }

    $(document).ready(function () {
        get_byZoekFunctie($("#zoeknaam").val());
        formListener_zoekOpNaam();
    });

    $(document).ajaxComplete(function () {
        ajaxTable_bewerkListener();
        ajaxTable_verwijderListener_showModal();
        ajaxTable_verwijderModalListener();
    });
</script>
