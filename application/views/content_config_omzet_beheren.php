<main role="main" class="container" id="content_config_omzet_toevoegen">
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
                                'id' => 'form_config_omzet_beheren',
                                'name' => 'form_config_omzet_beheren',
                                'data-toggle' => 'validator',
                                'role' => 'form');

                            $dataSubmit = array(
                                'id' => 'submit_config_omzet_beheren',
                                'name' => 'submit_config_omzet_beheren',
                                'type' => 'submit',
                                'value' => 'Opslaan',
                                'class' => 'btn btn-outline-success agricon-formsubmit-button');
                            ?>
                            <?php echo form_open('configuratie/omzet_insert', $dataOpen); ?>

                            <section>
                                <div class="form-row agricon-formcolumn">
                                    <div class="col-4">
                                        <label for="config_omzet_naam" class="form-text text-muted">Naam *</label>
                                        <?php echo form_input('config_omzet_naam', '', 'autofocus id="config_omzet_naam" type="text" class="form-control" required="required" placeholder="bv 2018 standaard" aria-label="omzet naam"'); ?>
                                    </div>
                                    <div class="col-4">
                                        <label for="config_omzet_zakjesperdag" class="form-text text-muted">Zakjes/dag
                                            *</label>
                                        <?php echo form_input('config_omzet_zakjesperdag', '', ' id="config_omzet_zakjesperdag" type="number" pattern="' . customNumberPattern() . '" title="' . customNumberPatternMessage() . '" class="form-control" required="required" placeholder="bv 1250" aria-label="omzet zakjes per dag"'); ?>
                                    </div>
                                    <div class="col-4">
                                        <label for="config_omzet_dagenperjaar" class="form-text text-muted">Dagen/jaar
                                            *</label>
                                        <?php echo form_input('config_omzet_dagenperjaar', '', ' id="config_omzet_dagenperjaar" type="number" pattern="' . customNumberPattern() . '" title="' . customNumberPatternMessage() . '" class="form-control" required="required" placeholder="bv 250" aria-label="omzet dagen per jaar"'); ?>
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
                                <?php echo form_input(array('name' => 'zoeknaam', 'id' => 'zoeknaam', 'class' => 'form-control', 'placeholder' => '- Zoek -', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = '- Zoek -'"), $zoeknaam_omzet_value); ?>
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
                            'id' => 'form_config_omzet_update',
                            'name' => 'form_config_omzet_update',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_config_omzet_update',
                            'name' => 'submit_config_omzet_update',
                            'type' => 'submit');

                        echo form_open('configuratie/omzet_update', $dataOpen);
                        echo form_input('config_omzet_id_update', '', 'id="config_omzet_id_update" class="form-control" required="required" aria-label="omzet id"');
                        echo form_input('config_omzet_naam_update', '', 'id="config_omzet_naam_update" class="form-control" required="required" placeholder="naam" aria-label="omzet naam"');
                        echo form_input('config_omzet_zakjesperdag_update', '', 'id="config_omzet_zakjesperdag_update" class="form-control" required="required" placeholder="naam" aria-label="omzet naam"');
                        echo form_input('config_omzet_dagenperjaar_update', '', 'id="config_omzet_dagenperjaar_update" class="form-control" required="required" placeholder="naam" aria-label="omzet naam"');
                        echo form_submit($dataSubmit);
                        echo form_close();
                        ?>
                    </div>
                    <div hidden>
                        <?php
                        $dataOpen = array(
                            'id' => 'form_config_omzet_delete',
                            'name' => 'form_config_omzet_delete',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_config_omzet_delete',
                            'name' => 'submit_config_omzet_delete',
                            'type' => 'submit');

                        echo form_open('configuratie/omzet_delete', $dataOpen);
                        echo form_input('config_omzet_id_delete', '', 'id="config_omzet_id_delete" class="form-control" required="required" aria-label="omzet id"');
                        echo form_input('config_omzet_naam_delete', '', 'id="config_omzet_naam_delete" class="form-control" required="required" placeholder="naam" aria-label="omzet naam"');
                        echo form_submit($dataSubmit);
                        echo form_close();
                        ?>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <?php createBasicDeleteModal('Waarschuwing',
        'Deze omzet is gekoppeld aan ...',
        'Deze verwijderfunctie is nog in ontwikkeling',
        'Wil je deze omzet verwijderen? ',
        "Verwijder"); ?>
</main>

<script>
    function get_byZoekFunctie(deelvannaam) {
        $.ajax({
            type: "POST",
            url: site_url + "/configuratie/omzet_ajax_get_by_zoekfunctie",
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

    function ajaxTable_bewerkListener() {
        $(".trigger-bewerkrij").click(function () {
            //controls
            var clickedIconSVG = $(this).find('i');
            var clickedRow = $(this).parent().parent();
            var targetInputField_Name = clickedRow.find('input#editableInput_naam');
            var targetInputField_ZakjesPerDag = clickedRow.find('input#editableInput_zakjesperdag');
            var targetInputField_DagenPerJaar = clickedRow.find('input#editableInput_dagenperjaar');
            //data
            var configOmzetId = $(this).data('id');

            targetInputField_Name.toggleClass('agricon-is-editable-input');

            //wanneer het "editable" is -> icoontje veranderen + autofocus op de input + een class toevoegen
            if (targetInputField_Name.hasClass('agricon-is-editable-input')) {
                clickedRow.addClass('trGlow');
                targetInputField_Name.focus();
                targetInputField_Name.removeAttr('readonly');
                targetInputField_ZakjesPerDag.removeAttr('readonly');
                targetInputField_DagenPerJaar.removeAttr('readonly');
                clickedIconSVG.removeClass('fa-pencil-alt');
                clickedIconSVG.addClass('fa-save');
            } else {
                // anders alles terugzetten + gegevens updaten in de database
                clickedRow.removeClass('trGlow');
                targetInputField_Name.attr('readonly', 'readonly');
                targetInputField_ZakjesPerDag.attr('readonly', 'readonly');
                targetInputField_DagenPerJaar.attr('readonly', 'readonly');
                clickedIconSVG.removeClass('fa-save');
                clickedIconSVG.addClass('fa-pencil-alt');

                var configOmzetNaam = targetInputField_Name.val();
                var configOmzetZakjesPerDag = targetInputField_ZakjesPerDag.val();
                var configOmzetDagenPerJaar = targetInputField_DagenPerJaar.val();

                if (configOmzetNaam != "" && configOmzetNaam != null && configOmzetId != 0 && configOmzetId != null) {
                    $("#form_config_omzet_update input#config_omzet_id_update").val(configOmzetId);
                    $("#form_config_omzet_update input#config_omzet_naam_update").val(configOmzetNaam);
                    $("#form_config_omzet_update input#config_omzet_zakjesperdag_update").val(configOmzetZakjesPerDag);
                    $("#form_config_omzet_update input#config_omzet_dagenperjaar_update").val(configOmzetDagenPerJaar);
                    $("#form_config_omzet_update").submit();
                }
            }
        });
    }

    function ajaxTable_verwijderListener_showModal() {
        $(".agricon-delete-icon").click(function () {
            var configOmzetId = $(this).data('id');
            var configOmzetNaam = $(this).data('omzetnaam');
            if (configOmzetId != 0 && configOmzetId != null) {
                $("#form_config_omzet_delete input#config_omzet_id_delete").val(configOmzetId);
                $("#form_config_omzet_delete input#config_omzet_naam_delete").val(configOmzetNaam);
            }
            $('#deleteModal').modal('show');
        });
    }

    function ajaxTable_verwijderModalListener() {
        $('#deleteAllData').click(function (e) {
            $('#deleteModal').modal('hide');
            $("#form_config_omzet_delete").submit();
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
