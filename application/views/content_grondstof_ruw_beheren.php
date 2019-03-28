<main role="main" class="container" id="content_grondstof_ruw_beheren">
    <div class="row agricon-content-title">
        <h3><?php echo $title; ?></h3>
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
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne"
                                    aria-expanded="true" aria-controls="collapseOne">
                                NIEUW
                            </button>
                        </h5>
                    </div>
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <?php
                            $dataOpen = array(
                                'id' => 'form_grondstof_ruw_beheren',
                                'name' => 'form_grondstof_ruw_beheren',
                                'data-toggle' => 'validator',
                                'role' => 'form');

                            $dataSubmit = array(
                                'id' => 'submit_grondstof_ruw_beheren',
                                'name' => 'submit_grondstof_ruw_beheren',
                                'type' => 'submit',
                                'value' => 'Opslaan',
                                'class' => 'btn btn-outline-success agricon-formsubmit-button');
                            ?>
                            <?php echo form_open('grondstof_ruw/insert', $dataOpen); ?>
                            <section>
                                <div class="form-row">
                                    <label for="grondstof_ruw_naam" class="form-text text-muted">Naam *</label>
                                    <?php echo form_input('grondstof_ruw_naam', $formData->grondstof_ruw_naam, 'autofocus id="grondstof_ruw_naam" type="text" class="form-control" required="required" placeholder="bv Garden Decor" aria-label="Naam"'); ?>
                                </div>

                                <div class="form-row agricon-formcolumn">
                                    <div class="col-11 ">
                                        <label for="grondstof_ruw_categorieid"
                                               class="form-text text-muted">Categorie *</label>

                                        <?php echo form_dropdown('grondstof_ruw_categorieid', $grondstofCategorieen_dropdownOptions, $formData->grondstof_ruw_categorieid, 'id="grondstof_ruw_categorieid" class="form-control" required="required" '); ?>
                                    </div>
                                    <div class="col-1">
                                        <?php echo anchor('grondstof_categorie/beheren/' . true, '<div class="agricon-fa-icon-plus" data-toggle="tooltip" data-placement="bottom" title="Nieuwe categorie"><i class="fas fa-plus-circle"></i></div>', 'onclick="saveToSession()"'); ?>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label for="grondstof_ruw_aankoopprijs"
                                           class="form-text text-muted">Aankoopprijs *</label>
                                    <?php echo form_input('grondstof_ruw_aankoopprijs', $formData->grondstof_ruw_aankoopprijs, 'id="grondstof_ruw_aankoopprijs" type="number" 
                         step="0.01" pattern="' . customDecimalNumberPattern() . '" title="' . customDecimalNumberPatternMessage() . '" class="form-control" required="required" '); ?>
                                </div>

                                <div class="form-row agricon-formcolumn">
                                    <div class="col-11">
                                        <label for="grondstof_ruw_aankoopprijs_eenheidid" class="form-text text-muted">Aankoopprijs
                                            eenheid *</label>
                                        <?php echo form_dropdown('grondstof_ruw_aankoopprijs_eenheidid', $eenheden_dropdownOptions, $formData->grondstof_ruw_aankoopprijs_eenheidid, 'id="grondstof_ruw_aankoopprijs_eenheidid" class="form-control" required="required" '); ?>
                                    </div>
                                    <div class="col-1">
                                        <?php echo anchor('configuratie/eenheden_beheren/' . true, '<div class="agricon-fa-icon-plus" data-toggle="tooltip" data-placement="bottom" title="Nieuwe eenheid"><i class="fas fa-plus-circle"></i></div>', 'onclick="saveToSession()"'); ?>
                                    </div>
                                </div>

                                <div class="form-row agricon-content-divider" style="margin-top: 75px">
                                    <h6>Fracties instellen (optioneel) </h6>
                                </div>

                                <div id="agricon_dynamic_formfields" style="margin: 0;padding: 0">
                                    <div class="form-row agricon-formcolumn">
                                        <div class="col-4">
                                            <label for="grondstof_ruw_afgewerkt-fractie1"
                                                   class="form-text text-muted agricon-fractie-counter">Naam
                                            </label>
                                            <?php echo form_input('grondstof_ruw_afgewerkt-fractie1', '', 'id="grondstof_ruw_afgewerkt-fractie1" type="text" class="form-control" placeholder="bv 15-25" aria-label="Fractie"'); ?>
                                        </div>
                                        <div class="col-2">
                                            <label for="grondstof_ruw_afgewerkt-percentage1"
                                                   class="form-text text-muted">Percentage</label>
                                            <?php echo form_input('grondstof_ruw_afgewerkt-percentage1', '', 'id="grondstof_ruw_afgewerkt-percentage1" type="number" pattern="' . customNumberPattern() . '" title="' . customNumberPatternMessage() . '"  class="form-control" placeholder="bv 70" aria-label="Percentage"'); ?>
                                        </div>
                                        <div class="col-2">
                                            <label for="grondstof_ruw_afgewerkt-prijs1"
                                                   class="form-text text-muted">Aankooppijs</label>
                                            <?php echo form_input('grondstof_ruw_afgewerkt-prijs1', '', 'id="grondstof_ruw_afgewerkt-prijs1" type="number" step="0.01" pattern="' . customDecimalNumberPattern() . '" title="' . customDecimalNumberPatternMessage() . '"  class="form-control" placeholder="bv 10" aria-label="aankoopprijs"'); ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- toevoeg button voor jQuery-->
                                <div class="form-row">
                                    <a href="#" id="agricon_add_fractieOptie"
                                       style="font-size: 14px;margin-top: 14px;margin-bottom:24px">Nog een fractie
                                        toevoegen</a>
                                </div>

                                <!-- met jQuery bijhouden hoeveel fracties er zijn-->
                                <div hidden>
                                    <?php echo form_input('aantal_fracties', "1", 'type="number" id="aantal_fracties" name="aantal_fracties" '); ?>
                                </div>

                                <div class="form-row agricon-formsubmit-container">
                                    <?php
                                    echo form_submit($dataSubmit);

                                    if (isset($show_back_button)) {
                                        if ($show_back_button) {
                                            echo '<button type="button" class="btn btn-outline-secondary" onclick="goBack()">Terug</button>';
                                        }
                                    }
                                    ?>
                                </div>
                            </section>
                            <?php echo form_close(); ?>
                            <div id="errorMessage_fractiePercentageContainer">
                                <p id="errorMessage_fractiePercentage">
                                    <span hidden id="errorMessage_innercontainer_fractiePercentage">
                                         Het totaal van de facties is <span id="errorMessage_fractiePercentage_value"
                                                                            style="font-weight: bold"></span>
                                        % maar moet 100% zijn.<br>
                                    </span>
                                    <span hidden id="errorMessage_innercontainer_prijs">
                                         Het totaal van de aankoopprijs is <span id="errorMessage_prijs_value"
                                                                                 style="font-weight: bold"></span> maar
                                        moet <span id="errorMessage_prijsTOTAAL_value"></span> zijn.<br>
                                    </span>
                                </p>
                            </div>
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
                                <?php echo form_input(array('name' => 'zoeknaam', 'id' => 'zoeknaam', 'class' => 'form-control', 'placeholder' => '- Zoek -', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = '- Zoek -'"), $zoeknaam_grondstofruw_value); ?>
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
                            'id' => 'form_grondstof_ruw_update',
                            'name' => 'form_grondstof_ruw_update',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_grondstof_ruw_update',
                            'name' => 'submit_grondstof_ruw_update',
                            'type' => 'submit');

                        echo form_open('grondstof_ruw/update', $dataOpen);
                        echo form_input('grondstof_ruw_id_update', '', 'id="grondstof_ruw_id_update" class="form-control" required="required" aria-label="Id"');
                        echo form_input('grondstof_ruw_naam_update', '', 'id="grondstof_ruw_naam_update" class="form-control" required="required" aria-label="Naam"');
                        echo form_input('grondstof_ruw_categorieid_update', '', 'id="grondstof_ruw_categorieid_update" class="form-control" required="required" aria-label="Naam"');
                        echo form_input('grondstof_ruw_aankoopprijs_update', '', 'id="grondstof_ruw_aankoopprijs_update" class="form-control" required="required" aria-label="Aankoopprijs"');
                        echo form_input('grondstof_ruw_aankoopprijs_eenheid_update', '', 'id="grondstof_ruw_aankoopprijs_eenheid_update" class="form-control" required="required" aria-label="Eenheid"');
                        echo form_submit($dataSubmit);
                        echo form_close();
                        ?>
                    </div>
                    <div hidden>
                        <?php
                        $dataOpen = array(
                            'id' => 'form_grondstof_ruw_delete',
                            'name' => 'form_grondstof_ruw_delete',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_grondstof_ruw_delete',
                            'name' => 'submit_grondstof_ruw_delete',
                            'type' => 'submit');

                        echo form_open('grondstof_ruw/delete', $dataOpen);
                        echo form_input('grondstof_ruw_id_delete', '', 'id="grondstof_ruw_id_delete" class="form-control" required="required" aria-label="Id"');
                        echo form_input('grondstof_ruw_naam_delete', '', 'id="grondstof_ruw_naam_delete" class="form-control" required="required" aria-label="Naam"');
                        echo form_submit($dataSubmit);
                        echo form_close();
                        ?>
                    </div>
                    <div hidden>
                        <?php
                        $dataOpen = array(
                            'id' => 'form_getfracties',
                            'name' => 'form_getfracties',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_getfracties',
                            'name' => 'submit_getfracties',
                            'type' => 'submit');

                        echo form_open('grondstof_afgewerkt/fractiesbeheren_byGrondstofRuwId/' . true, $dataOpen);
                        echo form_input('grondstof_ruw_id_fracties', '', 'id="grondstof_ruw_id_fracties" class="form-control" required="required" aria-label="Id"');
                        echo form_input('grondstof_ruw_naam_fracties', '', 'id="grondstof_ruw_naam_fracties" class="form-control" required="required" aria-label="Naam"');
                        echo form_submit($dataSubmit);
                        echo form_close();
                        ?>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <?php createBasicDeleteModal('Waarschuwing',
        'Deze ruwe grondstof is gekoppeld aan grondstoffen.',
        'Deze ruwe grondstof heeft afgewerkte grondstoffen (fracties of niet) die gebruikt worden bij de samenstellingen van producten. Wanneer je deze ruwe grondstof verwijderd, zullen alle bijhorende grondstoffen mee verwijderd worden. <br><br>Producten die samengesteld zijn uit één van deze grondstoffen hebben geen totaal percentage (%) van 100 meer en zullen mee verwijderd worden.',
        'Wil je deze ruwe grondstof verwijderen? ',
        "Verwijder"); ?>

</main>


<script>
    // AJAX
    function ajax_saveToSession(naam, aankoopprijs, aankoopprijs_eenheidid, categorieid) {
        jQuery.ajax({
            type: "POST",
            url: site_url + "/grondstof_ruw/ajax_save_to_session",
            data: {
                naam: naam,
                aankoopprijs: aankoopprijs,
                aankoopprijs_eenheidid: aankoopprijs_eenheidid,
                categorieid: categorieid
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
        var naam = $("#grondstof_ruw_naam").val();
        var aankoopprijs = parseFloat($("#grondstof_ruw_aankoopprijs").val());
        var aankoopprijs_eenheidid = parseInt($("#grondstof_ruw_aankoopprijs_eenheidid").val());
        var categorieid = parseInt($("#grondstof_ruw_categorieid").val());
        ajax_saveToSession(naam, aankoopprijs, aankoopprijs_eenheidid, categorieid);
    }

    function get_byZoekFunctie(deelvannaam) {
        $.ajax({
            type: "POST",
            url: site_url + "/grondstof_ruw/ajax_get_by_zoekfunctie",
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
        // kommas vervangen door een punt
        var controlInput_aankoopprijs = $("#grondstof_ruw_aankoopprijs");
        controlInput_aankoopprijs.keyup(function () {
            var prijs = $(this).val();
            var correctValue;
            if (prijs.includes(",")) {
                correctValue = prijs.replace(",", ".");
                controlInput_aankoopprijs.val(correctValue);
            }
        });
    }

    // ajaxComplete functions ***************************************************************************************
    function ajaxTable_bewerkListener_vervangKommasDoorPunt() {
        // kommas vervangen door een punt
        var controlInput_editable_aankoopprijs = $("#editableInput_prijs");
        controlInput_editable_aankoopprijs.keyup(function () {
            var prijs = $(this).val();
            var correctValue;
            if (prijs.includes(",")) {
                correctValue = prijs.replace(",", ".");
                controlInput_editable_aankoopprijs.val(correctValue);
            }
        });
    }

    function addFractieOpionListener() {
        // fractie-toevoegButton
        $("#agricon_add_fractieOptie").click(function (e) {
            e.preventDefault();
            fractieTeller++;
            $('#agricon_dynamic_formfields').append(
                "<div class='form-row agricon-formcolumn'>" +
                "<div class='col-4'>" +
                "<input type='text' name='grondstof_ruw_afgewerkt-fractie" + fractieTeller + "' id='grondstof_ruw_afgewerkt-fractie" + fractieTeller + "' class='form-control' />" +
                "</div>" +
                "<div class='col-2'>" +
                "<input type='number' name='grondstof_ruw_afgewerkt-percentage" + fractieTeller + "' id='grondstof_ruw_afgewerkt-percentage" + fractieTeller + "' class='form-control' pattern='[0-9]+' title='Enkel numerieke karakters zijn toegelaten.' />" +
                "</div>" +
                "<div class='col-2'>" +
                "<input type='number' name='grondstof_ruw_afgewerkt-prijs" + fractieTeller + "' id='grondstof_ruw_afgewerkt-prijs" + fractieTeller + "' class='form-control' pattern='^\\d+(?:[\\.,]\\d{1,2})?$' title='Geef een geheel of decimaal getal in. Een decimaal moet minimum 1 cijfer voor, en maximum 2 cijfers na het scheidingsteken hebben.' />" +
                "</div>" +
                "</div>"
            );
            // hou bij hoeveel fracties er zijn in het hidden formfield
            // var number = $( "label.agricon-fractie-counter" ).length;
            $('#aantal_fracties').val(fractieTeller);
        });
    }
    function ajaxTable_onSubmitListener() {
        //bij klikken van de "OPSLAAN" knop, eerst controleren of het totale fractie procent 100
        $('#form_grondstof_ruw_beheren').on('submit', function (e) {
            // gewoon submitten indien deze functie al is uitgevoerd (en dus al gevalideerd is)
            if (readyToSubmit) {
                readyToSubmit = false; // reset
                return; // doorgaan met submit (formulier is reeds gevalideerd door voorgaande loop in deze functie)
            }

            e.preventDefault();

            var totaleFractiePercentage = 0;
            var totalePrijs = 0;
            var prijsDatHetMoetZijn = parseFloat($('input#grondstof_ruw_aankoopprijs').val());

            var fractie1 = $("#grondstof_ruw_afgewerkt-fractie1").val();
            var percentage1_raw = $("#grondstof_ruw_afgewerkt-percentage1").val();
            var percentage1 = percentage1_raw.replace(/[^\d.]/g, ''); //niet-numerieke karakters eruithalen
            var prijs1_raw = $("#grondstof_ruw_afgewerkt-prijs1").val();
            var prijs1 = prijs1_raw.replace(/[^\d.]/g, ''); //niet-numerieke karakters eruithalen

            // vervang de mogelijke incorrecte value door de correcte value in de form
            $("#grondstof_ruw_afgewerkt-percentage1").val(percentage1);
            $("#grondstof_ruw_afgewerkt-prijs1").val(prijs1);

            //als beide waarden van "fractie 1" zijn ingevuld, testen of deze percentage 100% is, anders message tonen
            if ((fractie1 != '' && fractie1 != null) && (percentage1 != '' && percentage1 != null) && (prijs1 != '' && prijs1 != null)) {
                // TESTEN OP totale 100%-waarde
                // aantal fracties is de 'fractieTeller' die verhoogt wordt bij het klikken op "nieuwe fratie toevoegen"
                var i;
                var percentage;
                var percentage_raw;
                var prijs;
                var prijs_raw;

                for (i = 1; i <= fractieTeller; i++) {
                    // enkel rekenen met percentages als zowel de naam, percentage  én de prijs is ingevuld.
                    if ($('#grondstof_ruw_afgewerkt-fractie' + i).val() != null && $('#grondstof_ruw_afgewerkt-fractie' + i).val() != ""
                        && $('#grondstof_ruw_afgewerkt-percentage' + i).val() != null && $('#grondstof_ruw_afgewerkt-percentage' + i).val() != 0
                        && $('#grondstof_ruw_afgewerkt-prijs' + i).val() != null && $('#grondstof_ruw_afgewerkt-prijs' + i).val() != 0) {

                        percentage_raw = $('#grondstof_ruw_afgewerkt-percentage' + i).val();
                        prijs_raw = $('#grondstof_ruw_afgewerkt-prijs' + i).val();

                        percentage = percentage_raw.replace(/[^\d.]/g, ''); //niet-numerieke karakters eruithalen
                        prijs = prijs_raw.replace(/[^\d.]/g, ''); //niet-numerieke karakters eruithalen

                        //indien er een veld werd bijgemaakt in de form, maar niet werdt ingevuld, is deze een lege STRING
                        if (!isNaN(parseInt(percentage))) {
                            totaleFractiePercentage += parseInt(percentage);
                        }
                        if (!isNaN(parseInt(prijs))) {
                            totalePrijs += parseFloat(prijs);
                        }

                        // vervang de mogelijke incorrecte value door de correcte value in de form
                        $('#grondstof_ruw_afgewerkt-percentage' + i).val(percentage);
                        $('#grondstof_ruw_afgewerkt-prijs' + i).val(prijs);
                    }
                }

                if (totaleFractiePercentage == 100 && totalePrijs == prijsDatHetMoetZijn) {
                    readyToSubmit = true;
                    $("#form_grondstof_ruw_beheren").submit();
                } else {
                    if (totaleFractiePercentage != 100) {
                        // error message naast de opslaan-knop tonen ("is geen 100%!")
                        $('#errorMessage_fractiePercentage_value').text(totaleFractiePercentage);
//                        $('#errorMessage_fractiePercentage').removeAttr('hidden');
                        $('#errorMessage_innercontainer_fractiePercentage').removeAttr('hidden');

                    } else {
                        $('#errorMessage_innercontainer_fractiePercentage').attr('hidden', 'hidden');
                    }
                    if (totalePrijs !== prijsDatHetMoetZijn) {
                        // error message naast de opslaan-knop tonen ("is geen 100%!")
                        $('#errorMessage_prijsTOTAAL_value').text(prijsDatHetMoetZijn);
                        $('#errorMessage_prijs_value').text(totalePrijs);
//                        $('#errorMessage_prijs').removeAttr('hidden');
                        $('#errorMessage_innercontainer_prijs').removeAttr('hidden');

                    } else {
                        $('#errorMessage_innercontainer_prijs').attr('hidden', 'hidden');
                    }
                }
            }
        });
    }

    function ajaxTable_bewerkListener() {
        $(".trigger-bewerkrij").click(function () {
            //controls
            var clickedIconSVG = $(this).find('i');
            var clickedRow = $(this).parent().parent();
            var targetInputField_Name = clickedRow.find('input#editableInput_naam');
            var targetInputField_Prijs = clickedRow.find('input#editableInput_prijs');
            var targetDropdownField_Categorie = clickedRow.find('select#editableInput_grondstofcategorie');
            var targetDropdownField_Eenheid = clickedRow.find('select#editableInput_grondstofeenheid');

            //data
            var grondstofRuwId = $(this).data('id');

            targetInputField_Name.toggleClass('agricon-is-editable-input');
            //wanneer het "editable" is -> icoontje veranderen + autofocus op de input + een class toevoegen
            if (targetInputField_Name.hasClass('agricon-is-editable-input')) {
                clickedRow.addClass('trGlow');
                targetInputField_Name.focus();
                targetInputField_Name.removeAttr('readonly');
                targetInputField_Prijs.removeAttr('readonly');
                targetDropdownField_Categorie.removeAttr('disabled');
                targetDropdownField_Eenheid.removeAttr('disabled');

                clickedIconSVG.removeClass('fa-pencil-alt');
                clickedIconSVG.addClass('fa-save');
            } else {
                // anders alles terugzetten + gegevens updaten in de database
                clickedRow.removeClass('trGlow');
                targetInputField_Name.attr('readonly', 'readonly');
                targetInputField_Prijs.attr('readonly', 'readonly');
                targetDropdownField_Categorie.attr('disabled', 'disabled');
                targetDropdownField_Eenheid.attr('disabled', 'disabled');

                clickedIconSVG.removeClass('fa-save');
                clickedIconSVG.addClass('fa-pencil-alt');

                //hidden form opvullen
                var grondstofRuwNaam = targetInputField_Name.val();
                var grondstofRuwCategorieId = targetDropdownField_Categorie.val();
                var grondstofRuwAankoopprijs = targetInputField_Prijs.val();
                var grondstofRuwAankoopprijsEenheidId = targetDropdownField_Eenheid.val();

                if (grondstofRuwNaam != "" && grondstofRuwNaam != null && grondstofRuwId != 0 && grondstofRuwId != null) {
                    $("#form_grondstof_ruw_update input#grondstof_ruw_id_update").val(grondstofRuwId);
                    $("#form_grondstof_ruw_update input#grondstof_ruw_naam_update").val(grondstofRuwNaam);
                    $("#form_grondstof_ruw_update input#grondstof_ruw_categorieid_update").val(grondstofRuwCategorieId);
                    $("#form_grondstof_ruw_update input#grondstof_ruw_aankoopprijs_update").val(grondstofRuwAankoopprijs);
                    $("#form_grondstof_ruw_update input#grondstof_ruw_aankoopprijs_eenheid_update").val(grondstofRuwAankoopprijsEenheidId);
                    $("#form_grondstof_ruw_update").submit();
                }
            }
        });
    }


    function ajaxTable_verwijderListener_showModal() {
        $(".agricon-delete-icon").click(function () {
            // hidden form opvullen
            var grondstofRuwId = $(this).data('id');
            var grondstofRuwNaam = $(this).data('grondstofruwnaam');

            if (grondstofRuwId != 0 && grondstofRuwId != null) {
                $("#form_grondstof_ruw_delete input#grondstof_ruw_id_delete").val(grondstofRuwId);
                $("#form_grondstof_ruw_delete input#grondstof_ruw_naam_delete").val(grondstofRuwNaam);
            }
            $('#deleteModal').modal('show');
        });
    }

    function ajaxTable_verwijderModalListener() {
        $('#deleteAllData').click(function (e) {
            $('#deleteModal').modal('hide');
            $("#form_grondstof_ruw_delete").submit();
        });
    }

    function showFractionsListener() {
        // TRIGGER - GET FRACTIES (=AFGEWERKTE GRONDSTOFFEN)
        $(".trigger-show-fractions").click(function () {
            // hidden form opvullen
            var grondstofRuwId = $(this).data('id');
            var grondstofRuwNaam = $(this).data('grondstofruwnaam');
            $("#form_getfracties input#grondstof_ruw_id_fracties").val(grondstofRuwId);
            $("#form_getfracties input#grondstof_ruw_naam_fracties").val(grondstofRuwNaam);
            $("#form_getfracties").submit();
        });
    }

    $(document).ready(function () {
        get_byZoekFunctie($("#zoeknaam").val());
        formListener_zoekOpNaam();
        formEditListener_vervangKommasDoorPunt();
    });

    var fractieTeller = 1;
    var readyToSubmit;
    $(document).ajaxComplete(function () {
        readyToSubmit = false;
        ajaxTable_bewerkListener_vervangKommasDoorPunt();
        addFractieOpionListener();
        ajaxTable_onSubmitListener();
        ajaxTable_bewerkListener();
        ajaxTable_verwijderListener_showModal();
        ajaxTable_verwijderModalListener();
        showFractionsListener();
    });
</script>


