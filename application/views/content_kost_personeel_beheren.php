<main role="main" class="container" id="content_kost_personeel_beheren">
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
                            <section style="margin-top: 0;margin-bottom: 5px">
                                  <span style="font-size: 12px">De personeelskost per jaar wordt hier berekend met 365 dagen. Bij de samenstelling van een product wordt er rekening gehouden met het aantal werkdagen per jaar, bv 200 werkdagen.<br>
                                      Deze configuratie setting kan ingesteld worden via "beheren/configuratie/settings".
                            </section>
                            <?php
                            $dataOpen = array(
                                'id' => 'form_kost_personeel_beheren',
                                'name' => 'form_kost_personeel_beheren',
                                'data-toggle' => 'validator',
                                'role' => 'form');

                            $dataSubmit = array(
                                'id' => 'submit_kost_personeel_beheren',
                                'name' => 'submit_kost_personeel_beheren',
                                'type' => 'submit',
                                'value' => 'Opslaan',
                                'class' => 'btn btn-outline-success agricon-formsubmit-button');
                            ?>
                            <?php echo form_open('kost_personeel/insert', $dataOpen); ?>

                            <section>
                                <div class="form-row">
                                    <label for="kost_personeel_naam" class="form-text text-muted">Naam *</label>
                                    <?php echo form_input('kost_personeel_naam', '', 'autofocus id="kost_personeel_naam" class="form-control" 
                                    type="text" required="required" placeholder="bv 2018 standaard" aria-label="kost gebouwen naam"'); ?>
                                </div>
                                <div class="form-row agricon-formcolumn">
                                    <div class="col-4">
                                        <label for="kost_personeel_aantalWerknemers" class="form-text text-muted">Aantal
                                            Werknemers *</label>
                                        <?php echo form_input('kost_personeel_aantalWerknemers', '', ' id="kost_personeel_aantalWerknemers" class="form-control" 
                                    type="number" pattern="' . customNumberPattern() . '" title="' . customNumberPatternMessage() . '"  required="required" aria-label="kost personeel aantal werknemers"'); ?>
                                    </div>
                                    <div class="col-4">
                                        <label for="kost_personeel_aantalUren" class="form-text text-muted">Aantal
                                            uur/Dag *</label>
                                        <?php echo form_input('kost_personeel_aantalUren', '', ' id="kost_personeel_aantalUren" class="form-control" 
                                    type="number" step="0.01" pattern="' . customDecimalNumberPattern() . '" title="' . customDecimalNumberPatternMessage() . '"required="required" aria-label="kost personeel aantal uren"'); ?>
                                    </div>
                                    <div class="col-4">
                                        <label for="kost_personeel_uurloon" class="form-text text-muted">Uurloon
                                            *</label>
                                        <?php echo form_input('kost_personeel_uurloon', '', ' id="kost_personeel_uurloon" class="form-control" 
                                    type="number" step="0.01" pattern="' . customDecimalNumberPattern() . '" title="' . customDecimalNumberPatternMessage() . '" required="required" aria-label="kost personeel uurloon"'); ?>
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
                                <?php echo form_input(array('name' => 'zoeknaam', 'id' => 'zoeknaam', 'class' => 'form-control', 'placeholder' => '- Zoek -', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = '- Zoek -'"), $zoeknaam_kost_personeel_value); ?>
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
                            'id' => 'form_kost_personeel_update',
                            'name' => 'form_kost_personeel_update',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_kost_personeel_update',
                            'name' => 'submit_kost_personeel_update',
                            'type' => 'submit');

                        echo form_open('kost_personeel/update', $dataOpen);
                        echo form_input('kost_personeel_id_update', '', 'id="kost_personeel_id_update" class="form-control" required="required" aria-label="kost personeel id"');
                        echo form_input('kost_personeel_naam_update', '', 'id="kost_personeel_naam_update" class="form-control" required="required" aria-label="kost personeel naam"');
                        echo form_input('kost_personeel_aantalWerknemers_update', '', 'id="kost_personeel_aantalWerknemers_update" class="form-control" required="required" aria-label="kost personeel aantal werknemers"');
                        echo form_input('kost_personeel_aantalUren_update', '', 'id="kost_personeel_aantalUren_update" class="form-control" required="required" aria-label="kost personeel aantal uren"');
                        echo form_input('kost_personeel_uurloon_update', '', 'id="kost_personeel_uurloon_update" type="number" step="0.01" class="form-control" aria-label="kost personeel uurloon" required="required"');
                        echo form_submit($dataSubmit);
                        echo form_close();
                        ?>
                    </div>
                    <div hidden>
                        <?php
                        $dataOpen = array(
                            'id' => 'form_kost_personeel_delete',
                            'name' => 'form_kost_personeel_delete',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_kost_personeel_delete',
                            'name' => 'submit_kost_personeel_delete',
                            'type' => 'submit');

                        echo form_open('kost_personeel/delete', $dataOpen);
                        echo form_input('kost_personeel_id_delete', '', 'id="kost_personeel_id_delete" class="form-control" required="required" aria-label="kost personeel id"');
                        echo form_input('kost_personeel_naam_delete', '', 'id="kost_personeel_naam_delete" class="form-control" required="required" aria-label="kost personeel naam"');
                        echo form_submit($dataSubmit);
                        echo form_close();
                        ?>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <?php createBasicDeleteModal('Waarschuwing',
        'Deze personeelskost is gekoppeld aan productiekost.',
        'Wanneer je deze personeelskost verwijderd, zullen alle productiekosten die hieraan gekoppeld zijn naar "geen" gelinkt worden.',
        'Wil je deze personeelskost verwijderen? ',
        "Verwijder"); ?>

</main>

<script>
    // AJAX
    function ajax_saveToSession(naam, aantalwerknemers, aantaluren, uurloon) {
        jQuery.ajax({
            type: "POST",
            url: site_url + "/kost_personeel/ajax_save_to_session",
            data: {
                naam: naam,
                aantalwerknemers: aantalwerknemers,
                aantaluren: aantaluren,
                uurloon: uurloon
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
        var naam = $("#kost_personeel_naam").val();
        var aantalwerknemers = parseInt($("#kost_personeel_aantalWerknemers").val());
        var aantaluren = parseFloat($("#kost_personeel_aantalurent").val());
        var uurloon = parseFloat($("#kost_personeel_uurloon").val());
        ajax_saveToSession(naam, aantalwerknemers, aantaluren, uurloon);
    }

    function get_byZoekFunctie(deelvannaam) {
        $.ajax({
            type: "POST",
            url: site_url + "/kost_personeel/ajax_get_by_zoekfunctie",
            data: {
                zoeknaam: deelvannaam
            },
            success: function (result) {
                $("#resultaat").html(result);
            },
            error: function (xhr, status, error) {
//                alert("-- kostpersoneelnaam --\n\n" + xhr.responseText + error);
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
        // kommas vervangen door een punt
        var controlInput_aantalUren = $("#kost_personeel_aantalUren");
        var controlInput_uurloon = $("#kost_personeel_uurloon");
        controlInput_aantalUren.add(controlInput_uurloon).keyup(function () {
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
            var targetInputField_naam = clickedRow.find('input#editableInput_naam');
            var targetInputField_aantalWerknemers = clickedRow.find('input#editableInput_aantalWerknemers');
            var targetInputField_aantalUren = clickedRow.find('input#editableInput_aantalUren');
            var targetInputField_uurloon = clickedRow.find('input#editableInput_uurloon');

            //data
            var kostPersoneelId = $(this).data('id');

            targetInputField_naam.toggleClass('agricon-is-editable-input');

            //wanneer het "editable" is -> icoontje veranderen + autofocus op de input + een class toevoegen
            if (targetInputField_naam.hasClass('agricon-is-editable-input')) {
                clickedRow.addClass('trGlow');
                targetInputField_naam.focus();
                targetInputField_naam.removeAttr('readonly');
                targetInputField_aantalWerknemers.removeAttr('readonly');
                targetInputField_aantalUren.removeAttr('readonly');
                targetInputField_uurloon.removeAttr('readonly');

                clickedIconSVG.removeClass('fa-pencil-alt');
                clickedIconSVG.addClass('fa-save');
            } else {
                // anders alles terugzetten + gegevens updaten in de database
                clickedRow.removeClass('trGlow');
                targetInputField_naam.attr('readonly', 'readonly');
                targetInputField_aantalWerknemers.attr('readonly', 'readonly');
                targetInputField_aantalUren.attr('readonly', 'readonly');
                targetInputField_uurloon.attr('readonly', 'readonly');

                clickedIconSVG.removeClass('fa-save');
                clickedIconSVG.addClass('fa-pencil-alt');

                //hidden form opvullen
                var kostPersoneelNaam = targetInputField_naam.val();
                var kostPersoneelAantalWerknemers = targetInputField_aantalWerknemers.val();
                var kostPersoneelAantalUren = targetInputField_aantalUren.val();
                var kostPersoneelUurloon = targetInputField_uurloon.val();
                if (kostPersoneelNaam != "" && kostPersoneelNaam != null && kostPersoneelId != 0 && kostPersoneelId != null) {
                    $("#form_kost_personeel_update input#kost_personeel_id_update").val(kostPersoneelId);
                    $("#form_kost_personeel_update input#kost_personeel_naam_update").val(kostPersoneelNaam);
                    $("#form_kost_personeel_update input#kost_personeel_aantalWerknemers_update").val(kostPersoneelAantalWerknemers);
                    $("#form_kost_personeel_update input#kost_personeel_aantalUren_update").val(kostPersoneelAantalUren);
                    $("#form_kost_personeel_update input#kost_personeel_uurloon_update").val(kostPersoneelUurloon);
                    $("#form_kost_personeel_update").submit();
                }
            }
        });
    }

    function ajaxTable_bewerkListener_vervangKommasDoorPunt() {
        // kommas vervangen door een punt
        var controlInput_aantalUren = $("#editableInput_aantalUren");
        var controlInput_uurloon = $("#editableInput_uurloon");
        controlInput_aantalUren.add(controlInput_uurloon).keyup(function () {
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
            var kostPersoneelId = $(this).data('id');
            var kostPersoneelNaam = $(this).data('kostpersoneelnaam');
            if (kostPersoneelId != 0 && kostPersoneelId != null) {
                $("#form_kost_personeel_delete input#kost_personeel_id_delete").val(kostPersoneelId);
                $("#form_kost_personeel_delete input#kost_personeel_naam_delete").val(kostPersoneelNaam);
            }
            $('#deleteModal').modal('show');
        });
    }

    function ajaxTable_verwijderModalListener() {
        $('#deleteAllData').click(function (e) {
            $('#deleteModal').modal('hide');
            $("#form_kost_personeel_delete").submit();
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
