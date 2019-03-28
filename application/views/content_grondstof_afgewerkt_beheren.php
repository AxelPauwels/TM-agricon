<main role="main" class="container" id="content_grondstof_afgewerkt_beheren">
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
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne"
                                    aria-expanded="true" aria-controls="collapseOne">
                                NIEUW
                            </button>
                        </h5>
                    </div>
                    <div id="collapseOne" class="collapse " aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <section style="margin-top: 0">
                                  <span style="font-size: 12px">Grondstof-fracties kunnen hier niet aangemaakt worden. Fracties worden automatisch aangemaakt bij het toevoegen van een "ruwe grondstof".<br>
                                Je kan fracties beheren via ruwe grondstoffen. Hieronder bij "bestaande wijzigen" of via Beheer/GrondstoffenRuw/Bestaande Wijzigen.</span>

                            </section>

                            <?php
                            $dataOpen = array(
                                'id' => 'form_grondstof_afgewerkt_beheren',
                                'name' => 'form_grondstof_afgewerkt_beheren',
                                'data-toggle' => 'validator',
                                'role' => 'form');

                            $dataSubmit = array(
                                'id' => 'submit_grondstof_afgewerkt_beheren',
                                'name' => 'submit_grondstof_afgewerkt_beheren',
                                'type' => 'submit',
                                'value' => 'Opslaan',
                                'class' => 'btn btn-outline-success agricon-formsubmit-button');
                            ?>
                            <?php echo form_open('grondstof_afgewerkt/insert', $dataOpen); ?>
                            <section>
                                <div class="form-row agricon-formcolumn">
                                    <div class="col-11 ">
                                        <label for="grondstof_afgewerkt_categorieid"
                                               class="form-text text-muted">Categorie</label>
                                        <?php echo form_dropdown('grondstof_afgewerkt_categorieid', $grondstofCategorieen_enkelVoorFracties_dropdownOptions, $formData->grondstof_afgewerkt_categorieid, 'id="grondstof_afgewerkt_categorieid" class="form-control" required="required" '); ?>
                                    </div>
                                    <div class="col-1">
                                        <?php echo anchor('grondstof_categorie/beheren/' . true, '<div class="agricon-fa-icon-plus" data-toggle="tooltip" data-placement="bottom" title="Nieuwe categorie"><i class="fas fa-plus-circle"></i></div>', 'onclick="saveToSession()"'); ?>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <label for="grondstof_afgewerkt_naam" class="form-text text-muted">Naam</label>
                                    <?php echo form_input('grondstof_afgewerkt_naam', $formData->grondstof_afgewerkt_naam, 'id="grondstof_afgewerkt_naam" autofocus class="form-control" required="required" placeholder="bv kalk min 12V" aria-label="Naam"'); ?>
                                </div>

                                <div class="form-row">
                                    <label for="grondstof_afgewerkt_aankoopprijs"
                                           class="form-text text-muted">Aankoopprijs</label>
                                    <?php echo form_input('grondstof_afgewerkt_aankoopprijs', $formData->grondstof_afgewerkt_aankoopprijs, 'id="grondstof_afgewerkt_aankoopprijs" type="number" 
                         step="0.01" pattern="' . customDecimalNumberPattern() . '" title="' . customDecimalNumberPatternMessage() . '" class="form-control" required="required" '); ?>
                                </div>

                                <div class="form-row agricon-formcolumn">
                                    <div class="col-11">
                                        <label for="grondstof_afgewerkt_aankoopprijs_eenheidid"
                                               class="form-text text-muted">Aankoopprijs
                                            eenheid</label>
                                        <?php echo form_dropdown('grondstof_afgewerkt_aankoopprijs_eenheidid', $eenheden_dropdownOptions, $formData->grondstof_afgewerkt_aankoopprijs_eenheidid, 'id="grondstof_afgewerkt_aankoopprijs_eenheidid" class="form-control" required="required" '); ?>
                                    </div>
                                    <div class="col-1">
                                        <?php echo anchor('configuratie/eenheden_beheren/' . true, '<div class="agricon-fa-icon-plus" data-toggle="tooltip" data-placement="bottom" title="Nieuwe eenheid"><i class="fas fa-plus-circle"></i></div>', 'onclick="saveToSession()"'); ?>
                                    </div>
                                </div>

                                <div class="form-row agricon-formsubmit-container">
                                    <?php
                                    echo form_submit($dataSubmit);

                                    if ($show_back_button) {
                                        echo '<button type="button" class="btn btn-outline-secondary" onclick="goBack()">Terug</button>';
                                    }
                                    ?>
                                </div>
                            </section>
                            <?php echo form_close(); ?>
                            <div id="errorMessage_fractiePercentageContainer">
                                <p hidden id="errorMessage_fractiePercentage">ERROR<br>
                                    Het totaal van de facties moet 100% zijn. Momenteel is deze <span
                                            id="errorMessage_fractiePercentage_value" style="font-weight: bold"></span>%.
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
                            <div class="form-row agricon-wijzigbestaande-zoekveld">
                                <div class="col-6">
                                    <label for="grondstof_afgewerkt_grondstofcategorieid"
                                           class="form-text text-muted">Grondstof Categorie</label>
                                    <?php echo form_dropdown('grondstof_afgewerkt_grondstofcategorieid', $grondstof_categorieen_dropdownOptions, $zoekid_categorieid_value, 'id="grondstof_afgewerkt_grondstofcategorieid" class="form-control" required="required" '); ?>
                                </div>
                                <div class="col-6" hidden id="tweededropdown">
                                    <label for="grondstof_afgewerkt_grondstofid"
                                           class="form-text text-muted">Grondstof</label>
                                    <?php echo form_dropdown('grondstof_afgewerkt_grondstofid', array(), '', 'id="grondstof_afgewerkt_grondstofid" class="form-control" required="required" '); ?>
                                </div>
                            </div>
                            <input hidden id="hiddenDropdownValueFromSession"
                                   value="<?php echo $zoekid_categorieid_value; ?>">
                            <input hidden id="hiddenDropdownValue2FromSession"
                                   value="<?php echo $zoekid_grondstofruwid_value; ?>">
                            <section id="resultaat">

                            </section>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!--    deletemodal voor niet fracties-->
    <?php createBasicDeleteModal('Waarschuwing',
        'Deze grondstof is gekoppeld aan producten.',
        'Deze grondstof wordt gebruikt bij samenstellingen van producten. <br>Indien deze grondstof bij de samenstelling percentage-gebaseerd (%) is, zal deze naar "Geen" gelinkt worden.',
        'Wil je deze grondstof verwijderen? ',
        "Verwijder"); ?>

    <!--    deletemodal voor fracties (zonder helper omdat dit id "deleteModal2" moet hebben) -->
    <div id="deleteModal2" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-exclamation-triangle"> </i>Waarschuwing</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Deze fractie is gekoppeld aan producten.<br><span style="font-size: 12px;font-style: italic">
                             Deze fractie wordt gebruikt bij samenstellingen van producten. De samenstelling zal naar "Geen" gelinkt worden.<br><br>Indien dit de laatste fractie is zal ook de ruwe grondstof verwijderd worden. Producten die samengesteld zijn uit deze ruwe grondstof hebben geen totaal percentage (%) van 100 meer en zullen dus mee verwijderd worden.
                        </span><br><br>Wil je deze fractie verwijderen?</p>
                </div>
                <div class="modal-footer">
                    <button id="deleteAllData2" type="button" class="btn btn-danger">Verwijder</button>
                    <button type="button" class="btn btn-success" data-dismiss="modal">Annuleer</button>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    // AJAX
    function ajax_saveToSession(naam, aankoopprijs, aankoopprijs_eenheidid, categorieid) {
        jQuery.ajax({
            type: "POST",
            url: site_url + "/grondstof_afgewerkt/ajax_save_to_session",
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
        var naam = $("#grondstof_afgewerkt_naam").val();
        var aankoopprijs = parseFloat($("#grondstof_afgewerkt_aankoopprijs").val());
        var aankoopprijs_eenheidid = parseInt($("#grondstof_afgewerkt_aankoopprijs_eenheidid").val());
        var categorieid = parseInt($("#grondstof_afgewerkt_categorieid").val());
        ajax_saveToSession(naam, aankoopprijs, aankoopprijs_eenheidid, categorieid);
    }

    function get_by_grondstofRuwId_of_grondstofCategorieId(soortId, id) {
        $.ajax({
            type: "POST",
            url: site_url + "/grondstof_afgewerkt/ajax_get_by_grondstofRuwId_of_grondstofCategorieId",
            data: {
                soortId: soortId,
                id: id
            },
            success: function (result) {
                $("#resultaat").html(result);
            },
            error: function (xhr, status, error) {
//                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText + error);
            }
        });
    }

    function getGrondstofDropdownOptions_byCategorieId(soortId, id) {
        $.ajax({
            type: "POST",
            url: site_url + "/grondstof_afgewerkt/ajaxGetGrondstofDropdownOptions_byCategorieId",
            data: {
                soortId: soortId,
                id: id
            },
            success: function (result) {
                //dropdown opvullen met options
                $("#grondstof_afgewerkt_grondstofid").html(result);
            },
            error: function (xhr, status, error) {
//                alert("-- ERROR IN getGrondstofDropdownOptions_byCategorieId --\n\n" + xhr.responseText);
            }
        });
    }

    function addFractieListener() {
        $('span#addNaamloosFractieLink').click(function () {
            var grondstofruwid = $(this).data('grondstofruwid');
            $.ajax({
                type: "POST",
                url: site_url + "/grondstof_afgewerkt/addNaamloosFractie",
                data: {
                    grondstofruwid: grondstofruwid
                },
                success: function (result) {
                    location.reload(); // then reload the page
                },
                error: function (xhr, status, error) {
//                    alert("-- ERROR IN AJAX --\n\n" + xhr.responseText + error);
                }
            });
        });
    }

    function formEditListener_vervangKommasDoorPunt() {
        var controlInput_aankoopprijs = $("#grondstof_afgewerkt_aankoopprijs");
        controlInput_aankoopprijs.keyup(function () {
            var prijs = $(this).val();
            var correctValue;
            if (prijs.includes(",")) {
                correctValue = prijs.replace(",", ".");
                controlInput_aankoopprijs.val(correctValue);
            }
        });
    }
    var isExecutedAjax = false;
    function getDropdownEnView_bySessionData() {
        if (isExecutedAjax == false) {
            isExecutedAjax = true;

            // haal de dropdowns of views op die geset zijn via zoekid in session (voor de andere dropdown wordt deze getriggerd in ajax.complete)
            var dropdownCategorieValue_fromSession = $('#hiddenDropdownValueFromSession').val();
            if (dropdownCategorieValue_fromSession > 0) {
                var findOptionByValue = 'option[value="' + dropdownCategorieValue_fromSession + '"]';
                var categorieNaam = $('#grondstof_afgewerkt_grondstofcategorieid').find(findOptionByValue).text();
                var tweedeDropdown = $('#tweededropdown');
                // vervangen door property "isFractieCategorie" ajax call doen en true of false terugkrijgen indien dit zo is of niet
                if (categorieNaam.toLowerCase() == "schors") {
                    getGrondstofDropdownOptions_byCategorieId("categorie", dropdownCategorieValue_fromSession);
                    tweedeDropdown.removeAttr('hidden');
                } else {
                    tweedeDropdown.attr('hidden', 'hidden');
                    // ajax-view met grondstoffen ophalen
                    get_by_grondstofRuwId_of_grondstofCategorieId("categorie", dropdownCategorieValue_fromSession);
                }
            }
        }
    }

    function dropdown1Listener() {
        // LUISTEREN NAAR 1ste DROPDOWN - dropdownoptions voor grondstoffen ophalen
        $("#grondstof_afgewerkt_grondstofcategorieid").change(function () {
            // controleren of de dropdown van categorie schors is of niet.
            // indien het schors is , wordt er een 2de dropdown getoont, anders met ajax alles opgehaald
            var categorieId = $(this).val();
            var categorieNaam = $(this).find('option:selected').text();
            var tweedeDropdown = $('#tweededropdown');
            if (categorieNaam.toLowerCase() == "schors") {
                getGrondstofDropdownOptions_byCategorieId("categorie", categorieId);
                tweedeDropdown.removeAttr('hidden');
                $("#resultaat").html(""); // eventueel vorige ajax-view leegmaken
            } else {
                tweedeDropdown.attr('hidden', 'hidden');
                // ajax-view met grondstoffen ophalen
                get_by_grondstofRuwId_of_grondstofCategorieId("categorie", categorieId);
            }
        });
    }

    // ajaxComplete functions ***************************************************************************************

    function dropdown2Listener() {
        $("#grondstof_afgewerkt_grondstofid").change(function () {
            var grondstofRuwId = $(this).val();
            // ajax-view met ruwe grondstoffen ophalen
            get_by_grondstofRuwId_of_grondstofCategorieId("grondstofruw", grondstofRuwId);
        });
    }

    function getDropdownEnView_bySessionData_afterAjax() {
        // haal de views op die geset zijn via zoekid in session
        if (isExecuted == false) {
            isExecuted = true;
            var attr = $('div#tweededropdown').attr('hidden'); // kijk of de 2de dropdown hidden is
            if (typeof attr !== typeof undefined && attr !== false) {
                var dropdownCategorieValue_fromSession = $('#hiddenDropdownValueFromSession').val();
                if (dropdownCategorieValue_fromSession > 0) {
                    $("#grondstof_afgewerkt_categorieid").val(dropdownCategorieValue_fromSession);
                    get_by_grondstofRuwId_of_grondstofCategorieId("categorie", dropdownCategorieValue_fromSession);
                }
            } else {
                var dropdownGrondstofruwValue_fromSession = $('#hiddenDropdownValue2FromSession').val();
                if (dropdownGrondstofruwValue_fromSession > 0) {
                    $("#grondstof_afgewerkt_grondstofid").val(dropdownGrondstofruwValue_fromSession);
                    get_by_grondstofRuwId_of_grondstofCategorieId("grondstofruw", dropdownGrondstofruwValue_fromSession);
                }
            }
        }
    }

    var readyToSubmit,
        errorMeldingContainer,
        successMeldingContainer,
        deleteMeldingContainer,
        targetErrorContainer_percentage,
        targetErrorContainer_prijs,
        targetSuccessContainer_percentage,
        targetSuccessContainer_prijs,
        errorMessageTarget_totaalPercentage,
        errorMessageTarget_totaalPrijs,
        errorMessageTarget_totaalPrijsDatHetMoetZijn,
        successMessageTarget_totaalPrijsDatHetMoetZijn,
        totaalPrijsDatHetMoetZijn;

    function getDocumentControls() {
        readyToSubmit = false;
        errorMeldingContainer = $('div#MeldingError_container');
        successMeldingContainer = $('div#MeldingSucces_container');
        deleteMeldingContainer = $('div#MeldingDelete_container');
        targetErrorContainer_percentage = $('div#MeldingError_container > span#percentage_innercontainer');
        targetErrorContainer_prijs = $('div#MeldingError_container > span#prijs_innercontainer');
        targetSuccessContainer_percentage = $('div#MeldingSuccess_container > span#percentage_innercontainer2');
        targetSuccessContainer_prijs = $('div#MeldingSuccess_container > span#prijs_innercontainer2');

        errorMessageTarget_totaalPercentage = targetErrorContainer_percentage.find('span#totaalpercentageWaarde');
        errorMessageTarget_totaalPrijs = targetErrorContainer_prijs.find('span#totaalprijsWaarde');
        errorMessageTarget_totaalPrijsDatHetMoetZijn = targetErrorContainer_prijs.find('span#totaalprijsDatHetMoetZijn');
        successMessageTarget_totaalPrijsDatHetMoetZijn = targetSuccessContainer_prijs.find('span#totaalprijsDatHetMoetZijn2');

        totaalPrijsDatHetMoetZijn = parseFloat($('input#totaalPrijs_dat_het_moet_zijn').val());
    }


    function ajaxTable_bewerkFRACTIESListener() {
        // *** FUNCTIE -> fracties, luistert naar de view "ajax_content_grondstof_afgewerkt_bygrondstofid ***
        $(".trigger-bewerkrij-fracties").click(function () {
            // eventuele meldingen van "verwijderen" verbergen, en van "wijzigen" tonen
            deleteMeldingContainer.attr('hidden', 'hidden');
            errorMeldingContainer.removeAttr('hidden');
            successMeldingContainer.removeAttr('hidden');
            // vaste waarde in meldingen al opvullen
            errorMessageTarget_totaalPrijsDatHetMoetZijn.text(totaalPrijsDatHetMoetZijn);
            successMessageTarget_totaalPrijsDatHetMoetZijn.text(totaalPrijsDatHetMoetZijn);

            //controls
            var clickedRow = $(this).parent().parent();
            var clickedForm = $(this).parent().parent().parent();

            //data
            var grondstofRuwId = $(this).data('grondstofruwid');
            var aantalRijen = $('input.domElementCounter').length / 2; // kijken hoeveel <tr>'s er zijn om alle rijen als 1 form te beschouwen (delen door 2 omdate deze class op zowel percentage als prijs staat)

            // elke rij editable maken
            var targetInputField_Ids = [];
            var targetInputField_Namen = [];
            var targetInputField_Percentages = [];
            var targetInputField_Prijzen = [];
            var clickedIconSVGs = [];

            for (var i = 0; i < aantalRijen; i++) {
                clickedForm.find('tr').addClass('trGlow');

                targetInputField_Ids[i + 1] = clickedForm.find('input#notEditableInput_grondstofid' + (i + 1));
                targetInputField_Namen[i + 1] = clickedForm.find('input#editableInput_naam' + (i + 1));
                targetInputField_Percentages[i + 1] = clickedForm.find('input#editableInput_fractiepercentage' + (i + 1));
                targetInputField_Prijzen[i + 1] = clickedForm.find('input#editableInput_aankoopPrijsPerFractie' + (i + 1));
                clickedIconSVGs[i + 1] = clickedForm.find('.changeIcon' + (i + 1) + ' i');

                targetInputField_Namen[i + 1].toggleClass('agricon-is-editable-input');

                if (targetInputField_Namen[i + 1].hasClass('agricon-is-editable-input')) {
                    targetInputField_Namen[i + 1].removeAttr('readonly');
                    targetInputField_Percentages[i + 1].removeAttr('readonly');
                    targetInputField_Prijzen[i + 1].removeAttr('readonly');
                    clickedIconSVGs[i + 1].removeClass('fa-pencil-alt');
                    clickedIconSVGs[i + 1].addClass('fa-save');
                } else {
                    // anders alles terugzetten + gegevens updaten in de database
                    clickedForm.find('tr').removeClass('trGlow');

                    targetInputField_Namen[i + 1].attr('readonly', 'readonly');
                    targetInputField_Percentages[i + 1].attr('readonly', 'readonly');
                    targetInputField_Prijzen[i + 1].attr('readonly', 'readonly');

                    clickedIconSVGs[i + 1].removeClass('fa-save');
                    clickedIconSVGs[i + 1].addClass('fa-pencil-alt');
                }
            }

            if (readyToSubmit) {
                $("#form_grondstof_afgewerkt_update").submit();
            }

            // controleer of het percentage 100% is en het de juiste totalePrijs is , anders mag de form_update niet gesubmit worden.
            $('input.domElementCounter').add('input.naam').keyup(function (e) {
                var percentage = 0;
                var totaalPercentage = 0;
                var prijs = 0;
                var totaalPrijs = 0;

                for (var i = 0; i < aantalRijen; i++) {
                    // alle percentages optellen van de aanwezige DOMelementen
                    percentage = parseFloat($('input.fractie' + (i + 1)).val());
                    prijs = parseFloat($('input.prijs' + (i + 1)).val());
                    if (isNaN(percentage)) {
                        percentage = 0;
                    }
                    if (isNaN(prijs)) {
                        prijs = 0;
                    }
                    totaalPercentage += percentage;
                    totaalPrijs += prijs;

                    // hidden form opvullen
                    $("#form_grondstof_afgewerkt_update input#grondstof_afgewerkt_id_update" + (i + 1)).val(targetInputField_Ids[i + 1].val());
                    $("#form_grondstof_afgewerkt_update input#grondstof_afgewerkt_naam_update" + (i + 1)).val(targetInputField_Namen[i + 1].val());
                    $("#form_grondstof_afgewerkt_update input#grondstof_afgewerkt_percentage_update" + (i + 1)).val(targetInputField_Percentages[i + 1].val());
                    $("#form_grondstof_afgewerkt_update input#grondstof_afgewerkt_prijs_update" + (i + 1)).val(targetInputField_Prijzen[i + 1].val());
                    $("#form_grondstof_afgewerkt_update input#grondstof_afgewerkt_grondstofruwid_update" + (i + 1)).val(grondstofRuwId);
                }

                if (totaalPercentage == 100 && totaalPrijs == totaalPrijsDatHetMoetZijn) {
                    readyToSubmit = true;
                    targetErrorContainer_percentage.attr('hidden', 'hidden');
                    targetErrorContainer_prijs.attr('hidden', 'hidden');
                    targetSuccessContainer_percentage.removeAttr('hidden');
                    targetSuccessContainer_prijs.removeAttr('hidden');
                } else if (totaalPercentage == 100 || totaalPrijs == totaalPrijsDatHetMoetZijn) {
                    readyToSubmit = false;
                    if (totaalPercentage == 100) {
                        targetErrorContainer_percentage.attr('hidden', 'hidden');
                        targetSuccessContainer_percentage.removeAttr('hidden');
                    } else {
                        errorMessageTarget_totaalPercentage.text(totaalPercentage);
                        targetSuccessContainer_percentage.attr('hidden', 'hidden');
                        targetErrorContainer_percentage.removeAttr('hidden');
                    }
                    if (totaalPrijs == totaalPrijsDatHetMoetZijn) {
                        targetErrorContainer_prijs.attr('hidden', 'hidden');
                        targetSuccessContainer_prijs.removeAttr('hidden');
                    } else {
                        errorMessageTarget_totaalPrijs.text(totaalPrijs);
                        targetSuccessContainer_prijs.attr('hidden', 'hidden');
                        targetErrorContainer_prijs.removeAttr('hidden');
                    }
                } else {
                    readyToSubmit = false;
                    targetSuccessContainer_percentage.attr('hidden', 'hidden');
                    errorMessageTarget_totaalPercentage.text(totaalPercentage);
                    targetErrorContainer_percentage.removeAttr('hidden');
                    targetSuccessContainer_prijs.attr('hidden', 'hidden');
                    errorMessageTarget_totaalPrijs.text(totaalPrijs);
                    targetErrorContainer_prijs.removeAttr('hidden');
                }
            });
        });
    }

    function ajaxTable_bewerkNIETFRACTIESListener() {
        $(".trigger-bewerkrij-nietfracties").click(function () {
            //controls
            var clickedIconSVG = $(this).find('svg');
            var clickedRow = $(this).parent().parent();
            var targetInputField_Name = clickedRow.find('input#editableInput_naam');
            var targetInputField_Prijs = clickedRow.find('input#editableInput_prijs');
            var targetDropdownField_Categorie = clickedRow.find('select#editableInput_grondstofcategorie');
            var targetDropdownField_Eenheid = clickedRow.find('select#editableInput_grondstofeenheid');

            //data
            var grondstofAfgewerktId = $(this).data('id');
            var grondstofRuwId = $(this).data('grondstofruwid');

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
                var grondstofAfgewerktNaam = targetInputField_Name.val();
                var grondstofAfgewerktCategorieId = targetDropdownField_Categorie.val();
                var grondstofAfgewerktAankoopprijs = targetInputField_Prijs.val();
                var grondstofAfgewerktAankoopprijsEenheidId = targetDropdownField_Eenheid.val();

                if (grondstofAfgewerktNaam != "" && grondstofAfgewerktNaam != null && grondstofAfgewerktId != 0 && grondstofAfgewerktId != null) {
                    $("#form_grondstof_afgewerkt_update input#grondstof_afgewerkt_id_update").val(grondstofAfgewerktId);
                    $("#form_grondstof_afgewerkt_update input#grondstof_afgewerkt_grondstofruwid_update").val(grondstofRuwId);
                    $("#form_grondstof_afgewerkt_update input#grondstof_afgewerkt_naam_update").val(grondstofAfgewerktNaam);
                    $("#form_grondstof_afgewerkt_update input#grondstof_afgewerkt_categorieid_update").val(grondstofAfgewerktCategorieId);
                    $("#form_grondstof_afgewerkt_update input#grondstof_afgewerkt_aankoopprijs_update").val(grondstofAfgewerktAankoopprijs);
                    $("#form_grondstof_afgewerkt_update input#grondstof_afgewerkt_aankoopprijs_eenheid_update").val(grondstofAfgewerktAankoopprijsEenheidId);
                    $("#form_grondstof_afgewerkt_update").submit();
                }
            }
        });
    }

    function ajaxTable_bewerkListener_vervangKommasDoorPunt() {
        $("input.domElementCounter").click(function () {
            var controlInput = $(this);
            controlInput.keyup(function () {
                var currentValue = $(this).val();
                var correctValue;
                if (currentValue.includes(",")) {
                    correctValue = currentValue.replace(",", ".");
                    controlInput.val(correctValue);
                }
            });
        });
    }

    function ajaxTable_verwijderFRACTIESListener_showModal() {
        // *** FUNCTIE -> fracties, luisterd naar de view "ajax_content_grondstof_afgewerkt_bygrondstofid ***
        $(".agricon-delete-icon-fracties").click(function () {
            // eventuele meldingen van "wijzigen" verbergen
            errorMeldingContainer.attr("hidden", "hidden");
            successMeldingContainer.attr("hidden", "hidden");

            var grondstofAgewerktId = $(this).data('id');
            var grondstofAgewerktNaam = $(this).data('grondstofafgewerkt');
            var grondstofRuwId = $(this).data('grondstofruwid');
            var clickedRow = $(this).parent().parent();
            var aantalGrondstoffen = clickedRow.parent().find('tr').length;
            var percentage = clickedRow.find('input.domElementCounter:eq(0)').val();
            var prijs = clickedRow.find('input.domElementCounter:eq(1)').val();
            $("#form_grondstof_afgewerkt_delete input#aantal_grondstoffen_delete").val(aantalGrondstoffen);

            // enkel verwijderen toestaan indien de fractiePercentage en prijs gelijk is aan 0 of het de laaste fractie is
            if ((percentage == 0 && prijs == 0) || aantalGrondstoffen == 1) {
                //melding verbergen
                deleteMeldingContainer.attr('hidden', 'hidden');

                if (grondstofAgewerktId != 0 && grondstofAgewerktId != null) {
                    $("#form_grondstof_afgewerkt_delete input#grondstof_afgewerkt_id_delete").val(grondstofAgewerktId);
                    $("#form_grondstof_afgewerkt_delete input#grondstof_afgewerkt_naam_delete").val(grondstofAgewerktNaam);
                    $("#form_grondstof_afgewerkt_delete input#grondstof_afgewerkt_grondstofruwid_delete").val(grondstofRuwId);
                }
                $('#deleteModal2').modal('show');
            } else {
                //melding tonen
                deleteMeldingContainer.removeAttr('hidden');
            }
        });
    }

    function ajaxTable_verwijderNIETFRACTIESListener_showModal() {
        $(".agricon-delete-icon-nietfracties").click(function () {
            // hidden form opvullen
            var grondstofAfgewerktId = $(this).data('id');
            var grondstofAfgewerktNaam = $(this).data('grondstofafgewerktnaam');
            var grondstofRuwId = $(this).data('grondstofruwid');

            if (grondstofAfgewerktId != 0 && grondstofAfgewerktId != null) {
                $("#form_grondstof_afgewerkt_delete input#grondstof_afgewerkt_id_delete").val(grondstofAfgewerktId);
                $("#form_grondstof_afgewerkt_delete input#grondstof_afgewerkt_naam_delete").val(grondstofAfgewerktNaam);
                $("#form_grondstof_afgewerkt_delete input#grondstof_afgewerkt_grondstofruwid_delete").val(grondstofRuwId);
            }
            $('#deleteModal').modal('show');
        });
    }

    function ajaxTable_verwijderModalListener() {
        // DELETE MODAL LISTENER
        $('#deleteAllData').click(function (e) {
            $('#deleteModal').modal('hide');
            //note: dit form noemt in beide ajax-view hetzelfde, maar roept een andere functie op in controller
            $("#form_grondstof_afgewerkt_delete").submit();
        });
        $('#deleteAllData2').click(function (e) {
            $('#deleteModal2').modal('hide');
            $("#form_grondstof_afgewerkt_delete").submit();
        });
    }

    $(document).ready(function () {
        formEditListener_vervangKommasDoorPunt();
        getDropdownEnView_bySessionData();
        dropdown1Listener();
    });

    var isExecuted = false;
    $(document).ajaxComplete(function () {
        addFractieListener();
        getDocumentControls();
        getDropdownEnView_bySessionData_afterAjax();
        dropdown2Listener();
        ajaxTable_bewerkListener_vervangKommasDoorPunt();
        ajaxTable_bewerkFRACTIESListener();
        ajaxTable_bewerkNIETFRACTIESListener();
        ajaxTable_verwijderFRACTIESListener_showModal();
        ajaxTable_verwijderNIETFRACTIESListener_showModal();
        ajaxTable_verwijderModalListener();
    });
</script>
