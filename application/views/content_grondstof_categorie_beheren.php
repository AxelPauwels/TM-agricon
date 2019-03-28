<main role="main" class="container" id="content_grondstof_categorie_toevoegen">
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
                <div class="card agricon-card-firstaccordioncard">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne"
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
                                'id' => 'form_grondstof_categorie_toevoegen',
                                'name' => 'form_grondstof_categorie_toevoegen',
                                'data-toggle' => 'validator',
                                'role' => 'form');

                            $dataSubmit = array(
                                'id' => 'submit_grondstof_categorie_toevoegen',
                                'name' => 'submit_grondstof_categorie_toevoegen',
                                'type' => 'submit',
                                'value' => 'Opslaan',
                                'class' => 'btn btn-outline-success agricon-formsubmit-button');
                            ?>
                            <?php echo form_open('grondstof_categorie/insert', $dataOpen); ?>

                            <section>
                                <div class="form-row">
                                    <label for="categorie_naam" class="form-text text-muted">Naam *</label>
                                    <?php echo form_input('categorie_naam', '', 'autofocus id="categorie_naam" type="text" class="form-control" required="required" placeholder="bv potgrond" aria-label="Naam"'); ?>
                                </div>

                                <?php
                                $dropdownOptions = ['' => 'Selecteer', 1 => 'Dit is een fractie categorie', 0 => 'Dit is GEEN fractie categorie']
                                ?>
                                <div class="form-row">
                                    <label for="categorie_isfractiecategorie" class="form-text text-muted">Categorie
                                        voor fracties? *</label>
                                    <?php echo form_dropdown('categorie_isfractiecategorie', $dropdownOptions, '', 'id="categorie_isfractiecategorie" class="form-control" required="required" '); ?>
                                </div>
                                <p class=" text-muted" style="font-size: 12px;font-style: italic;">
                                    Info: Er wordt rekening gehouden met indien een grondstof een "gewone grondstof" of
                                    een "fractie grondstof" is. Een "fractie grondstof" komt voort uit een ruwe
                                    grondstof.
                                    Indien je "geen fractie categorie" selecteert, zal deze categorie niet verschijnen
                                    in dropdowns tijdens het beheren van fracties. Deze instelling wordt ook gebruikt
                                    tijdens het zoeken naar grondstoffen of fractiegrondstoffen. Dankzij deze instelling
                                    blijven grondstoffen gescheiden en kan er bijvoorbeeld niet per ongeluk een fractie
                                    van "schors" gekoppeld worden aan "meststof".
                                </p>

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
                                <?php echo form_input(array('name' => 'zoeknaam', 'id' => 'zoeknaam', 'class' => 'form-control', 'placeholder' => '- Zoek -', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = '- Zoek -'"), $zoeknaam_grondstofcategorie_value); ?>
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
                            'id' => 'form_grondstof_categorie_update',
                            'name' => 'form_grondstof_categorie_update',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_grondstof_categorie_update',
                            'name' => 'submit_grondstof_categorie_update',
                            'type' => 'submit');

                        echo form_open('grondstof_categorie/update', $dataOpen);
                        echo form_input('categorie_id', '', 'id="categorie_id" class="form-control" required="required" aria-label="categorie id"');
                        echo form_input('categorie_naam', '', 'id="categorie_naam" class="form-control" required="required" placeholder="naam" aria-label="categorie naam"');
                        echo form_submit($dataSubmit);
                        echo form_close();
                        ?>
                    </div>
                    <div hidden>
                        <?php
                        $dataOpen = array(
                            'id' => 'form_grondstof_categorie_delete',
                            'name' => 'form_grondstof_categorie_delete',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_grondstof_categorie_delete',
                            'name' => 'submit_grondstof_categorie_delete',
                            'type' => 'submit');

                        echo form_open('grondstof_categorie/delete', $dataOpen);
                        echo form_input('categorie_id', '', 'id="categorie_id" class="form-control" required="required" aria-label="categorie id"');
                        echo form_input('categorie_naam', '', 'id="categorie_naam" class="form-control" required="required" placeholder="naam" aria-label="categorie naam"');
                        echo form_submit($dataSubmit);
                        echo form_close();
                        ?>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <?php createBasicDeleteModal('Waarschuwing',
        'Deze categorie is gekoppeld aan ruwe grondstoffen.',
        'Deze ruwe grondstof heeft afgewerkte grondstoffen (fracties of niet) die gebruikt worden bij de samenstellingen van producten. Wanneer je deze categorie verwijderd, zullen alle ruwe grondstoffen met bijhorende grondstoffen mee verwijderd worden. <br><br> Indien een product samengesteld is uit een grondstof met een percentage (%) is het totaal niet meer 100% en zullen deze producten mee verwijderd worden.',
        'Wil je deze categorie verwijderen? ',
        "Verwijder"); ?>
</main>

<script>
    function get_byZoekFunctie(deelvannaam) {
        $.ajax({
            type: "POST",
            url: site_url + "/grondstof_categorie/ajax_get_by_zoekfunctie",
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
//            var targetInputField_Name = clickedRow.find('input:first');
            var targetInputField_Name = clickedRow.find('input#editableInput_naam');

            //data
            var categorieId = $(this).data('id');

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

                var categorieNaam = targetInputField_Name.val();
                if (categorieNaam != "" && categorieNaam != null && categorieId != 0 && categorieId != null) {
                    $("#form_grondstof_categorie_update input#categorie_id").val(categorieId);
                    $("#form_grondstof_categorie_update input#categorie_naam").val(categorieNaam);
                    $("#form_grondstof_categorie_update").submit();
                }
            }
        });
    }

    function ajaxTable_verwijderListener_showModal() {
        $(".agricon-delete-icon").click(function () {
            var categorieId = $(this).data('id');
            var categorieNaam = $(this).data('categorienaam');
            if (categorieId != 0 && categorieId != null) {
                $("#form_grondstof_categorie_delete input#categorie_id").val(categorieId);
                $("#form_grondstof_categorie_delete input#categorie_naam").val(categorieNaam);
            }
            $('#deleteModal').modal('show');

        });
    }

    function ajaxTable_verwijderModalListener() {
        $('#deleteAllData').click(function (e) {
            $('#deleteModal').modal('hide');
            $("#form_grondstof_categorie_delete").submit();
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
