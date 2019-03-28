<main role="main" class="container" id="content_kost_elektriciteit_beheren">
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
                                'id' => 'form_kost_elektriciteit_beheren',
                                'name' => 'form_kost_elektriciteit_beheren',
                                'data-toggle' => 'validator',
                                'role' => 'form');

                            $dataSubmit = array(
                                'id' => 'submit_kost_elektriciteit_beheren',
                                'name' => 'submit_kost_elektriciteit_beheren',
                                'type' => 'submit',
                                'value' => 'Opslaan',
                                'class' => 'btn btn-outline-success agricon-formsubmit-button');
                            ?>
                            <?php echo form_open('kost_elektriciteit/insert', $dataOpen); ?>

                            <section>
                                <div class="form-row">
                                    <label for="kost_elektriciteit_naam" class="form-text text-muted">Naam *</label>
                                    <?php echo form_input('kost_elektriciteit_naam', '', 'autofocus id="kost_elektriciteit_naam" class="form-control" 
                                    type="text" required="required" placeholder="bv 2018 standaard" aria-label="kost elektriciteit naam"'); ?>
                                </div>

                                <div class="form-row">
                                    <label for="kost_elektriciteit_verbruikPerJaarInKwh" class="form-text text-muted">Verbruik/Jaar
                                        (in Kwh) *</label>
                                    <?php echo form_input('kost_elektriciteit_verbruikPerJaarInKwh', '', 'id="kost_elektriciteit_verbruikPerJaarInKwh" class="form-control" 
                                    type="number" step="0.01" pattern="' . customDecimalNumberPattern() . '" title="' . customDecimalNumberPatternMessage() . '" required="required" aria-label="kost elektriciteit verbruikPerJaarInKwh"'); ?>
                                </div>
                                <div class="form-row">
                                    <label for="kost_elektriciteit_kostprijsPerKwh" class="form-text text-muted">Kostprijs/Kwh
                                        *</label>
                                    <?php echo form_input('kost_elektriciteit_kostprijsPerKwh', '', 'id="kost_elektriciteit_kostprijsPerKwh" type="number" 
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
                                <?php echo form_input(array('name' => 'zoeknaam', 'id' => 'zoeknaam', 'class' => 'form-control', 'placeholder' => '- Zoek -', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = '- Zoek -'"), $zoeknaam_kost_elektriciteit_value); ?>
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
                            'id' => 'form_kost_elektriciteit_update',
                            'name' => 'form_kost_elektriciteit_update',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_kost_elektriciteit_update',
                            'name' => 'submit_kost_elektriciteit_update',
                            'type' => 'submit');

                        echo form_open('kost_elektriciteit/update', $dataOpen);
                        echo form_input('kost_elektriciteit_id_update', '', 'id="kost_elektriciteit_id_update" class="form-control" required="required" aria-label="kost elektriciteit id"');
                        echo form_input('kost_elektriciteit_naam_update', '', 'id="kost_elektriciteit_naam_update" class="form-control" required="required" aria-label="kost elektriciteit naam"');
                        echo form_input('kost_elektriciteit_verbruikPerJaarInKwh_update', '', 'id="kost_elektriciteit_verbruikPerJaarInKwh_update" type="number" step="0.01" class="form-control" aria-label="kost elektriciteit verbruikPerJaarInKwh" required="required"');
                        echo form_input('kost_elektriciteit_kostprijsPerKwh_update', '', 'id="kost_elektriciteit_kostprijsPerKwh_update" type="number" step="0.01" class="form-control" aria-label="kost elektriciteit kostprijsPerKwh_update" required="required"');
                        echo form_submit($dataSubmit);
                        echo form_close();
                        ?>
                    </div>
                    <div hidden>
                        <?php
                        $dataOpen = array(
                            'id' => 'form_kost_elektriciteit_delete',
                            'name' => 'form_kost_elektriciteit_delete',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_kost_elektriciteit_delete',
                            'name' => 'submit_kost_elektriciteit_delete',
                            'type' => 'submit');

                        echo form_open('kost_elektriciteit/delete', $dataOpen);
                        echo form_input('kost_elektriciteit_id_delete', '', 'id="kost_elektriciteit_id_delete" class="form-control" required="required" aria-label="kost_elektriciteit_id_delete"');
                        echo form_input('kost_elektriciteit_naam_delete', '', 'id="kost_elektriciteit_naam_delete" class="form-control" required="required" aria-label="kost_elektriciteit_id_delete"');
                        //                        echo form_input('kost_elektriciteit_verbruikPerJaarInKwh_delete', '', 'id="kost_elektriciteit_verbruikPerJaarInKwh_delete" type="number" step="0.01" class="form-control" aria-label="kost elektriciteit verbruikPerJaarInKwh" required="required"');
                        //                        echo form_input('kost_elektriciteit_kostprijsPerKwh_delete', '', 'id="kost_elektriciteit_kostprijsPerKwh_delete" type="number" step="0.01" class="form-control" aria-label="kost elektriciteit kostprijsPerKwh" required="required"');
                        echo form_submit($dataSubmit);
                        echo form_close();
                        ?>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <?php createBasicDeleteModal('Waarschuwing',
        'Deze elektriciteitskost is gekoppeld aan productiekost.',
        'Wanneer je deze elektriciteitskost verwijderd, zullen alle productiekosten die hieraan gekoppeld zij naar "geen" gelinkt worden.',
        'Wil je deze elektriciteitskost verwijderen? ',
        "Verwijder"); ?>

</main>

<script>
    // AJAX
    function ajax_saveToSession(naam, verbruikPerJaarInKwh, kostprijsPerKwh) {
        jQuery.ajax({
            type: "POST",
            url: site_url + "/kost_elektriciteit/ajax_save_to_session",
            data: {
                naam: naam,
                verbruikPerJaarInKwh: verbruikPerJaarInKwh,
                kostprijsPerKwh: kostprijsPerKwh
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
        var naam = $("#kost_elektriciteit_naam").val();
        var verbruikPerJaarInKwh = parseFloat($("#kost_elektriciteit_verbruikPerJaarInKwh").val());
        var kostprijsPerKwh = parseFloat($("#kost_elektriciteit_kostprijsPerKwh").val());
        ajax_saveToSession(naam, verbruikPerJaarInKwh, kostprijsPerKwh);
    }


    function get_byZoekFunctie(deelvannaam) {
        $.ajax({
            type: "POST",
            url: site_url + "/kost_elektriciteit/ajax_get_by_zoekfunctie",
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
        var controlInput_verbruikPerJaarInKwh = $("#kost_elektriciteit_verbruikPerJaarInKwh");
        var controlInput_kostprijsPerKwh = $("#kost_elektriciteit_kostprijsPerKwh");

        $(controlInput_verbruikPerJaarInKwh).add(controlInput_kostprijsPerKwh).keyup(function () {
            var currentValue = $(this).val();
            var correctValue;
            if (currentValue.includes(",")) {
                correctValue = currentValue.replace(",", ".");
                $(this).val(correctValue);
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
            var targetInputField_verbruikPerJaarInKwh = clickedRow.find('input#editableInput_verbruikPerJaarInKwh');
            var targetInputField_kostprijsPerKwh = clickedRow.find('input#editableInput_kostprijsPerKwh');

            //data
            var kostElektriciteitId = $(this).data('id');

            targetInputField_naam.toggleClass('agricon-is-editable-input');

            //wanneer het "editable" is -> icoontje veranderen + autofocus op de input + een class toevoegen
            if (targetInputField_naam.hasClass('agricon-is-editable-input')) {
                clickedRow.addClass('trGlow');
                targetInputField_naam.focus();
                targetInputField_naam.removeAttr('readonly');
                targetInputField_verbruikPerJaarInKwh.removeAttr('readonly');
                targetInputField_kostprijsPerKwh.removeAttr('readonly');

                clickedIconSVG.removeClass('fa-pencil-alt');
                clickedIconSVG.addClass('fa-save');
            } else {
                // anders alles terugzetten + gegevens updaten in de database
                clickedRow.removeClass('trGlow');
                targetInputField_naam.attr('readonly', 'readonly');
                targetInputField_verbruikPerJaarInKwh.attr('readonly', 'readonly');
                targetInputField_kostprijsPerKwh.attr('readonly', 'readonly');

                clickedIconSVG.removeClass('fa-save');
                clickedIconSVG.addClass('fa-pencil-alt');

                //hidden form opvullen
                var kostElektriciteitNaam = targetInputField_naam.val();
                var kostElektriciteitVerbruikPerJaarInKwh = targetInputField_verbruikPerJaarInKwh.val();
                var kostElektriciteitKostprijsPerKwh = targetInputField_kostprijsPerKwh.val();
                if (kostElektriciteitVerbruikPerJaarInKwh != "" && kostElektriciteitVerbruikPerJaarInKwh != null && kostElektriciteitId != 0 && kostElektriciteitId != null) {
                    $("#form_kost_elektriciteit_update input#kost_elektriciteit_id_update").val(kostElektriciteitId);
                    $("#form_kost_elektriciteit_update input#kost_elektriciteit_naam_update").val(kostElektriciteitNaam);
                    $("#form_kost_elektriciteit_update input#kost_elektriciteit_verbruikPerJaarInKwh_update").val(kostElektriciteitVerbruikPerJaarInKwh);
                    $("#form_kost_elektriciteit_update input#kost_elektriciteit_kostprijsPerKwh_update").val(kostElektriciteitKostprijsPerKwh);

                    $("#form_kost_elektriciteit_update").submit();
                }
            }
        });
    }
    function ajaxTable_bewerkListener_vervangKommasDoorPunt() {
        // kommas vervangen door een punt
        var controlInput_verbruikPerJaarInKwh = $("#editableInput_verbruikPerJaarInKwh");
        var controlInput_kostprijsPerKwh = $("#editableInput_kostprijsPerKwh");
        $(controlInput_verbruikPerJaarInKwh).add(controlInput_kostprijsPerKwh).keyup(function () {
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
            var kostElektriciteitId = $(this).data('id');
            var kostElektriciteitNaam = $(this).data('kostelektriciteitnaam');
            if (kostElektriciteitId != 0 && kostElektriciteitId != null) {
                $("#form_kost_elektriciteit_delete input#kost_elektriciteit_id_delete").val(kostElektriciteitId);
                $("#form_kost_elektriciteit_delete input#kost_elektriciteit_naam_delete").val(kostElektriciteitNaam);
            }
            $('#deleteModal').modal('show');
        });
    }

    function ajaxTable_verwijderModalListener() {
        $('#deleteAllData').click(function (e) {
            $('#deleteModal').modal('hide');
            $("#form_kost_elektriciteit_delete").submit();
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
