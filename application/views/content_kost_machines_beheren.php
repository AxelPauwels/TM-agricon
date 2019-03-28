<main role="main" class="container" id="content_kost_machines_beheren">
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
                                'id' => 'form_kost_machines_beheren',
                                'name' => 'form_kost_machines_beheren',
                                'data-toggle' => 'validator',
                                'role' => 'form');

                            $dataSubmit = array(
                                'id' => 'submit_kost_machines_beheren',
                                'name' => 'submit_kost_machines_beheren',
                                'type' => 'submit',
                                'value' => 'Opslaan',
                                'class' => 'btn btn-outline-success agricon-formsubmit-button');
                            ?>
                            <?php echo form_open('kost_machines/insert', $dataOpen); ?>

                            <section>
                                <!--                                onderstaand hidden input "naam" mag verwijderd worden na bevestiging van klant, wordt momenteel niet gebruikt, maar even behouden-->
                                <div hidden class="form-row">
                                    <label for="kost_machines_naam" class="form-text text-muted">Naam *</label>
                                    <?php echo form_input('kost_machines_naam', "magweg", 'id="kost_machines_naam" type="text" class="form-control" placeholder="bv 2018 standaard" aria-label="kost machines naam"'); ?>
                                </div>
                                <div class="form-row agricon-formcolumn">
                                    <div class="col-11">
                                        <label for="kost_machines_machinesoortid"
                                               class="form-text text-muted">Machine soort * <span style="float: right">(De naam van deze machinesoort wordt ook automatisch als "naam" opgeslagen)</span></label>
                                        <?php echo form_dropdown('kost_machines_machinesoortid', $machineSoorten_dropdownOptions, $formData->kost_machines_machinesoortid, 'id="kost_machines_machinesoortid" required="required" class="form-control" '); ?>
                                    </div>
                                    <div class="col-1">
                                        <?php echo anchor('machine_soort/beheren/' . true, '<div class="agricon-fa-icon-plus" data-toggle="tooltip" data-placement="bottom" title="Nieuwe machine soort"><i class="fas fa-plus-circle"></i></div>', 'onclick="saveToSession()"'); ?>
                                    </div>
                                </div>
                                <div class="form-row agricon-formcolumn">
                                    <div class="col-4">
                                        <label for="kost_machines_aankoopPrijs" class="form-text text-muted">Aankoopprijs
                                            *</label>
                                        <?php echo form_input('kost_machines_aankoopPrijs', $formData->kost_machines_aankoopprijs, ' id="kost_machines_aankoopPrijs" type="number" 
                                        step="0.01" pattern="' . customDecimalNumberPattern() . '" title="' . customDecimalNumberPatternMessage() . '" class="form-control" required="required" aria-label="kost machines aankoopprijs" '); ?>
                                    </div>
                                    <div class="col-4">
                                        <label for="kost_machines_aantal" class="form-text text-muted">Aantal *</label>
                                        <?php echo form_input('kost_machines_aantal', $formData->kost_machines_aantal, ' id="kost_machines_aantal" type="number" 
                                        pattern="' . customNumberPattern() . '" title="' . customNumberPatternMessage() . '" class="form-control" required="required" aria-label="kost machines aantal"'); ?>
                                    </div>
                                    <div class="col-4">
                                        <label for="kost_machines_afschrijfperiodePerJaar" class="form-text text-muted"
                                               style="padding-left:5px">Afschrijfperiode/Jaar *</label>
                                        <?php echo form_input('kost_machines_afschrijfperiodePerJaar', $formData->kost_machines_afschrijfperiodeperjaar, ' id="kost_machines_afschrijfperiodePerJaar" type="number" 
                                        pattern="' . customNumberPattern() . '" title="' . customNumberPatternMessage() . '" class="form-control" required="required" aria-label="kost machines afschrijfperiode per jaar" style="margin-left:5px"'); ?>
                                    </div>
                                </div>


                                <div class="form-row agricon-content-divider" style="margin-top: 50px">
                                    <h6>Jaarlijks onderhoud</h6>
                                </div>

                                <div class="form-row agricon-formcolumn">
                                    <div class="col-3">
                                        <label for="kost_machines_onderhoudFrequentiePerJaar"
                                               class="form-text text-muted">Frequentie/Jaar *</label>
                                        <?php echo form_input('kost_machines_onderhoudFrequentiePerJaar', $formData->kost_machines_onderhoudfrequentieperjaar, 'id="kost_machines_onderhoudFrequentiePerJaar" type="number" 
                                    pattern="' . customNumberPattern() . '" title="' . customNumberPatternMessage() . '" class="form-control" required="required" placeholder="" aria-label="kost machines onderhoud frequentie per jaar"'); ?>
                                    </div>

                                    <div class="col-3">
                                        <label for="kost_machines_onderhoudKost"
                                               class="form-text text-muted">Kost *</label>
                                        <?php echo form_input('kost_machines_onderhoudKost', $formData->kost_machines_onderhoudkost, 'id="kost_machines_onderhoudKost" type="number" 
                                        step="0.01" pattern="' . customDecimalNumberPattern() . '" title="' . customDecimalNumberPatternMessage() . '" class="form-control" required="required" '); ?>

                                    </div>
                                    <div class="col-3">
                                        <label for="kost_machines_onderhoudUren"
                                               class="form-text text-muted">Uren/Onderhoud *</label>
                                        <?php echo form_input('kost_machines_onderhoudUren', $formData->kost_machines_onderhouduren, 'id="kost_machines_onderhoudUren" type="number" 
                                        step="0.01" pattern="' . customDecimalNumberPattern() . '" title="' . customDecimalNumberPatternMessage() . '" class="form-control" required="required" '); ?>

                                    </div>

                                    <div class="col-3">
                                        <label for="kost_machines_onderhoudUurloon"
                                               class="form-text text-muted" style="padding-left:5px">Uurloon *</label>
                                        <?php echo form_input('kost_machines_onderhoudUurloon', $formData->kost_machines_onderhouduurloon, 'id="kost_machines_onderhoudUurloon" type="number" 
                                        step="0.01" pattern="' . customDecimalNumberPattern() . '" title="' . customDecimalNumberPatternMessage() . '" class="form-control" required="required" style="margin-left:5px"'); ?>

                                    </div>
                                </div>

                                <div class="form-row agricon-content-divider" style="margin-top: 50px">
                                    <h6>Reparaties (optioneel)</h6>
                                </div>

                                <div id="agricon_dynamic_formfields" style="margin: 0;padding: 0">
                                    <div class="form-row agricon-formcolumn">
                                        <div class="col-4">
                                            <label for="kost_machines_reparatieKost1"
                                                   class="form-text text-muted">Kost</label>
                                            <?php echo form_input('kost_machines_reparatieKost1', '', 'id="kost_machines_reparatieKost1" type="number" 
                                        step="0.01" pattern="' . customDecimalNumberPattern() . '" title="' . customDecimalNumberPatternMessage() . '" class="form-control" '); ?>

                                        </div>

                                        <div class="col-4">
                                            <label for="kost_machines_reparatieUren1" class="form-text text-muted">Uren/Reparatie</label>
                                            <?php echo form_input('kost_machines_reparatieUren1', '', 'id="kost_machines_reparatieUren1" type="number" 
                                        step="0.01" pattern="' . customDecimalNumberPattern() . '" title="' . customDecimalNumberPatternMessage() . '" class="form-control"  '); ?>

                                        </div>
                                        <div class="col-4">
                                            <label for="kost_machines_reparatieUurloon1" class="form-text text-muted"
                                                   style="padding-left:5px">Uurloon</label>
                                            <?php echo form_input('kost_machines_reparatieUurloon1', '', 'id="kost_machines_reparatieUurloon1" type="number" 
                                        step="0.01" pattern="' . customDecimalNumberPattern() . '" title="' . customDecimalNumberPatternMessage() . '" class="form-control" style="margin-left:5px"'); ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- toevoeg button voor jQuery-->
                                <div class="form-row">
                                    <a href="#" id="agricon_add_reparatieFields"
                                       style="font-size: 14px;margin-top: 14px;margin-bottom:24px">Nog een reparatie
                                        toevoegen</a>
                                </div>

                                <!-- met jQuery bijhouden hoeveel reparaties er zijn-->
                                <div hidden>
                                    <?php echo form_input('aantal_reparaties', 1, 'type="number" id="aantal_reparaties" name="aantal_reparaties" '); ?>
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
                                <?php echo form_input(array('name' => 'zoeknaam', 'id' => 'zoeknaam', 'class' => 'form-control', 'placeholder' => '- Zoek -', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = '- Zoek -'"), $zoeknaam_kost_machines_value); ?>
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
                            'id' => 'form_kost_machines_update',
                            'name' => 'form_kost_machines_update',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_kost_machines_update',
                            'name' => 'submit_kost_machines_update',
                            'type' => 'submit');

                        echo form_open('kost_machines/update', $dataOpen);
                        echo form_input('kost_machines_id_update', '', 'id="kost_machines_id_update" class="form-control" required="required" aria-label="kost machines id"');
                        echo form_input('kost_machines_naam_update', 'hier wordt geen rekening meer mee gehouden', 'id="kost_machines_naam_update" type="text" class="form-control" aria-label="kost machines naam"');

                        echo form_input('kost_machines_aankoopPrijs_update', '', 'id="kost_machines_aankoopPrijs_update" type="number" step="0.01" class="form-control" aria-label="kost machines aankoopprijs"');
                        echo form_input('kost_machines_machinesoortid_update', '', 'id="kost_machines_machinesoortid_update" type="number" class="form-control" required="required" aria-label="kost machine soort id"');
                        echo form_input('kost_machines_aantal_update', '', 'id="kost_machines_aantal_update" type="number" class="form-control" aria-label="kost machine aantal"');
                        echo form_input('kost_machines_afschrijfperiodePerJaar_update', '', 'id="kost_machines_afschrijfperiodePerJaar_update" type="number" class="form-control" aria-label="kost machines afschrijfperiode Per Jaar"');

                        echo form_input('kost_machines_onderhoudFrequentiePerJaar_update', '', 'id="kost_machines_onderhoudFrequentiePerJaar_update" type="number" class="form-control" aria-label="kost machines onderhoudFrequentie Per Jaar"');
                        echo form_input('kost_machines_onderhoudKost_update', '', 'id="kost_machines_onderhoudKost_update" type="number" step="0.01" class="form-control" aria-label="kost machines onderhoudskost"');
                        echo form_input('kost_machines_onderhoudUren_update', '', 'id="kost_machines_onderhoudUren_update" type="number" step="0.01" class="form-control" aria-label="kost machines onderhoud uren"');
                        echo form_input('kost_machines_onderhoudUurloon_update', '', 'id="kost_machines_onderhoudUurloon_update" type="number" step="0.01" class="form-control" aria-label="kost machines onderhoud uurloon"');

                        echo form_submit($dataSubmit);
                        echo form_close();
                        ?>
                    </div>
                    <div hidden>
                        <?php
                        $dataOpen = array(
                            'id' => 'form_kost_machines_delete',
                            'name' => 'form_kost_machines_delete',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_kost_machines_delete',
                            'name' => 'submit_kost_machines_delete',
                            'type' => 'submit');

                        echo form_open('kost_machines/delete', $dataOpen);
                        echo form_input('kost_machines_id_delete', '', 'id="kost_machines_id_delete" class="form-control" required="required" aria-label="machine kost id"');
                        echo form_input('kost_machines_naam_delete', '', 'id="kost_machines_naam_delete" type="text" class="form-control" aria-label="kost machines naam"');
                        echo form_submit($dataSubmit);
                        echo form_close();
                        ?>
                    </div>
                    <div hidden>
                        <?php
                        $dataOpen = array(
                            'id' => 'form_getReparaties',
                            'name' => 'form_getReparaties',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_getReparaties',
                            'name' => 'submit_getReparaties',
                            'type' => 'submit');

                        echo form_open('kost_machines_reparaties/beheren', $dataOpen);
                        echo form_input('kost_machines_reparaties_machineid', '', 'id="kost_machines_reparaties_machineid" class="form-control" required="required" aria-label="machine kost id"');
                        echo form_input('kost_machines_reparaties_machinenaam', '', 'id="kost_machines_reparaties_machinenaam" type="text" class="form-control" aria-label="kost machines naam"');
                        echo form_submit($dataSubmit);
                        echo form_close();
                        ?>
                    </div>
                </section>
            </div>
        </div>
    </div>


    <!--    TODO-->
    <?php createBasicDeleteModal('Waarschuwing',
        'Deze machinekost is gekoppeld aan productiekosten.',
        'Deze verwijdering is momenteel nog in ontwikkeling',
        'Wil je deze machinekost verwijderen? ',
        "Verwijder"); ?>

</main>

<script>
    // AJAX
    function ajax_saveToSession(naam, aankoopPrijs, aantal, afschrijfperiodePerJaar, machinesoortid,
                                onderhoudFrequentiePerJaar, onderhoudKost, onderhoudUren, onderhoudUurloon) {
        jQuery.ajax({
            type: "POST",
            url: site_url + "/kost_machines/ajax_save_to_session",
            data: {
                naam: naam,
                aankoopPrijs: aankoopPrijs,
                aantal: aantal,
                afschrijfperiodePerJaar: afschrijfperiodePerJaar,
                machinesoortid: machinesoortid,
                onderhoudFrequentiePerJaar: onderhoudFrequentiePerJaar,
                onderhoudKost: onderhoudKost,
                onderhoudUren: onderhoudUren,
                onderhoudUurloon: onderhoudUurloon
            },
            success: function (result) {
            },
            error: function (xhr, status, error) {
//                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText + error);
            }
        });
    }

    // AJAX TRIGGER (post de form om in session op te slaan)
    function saveToSession() {
        var naam = $("#kost_machines_naam").val();
        var machinesoortid = parseInt($("#kost_machines_machinesoortid").val());
        var aankoopPrijs = $("#kost_machines_aankoopPrijs").val() > 0 ? $("#kost_machines_aankoopPrijs").val() : "";
        var aantal = $("#kost_machines_aantal").val() > 0 ? $("#kost_machines_aantal").val() : "";
        var afschrijfperiodePerJaar = $("#kost_machines_afschrijfperiodePerJaar").val() > 0 ? $("#kost_machines_afschrijfperiodePerJaar").val() : "";
        var onderhoudFrequentiePerJaar = $("#kost_machines_onderhoudFrequentiePerJaar").val() > 0 ? $("#kost_machines_onderhoudFrequentiePerJaar").val() : "";
        var onderhoudKost = $("#kost_machines_onderhoudKost").val() > 0 ? $("#kost_machines_onderhoudKost").val() : "";
        var onderhoudUren = $("#kost_machines_onderhoudUren").val() > 0 ? $("#kost_machines_onderhoudUren").val() : "";
        var onderhoudUurloon = $("#kost_machines_onderhoudUurloon").val() > 0 ? $("#kost_machines_onderhoudUurloon").val() : "";

        ajax_saveToSession(naam, aankoopPrijs, aantal, afschrijfperiodePerJaar, machinesoortid,
            onderhoudFrequentiePerJaar, onderhoudKost, onderhoudUren, onderhoudUurloon);
    }

    function get_byZoekFunctie(deelvannaam) {
        $.ajax({
            type: "POST",
            url: site_url + "/kost_machines/ajax_get_by_zoekfunctie",
            data: {
                zoeknaam: deelvannaam
            },
            success: function (result) {
                $("#resultaat").html(result);
            },
            error: function (xhr, status, error) {
//                alert("-- ERROR IN AJAX get_byZoekFunctie --\n\n" + xhr.responseText + error);
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
        var controlInput_aankoopPrijs = $("#kost_machines_aankoopPrijs");
        var controlInput_onderhoudKost = $("#kost_machines_onderhoudKost");
        var controlInput_onderhoudUren = $("#kost_machines_onderhoudUren");
        var controlInput_onderhoudUurloon = $("#kost_machines_onderhoudUurloon");
        var controlInput_reparatieKost = $("#kost_machines_reparatieKost");
        var controlInput_reparatieUren = $("#kost_machines_reparatieUren");
        var controlInput_reparatieUurloon = $("#kost_machines_reparatieUurloon");

        $(controlInput_aankoopPrijs).add(controlInput_onderhoudKost).add(controlInput_onderhoudUren).add(controlInput_onderhoudUurloon)
            .add(controlInput_reparatieKost).add(controlInput_reparatieUren).add(controlInput_reparatieUurloon).keyup(function () {
            var currentValue = $(this).val();
            var correctValue;
            if (currentValue.includes(",")) {
                correctValue = currentValue.replace(",", ".");
                $(this).val(correctValue);
            }
        });
    }

    function addReparatieFields(e) {
        e.preventDefault();

        var reparatieTeller = (parseInt($('#aantal_reparaties').val()) + 1);
        $('#aantal_reparaties').val(reparatieTeller); //controleren in controller, er kunnen 6 aangemaakt zijn, maar 4 verwijderd van de DOM. Dan zijn er bv oplopende velden met "naam_xxx_1" en "naam_xxx4' -> is dus niet steeds mooi van 1, 2, 3

        $('#agricon_dynamic_formfields').append(
            '<div class="form-row agricon-formcolumn">' +
            '<div class="col-4">' +
            '<input type="text" name="kost_machines_reparatieKost' + reparatieTeller + '" id="kost_machines_reparatieKost' + reparatieTeller + '" class="form-control" ' +
            'type="number"  step="0.01" pattern="^\\d+(?:[\\.,]\\d{1,2})?$"' +
            'title="Geef een geheel of decimaal getal in. Een decimaal moet minimum 1 cijfer voor, en maximum 2 cijfers na het scheidingsteken hebben."/>' +
            '</div>' +
            '<div class="col-4">' +
            '<input type="text" name="kost_machines_reparatieUren' + reparatieTeller + '" id="kost_machines_reparatieUren' + reparatieTeller + '" class="form-control" ' +
            'type="number"  step="0.01"  pattern="^\\d+(?:[\\.,]\\d{1,2})?$"' +
            'title="Geef een geheel of decimaal getal in. Een decimaal moet minimum 1 cijfer voor, en maximum 2 cijfers na het scheidingsteken hebben."/>' +
            '</div>' +
            '<div class="col-4">' +
            '<input type="text" name="kost_machines_reparatieUurloon' + reparatieTeller + '" id="kost_machines_reparatieUurloon' + reparatieTeller + '" class="form-control" ' +
            'type="number"  step="0.01"  pattern="^\\d+(?:[\\.,]\\d{1,2})?$"' +
            'title="Geef een geheel of decimaal getal in. Een decimaal moet minimum 1 cijfer voor, en maximum 2 cijfers na het scheidingsteken hebben." style="margin-left:5px"/>' +
            '</div>' +
            '</div>'
        );
    }

    var readyToSubmit = false;
    function validateBeforeSubmit(e) {
        // gewoon submitten indien deze functie al is uitgevoerd (en dus al gevalideerd is)
        if (readyToSubmit) {
            readyToSubmit = false; // reset
            return;
        }
        e.preventDefault();
        var reparatie1 = $("#kost_machines_reparatieKost1").val();
        var reparatieUren1 = $("#kost_machines_reparatieUren1").val();
        var reparatieUurloon1 = $("#kost_machines_reparatieUurloon1").val();
        var reparatieTeller = parseInt($('#aantal_reparaties').val());

        if ((reparatie1 != '' && reparatie1 != null) && (reparatieUren1 != '' && reparatieUren1 != null) && (reparatieUurloon1 != '' && reparatieUurloon1 != null)) {
            var i = 1;
            for (i; i <= reparatieTeller; i++) {
                // enkel rekening houden met een reparatie die volledig ingevuld is, verwijderen van DOM indien dit niet het geval is
                if (
                    ($('#kost_machines_reparatieKost' + i).val() == null || $('#kost_machines_reparatieKost' + i).val() == 0 || $('#kost_machines_reparatieKost' + i).val() == "") ||
                    ($('#kost_machines_reparatieUren' + i).val() == null || $('#kost_machines_reparatieUren' + i).val() == 0 || $('#kost_machines_reparatieUren' + i).val() == "") ||
                    ($('#kost_machines_reparatieUurloon' + i).val() == null || $('#kost_machines_reparatieUurloon' + i).val() == 0 || $('#kost_machines_reparatieUurloon' + i).val() == "")) {
                    $('#kost_machines_reparatieKost' + i).parent().parent().remove();
                }
            }
            readyToSubmit = true;
            $("#form_kost_machines_beheren").submit(); //submit opnieuw triggeren
        } else {
            // reparaties moet niet gecontroleerd worden
            readyToSubmit = true;
            $("#form_kost_machines_beheren").submit(); //submit opnieuw triggeren
        }
    }
    // ajaxComplete functions ***************************************************************************************


    function ajaxTable_bewerkListener() {
        $(".trigger-bewerkrij").click(function () {
            //controls
            var clickedIconSVG = $(this).find('i');
            var clickedRow = $(this).parent().parent();

            var targetInputField_aankoopPrijs = clickedRow.find('input#editableInput_aankoopPrijs');
            var targetInputField_aantal = clickedRow.find('input#editableInput_aantal');
            var targetInputField_afschrijfperiodePerJaar = clickedRow.find('input#editableInput_afschrijfperiodePerJaar');
            var targetDropdownField_machinesoortid = clickedRow.find('select#editableInput_machinesoortid');
            var targetInputField_onderhoudFrequentiePerJaar = clickedRow.find('input#editableInput_onderhoudFrequentiePerJaar');
            var targetInputField_onderhoudKost = clickedRow.find('input#editableInput_onderhoudKost');
            var targetInputField_onderhoudUren = clickedRow.find('input#editableInput_onderhoudUren');
            var targetInputField_onderhoudUurloon = clickedRow.find('input#editableInput_onderhoudUurloon');

            //data
            var kostMachinesId = $(this).data('id');

            targetInputField_aankoopPrijs.toggleClass('agricon-is-editable-input');

            //wanneer het "editable" is -> icoontje veranderen + autofocus op de input + een class toevoegen
            if (targetInputField_aankoopPrijs.hasClass('agricon-is-editable-input')) {
                clickedRow.addClass('trGlow');
                targetInputField_aankoopPrijs.focus();
                targetInputField_aankoopPrijs.removeAttr('readonly');
                targetInputField_aantal.removeAttr('readonly');
                targetInputField_afschrijfperiodePerJaar.removeAttr('readonly');
                targetDropdownField_machinesoortid.removeAttr('disabled');
                targetInputField_onderhoudFrequentiePerJaar.removeAttr('readonly');
                targetInputField_onderhoudKost.removeAttr('readonly');
                targetInputField_onderhoudUren.removeAttr('readonly');
                targetInputField_onderhoudUurloon.removeAttr('readonly');

                clickedIconSVG.removeClass('fa-pencil-alt');
                clickedIconSVG.addClass('fa-save');
            } else {
                // anders alles terugzetten + gegevens updaten in de database
                clickedRow.removeClass('trGlow');
                targetInputField_aankoopPrijs.attr('readonly', 'readonly');
                targetInputField_aantal.attr('readonly', 'readonly');
                targetInputField_afschrijfperiodePerJaar.attr('readonly', 'readonly');
                targetDropdownField_machinesoortid.attr('disabled', 'disabled');
                targetInputField_onderhoudFrequentiePerJaar.attr('readonly', 'readonly');
                targetInputField_onderhoudKost.attr('readonly', 'readonly');
                targetInputField_onderhoudUren.attr('readonly', 'readonly');
                targetInputField_onderhoudUurloon.attr('readonly', 'readonly');

                clickedIconSVG.removeClass('fa-save');
                clickedIconSVG.addClass('fa-pencil-alt');

                //hidden form opvullen
                var kostMachinesAankoopPrijs = targetInputField_aankoopPrijs.val();
                var kostMachinesAantal = targetInputField_aantal.val();
                var kostMachinesAfschrijfperiodePerJaar = targetInputField_afschrijfperiodePerJaar.val();
                var kostMachinesMachineSoortId = targetDropdownField_machinesoortid.val();
                var kostMachinesOnderhoudFrequentiePerJaar = targetInputField_onderhoudFrequentiePerJaar.val();
                var kostMachinesOnderhoudKost = targetInputField_onderhoudKost.val();
                var kostMachinesOnderhoudUren = targetInputField_onderhoudUren.val();
                var kostMachinesOnderhoudUurloon = targetInputField_onderhoudUurloon.val();

                if (kostMachinesAankoopPrijs != "" && kostMachinesAankoopPrijs != null && kostMachinesId != 0 && kostMachinesId != null) {
                    $("#form_kost_machines_update input#kost_machines_id_update").val(kostMachinesId);
                    $("#form_kost_machines_update input#kost_machines_aankoopPrijs_update").val(kostMachinesAankoopPrijs);
                    $("#form_kost_machines_update input#kost_machines_aantal_update").val(kostMachinesAantal);
                    $("#form_kost_machines_update input#kost_machines_afschrijfperiodePerJaar_update").val(kostMachinesAfschrijfperiodePerJaar);
                    $("#form_kost_machines_update input#kost_machines_machinesoortid_update").val(kostMachinesMachineSoortId);
                    $("#form_kost_machines_update input#kost_machines_onderhoudFrequentiePerJaar_update").val(kostMachinesOnderhoudFrequentiePerJaar);
                    $("#form_kost_machines_update input#kost_machines_onderhoudKost_update").val(kostMachinesOnderhoudKost);
                    $("#form_kost_machines_update input#kost_machines_onderhoudUren_update").val(kostMachinesOnderhoudUren);
                    $("#form_kost_machines_update input#kost_machines_onderhoudUurloon_update").val(kostMachinesOnderhoudUurloon);

                    $("#form_kost_machines_update").submit();
                }
            }
        });
    }

    function ajaxTable_bewerkListener_vervangKommasDoorPunt() {
        // kommas vervangen door een punt
        var controlInput_aankoopPrijs = $("#editableInput_aankoopPrijs");
        var controlInput_onderhoudKost = $("#editableInput_onderhoudKost");
        var controlInput_onderhoudUren = $("#editableInput_onderhoudUren");
        var controlInput_onderhoudUurloon = $("#editableInput_onderhoudUurloon");
        var controlInput_reparatieKost = $("#editableInput_reparatieKost");
        var controlInput_reparatieUren = $("#editableInput_reparatieUren");
        var controlInput_reparatieUurloon = $("#editableInput_reparatieUurloon");

        $(controlInput_aankoopPrijs).add(controlInput_onderhoudKost).add(controlInput_onderhoudUren).add(controlInput_onderhoudUurloon)
            .add(controlInput_reparatieKost).add(controlInput_reparatieUren).add(controlInput_reparatieUurloon).keyup(function () {
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
            // hidden form opvullen
            var kostMachinesId = $(this).data('id');
            var kostMachinesNaam = $(this).data('kostmachinenaam');

            if (kostMachinesId != 0 && kostMachinesId != null) {
                $("#form_kost_machines_delete input#kost_machines_id_delete").val(kostMachinesId);
                $("#form_kost_machines_delete input#kost_machines_naam_delete").val(kostMachinesNaam);
            }
            $('#deleteModal').modal('show');
        });
    }

    function ajaxTable_verwijderModalListener() {
        $('#deleteAllData').click(function (e) {
            $('#deleteModal').modal('hide');
            $("#form_kost_machines_delete").submit();
        });
    }

    function showReparatiesListener() {
        // TRIGGER - GET FRACTIES (=AFGEWERKTE GRONDSTOFFEN)
        $(".trigger-show-reparaties").click(function () {
            // hidden form opvullen
            var machienId = $(this).data('machineid');
            var machineNaam = $(this).data('machinenaam');

            $("#form_getReparaties input#kost_machines_reparaties_machineid").val(machienId);
            $("#form_getReparaties input#kost_machines_reparaties_machinenaam").val(machineNaam);
            $("#form_getReparaties").submit();
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
        // reparatie-toevoegButton-trigger
        $("#agricon_add_reparatieFields").click(function (e) {
            addReparatieFields(e);
        });
        // bij klikken van de "OPSLAAN" knop, eerst controleren of alle reparaties ingevuld zijn
        $('#form_kost_machines_beheren').on('submit', function (e) {
            validateBeforeSubmit(e);
        });
        showReparatiesListener();
    });
</script>
