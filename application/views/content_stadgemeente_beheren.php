<main role="main" class="container" id="content_stadgemeente_beheren">
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

                            if (isset($show_back_button_twice)) {
                                if ($show_back_button_twice) {
                                    echo "<p class='agricon-back-to-page-button'><a href='$redirect_url_twice'><button type='button' class='btn btn-outline-secondary'>Terug</button></a></p>";
                                }
                            }
                            elseif (isset($show_back_button)) {
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
                                'id' => 'form_stadgemeente_beheren',
                                'name' => 'form_stadgemeente_beheren',
                                'data-toggle' => 'validator',
                                'role' => 'form');

                            $dataSubmit = array(
                                'id' => 'submit_stadgemeente_beheren',
                                'name' => 'submit_stadgemeente_beheren',
                                'type' => 'submit',
                                'value' => 'Opslaan',
                                'class' => 'btn btn-outline-success agricon-formsubmit-button');
                            ?>
                            <?php echo form_open('stadgemeente/insert', $dataOpen); ?>

                            <section>
                                <div class="form-row">
                                    <label for="stadgemeente_naam" class="form-text text-muted">Naam *</label>
                                    <?php echo form_input('stadgemeente_naam', $formData->stadgemeente_naam, 'autofocus id="stadgemeente_naam" type="text" class="form-control" required="required" aria-label="stadgemeente naam"'); ?>
                                </div>
                                <div class="form-row">
                                    <label for="stadgemeente_postcode" class="form-text text-muted">Postcode *</label>
                                    <?php echo form_input('stadgemeente_postcode', $formData->stadgemeente_postcode, 'id="stadgemeente_postcode" type="text" class="form-control" required="required" pattern="' . customNumberPattern() . '" title="' . customNumberPatternMessage() . '"  aria-label="stadgemeente postcode"'); ?>
                                </div>
                                <div class="form-row agricon-formcolumn">
                                    <div class="col-11">
                                        <label for="stadgemeente_landid" class="form-text text-muted">Land *</label>
                                        <?php echo form_dropdown('stadgemeente_landid', $landen_dropdownOptions, $formData->stadgemeente_landid, 'id="stadgemeente_landid" class="form-control" required="required" '); ?>
                                    </div>
                                    <div class="col-1">
                                        <?php echo anchor('land/beheren/' . true, '<div class="agricon-fa-icon-plus" data-toggle="tooltip" data-placement="bottom" title="Nieuw land"><i class="fas fa-plus-circle"></i></div>', 'onclick="saveToSession()"'); ?>
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
                                <?php echo form_input(array('name' => 'zoeknaam', 'id' => 'zoeknaam', 'class' => 'form-control', 'placeholder' => '- Zoek -', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = '- Zoek -'"), $zoeknaam_stadgemeente_value); ?>
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
                            'id' => 'form_stadgemeente_update',
                            'name' => 'form_stadgemeente_update',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_stadgemeente_update',
                            'name' => 'submit_stadgemeente_update',
                            'type' => 'submit');

                        echo form_open('stadgemeente/update', $dataOpen);
                        echo form_input('stadgemeente_id_update', '', 'id="stadgemeente_id_update" class="form-control" required="required" aria-label="stadgemeente id"');
                        echo form_input('stadgemeente_naam_update', '', 'id="stadgemeente_naam_update" class="form-control" required="required" placeholder="naam" aria-label="stadgemeente naam"');
                        echo form_input('stadgemeente_postcode_update', '', 'id="stadgemeente_postcode_update" class="form-control" required="required" placeholder="naam" aria-label="stadgemeente postcode"');
                        echo form_input('stadgemeente_landid_update', '', 'id="stadgemeente_landid_update" class="form-control" required="required" placeholder="naam" aria-label="stadgemeente landid"');
                        echo form_submit($dataSubmit);
                        echo form_close();
                        ?>
                    </div>
                    <div hidden>
                        <?php
                        $dataOpen = array(
                            'id' => 'form_stadgemeente_delete',
                            'name' => 'form_stadgemeente_delete',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_stadgemeente_delete',
                            'name' => 'submit_stadgemeente_delete',
                            'type' => 'submit');

                        echo form_open('stadgemeente/delete', $dataOpen);
                        echo form_input('stadgemeente_id_delete', '', 'id="stadgemeente_id_delete" class="form-control" required="required" aria-label="stadgemeente id"');
                        echo form_input('stadgemeente_naam_delete', '', 'id="stadgemeente_naam_delete" class="form-control" required="required" placeholder="naam" aria-label="stadgemeente naam"');
                        echo form_input('stadgemeente_postcode_delete', '', 'id="stadgemeente_postcode_delete" class="form-control" required="required" placeholder="naam" aria-label="stadgemeente postcode"');
                        echo form_input('stadgemeente_landid_delete', '', 'id="stadgemeente_landid_delete" class="form-control" required="required" placeholder="naam" aria-label="stadgemeente landid"');
                        echo form_submit($dataSubmit);
                        echo form_close();
                        ?>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <?php createBasicDeleteModal('Waarschuwing',
        'Deze stad/gemeente is gekoppeld aan leveranciers.',
        'Wanneer je deze stad/gemeente verwijderd, zullen alle leveranciers die hieraan gekoppeld naar "Geen" gelinkt worden. ',
        'Wil je deze stad/gemeente verwijderen? ',
        "Verwijder"); ?>
</main>

<script>
    // AJAX
    function ajax_saveToSession(naam, postcode, landid) {
        jQuery.ajax({
            type: "POST",
            url: site_url + "/stadgemeente/ajax_save_to_session",
            data: {
                naam: naam,
                postcode: postcode,
                landid: landid
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
        var naam = $("#stadgemeente_naam").val();
        var postcode = $("#stadgemeente_postcode").val();
        var landid = parseInt($("#stadgemeente_landid").val());
        ajax_saveToSession(naam, postcode, landid);
    }


    function get_byZoekFunctie(deelvannaam) {
        $.ajax({
            type: "POST",
            url: site_url + "/stadgemeente/ajax_get_by_zoekfunctie",
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
            var targetInputField_Postcode = clickedRow.find('input#editableInput_postcode');
            var targetDropdownField_Land = clickedRow.find('select#editableInput_landid');

            //data
            var stadGemeenteId = $(this).data('id');

            targetInputField_Name.toggleClass('agricon-is-editable-input');
            //wanneer het "editable" is -> icoontje veranderen + autofocus op de input + een class toevoegen
            if (targetInputField_Name.hasClass('agricon-is-editable-input')) {
                clickedRow.addClass('trGlow');
                targetInputField_Name.focus();
                targetInputField_Name.removeAttr('readonly');
                targetInputField_Postcode.removeAttr('readonly');
                targetDropdownField_Land.removeAttr('disabled');

                clickedIconSVG.removeClass('fa-pencil-alt');
                clickedIconSVG.addClass('fa-save');
            } else {
                // anders alles terugzetten + gegevens updaten in de database
                clickedRow.removeClass('trGlow');
                targetInputField_Postcode.attr('readonly', 'readonly');
                targetDropdownField_Land.attr('disabled', 'disabled');

                clickedIconSVG.removeClass('fa-save');
                clickedIconSVG.addClass('fa-pencil-alt');

                //hidden form opvullen
                var stadGemeenteNaam = targetInputField_Name.val();
                var stadGemeentePostcode = targetInputField_Postcode.val();
                var stadGemeenteLandId = targetDropdownField_Land.val();

                if (stadGemeenteNaam != "" && stadGemeenteNaam != null && stadGemeenteId != 0 && stadGemeenteId != null) {
                    $("#form_stadgemeente_update input#stadgemeente_id_update").val(stadGemeenteId);
                    $("#form_stadgemeente_update input#stadgemeente_naam_update").val(stadGemeenteNaam);
                    $("#form_stadgemeente_update input#stadgemeente_postcode_update").val(stadGemeentePostcode);
                    $("#form_stadgemeente_update input#stadgemeente_landid_update").val(stadGemeenteLandId);
                    $("#form_stadgemeente_update").submit();
                }
            }
        });

    }

    function ajaxTable_verwijderListener_showModal() {
        $(".agricon-delete-icon").click(function () {
            var stadGemeenteId = $(this).data('id');
            var stadGemeenteNaam = $(this).data('stadgemeentenaam');
            if (stadGemeenteId != 0 && stadGemeenteId != null) {
                $("#form_stadgemeente_delete input#stadgemeente_id_delete").val(stadGemeenteId);
                $("#form_stadgemeente_delete input#stadgemeente_naam_delete").val(stadGemeenteNaam);
            }
            $('#deleteModal').modal('show');
        });
    }

    function ajaxTable_verwijderModalListener() {
        $('#deleteAllData').click(function (e) {
            $('#deleteModal').modal('hide');
            $("#form_stadgemeente_delete").submit();
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
