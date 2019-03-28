<main role="main" class="container" id="content_kost_machines_reparaties_beheren">
    <div class="row agricon-content-title">
        <h3 style="position: relative"><?php echo $title; ?></h3>

        <div id="agricon_alert_container">
            <div class="alert agricon-alert alert-dismissible fade <?php echo $alert->class; ?>" role="alert">
                <?php echo $alert->message; ?>
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
                            echo "<p class='agricon-back-to-page-button'><a href='" . site_url('kost_machines/beheren') . "'><button type='button' class='btn btn-outline-secondary'>Terug</button></a></p>";
                            ?>
                        </h5>
                    </div>
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <?php
                            $dataOpen = array(
                                'id' => 'form_kost_machines_reparaties_beheren',
                                'name' => 'form_kost_machines_reparaties_beheren',
                                'data-toggle' => 'validator',
                                'role' => 'form');

                            $dataSubmit = array(
                                'id' => 'submit_kost_machines_reparaties_beheren',
                                'name' => 'submit_kost_machines_reparaties_beheren',
                                'type' => 'submit',
                                'value' => 'Opslaan',
                                'class' => 'btn btn-outline-success agricon-formsubmit-button');
                            ?>
                            <?php echo form_open('kost_machines_reparaties/insert', $dataOpen); ?>

                            <section>
                                <?php
                                // machineId nemen, anders op id -1 zetten (= N/A)
                                if (isset($machineId)) {
                                    $machine_id = $machineId;
                                }
                                elseif (isset($reparaties)) {
                                    $machine_id = $reparaties[0]->kostMachinesId;
                                }
                                else {
                                    $machine_id = -1;
                                }
                                // machineId nemen, anders op id -1 zetten (= N/A)
                                if (isset($machineNaam)) {
                                    $machine_naam = $machineNaam;
                                }
                                else {
                                    $machine_naam = "reparaties";
                                }
                                ?>
                                <div hidden class="form-row">
                                    <label for="kost_machinenaam" class="form-text text-muted">Naam *</label>
                                    <?php echo form_input('reparatie_machinenaam', $machine_naam, 'id="reparatie_machinenaam" type="text" class="form-control" placeholder="bv 2018 standaard" aria-label=" machine naam"'); ?>
                                </div>
                                <div hidden class="form-row">
                                    <label for="kost_machineid" class="form-text text-muted">Id *</label>
                                    <?php echo form_input('reparatie_machineid', $machine_id, 'id="reparatie_machineid" type="text" class="form-control" placeholder="bv 2018 standaard" aria-label=" machine id"'); ?>
                                </div>

                                <div id="agricon_dynamic_formfields" style="margin: 0;padding: 0">
                                    <div class="form-row agricon-formcolumn">
                                        <div class="col-4">
                                            <label for="kost_machines_reparaties_reparatieKost1"
                                                   class="form-text text-muted">Kost *</label>
                                            <?php echo form_input('kost_machines_reparaties_reparatieKost1', '', 'id="kost_machines_reparaties_reparatieKost1" type="number" 
                                        step="0.01" pattern="' . customDecimalNumberPattern() . '" title="' . customDecimalNumberPatternMessage() . '" class="form-control" required="required" '); ?>

                                        </div>

                                        <div class="col-4">
                                            <label for="kost_machines_reparaties_reparatieUren1"
                                                   class="form-text text-muted">Uren/Reparatie *</label>
                                            <?php echo form_input('kost_machines_reparaties_reparatieUren1', '', 'id="kost_machines_reparaties_reparatieUren1" type="number" 
                                        step="0.01" pattern="' . customDecimalNumberPattern() . '" title="' . customDecimalNumberPatternMessage() . '" class="form-control" required="required" '); ?>

                                        </div>
                                        <div class="col-4">
                                            <label for="kost_machines_reparaties_reparatieUurloon1"
                                                   class="form-text text-muted"
                                                   style="padding-left:5px">Uurloon *</label>
                                            <?php echo form_input('kost_machines_reparaties_reparatieUurloon1', '', 'id="kost_machines_reparaties_reparatieUurloon1" type="number" 
                                        step="0.01" pattern="' . customDecimalNumberPattern() . '" title="' . customDecimalNumberPatternMessage() . '" class="form-control" required="required" style="margin-left:5px"'); ?>
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
                                REPARATIES VAN <?php echo strtoupper($machineNaam); ?>
                            </button>
                        </h5>
                    </div>
                    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body agricon-card-body-table">

                            <div class="form-group " style="height: 78px"></div>

                            <section id="resultaat" style="position: relative">
                                <div id="cal_kostperjaar"
                                     class="agricon-calculation-message-container agricon-c-m-c-large agricon-hide-this">
                                    <?php
                                    if (isset($reparaties)) {
                                        getCalculationMessage_kost_machines_reparaties($reparaties[0], $machineNaam);
                                    }
                                    ?>
                                </div>

                                <div class="form-row agricon-table-container agricon-wijzigbestaande-ajaxtable">
                                    <?php
                                    if (isset($reparaties)) {
                                        $template = array('table_open' => '<table id="kost_machines_reparaties_table" class="agricon-table table table-responsive-sm table-sm table-striped noHoverAllowed tablesorter " border="0" cellpadding="4" cellspacing="0">');
                                        $this->table->set_template($template);

                                        $sortIcon = '<div class="agricon-sort-icon"><i class="fas fa-sort"></i></div>';
                                        $calcIcon = array(
                                            'data' => '<div style="position: relative" class="trigger_showCalculation" data-toggle="tooltip" data-placement="bottom"
                                                        title="Toon/Verberg berekening"><i class="fas fa-calculator"></i></div>',
                                            'style' => 'width:20px;margin-right:10px'
                                        );
                                        $th_gewijzigdOp = ['data' => 'Gewijzigd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];
                                        $th_toegevoedOp = ['data' => 'Toegevoegd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];

                                        $this->table->set_heading($calcIcon, 'Reparatie Kost' . $sortIcon, 'Reparatie Uren' . $sortIcon, 'Reparatie Uurloon' . $sortIcon, 'Reparatie Totaalkost' . $sortIcon,
                                            $th_gewijzigdOp,
                                            'Door' . $sortIcon, $th_toegevoedOp, 'Door' . $sortIcon, '', '');//laaste kolom als reparatieId gebruiken
                                        $rijNummer = 0;
                                        foreach ($reparaties as $reparatie) {
                                            $rijNummer++;
                                            // <span hidden></span> gebruiken om te sorteren via tablesorter() -> de inputvelden kunnen editable gemaakt worden met jQuery
                                            $this->table->add_row(
                                                $rijNummer,
                                                '<span hidden>' . $reparatie->reparatieKost . '</span><input id="editableInput_reparatieKost" readonly="readonly" value="' . $reparatie->reparatieKost . '" onfocus="var temp_value=this.value; this.value=\'\'; this.value=temp_value">',
                                                '<span hidden>' . $reparatie->reparatieUren . '</span><input id="editableInput_reparatieUren" readonly="readonly" value="' . $reparatie->reparatieUren . '" onfocus="var temp_value=this.value; this.value=\'\'; this.value=temp_value">',
                                                '<span hidden>' . $reparatie->reparatieUurloon . '</span><input id="editableInput_reparatieUurloon" readonly="readonly" value="' . $reparatie->reparatieUurloon . '" onfocus="var temp_value=this.value; this.value=\'\'; this.value=temp_value">',
                                                '<span hidden>' . $reparatie->reparatieKostPerReparatie . '</span><input id="notEditableInput_reparatieKostPerReparatie" readonly="readonly" style="font-weight: 600" value="' . $reparatie->reparatieKostPerReparatie . '">',
                                                $reparatie->gewijzigdOp_datum . ' ' . $reparatie->gewijzigdOp_tijd,
                                                ucfirst($reparatie->gewijzigdDoorUser),
                                                $reparatie->toegevoegdOp_datum . ' ' . $reparatie->toegevoegdOp_tijd,
                                                ucfirst($reparatie->toegevoegdDoorUser),
                                                '<div class="trigger-bewerkrij agricon-changeable-icon changeIcon' . $rijNummer . '" data-id="' . $reparatie->id . '" data-machineid="' . $reparatie->kostMachinesId . '"><i class="fas fa-pencil-alt"></i></div>',
                                                '<div class="agricon-delete-icon" data-id="' . $reparatie->id . '" data-machinenaam="' . $machineNaam . '" data-machineid="' . $reparatie->kostMachinesId . '"><i class="fas fa-times"></i></div>'
                                            );
                                        }
                                        echo $this->table->generate();
                                    } ?>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>

                <section>
                    <div hidden>
                        <?php
                        $dataOpen = array(
                            'id' => 'form_reparaties_update',
                            'name' => 'form_reparaties_update',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_reparaties_update',
                            'name' => 'submit_reparaties_update',
                            'type' => 'submit');

                        echo form_open('kost_machines_reparaties/update', $dataOpen);

                        echo form_input('reparatie_id_update', '', 'id="reparatie_id_update" class="form-control" required="required" aria-label="categorie id"');
                        echo form_input('reparatie_kost_update', '', 'id="reparatie_kost_update" class="form-control" required="required" placeholder="percentage" aria-label="percentage naam"');
                        echo form_input('reparatie_uren_update', '', 'id="reparatie_uren_update" class="form-control" required="required" placeholder="percentage" aria-label="percentage naam"');
                        echo form_input('reparatie_uurloon_update', '', 'id="reparatie_uurloon_update" class="form-control" required="required" placeholder="percentage" aria-label="percentage naam"');

                        echo form_input('reparatie_machineid_update', $machineId, 'id="reparatie_machineid_update" class="form-control" required="required" aria-label="categorie id"');
                        echo form_input('reparatie_machinenaam_update', $machineNaam, 'id="reparatie_machinenaam_update" class="form-control" required="required" placeholder="naam" aria-label="categorie naam"');

                        echo form_submit($dataSubmit);
                        echo form_close();
                        ?>
                    </div>
                    <div hidden>
                        <?php
                        $dataOpen = array(
                            'id' => 'form_reparaties_delete',
                            'name' => 'form_reparaties_delete',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_reparaties_delete',
                            'name' => 'submit_reparaties_delete',
                            'type' => 'submit');

                        echo form_open('kost_machines_reparaties/delete', $dataOpen);
                        echo form_input('reparatie_id_delete', '', 'id="reparatie_id_delete" class="form-control"  aria-label="reparatie id"');
                        echo form_input('reparatie_machineid_delete', '', 'id="reparatie_machineid_delete" class="form-control"  placeholder="naam" aria-label="machine id"');
                        echo form_input('reparatie_machinenaam_delete', '', 'id="reparatie_machinenaam_delete" class="form-control"  placeholder="naam" aria-label="machine naam"');

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
        'Deze machinereparatie is gekoppeld aan machinekosten.',
        'Deze verwijdering is momenteel nog in ontwikkeling',
        'Wil je deze machinereparatie verwijderen? ',
        "Verwijder"); ?>

</main>

<script>

    function addReparatieFields(e) {
        e.preventDefault();
        var reparatieTeller = (parseInt($('#aantal_reparaties').val()) + 1);
        $('#aantal_reparaties').val(reparatieTeller); //controleren in controller, er kunnen 6 aangemaakt zijn, maar 4 verwijderd van de DOM. Dan zijn er bv oplopende velden met "naam_xxx_1" en "naam_xxx4' -> is dus niet steeds mooi van 1, 2, 3

        $('#agricon_dynamic_formfields').append(
            '<div class="form-row agricon-formcolumn">' +
            '<div class="col-4">' +
            '<input type="text" name="kost_machines_reparaties_reparatieKost' + reparatieTeller + '" id="kost_machines_reparaties_reparatieKost' + reparatieTeller + '" class="form-control" ' +
            'type="number"  step="0.01" pattern="^\\d+(?:[\\.,]\\d{1,2})?$"' +
            'title="Geef een geheel of decimaal getal in. Een decimaal moet minimum 1 cijfer voor, en maximum 2 cijfers na het scheidingsteken hebben."/>' +
            '</div>' +
            '<div class="col-4">' +
            '<input type="text" name="kost_machines_reparaties_reparatieUren' + reparatieTeller + '" id="kost_machines_reparaties_reparatieUren' + reparatieTeller + '" class="form-control" ' +
            'type="number"  step="0.01"  pattern="^\\d+(?:[\\.,]\\d{1,2})?$"' +
            'title="Geef een geheel of decimaal getal in. Een decimaal moet minimum 1 cijfer voor, en maximum 2 cijfers na het scheidingsteken hebben."/>' +
            '</div>' +
            '<div class="col-4">' +
            '<input type="text" name="kost_machines_reparaties_reparatieUurloon' + reparatieTeller + '" id="kost_machines_reparaties_reparatieUurloon' + reparatieTeller + '" class="form-control" ' +
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
        var reparatie1 = $("#kost_machines_reparaties_reparatieKost1").val();
        var reparatieUren1 = $("#kost_machines_reparaties_reparatieUren1").val();
        var reparatieUurloon1 = $("#kost_machines_reparaties_reparatieUurloon1").val();
        var reparatieTeller = parseInt($('#aantal_reparaties').val());

        if ((reparatie1 != '' && reparatie1 != null) && (reparatieUren1 != '' && reparatieUren1 != null) && (reparatieUurloon1 != '' && reparatieUurloon1 != null)) {
            var i = 1;
            for (i; i <= reparatieTeller; i++) {
                // enkel rekening houden met een reparatie die volledig ingevuld is, verwijderen van DOM indien dit niet het geval is
                if (
                    ($('#kost_machines_reparaties_reparatieKost' + i).val() == null || $('#kost_machines_reparaties_reparatieKost' + i).val() == 0 || $('#kost_machines_reparaties_reparatieKost' + i).val() == "") ||
                    ($('#kost_machines_reparaties_reparatieUren' + i).val() == null || $('#kost_machines_reparaties_reparatieUren' + i).val() == 0 || $('#kost_machines_reparaties_reparatieUren' + i).val() == "") ||
                    ($('#kost_machines_reparaties_reparatieUurloon' + i).val() == null || $('#kost_machines_reparaties_reparatieUurloon' + i).val() == 0 || $('#kost_machines_reparaties_reparatieUurloon' + i).val() == "")) {
                    $('#kost_machines_reparaties_reparatieKost' + i).parent().parent().remove();
                }
            }
            readyToSubmit = true;
            $("#form_kost_machines_reparaties_beheren").submit(); //submit opnieuw triggeren
        }
    }

    function changeListener() {
        //UPDATE - trigger om input fields editable te maken
        $(".trigger-bewerkrij").click(function () {
            //controls
            var clickedIconSVG = $(this).find('i');
            var clickedRow = $(this).parent().parent();

            var targetInputField_kost = clickedRow.find('input#editableInput_reparatieKost');
            var targetInputField_uren = clickedRow.find('input#editableInput_reparatieUren');
            var targetInputField_uurloon = clickedRow.find('input#editableInput_reparatieUurloon');

            //data
            var reparatieId = $(this).data('id');
            targetInputField_kost.toggleClass('agricon-is-editable-input');

            //wanneer het "editable" is -> icoontje veranderen + autofocus op de input + een class toevoegen
            if (targetInputField_kost.hasClass('agricon-is-editable-input')) {
                clickedRow.addClass('trGlow');
                targetInputField_kost.focus();
                targetInputField_kost.removeAttr('readonly');
                targetInputField_uren.removeAttr('readonly');
                targetInputField_uurloon.removeAttr('readonly');

                clickedIconSVG.removeClass('fa-pencil-alt');
                clickedIconSVG.addClass('fa-save');
            } else {
                // anders alles terugzetten + gegevens updaten in de database
                clickedRow.removeClass('trGlow');
                targetInputField_kost.attr('readonly', 'readonly');
                targetInputField_uren.attr('readonly', 'readonly');
                targetInputField_uurloon.attr('readonly', 'readonly');

                clickedIconSVG.removeClass('fa-save');
                clickedIconSVG.addClass('fa-pencil-alt');

                //hidden form opvullen
                var reparatieKost = targetInputField_kost.val();
                var reparatieUren = targetInputField_uren.val();
                var reparatieUurloon = targetInputField_uurloon.val();

                if (reparatieId != "" && reparatieId != null && reparatieId != 0) {
                    $("#form_reparaties_update input#reparatie_id_update").val(reparatieId);
                    $("#form_reparaties_update input#reparatie_kost_update").val(reparatieKost);
                    $("#form_reparaties_update input#reparatie_uren_update").val(reparatieUren);
                    $("#form_reparaties_update input#reparatie_uurloon_update").val(reparatieUurloon);

                    $("#form_reparaties_update").submit();
                }
            }


        });
    }

    function deleteListener() {
        // DELETE - SHOW CONFIRMATION MODAL
        $(".agricon-delete-icon").click(function () {
            var reparatieId = $(this).data('id');
            var machineId = $(this).data('machineid');
            var machineNaam = $(this).data('machinenaam');
            // hidden form opvullen
            if (reparatieId != 0 && reparatieId != null) {
                $("#form_reparaties_delete input#reparatie_id_delete").val(reparatieId);
                $("#form_reparaties_delete input#reparatie_machineid_delete").val(machineId);
                $("#form_reparaties_delete input#reparatie_machinenaam_delete").val(machineNaam);
            }
            $('#deleteModal').modal('show');
        });

    }

    function deleteConfirmationListener() {
        // DELETE MODAL LISTENER
        $('#deleteAllData').click(function (e) {
            $('#deleteModal').modal('hide');
            $("#form_reparaties_delete").submit();
        });
    }

    function formEditListener_vervangKommasDoorPunt() {
        // kommas vervangen door een punt
        var controlInput_reparatieKost = $("input#editableInput_reparatieKost");
        var controlInput_reparatieUren = $("input#editableInput_reparatieUren");
        var controlInput_reparatieUurloon = $("input#editableInput_reparatieUurloon");

        $(controlInput_reparatieKost).add(controlInput_reparatieUren).add(controlInput_reparatieUurloon).keyup(function () {
            var currentValue = $(this).val();
            var correctValue;
            if (currentValue.includes(",")) {
                correctValue = currentValue.replace(",", ".");
                $(this).val(correctValue);
            }
        });
    }

    $(document).ready(function () {
        formEditListener_vervangKommasDoorPunt();
        // reparatie-toevoegButton-trigger
        $("#agricon_add_reparatieFields").click(function (e) {
            addReparatieFields(e);
        });

        // bij klikken van de "OPSLAAN" knop, eerst controleren of alle reparaties ingevuld zijn
        $('#form_kost_machines_reparaties_beheren').on('submit', function (e) {
            validateBeforeSubmit(e);
        });

        // showCalculationListener();   // wordt gertriggerd in main_master
        calculationMessage_ResizeListener();
        calculationMessage_CloseListener();
        changeListener();
        deleteListener();
        deleteConfirmationListener();
    });
</script>
