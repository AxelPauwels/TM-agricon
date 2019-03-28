<main role="main" class="container" id="content_users_beheren">
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
                                'id' => 'form_users_beheren',
                                'name' => 'form_users_beheren',
                                'data-toggle' => 'validator',
                                'role' => 'form');

                            $dataSubmit = array(
                                'id' => 'submit_users_beheren',
                                'name' => 'submit_users_beheren',
                                'type' => 'submit',
                                'value' => 'Opslaan',
                                'class' => 'btn btn-outline-success agricon-formsubmit-button');
                            ?>
                            <?php echo form_open('user/insert', $dataOpen); ?>

                            <section>
                                <div id="resultaatUserExists" style="height: 0px;float:right"></div>
                                <div class="form-row">
                                    <label for="user_naam" class="form-text text-muted">Naam *</label>
                                    <?php echo form_input('user_naam', '', 'autofocus id="user_naam" type="text" class="form-control" required="required" aria-label="user naam"'); ?>
                                </div>
                                <div class="resultaatPasswordMatch" style="height: 0px;float:right"></div>
                                <div class="form-row">
                                    <label for="user_password1" class="form-text text-muted">Wachtwoord *</label>
                                    <?php echo form_password('user_password1', '', 'autofocus id="user_password1" type="password" class="form-control" required="required" aria-label="user paswoord 1"'); ?>
                                </div>
                                <div class="resultaatPasswordMatch" style="height: 0px;float:right"></div>
                                <div class="form-row">
                                    <label for="user_password2" class="form-text text-muted">Wachtwoord herhalen
                                        *</label>
                                    <?php echo form_password('user_password2', '', 'autofocus id="user_password2" type="password" class="form-control" required="required" aria-label="user paswoord 1"'); ?>
                                </div>
                                <div class="form-row">
                                    <label for="user_level" class="form-text text-muted">Gebruikersrechten</label>
                                    <?php echo form_dropdown('user_level', $userLevel_dropdownOptions, '', 'id="user_level" required="required" class="form-control" '); ?>
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
                                <?php echo form_input(array('name' => 'zoeknaam', 'id' => 'zoeknaam', 'class' => 'form-control', 'placeholder' => '- Zoek -', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = '- Zoek -'"), $zoeknaam_user_value); ?>
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
                            'id' => 'form_user_update',
                            'name' => 'form_user_update',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_user_update',
                            'name' => 'submit_user_update',
                            'type' => 'submit');

                        echo form_open('user/update', $dataOpen);
                        echo form_input('user_id_update', '', 'id="user_id_update" type="number" class="form-control" required="required" aria-label="user id"');
                        echo form_input('user_naam_update', '', 'id="user_naam_update" type="text" class="form-control" required="required" aria-label="user naam"');

                        echo form_input('user_password_update', '', 'id="user_password_update" type="password" class="form-control" required="required" aria-label="folie gesneden leverancierid"');
                        echo form_input('user_level_update', '', 'id="user_level_update" type="number" class="form-control" required="required" aria-label="folie gesneden leverancierid"');

                        echo form_submit($dataSubmit);
                        echo form_close();
                        ?>
                    </div>
                    <div hidden>
                        <?php
                        $dataOpen = array(
                            'id' => 'form_user_delete',
                            'name' => 'form_user_delete',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_user_delete',
                            'name' => 'submit_user_delete',
                            'type' => 'submit');

                        echo form_open('user/delete', $dataOpen);
                        echo form_input('user_id_delete', '', 'id="user_id_delete" class="form-control" required="required" aria-label="user id"');
                        echo form_input('user_naam_delete', '', 'id="user_naam_delete" class="form-control" required="required" aria-label="user naam"');
                        echo form_submit($dataSubmit);
                        echo form_close();
                        ?>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <?php createBasicDeleteModal('Waarschuwing',
        '',
        'Wanneer je deze gebruiker verwijderd, zullen alle gegevens die toegevoegd of bewerkt zijn door deze gebruiker naar "Geen" gebruiker gelinkt worden.<br>Gebruikers met gebruikersrechten "level 5" kunnen niet verwijderd worden.',
        'Wil je deze gebruiker verwijderen? ',
        "Verwijder "); ?>

</main>

<script>
    function get_byZoekFunctie(deelvannaam) {
        $.ajax({
            type: "POST",
            url: site_url + "/user/ajax_get_by_zoekfunctie",
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

    var userIsNewAndPasswordsMatch = true;
    function checkIfUserAlreadyExists(naam) {
        $.ajax({
            type: "POST",
            url: site_url + "/user/check_if_username_exists",
            data: {
                naam: naam
            },
            success: function (result) {
                $("div#resultaatUserExists").html('');
                if (JSON.parse(result) == true) {
                    $("div#resultaatUserExists").html('<span style="color:darkred;font-size:12px"> Deze gebruikersnaam bestaat al. Gelieve een andere naam te kiezen.</span>');
                    userIsNewAndPasswordsMatch = false;
                } else {
                    userIsNewAndPasswordsMatch = true;
                }
            },
            error: function (xhr, status, error) {
//                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText + error);
            }
        });
    }

    function checkIfPasswordsMatch() {
        var password1 = $('input#user_password1').val();
        var password2 = $('input#user_password2').val();
        if (password1 === password2) {
            $("div.resultaatPasswordMatch").html('');
            userIsNewAndPasswordsMatch = true;
        } else {
            $("div.resultaatPasswordMatch").html('<span style="color:darkred;font-size:12px"> Deze paswoorden komen niet overeen.</span>');
            userIsNewAndPasswordsMatch = false;
        }
    }

    function checkIfUserAlreadyExistsListener() {
        $('input#user_naam').keyup(function (e) {
            $(this).val($(this).val().toLowerCase());
            checkIfUserAlreadyExists($(this).val());
        });
    }
    function checkIfPasswordsMatchListener() {
        $('input#user_password2').keyup(function (e) {
            var password1 = $('input#user_password1').val();
            var password2 = $('input#user_password2').val();
            if (password1.length <= password2.length) {
                checkIfPasswordsMatch();
            }
        });
        $('input#user_password2').focusout(function (e) {
            checkIfPasswordsMatch(); // final check (indien er eerst een foutmelding werdt gegeven, maar nadien er te weinig karakters zijn in het 2de paswoord veld)
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
            var targetInputField_naam = clickedRow.find('input.editableInput_naam');
            var targetInputField_wachtwoord = clickedRow.find('input.editableInput_wachtwoord');
            var targetDropdownField_level = clickedRow.find('select.editableInput_level');

            //data
            var userId = $(this).data('id');
            targetInputField_naam.toggleClass('agricon-is-editable-input');

            //wanneer het "editable" is -> icoontje veranderen + autofocus op de input + een class toevoegen
            if (targetInputField_naam.hasClass('agricon-is-editable-input')) {
                clickedRow.addClass('trGlow');
                targetInputField_naam.focus();
                targetInputField_naam.removeAttr('readonly');
                targetInputField_wachtwoord.removeAttr('readonly');
                targetDropdownField_level.removeAttr('disabled');

                clickedIconSVG.removeClass('fa-pencil-alt');
                clickedIconSVG.addClass('fa-save');
            } else {
                // anders alles terugzetten + gegevens updaten in de database
                clickedRow.removeClass('trGlow');
                targetInputField_naam.attr('readonly', 'readonly');
                targetInputField_wachtwoord.attr('readonly', 'readonly');
                targetDropdownField_level.attr('disabled', 'disabled');

                clickedIconSVG.removeClass('fa-save');
                clickedIconSVG.addClass('fa-pencil-alt');

                //hidden form opvullen
                var userNaam = targetInputField_naam.val();
                var userWachtwoord = targetInputField_wachtwoord.val();
                var userLevel = targetDropdownField_level.val();

                if (userNaam != "" && userNaam != null && userId != 0 && userId != null) {
                    $("#form_user_update input#user_id_update").val(userId);
                    $("#form_user_update input#user_naam_update").val(userNaam);
                    $("#form_user_update input#user_password_update").val(userWachtwoord);
                    $("#form_user_update input#user_level_update").val(userLevel);

                    $("#form_user_update").submit();
                }
            }
        });
    }

    function ajaxTable_verwijderListener_showModal() {
        $(".agricon-delete-icon").click(function () {
            // hidden form opvullen
            var userId = $(this).data('id');
            var userNaam = $(this).data('usernaam');
            if (userId != 0 && userId != null) {
                $("#form_user_delete input#user_id_delete").val(userId);
                $("#form_user_delete input#user_naam_delete").val(userNaam);
            }
            $('#deleteModal').modal('show');
        });
    }

    function ajaxTable_verwijderModalListener() {
        $('#deleteAllData').click(function (e) {
            $('#deleteModal').modal('hide');
            $("#form_user_delete").submit();
        });
    }

    $(document).ready(function () {
        get_byZoekFunctie($("#zoeknaam").val());
        formListener_zoekOpNaam();
        checkIfUserAlreadyExistsListener();
        checkIfPasswordsMatchListener();

        // enkel submitten indien het mag (de usernaam nog niet bestaat en de paswoorden gelijk zijn)
        var readyToSubmit = false;
        $('#form_user_beheren').on('submit', function (e) {
            // gewoon submitten indien deze functie al is uitgevoerd (en dus al gevalideerd is)
            if (userIsNewAndPasswordsMatch) {
                userIsNewAndPasswordsMatch = false; // reset
                return; // doorgaan met submit (formulier is reeds gevalideerd door voorgaande loop in deze functie)
            }
            e.preventDefault();
        });
    });

    $(document).ajaxComplete(function () {
        ajaxTable_bewerkListener();
        ajaxTable_verwijderListener_showModal();
        ajaxTable_verwijderModalListener();
    });
</script>
