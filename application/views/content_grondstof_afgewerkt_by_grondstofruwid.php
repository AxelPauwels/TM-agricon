<main role="main" class="container" id="content_grondstof_afgewerkt_pergrondstofruwid_beheren">
    <div class="row agricon-content-title">
        <h3 style='position:relative'><?php echo $title; ?> </h3>
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
                <div class="card">
                    <div class="card-header" id="headingTwo" style="position: relative">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo"
                                    aria-expanded="false" aria-controls="collapseTwo">
                                <?php
                                if (isset($grondstofRuwNaam)) {
                                    echo strtoupper($grondstofRuwNaam);
                                }
                                ?>
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
                    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body agricon-card-body-table">
                            <section id="resultaat">
                                <div class="form-row agricon-table-container agricon-wijzigbestaande-ajaxtable"
                                     style="position: relative">
                                    <span id="addNaamloosFractieLink"
                                          style="display: inline-block;position: absolute;cursor:pointer;right: 20px;top:35px;color:royalblue"
                                          data-grondstofruwid="<?php if (isset($grondstofruwid)) {
                                              echo $grondstofruwid;
                                          } ?>">Nieuwe fractie toevoegen</span>
                                    <div style="height: 90px;width: 100%;padding-left: 32px"><span
                                                style="color:transparent">|</span>
                                        <div id="MeldingError_container" style="color: darkred;font-size:14px">
                                            <span hidden id="percentage_innercontainer">
                                                <i class="fas fa-info-circle"></i> Het totaal van deze fracties is
                                                <span id="totaalpercentageWaarde" style="font-weight: bold"></span>%
                                                maar deze moet <span style="font-weight: bold">100%</span> zijn om de wijzigingen te kunnen opslaan.
                                            </span>
                                            <br>
                                            <span hidden id="prijs_innercontainer">
                                                <i class="fas fa-info-circle"></i> Het totaal van deze prijzen is
                                                <span id="totaalprijsWaarde" style="font-weight: bold"></span>
                                                maar deze moet <span style="font-weight: bold"><span
                                                            id="totaalprijsDatHetMoetZijn"></span></span> zijn om de wijzigingen te kunnen opslaan.
                                            </span>
                                        </div>

                                        <div id="MeldingSuccess_container" style="color: darkgreen;font-size:14px">
                                            <span hidden id="percentage_innercontainer2">
                                                <i class="fas fa-info-circle"></i> Het totaal van deze fracties is
                                                <span style="font-weight: bold">100% </span>
                                            </span>
                                            <br>
                                            <span hidden id="prijs_innercontainer2">
                                                <i class="fas fa-info-circle"></i> Het totaal van deze prijzen is
                                                <span id="totaalprijsDatHetMoetZijn2" style="font-weight: bold"></span>
                                            </span>
                                        </div>

                                        <div hidden id="MeldingDelete_container" style="color: darkred;font-size:14px">
                                            <i class="fas fa-info-circle"></i> Enkel grondstoffen met percentage én
                                            prijs 0 kunnen verwijderd worden.
                                            <br>
                                            Gelieve eerst de grondstof eerst <span
                                                    style="font-weight: bold">wijzigen</span> zodat de waardes <span
                                                    style="font-weight: bold">0</span> zijn voor wat je wil verwijderen.
                                        </div>
                                    </div>
                                    <input hidden id="totaalPrijs_dat_het_moet_zijn"
                                           value="<?php if (isset($totaalPrijs)) {
                                               echo $totaalPrijs;
                                           } ?>">


                                    <?php
                                    if (isset($grondstoffenAfgewerkt)) {
                                        $template = array('table_open' => '<table id="grondstof_afgewerkt_pergrondstofruwid_table" class="agricon-table table table-responsive-sm table-sm table-striped noHoverAllowed tablesorter " border="0" cellpadding="4" cellspacing="0">');
                                        $this->table->set_template($template);

                                        $sortIcon = '<div class="agricon-sort-icon"><i class="fas fa-sort"></i></div>';
                                        $th_gewijzigdOp = ['data' => 'Gewijzigd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];
                                        $th_toegevoedOp = ['data' => 'Toegevoegd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];

                                        $this->table->set_heading('', 'Naam' . $sortIcon, 'Fractie %' . $sortIcon, 'Prijs/fractie' . $sortIcon, $th_gewijzigdOp,
                                            'Door' . $sortIcon, $th_toegevoedOp, 'Door' . $sortIcon, '', '');
                                        $rijNummer = 0;
                                        foreach ($grondstoffenAfgewerkt as $grondstof) {
                                            $rijNummer++;
                                            // <span hidden></span> gebruiken om te sorteren via tablesorter() -> de inputvelden kunnen editable gemaakt worden met jQuery
                                            $this->table->add_row(
                                                $rijNummer . '<input hidden id="notEditableInput_grondstofid' . $rijNummer . '" value="' . $grondstof->id . '" >',
                                                '<span hidden>' . ucfirst($grondstof->naam) . '</span><input id="editableInput_naam' . $rijNummer . '" class="naam" readonly="readonly" value="' . ucfirst($grondstof->naam) . '" onfocus="var temp_value=this.value; this.value=\'\'; this.value=temp_value">',
                                                '<span hidden>' . $grondstof->fractiePercentage . '</span><input data-soortwaarde="percentage" id="editableInput_fractiepercentage' . $rijNummer . '" class="domElementCounter fractie' . $rijNummer . ' " readonly="readonly" value="' . $grondstof->fractiePercentage . '" >',
                                                '<span hidden>' . $grondstof->aankoopPrijsPerFractie . '</span><input data-soortwaarde="prijs" id="editableInput_aankoopPrijsPerFractie' . $rijNummer . '" class="domElementCounter prijs' . $rijNummer . ' " readonly="readonly" value="' . $grondstof->aankoopPrijsPerFractie . '" >',

                                                $grondstof->gewijzigdOp_datum . ' ' . $grondstof->gewijzigdOp_tijd,
                                                ucfirst($grondstof->gewijzigdDoorUser),
                                                $grondstof->toegevoegdOp_datum . ' ' . $grondstof->toegevoegdOp_tijd,
                                                ucfirst($grondstof->toegevoegdDoorUser),
                                                '<div class="trigger-bewerkrij-fracties agricon-changeable-icon changeIcon' . $rijNummer . '" data-id="' . $grondstof->id . '" data-grondstofruwid="' . $grondstof->grondstofRuwId . '"><i class="fas fa-pencil-alt"></i></div>',
                                                '<div class="agricon-delete-icon-fracties" data-id="' . $grondstof->id . '" data-grondstofafgewerkt="' . $grondstof->naam . '" data-grondstofruwid="' . $grondstof->grondstofRuwId . '"><i class="fas fa-times"></i></div>'

                                            );
                                        }
                                        echo $this->table->generate();
                                    }
                                    ?>
                                </div>
                            </section>

                        </div>
                    </div>
                </div>

                <section>
                    <div hidden>
                        <?php
                        $dataOpen = array(
                            'id' => 'form_grondstof_afgewerkt_update',
                            'name' => 'form_grondstof_afgewerkt_update',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_grondstof_afgewerkt_update',
                            'name' => 'submit_grondstof_afgewerkt_update',
                            'type' => 'submit');

                        echo form_open('grondstof_afgewerkt/fractiesupdate', $dataOpen);

                        $nummer = 0;
                        if (isset($grondstoffenAfgewerkt)) {
                            foreach ($grondstoffenAfgewerkt as $grondstof) {
                                $nummer++;
                                echo form_input('grondstof_afgewerkt_id_update[]', $grondstof->id, 'id="grondstof_afgewerkt_id_update' . $nummer . '" class="form-control" required="required" aria-label="categorie id"');
                                echo form_input('grondstof_afgewerkt_naam_update[]', $grondstof->naam, 'id="grondstof_afgewerkt_naam_update' . $nummer . '" class="form-control" required="required" placeholder="naam" aria-label="categorie naam"');
                                echo form_input('grondstof_afgewerkt_percentage_update[]', $grondstof->fractiePercentage, 'id="grondstof_afgewerkt_percentage_update' . $nummer . '" class="form-control" required="required" placeholder="percentage" aria-label="percentage naam"');
                                echo form_input('grondstof_afgewerkt_prijs_update[]', $grondstof->aankoopPrijsPerFractie, 'id="grondstof_afgewerkt_prijs_update' . $nummer . '" class="form-control" required="required" placeholder="prijs" aria-label="prijs "');
                                echo form_input('grondstof_afgewerkt_grondstofruwid_update', $grondstof->grondstofRuwId, 'id="grondstof_afgewerkt_grondstofruwid_update' . $nummer . '" class="form-control" type="number" required="required" placeholder="grondstofruwid" aria-label="percentage naam"');
                                echo form_input('grondstof_afgewerkt_redirectview_update', "content_grondstof_afgewerkt_by_grondstofruwid", 'id="grondstof_afgewerkt_redirectview_update' . $nummer . '" class="form-control" type="number" required="required" placeholder="grondstofruwid" aria-label="percentage naam"');
                            }
                        }

                        echo form_submit($dataSubmit);
                        echo form_close();
                        ?>
                    </div>
                    <div hidden>
                        <?php
                        $dataOpen = array(
                            'id' => 'form_grondstof_afgewerkt_delete',
                            'name' => 'form_grondstof_afgewerkt_delete',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_grondstof_afgewerkt_delete',
                            'name' => 'submit_grondstof_afgewerkt_delete',
                            'type' => 'submit');

                        echo form_open('grondstof_afgewerkt/fractiesdelete', $dataOpen);
                        echo form_input('grondstof_afgewerkt_id_delete', '', 'id="grondstof_afgewerkt_id_delete" class="form-control" required="required" aria-label="categorie id"');
                        echo form_input('grondstof_afgewerkt_naam_delete', '', 'id="grondstof_afgewerkt_naam_delete" class="form-control" required="required" placeholder="naam" aria-label="categorie naam"');
                        echo form_input('grondstof_afgewerkt_grondstofruwid_delete', '', 'id="grondstof_afgewerkt_grondstofruwid_delete" type="number" class="form-control" required="required" placeholder="grondstofruwid" aria-label="percentage naam"');
                        echo form_input('grondstof_afgewerkt_redirectview_delete', "content_grondstof_afgewerkt_by_grondstofruwid", 'id="grondstof_afgewerkt_redirectview_delete' . $nummer . '" class="form-control" type="number" required="required" placeholder="grondstofruwid" aria-label="percentage naam"');
                        echo form_input('aantal_grondstoffen_delete', '', 'id="aantal_grondstoffen_delete" class="form-control" type="number" required="required" placeholder="grondstofruwid" aria-label="percentage naam"');

                        echo form_submit($dataSubmit);
                        echo form_close();
                        ?>
                    </div>
                </section>

            </div>
        </div>
    </div>

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
                }
                else {
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

    function formEditListener_vervangKommasDoorPunt() {
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

    function ajaxTable_verwijderModalListener() {
        $('#deleteAllData2').click(function (e) {
            $('#deleteModal2').modal('hide');
            //note: dit form noemt in beide ajax-view hetzelfde, maar roept een andere functie op in controller
            $("#form_grondstof_afgewerkt_delete").submit();
        });
    }

    $(document).ready(function () {
        addFractieListener();
        getDocumentControls();
        formEditListener_vervangKommasDoorPunt();
        ajaxTable_bewerkFRACTIESListener();
        ajaxTable_verwijderFRACTIESListener_showModal();
        ajaxTable_verwijderModalListener();
    });
</script>
