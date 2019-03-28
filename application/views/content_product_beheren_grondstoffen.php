<main role="main" class="container" id="content_product_beheren_grondstoffen">
    <div class="row agricon-content-title">
        <h3 style='position:relative'><?php echo $title; ?></h3>
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
                                if (isset($productNaam)) {
                                    echo ucwords($productNaam);
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
                                          style="display: inline-block;position: absolute;cursor:pointer;right: 27px;top:30px;color:royalblue"
                                          data-grondstofruwid="<?php if (isset($grondstofruwid)) {
                                              echo $grondstofruwid;
                                          } ?>">Nieuwe grondstof toevoegen
                                    </span>
                                    <div style="height: 90px;width: 100%;padding-left: 32px"><span
                                                style="color:transparent">|</span>
                                        <div id="MeldingError_container" style="color: darkred;font-size:14px">
                                            <span hidden id="percentage_innercontainer">
                                                <i class="fas fa-info-circle"></i> Het totaal van deze grondstoffen is
                                                <span id="totaalpercentageWaarde" style="font-weight: bold"></span>%
                                                maar deze moet <span style="font-weight: bold">100%</span> zijn om de wijzigingen te kunnen opslaan.
                                            </span>
                                        </div>

                                        <div id="MeldingSuccess_container" style="color: darkgreen;font-size:14px">
                                            <span hidden id="percentage_innercontainer2">
                                                <i class="fas fa-info-circle"></i> Het totaal van deze grondstoffen is
                                                <span style="font-weight: bold">100% </span>
                                            </span>
                                        </div>

                                        <div hidden id="MeldingDelete_container" style="color: darkred;font-size:14px">
                                            <i class="fas fa-info-circle"></i> Enkel grondstoffen met 0% kunnen
                                            verwijderd worden.
                                            <br>
                                            Gelieve de grondstoffen eerst te <span
                                                    style="font-weight: bold">wijzigen</span> zodat de waarde <span
                                                    style="font-weight: bold">0%</span> is bij diegene die je wil
                                            verwijderen.
                                        </div>
                                    </div>

                                    <?php
                                    if (isset($samenstellingen)) {
                                        $template = array('table_open' => '<table id="product_grondstoffen_table" class="agricon-table table table-responsive-sm table-sm table-striped noHoverAllowed tablesorter " border="0" cellpadding="4" cellspacing="0">');
                                        $this->table->set_template($template);

                                        $sortIcon = '<div class="agricon-sort-icon"><i class="fas fa-sort"></i></div>';
                                        $th_gewijzigdOp = ['data' => 'Gewijzigd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];
                                        $th_toegevoedOp = ['data' => 'Toegevoegd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];

                                        $this->table->set_heading('', 'Naam' . $sortIcon, 'Hoeveelheid' . $sortIcon, '', 'Categorie' . $sortIcon, $th_gewijzigdOp,
                                            'Door' . $sortIcon, $th_toegevoedOp, 'Door' . $sortIcon, '', '');
                                        $rijNummer = 0;
                                        foreach ($samenstellingen as $samenstelling) {
                                            //naam
                                            if ($samenstelling->grondstofCategorie->isFractieCategorie == 1) {
                                                $grondstofNaam = '<span hidden>' . ucwords($samenstelling->grondstofRuw->naam) . ucfirst($samenstelling->grondstof->naam) . '</span><input id="notEditableInput_naam' . $rijNummer . '" class="naam" readonly="readonly" value="' . ucwords($samenstelling->grondstofRuw->naam) . ' ' . ucfirst($samenstelling->grondstof->naam) . '" >';
                                            }
                                            else {
                                                $grondstofNaam = '<span hidden>' . ucfirst($samenstelling->grondstof->naam) . '</span><input id="notEditableInput_naam' . $rijNummer . '" class="naam" readonly="readonly" value="' . ucfirst($samenstelling->grondstof->naam) . '" >';
                                            }
                                            //hoeveelheid
                                            if ($samenstelling->percentage != null) {
                                                $percentageOfGewicht = '<span hidden>' . $samenstelling->percentage . '</span><input data-soortwaarde="percentage" id="editableInput_percentage' . $rijNummer . '" class="domElementCounter percentage' . $rijNummer . ' " readonly="readonly" value="' . $samenstelling->percentage . '" >';
                                                $percentageOfGewicht_text = '<div style="position: relative"><span style="position: absolute;margin-left: -35px;line-height: .2">%</span></div>';
                                            }
                                            else {
                                                $percentageOfGewicht = '<span hidden>' . $samenstelling->gewicht . '</span><input data-soortwaarde="gewicht" id="editableInput_gewicht' . $rijNummer . '" class="domElementCounter gewicht' . $rijNummer . ' " readonly="readonly" value="' . $samenstelling->gewicht . '" >';
                                                $percentageOfGewicht_text = '<div style="position: relative"><span style="position: absolute;margin-left: -35px;line-height: .2">kg</span>';
                                            }

                                            $rijNummer++;
                                            // <span hidden></span> gebruiken om te sorteren via tablesorter() -> de inputvelden kunnen editable gemaakt worden met jQuery
                                            $this->table->add_row(
                                                $rijNummer . '<input hidden id="notEditableInput_samenstellingid' . $rijNummer . '" value="' . $samenstelling->id . '" >',
                                                $grondstofNaam,
                                                $percentageOfGewicht,
                                                $percentageOfGewicht_text,
                                                $samenstelling->grondstofCategorie->naam,
                                                $samenstelling->gewijzigdOp_datum . ' ' . $samenstelling->gewijzigdOp_tijd,
                                                ucfirst($samenstelling->gewijzigdDoorUser),
                                                $samenstelling->toegevoegdOp_datum . ' ' . $samenstelling->toegevoegdOp_tijd,
                                                ucfirst($samenstelling->toegevoegdDoorUser),
                                                '<div class="trigger-bewerkrij-grondstof agricon-changeable-icon changeIcon' . $rijNummer . '" data-id="' . $samenstelling->id . '" data-grondstofid="' . $samenstelling->grondstof->id . '" data-samenstellingid="' . $samenstelling->id . '"><i class="fas fa-pencil-alt"></i></div>',
                                                '<div class="agricon-delete-icon-grondstof" data-productid="' . $samenstelling->productId . '" data-naam="' . $productNaam . '" data-samenstellingid="' . $samenstelling->id . '"><i class="fas fa-times"></i></div>'
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
                            'id' => 'form_product_beheren_grondstoffen_update',
                            'name' => 'form_product_beheren_grondstoffen_update',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_product_beheren_grondstoffen_update',
                            'name' => 'submit_product_beheren_grondstoffen_update',
                            'type' => 'submit');

                        echo form_open('product/update_grondstoffen', $dataOpen);

                        $nummer = 0;
                        if (isset($samenstellingen)) {
                            echo form_input('product_id_update', $samenstellingen[0]->productId, 'id="product_id_update" class="form-control" required="required" aria-label="samenstelling id"');
                            foreach ($samenstellingen as $samenstelling) {
                                $nummer++;
                                echo form_input('samenstelling_id_update[]', $samenstelling->id, 'id="samenstelling_id_update' . $nummer . '" class="form-control" required="required" aria-label="samenstelling id"');
                                echo form_input('samenstelling_percentage_update[]', $samenstelling->id, 'id="samenstelling_percentage_update' . $nummer . '" class="form-control" required="required" aria-label="samenstelling percentage"');
                                echo form_input('samenstelling_gewicht_update[]', $samenstelling->id, 'id="samenstelling_gewicht_update' . $nummer . '" class="form-control" required="required" aria-label="samenstelling gewicht"');
                            }
                        }

                        echo form_submit($dataSubmit);
                        echo form_close();
                        ?>
                    </div>
                    <div hidden>
                        <?php
                        $dataOpen = array(
                            'id' => 'form_product_beheren_grondstoffen_delete',
                            'name' => 'form_product_beheren_grondstoffen_delete',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_product_beheren_grondstoffen_delete',
                            'name' => 'submit_product_beheren_grondstoffen_delete',
                            'type' => 'submit');

                        echo form_open('product/delete_grondstoffen', $dataOpen);

                        echo form_input('product_id_delete', '', 'id="product_id_delete" class="form-control" required="required" aria-label="product id"');
                        echo form_input('samenstelling_id_delete', '', 'id="samenstelling_id_delete" class="form-control" required="required" aria-label="samenstelling id"');
                        echo form_input('productnaam_delete', '', 'id="productnaam_delete" class="form-control" required="required" placeholder="naam" aria-label="product naam"');
                        echo form_input('percentageOfGewicht_delete', '', 'id="percentageOfGewicht_delete" class="form-control" required="required" placeholder="naam" aria-label="product naam"');

                        echo form_submit($dataSubmit);
                        echo form_close();
                        ?>
                    </div>
                </section>

            </div>
        </div>
    </div>

    <!--    modal voor percentage-gebaseerde grondstoffen-->
    <?php createBasicDeleteModal('Waarschuwing',
        'Wil je deze grondstof verwijderen?',
        '',
        '',
        "Verwijder"); ?>

    <!--    modal voor niet-percentage-gebaseerde grondstoffen-->
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
                    <p>Wil je deze grondstof verwijderen?<br><span style="font-size: 12px;font-style: italic">
                        </span><br><br></p>
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


    var readyToSubmit,
        errorMeldingContainer,
        successMeldingContainer,
        deleteMeldingContainer,
        targetErrorContainer_percentage,
        targetSuccessContainer_percentage,
        errorMessageTarget_totaalPercentage;

    function getDocumentControls() {
        readyToSubmit = false;
        errorMeldingContainer = $('div#MeldingError_container');
        successMeldingContainer = $('div#MeldingSucces_container');
        deleteMeldingContainer = $('div#MeldingDelete_container');
        targetErrorContainer_percentage = $('div#MeldingError_container > span#percentage_innercontainer');
        targetSuccessContainer_percentage = $('div#MeldingSuccess_container > span#percentage_innercontainer2');
        errorMessageTarget_totaalPercentage = targetErrorContainer_percentage.find('span#totaalpercentageWaarde');
    }

    function ajaxTable_bewerkListener() {
        $(".trigger-bewerkrij-grondstof").click(function () {
            // eventuele meldingen van "verwijderen" verbergen, en van "wijzigen" tonen
            deleteMeldingContainer.attr('hidden', 'hidden');
            errorMeldingContainer.removeAttr('hidden');
            successMeldingContainer.removeAttr('hidden');

            //controls
            var clickedRow = $(this).parent().parent();
            var clickedForm = $(this).parent().parent().parent();
            clickedForm.addClass('editMode');

            //data
            var aantalRijen = $('input.domElementCounter').length;
            var percentageOfGewicht = $(this).data('percentageOfGewicht');

            // elke rij editable maken
            var targetInputField_samenstellingIds = [];
            var targetInputField_PercentagesOfGewichten = [];
            var clickedIconSVGs = [];

            for (var i = 0; i < aantalRijen; i++) {
                clickedForm.find('tr').addClass('trGlow');
                var soortwaarde = clickedForm.find('tr:eq(' + i + ')').find('input.domElementCounter').data('soortwaarde');
                targetInputField_samenstellingIds[i + 1] = clickedForm.find('input#notEditableInput_samenstellingid' + (i + 1));

                // bepaal of het percentage of gewicht is
                if (soortwaarde === "percentage") {
                    targetInputField_PercentagesOfGewichten[i + 1] = clickedForm.find('input#editableInput_percentage' + i);
                } else if
                (soortwaarde === "gewicht") {
                    targetInputField_PercentagesOfGewichten[i + 1] = clickedForm.find('input#editableInput_gewicht' + i);
                }
                clickedIconSVGs[i + 1] = clickedForm.find('.changeIcon' + (i + 1) + ' i');

                // toggle class
                targetInputField_PercentagesOfGewichten[i + 1].toggleClass('agricon-is-editable-input');

                if (targetInputField_PercentagesOfGewichten[i + 1].hasClass('agricon-is-editable-input')) {
                    targetInputField_PercentagesOfGewichten[i + 1].removeAttr('readonly');
                    clickedIconSVGs[i + 1].removeClass('fa-pencil-alt');
                    clickedIconSVGs[i + 1].addClass('fa-save');
                } else {
                    // anders alles terugzetten + gegevens updaten in de database
                    clickedForm.find('tr').removeClass('trGlow');
                    targetInputField_PercentagesOfGewichten[i + 1].attr('readonly', 'readonly');
                    clickedIconSVGs[i + 1].removeClass('fa-save');
                    clickedIconSVGs[i + 1].addClass('fa-pencil-alt');
                }
            }

            if (readyToSubmit) {
                $("#form_product_beheren_grondstoffen_update").submit();
            }
//
            // controleer of het percentage 100% is, anders mag de form_update niet gesubmit worden.
            $('input.domElementCounter').keyup(function (e) {
                var percentage = 0;
                var gewicht = 0.00;
                var totaalPercentage = 0;
                for (var i = 0; i < aantalRijen; i++) {
                    // alle percentages optellen van de aanwezige DOMelementen
                    percentage = parseFloat($('input.percentage' + i).val());
                    gewicht = parseFloat($('input.gewicht' + i).val());

                    var hiddenFormTarget_samenstellingid = $("#form_product_beheren_grondstoffen_update input#samenstelling_id_update" + (i + 1));
                    var hiddenFormTarget_gewicht = $("#form_product_beheren_grondstoffen_update input#samenstelling_gewicht_update" + (i + 1));
                    var hiddenFormTarget_percentage = $("#form_product_beheren_grondstoffen_update input#samenstelling_percentage_update" + (i + 1));

                    if (isNaN(percentage)) {
                        percentage = 0;
                        hiddenFormTarget_gewicht.val(gewicht);
                        hiddenFormTarget_percentage.val(null);

                    } else {
                        hiddenFormTarget_percentage.val(percentage);
                        hiddenFormTarget_gewicht.val(null);
                    }
                    totaalPercentage += percentage;
                    hiddenFormTarget_samenstellingid.val(targetInputField_samenstellingIds[i + 1].val());
                }

                if (totaalPercentage == 100) {
                    readyToSubmit = true;
                    targetErrorContainer_percentage.attr('hidden', 'hidden');
                    targetSuccessContainer_percentage.removeAttr('hidden');
                } else {
                    readyToSubmit = false;
                    targetSuccessContainer_percentage.attr('hidden', 'hidden');
                    errorMessageTarget_totaalPercentage.text(totaalPercentage);
                    targetErrorContainer_percentage.removeAttr('hidden');
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

    function ajaxTable_verwijderListener_showModal() {
        $(".agricon-delete-icon-grondstof").click(function () {
            // eventuele meldingen van "wijzigen" verbergen
            errorMeldingContainer.attr("hidden", "hidden");
            successMeldingContainer.attr("hidden", "hidden");

            var clickedRow = $(this).parent().parent();
            var productId = $(this).data('productid');
            var samenstellingId = $(this).data('samenstellingid');
            var productNaam = $(this).data('naam');
            var percentage = clickedRow.find('input.domElementCounter:eq(0)').val();
            var soortwaarde = clickedRow.find('input.domElementCounter:eq(0)').data('soortwaarde');

            $("#form_product_beheren_grondstoffen_delete input#product_id_delete").val(productId);
            $("#form_product_beheren_grondstoffen_delete input#productnaam_delete").val(productNaam);
            $("#form_product_beheren_grondstoffen_delete input#samenstelling_id_delete").val(samenstellingId);
            $("#form_product_beheren_grondstoffen_delete input#percentageOfGewicht_delete").val(soortwaarde);

            // enkel verwijderen toestaan indien de fractiePercentage gelijk is aan 0 of het niet-percentage-gebaseerd is
            if (percentage == 0 || soortwaarde == "gewicht") {
                //melding verbergen
                deleteMeldingContainer.attr('hidden', 'hidden');

                $('#deleteModal').modal('show');
            } else {
                //melding tonen
                deleteMeldingContainer.removeAttr('hidden');
            }
        });
    }

    function ajaxTable_verwijderModalListener() {
        $('#deleteAllData').click(function (e) {
            $('#deleteModal').modal('hide');
            //note: dit form noemt in beide ajax-view hetzelfde, maar roept een andere functie op in controller
            $("#form_product_beheren_grondstoffen_delete").submit();
        });
    }

    $(document).ready(function () {
        getDocumentControls();
        formEditListener_vervangKommasDoorPunt();
        ajaxTable_bewerkListener();
        ajaxTable_verwijderListener_showModal();
        ajaxTable_verwijderModalListener();
    });
</script>
