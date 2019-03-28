<main role="main" class="container" id="content_config_eenheid_toevoegen">
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
                                'id' => 'form_config_eenheid_beheren',
                                'name' => 'form_config_eenheid_beheren',
                                'data-toggle' => 'validator',
                                'role' => 'form');

                            $dataSubmit = array(
                                'id' => 'submit_config_eenheid_beheren',
                                'name' => 'submit_config_eenheid_beheren',
                                'type' => 'submit',
                                'value' => 'Opslaan',
                                'class' => 'btn btn-outline-success agricon-formsubmit-button');
                            ?>
                            <?php echo form_open('configuratie/eenheden_insert', $dataOpen); ?>

                            <section>
                                <div class="form-row">
                                    <label for="config_eenheid_naam" class="form-text text-muted">Naam *</label>
                                    <?php echo form_input('config_eenheid_naam', '', 'autofocus id="config_eenheid_naam" type="text" class="form-control" required="required" placeholder="bv m&sup3;, ton, liter" aria-label="eenheid naam"'); ?>
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
                                <?php echo form_input(array('name' => 'zoeknaam', 'id' => 'zoeknaam', 'class' => 'form-control', 'placeholder' => '- Zoek -', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = '- Zoek -'"), $zoeknaam_eenheid_value); ?>
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
                            'id' => 'form_config_eenheid_update',
                            'name' => 'form_config_eenheid_update',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_config_eenheid_update',
                            'name' => 'submit_config_eenheid_update',
                            'type' => 'submit');

                        echo form_open('configuratie/eenheden_update', $dataOpen);
                        echo form_input('config_eenheid_id_update', '', 'id="config_eenheid_id_update" class="form-control" required="required" aria-label="eenheid id"');
                        echo form_input('config_eenheid_naam_update', '', 'id="config_eenheid_naam_update" class="form-control" required="required" placeholder="naam" aria-label="eenheid naam"');
                        echo form_submit($dataSubmit);
                        echo form_close();
                        ?>
                    </div>
                    <div hidden>
                        <?php
                        $dataOpen = array(
                            'id' => 'form_config_eenheid_delete',
                            'name' => 'form_config_eenheid_delete',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_config_eenheid_delete',
                            'name' => 'submit_config_eenheid_delete',
                            'type' => 'submit');

                        echo form_open('configuratie/eenheden_delete', $dataOpen);
                        echo form_input('config_eenheid_id_delete', '', 'id="config_eenheid_id_delete" class="form-control" required="required" aria-label="eenheid id"');
                        echo form_input('config_eenheid_naam_delete', '', 'id="config_eenheid_naam_delete" class="form-control" required="required" placeholder="naam" aria-label="eenheid naam"');
                        echo form_submit($dataSubmit);
                        echo form_close();
                        ?>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <?php createBasicDeleteModal('Waarschuwing',
        'Deze eenheid is gekoppeld aan ruwe grondstoffen.',
//        'Wanneer je deze eenheid verwijderd, zullen alle ruwe grondstoffen gelinkt worden naar "Geen".<br>Deze eenheid wordt ook gebruikt om *** te berekenen, waardoor ...  ',
        'Deze verwijderfunctie is nog in ontwikkeling',
        'Wil je deze eenheid verwijderen? ',
        "Verwijder"); ?>
</main>

<script>
    function get_byZoekFunctie(deelvannaam) {
        $.ajax({
            type: "POST",
            url: site_url + "/configuratie/eenheden_ajax_get_by_zoekfunctie",
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
            //data
            var configEenheidId = $(this).data('id');

            targetInputField_Name.toggleClass('agricon-is-editable-input');

            //wanneer het "editable" is -> icoontje veranderen + autofocus op de input + een class toevoegen
            if (targetInputField_Name.hasClass('agricon-is-editable-input')) {
                clickedRow.addClass('trGlow');
                targetInputField_Name.focus();
                targetInputField_Name.removeAttr('readonly');
                clickedIconSVG.removeClass('fa-pencil-alt');
                clickedIconSVG.addClass('fa-save');
            } else {
                // anders alles terugzetten + gegevens updaten in de database
                clickedRow.removeClass('trGlow');
                targetInputField_Name.attr('readonly', 'readonly');
                clickedIconSVG.removeClass('fa-save');
                clickedIconSVG.addClass('fa-pencil-alt');

                var configEenheidNaam = targetInputField_Name.val();
                if (configEenheidNaam != "" && configEenheidNaam != null && configEenheidId != 0 && configEenheidId != null) {
                    $("#form_config_eenheid_update input#config_eenheid_id_update").val(configEenheidId);
                    $("#form_config_eenheid_update input#config_eenheid_naam_update").val(configEenheidNaam);
                    $("#form_config_eenheid_update").submit();
                }
            }
        });
    }

    function ajaxTable_verwijderListener_showModal() {
        $(".agricon-delete-icon").click(function () {
            var configEenheidId = $(this).data('id');
            var configEenheidNaam = $(this).data('eenheidnaam');
            if (configEenheidId != 0 && configEenheidId != null) {
                $("#form_config_eenheid_delete input#config_eenheid_id_delete").val(configEenheidId);
                $("#form_config_eenheid_delete input#config_eenheid_naam_delete").val(configEenheidNaam);
            }
            $('#deleteModal').modal('show');

        });
    }

    function ajaxTable_verwijderModalListener() {
        $('#deleteAllData').click(function (e) {
            $('#deleteModal').modal('hide');
            $("#form_config_eenheid_delete").submit();
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
