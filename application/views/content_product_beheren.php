<main role="main" class="container" id="content_product_beheren">
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

    <div id="agricon_product_accordion_met_overzicht_container" class="row">
        <div id="accordion" class="col-8">
            <div class="card agricon-card-firstaccordioncard">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link " data-toggle="collapse"
                                data-target="#collapseOne"
                                aria-expanded="true" aria-controls="collapseOne">
                            NIEUW
                        </button>
                    </h5>
                </div>
                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <?php
                        $dataOpen = array(
                            'id' => 'form_product_beheren',
                            'name' => 'form_product_beheren',
                            'data-toggle' => 'validator',
                            'role' => 'form');

                        $dataSubmit = array(
                            'id' => 'submit_product_beheren',
                            'name' => 'submit_product_beheren',
                            'type' => 'submit',
                            'value' => 'Opslaan',
                            'class' => 'btn btn-outline-success agricon-formsubmit-button');
                        ?>
                        <?php echo form_open('product/insert', $dataOpen); ?>

                        <section>
                            <!--ALGEMEEN-->
                            <div class="form-row agricon-formcolumn">
                                <div class="col-3">
                                    <label for="product_artikelcode"
                                           class="form-text text-muted">Artikelcode *</label>
                                    <?php echo form_input('product_artikelcode', $formData->product_artikelcode, 'autofocus id="product_artikelcode" type="text" class="form-control" required="required" aria-label="product artikelcode"'); ?>
                                </div>
                                <div class="col-9">
                                    <label for="product_beschrijving"
                                           class="form-text text-muted">Beschrijving *</label>
                                    <?php echo form_input('product_beschrijving', $formData->product_beschrijving, 'id="product_beschrijving" type="text" class="form-control" required="required" aria-label="product beschrijving"'); ?>
                                </div>
                            </div>

                            <div class="form-row agricon-formcolumn">
                                <div class="col-3">
                                    <label for="product_stuksperpallet"
                                           class="form-text text-muted">Stuks/pallet *</label>
                                    <?php echo form_input('product_stuksperpallet', $formData->product_stuksperpallet, 'id="product_stuksperpallet" type="number" pattern="' . customNumberPattern() . '" title="' . customNumberPatternMessage() . '" class="form-control" required="required" aria-label="product stuks per pallet"'); ?>
                                </div>
                                <div class="col-3" style="padding-left: 0">
                                    <label for="product_inhoudperzak"
                                           class="form-text text-muted">Inhoud/zak *</label>
                                    <?php echo form_input('product_inhoudperzak', $formData->product_inhoudperzak, 'id="product_inhoudperzak" type="number"
                             step="0.01" pattern="' . customDecimalNumberPattern() . '" title="' . customDecimalNumberPatternMessage() . '" class="form-control" required="required" '); ?>
                                </div>
                                <div class="col-3">
                                    <label for="product_folieid"
                                           class="form-text text-muted">Folie *</label>
                                    <?php echo form_dropdown('product_folieid', $folies_dropdownOptions, $formData->product_folieid, 'id="product_folieid" class="form-control" required="required" '); ?>
                                </div>
                                <div class="col-3">
                                    <label for="product_verpakkingskostid"
                                           class="form-text text-muted">Verpakkingskost *</label>
                                    <?php echo form_dropdown('product_verpakkingskostid', $config_verpakkingskost_dropdownOptions, '', 'id="product_verpakkingskostid" class="form-control" required="required" '); ?>
                                </div>
                            </div>

                            <!--GRONDSTOFFEN-->
                            <div class="form-row agricon-content-divider" style="margin-top: 50px">
                                <h6>Grondstoffen</h6>
                            </div>

                            <div class="form-row agricon-formcolumn">
                                <div class="col-4">
                                    <label for="product_grondstofcategorieid"
                                           class="form-text text-muted">Grondstof Categorie *</label>
                                    <?php echo form_dropdown('product_grondstofcategorieid', $grondstof_categorieen_dropdownOptions, '', 'id="product_grondstofcategorieid" class="form-control" '); ?>
                                </div>

                                <div class="col-4">
                                    <label for="product_grondstofid"
                                           class="form-text text-muted">Grondstof *</label>
                                    <?php echo form_dropdown('product_grondstofid', array(), '', 'id="product_grondstofid" class="form-control" '); ?>
                                </div>

                                <div class="col-2">
                                    <label for="product_waarde"
                                           class="form-text text-muted">Waarde *</label>
                                    <?php echo form_input('product_waarde', '', 'id="product_waarde" type="number"  pattern="' . customDecimalNumberPattern() . '" title="' . customDecimalNumberPatternMessage() . '"  
                                            class="form-control" aria-label="grondstof waarde"'); ?>
                                </div>

                                <?php $keuze = ['1' => 'kg', '2' => '%']; ?>
                                <div class="col-1">
                                    <label for="product_waardesoort"
                                           class="form-text text-muted" style="height:19px"></label>
                                    <?php echo form_dropdown('product_waardesoort', $keuze, '2', 'id="product_waardesoort" class="form-control" '); ?>
                                </div>

                                <div class="col-1">
                                    <div id="fractiesToevoegenButton"
                                         onclick="grondstoffen_grondstoffenToevoegenListener()">
                                        <div style="font-size: 26px;line-height: 1"><i class="fas fa-plus-circle"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--KOSTEN-->
                            <div class="form-row agricon-content-divider" style="margin-top: 50px">
                                <h6>Kosten</h6>
                            </div>

                            <div class="form-row">
                                <label for="product_kost_omzetid"
                                       class="form-text text-muted">Geschatte omzet *</label>
                                <?php echo form_dropdown('product_kost_omzetid', $kost_omzet_dropdownOptions, '', 'id="product_kost_omzetid" class="form-control" required="required" name="geschatte jaar omzet" '); ?>
                            </div>


                            <div class="form-row agricon-formcolumn">
                                <div class="col-6">
                                    <label for="product_kost_elektriciteitid"
                                           class="form-text text-muted">Elektriciteit *</label>
                                    <?php echo form_dropdown('product_kost_elektriciteitid', $kost_elektriciteit_dropdownOptions, '', 'id="product_kost_elektriciteitid" class="form-control" required="required" name="elektriciteit" '); ?>
                                </div>
                                <div class="col-6">
                                    <label for="product_kost_personeelid"
                                           class="form-text text-muted">Personeel *</label>
                                    <?php echo form_dropdown('product_kost_personeelid', $kost_personeel_dropdownOptions, '', 'id="product_kost_personeelid" class="form-control" required="required" name="personeel" '); ?>
                                </div>

                            </div>
                            <div class="form-row agricon-formcolumn">
                                <div class="col-6">
                                    <label for="product_kost_gebouwenid"
                                           class="form-text text-muted">Gebouwen *</label>
                                    <?php echo form_multiselect('product_kost_gebouwenid[]', $kost_gebouwen_dropdownOptions, '', 'id="product_kost_gebouwenid" class="form-control" required="required" multiple="multiple" '); ?>
                                </div>
                                <div class="col-6">
                                    <label for="product_kost_machinesid"
                                           class="form-text text-muted">Machines *</label>
                                    <?php echo form_multiselect('product_kost_machinesid[]', $kost_machines_dropdownOptions, '', 'id="product_kost_machinesid" class="form-control" required="required"  '); ?>
                                </div>
                            </div>

                            <!-- Alle grondstoffen zijn ids,waardes en waardesoorten meegeven -->
                            <div hidden>
                                <?php
                                echo form_input('product_samenstelling_grondstoffen', '', 'id="product_samenstelling_grondstoffen"  name="product_samenstelling_grondstoffen[]"');
                                echo form_input('product_samenstelling_waardes', '', 'id="product_samenstelling_waardes"  name="product_samenstelling_waardes[]"');
                                echo form_input('product_samenstelling_waardesoorten', '', 'id="product_samenstelling_waardesoorten"  name="product_samenstelling_waardesoorten[]"');
                                ?>
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
        </div>

        <!-- OVERZICHT-->
        <div id="grondstof_overzicht_container" class="col-4">
            <div id="grondstof_overzicht_content">

                <div id="grondstof_overzicht_titel"><p style="padding-top: 20px">OVERZICHT<span
                                style="float:right;padding-right: 10px;cursor:pointer" data-view="1"
                                class="switchViewIcon"><i class="fas fa-calculator"></i></span></p></div>
                <div id="grondstof_overzicht_target">
                    <p class="overzicht-subtitle">Algemeen

                    </p>
                    <span style="display: inline-block;width: 105px">Artikelcode:</span>
                    <span id="overzicht_artikelcode" style="padding-left: 10px"></span><br>
                    <span style="display: inline-block;width: 105px">Beschrijving:</span>
                    <span id="overzicht_beschrijving" style="padding-left: 10px"></span><br>
                    <span style="display: inline-block;width: 105px">Stuks per pallet:</span>
                    <span id="overzicht_stuksperpallet" style="padding-left: 10px"></span><br>
                    <span style="display: inline-block;width: 105px">Inhoud per zak:</span>
                    <span id="overzicht_inhoudperzak" style="padding-left: 10px"></span><br>
                    <span style="display: inline-block;width: 105px">Folie:</span>
                    <span id="overzicht_folieid" style="padding-left: 10px"></span><br>
                    <span style="display: inline-block;width: 105px">Folieprijs:</span>
                    <span id="overzicht_folieprijsperstuk" style="padding-left: 10px"></span><br>

                    <!--GRONDSTOFFEN-->
                    <p class="overzicht-subtitle">Grondstoffen
                        <span id="overzicht_grondstoftotaalpercentage"
                              class="set-color-red">0%</span>
                        <span id="overzicht_totaal_grondstof" style="float:right">€ 0</span>
                    </p>
                    <span id="grondstof_overzicht_target_grondstoffen"></span>

                    <!--VERPAKKINGSKOST-->
                    <p class="overzicht-subtitle">Verpakking en Productiekost
                        <span id="overzicht_totaal_verpakkingskost" style="float:right">€ 0</span>
                    </p>
                    <span id="grondstof_overzicht_target_verpakkingskost"></span>

                    <!--KOSTEN-->
                    <p class="overzicht-subtitle">Kosten
                        <span id="overzicht_totaal_kosten" style="float:right">€ 0</span>
                    </p>
                    <span id="grondstof_overzicht_target_kosten_omzet"></span><br>
                    <span id="grondstof_overzicht_target_kosten_elektriciteit"></span><br>
                    <span id="grondstof_overzicht_target_kosten_personeel"></span><br>
                    <span id="grondstof_overzicht_target_kosten_gebouwen"></span><br>
                    <span id="grondstof_overzicht_target_kosten_machines"></span><br>

                    <!--TOTAAL-->
                    <p class="overzicht-subtitle" style="margin-bottom: 15px">TOTAAL:
                        <span id="overzicht_totaalprijs" style="float:right;font-weight:600">€ 0</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- OVERZICHTBEREKENING-->
        <div style="display: none" id="grondstof_overzichtberekening_container" class="col-4">
            <div id="grondstof_overzichtberekening_content">

                <div id="grondstof_overzichtberekening_titel"><p style="padding-top: 20px">OVERZICHT BEREKENING<span
                                style="float:right;padding-right: 10px;cursor:pointer" data-view="2"
                                class="switchViewIcon"><i class="fas fa-calculator"></i></span></p></div>
                <div id="grondstof_overzichtberekening_target">

                    <!--GRONDSTOFFEN-->
                    <p class="overzichtberekening-subtitle">Grondstoffen
                        <span id="overzichtberekening_totaal_grondstof" style="float:right">€ 0</span>
                    </p>
                    <span id="grondstof_overzichtberekening_target_grondstoffen"></span>

                    <!--VERPAKKINGSKOST-->
                    <p class="overzichtberekening-subtitle">Verpakking en Productiekost
                        <span id="overzichtberekening_totaal_verpakkingskost" style="float:right">€ 0</span>
                    </p>
                    <span id="grondstof_overzichtberekening_target_verpakkingskost"></span>

                    <!--KOSTEN-->
                    <p class="overzichtberekening-subtitle">Kosten
                        <span id="overzichtberekening_totaal_kosten" style="float:right">€ 0</span>
                    </p>
                    <span id="grondstof_overzichtberekening_target_kosten_omzet"></span><br>

                    <span id="grondstof_overzichtberekening_target_kosten_elektriciteit"></span><br>
                    <span id="grondstof_overzichtberekening_target_kosten_personeel"></span><br>
                    <span id="grondstof_overzichtberekening_target_kosten_gebouwen"></span><br>
                    <span id="grondstof_overzichtberekening_target_kosten_machines"></span><br>
                    <span id="grondstof_overzichtberekening_target_kosten_berekening"></span><br>

                    <!--TOTAAL-->
                    <p class="overzichtberekening-subtitle" style="margin-bottom: 0px">TOTAAL:
                        <span id="overzichtberekening_totaalprijs" style="float:right;font-weight:600">€ 0</span>
                    </p>
                    <span id="overzichtberekening_target_totaal"></span>
                    <br>
                </div>
            </div>
        </div>

        <!-- HIDDEN DIV MET ALLE WAARDES OM TE REKENEN-->
        <div hidden id="berekeningresultaten">
            <input id="berekeningresultaten_folie" type="number" value="0">
            <input id="berekeningresultaten_opgehaalde_verpakkingskost" type="number" value="0">
            <input id="berekeningresultaten_grondstoffen" type="number" value="0">
            <input id="berekeningresultaten_verpakkingskost" type="number" value="0">
            <input id="berekeningresultaten_kost_omzet" type="number" value="0">
            <input id="berekeningresultaten_kost_elektriciteit" type="number" value="0">
            <input id="berekeningresultaten_kost_gebouwen" type="number" value="0">
            <input id="berekeningresultaten_kost_machines" type="number" value="0">
            <input id="berekeningresultaten_kost_personeel" type="number" value="0">

            <input id="berekeningresultaten_kosten" type="number" value="0">
            <input id="berekeningresultaten_totaal" type="number" value="0">
            <!-- deze waardes zijn voor mee te geven bij submit-->
            <input id="berekeningresultaten_kosten" type="number" value="0">
        </div>
    </div>

    <div class="row">
        <div class="container">
            <div class="card">
                <div class="card-header" id="headingTwo" style="background-color: lightgray">
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
                            <?php echo form_input(array('name' => 'zoeknaam', 'id' => 'zoeknaam', 'class' => 'form-control', 'placeholder' => '- Zoek -', 'onfocus' => "this.placeholder = ''", 'onblur' => "this.placeholder = '- Zoek -'"), $zoeknaam_product_value); ?>
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
                        'id' => 'form_product_update',
                        'name' => 'form_product_update',
                        'data-toggle' => 'validator',
                        'role' => 'form');

                    $dataSubmit = array(
                        'id' => 'submit_product_update',
                        'name' => 'submit_product_update',
                        'type' => 'submit');

                    echo form_open('product/update', $dataOpen);
                    echo form_input('product_id_update', '', 'id="product_id_update" class="form-control" required="required" aria-label="folie ruw id"');
                    echo form_input('product_naam_update', '', 'id="product_naam_update" type="text" class="form-control" required="required" ');

                    echo form_input('product_artikelcode_update', '', 'id="product_artikelcode_update" type="text" class="form-control" required="required" ');
                    echo form_input('product_beschrijving_update', '', 'id="product_beschrijving_update" type="text" step="0.01" class="form-control" ');
                    echo form_input('product_stuksperpallet_update', '', 'id="product_stuksperpallet_update" type="number" class="form-control" ');
                    echo form_input('product_inhoudperzak_update', '', 'id="product_inhoudperzak_update" type="number" step="0.01" class="form-control" ');
                    echo form_input('product_folieid_update', '', 'id="product_folieid_update" type="number" class="form-control" ');
                    echo form_input('product_verpakkingskostid_update', '', 'id="product_verpakkingskostid_update" type="number" class="form-control" ');

                    echo form_submit($dataSubmit);
                    echo form_close();
                    ?>
                </div>
                <div hidden>
                    <?php
                    $dataOpen = array(
                        'id' => 'form_product_delete',
                        'name' => 'form_product_delete',
                        'data-toggle' => 'validator',
                        'role' => 'form');

                    $dataSubmit = array(
                        'id' => 'submit_product_delete',
                        'name' => 'submit_product_delete',
                        'type' => 'submit');

                    echo form_open('product/delete', $dataOpen);
                    echo form_input('product_id_delete', '', 'id="product_id_delete" type="number" class="form-control" required="required" ');
                    echo form_input('product_naam_delete', '', 'id="product_naam_delete" type="text" class="form-control" required="required" ');
                    echo form_submit($dataSubmit);
                    echo form_close();
                    ?>
                </div>
            </section>
        </div>

    </div>

    <?php createBasicDeleteModal('Wil je dit product verwijderen?',
        '',
        '',
        '',
        "Verwijder"); ?>

    <div id="productBerekeningModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Terug</button>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    var grondstofOmToeTeVoegen_isFractieCategorie = true;
    var readyToSubmit_percentageIs100 = false;

    function switchViewListener() {
        $('.switchViewIcon').click(function () {
            var view = $(this).data('view');
            var view1 = $('div#grondstof_overzicht_container');
            var view2 = $('div#grondstof_overzichtberekening_container');

            if (view == 1) {
                view1.hide();
                view2.show();

            } else {
                view2.hide();
                view1.show();
            }
        });
    }
    // tijdens de accordion-collapse van "NIEUW" ... ook het overzicht verbergen
    $('#collapseOne').on('hidden.bs.collapse', function (e) {
        $('div#grondstof_overzicht_container').hide();
    });
    $('#collapseOne').on('shown.bs.collapse', function (e) {
        $('div#grondstof_overzicht_container').show();
    });

    // TODO - NOG DOEN
    // AJAX ----------------------------------------------------------------------------------------------------------
    function ajax_saveToSession(naam, artikelcode, beschrijving, stuksperpallet, inhoudperzak, folieid) {
        jQuery.ajax({
            type: "POST",
            url: site_url + "/product/ajax_save_to_session",
            data: {
                naam: naam,
                artikelcode: artikelcode,
                beschrijving: beschrijving,
                stuksperpallet: stuksperpallet,
                inhoudperzak: inhoudperzak,
                folieid: folieid
            },
            success: function (result) {
            },
            error: function (xhr, status, error) {
//                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }
    // AJAX ----------------------------------------------------------------------------------------------------------
    function ajax_getCalulationMessage_product(productnaam, productid, productiekostid) {
        jQuery.ajax({
            type: "POST",
            url: site_url + "/product/ajax_getCalulationMessage_product",
            data: {
                productnaam: productnaam,
                productid: productid,
                productiekostid: productiekostid
            },
            success: function (result) {
                $('#productBerekeningModal h5.modal-title').html(productnaam);
                $('#productBerekeningModal div.modal-body').html(result);
                $('#productBerekeningModal').modal('show');
            },
            error: function (xhr, status, error) {
//                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }

    // TODO - NOG DOEN
    function saveToSession() {
        var naam = $("#product_beschrijving").val(); // is beschrijving
        var artikelcode = $("#product_artikelcode").val();
        var beschrijving = $("#product_beschrijving").val();
        var stuksperpallet = parseInt($("#product_stuksperpallet").val());
        var inhoudperzak = parseFloat($("#product_inhoudperzak").val());
        var folieid = parseInt($("#product_folieid").val());

        ajax_saveToSession(naam, artikelcode, beschrijving, stuksperpallet, inhoudperzak, folieid);
    }

    function get_byZoekFunctie(deelvannaam) {
        $.ajax({
            type: "POST",
            url: site_url + "/product/ajax_get_by_zoekfunctie",
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

    function ajax_getGrondstofDropdownOptions_byCategorieId(grondstofCategorieId) {
        $.ajax({
            type: "GET",
            url: site_url + "/product/ajaxGetGrondstofDropdownOptions_byCategorieId",
            data: {
                grondstofCategorieId: grondstofCategorieId
            },
            success: function (result) {
                //dropdown opvullen met options
                $("#product_grondstofid").html(result);
            },
            error: function (xhr, status, error) {
//                alert("-- ERROR IN ajax_getGrondstofDropdownOptions_byCategorieId --\n\n" + xhr.responseText);
            }
        });
    }

    function ajax_getFoliePrijs(folieid) {
        $.ajax({
            type: "GET",
            url: site_url + "/product/ajaxGetFoliePrijs",
            data: {
                folieid: folieid
            },
            success: function (result) {
                var foliePrijs = parseFloat(result);
                // indien de prijs een nummer is én niet 0 is, gegevens in het overzicht tonen
                if (!isNaN(foliePrijs) && foliePrijs != 0) {
                    $("#overzicht_folieprijsperstuk").html('€ ' + foliePrijs + "/zakje");
                    $('#overzicht_folieprijsperstuk').show();
                } else {
                    $("#overzicht_folieprijsperstuk").html('');
                    $('#overzicht_folieprijsperstuk').hide();
                }

                $('input#berekeningresultaten_folie').val(foliePrijs);
                if (readyToSubmit_percentageIs100) {
                    ajax_getCalculation_verpakkingskost(); // even wachten op waarde "totaal"
                }
            },
            error: function (xhr, status, error) {
//                alert("-- ERROR IN ajax_getFoliePrijs --\n\n" + xhr.responseText);
            }
        });
    }

    function ajax_getCalculation_folie(stuksperpallet, folieid) {
        $.ajax({
            type: "GET",
            url: site_url + "/product/ajaxGetCalculation_folie",
            data: {
                stuksperpallet: stuksperpallet,
                folieid: folieid
            },
            success: function (result) {
                // berekening message tonen
                $("#overzichtberekening_folie").html(result);

                // totaal eruithalen en tonen in de 2 views
                var totaal = parseFloat($("#overzichtberekening_folie").find('.totaal').text());
                if (isNaN(totaal)) {
                    totaal = 0;
                }

                $('#overzicht_totaal_folie').text("€ " + totaal);
                $('#overzichtberekening_totaal_folie').text("€ " + totaal);

                // totaal ook bijhouden (om totaal te berekenen), en TOTAALPRIJS updaten
                $('input#berekeningresultaten_folie').val(totaal);

                updateTotaalPrijsInOverzicht();
            },
            error: function (xhr, status, error) {
//                alert("-- ERROR IN ajax_getCalculation_folie --\n\n" + xhr.responseText);
            }
        });
    }

    function ajax_getCalculation_grondstof_fractie(messageText, grondstofid, waarde) {
        $.ajax({
            type: "POST",
            url: site_url + "/product/ajaxGetCalculation_grondstof_fractie",
            data: {
                waarde: waarde,
                grondstofid: grondstofid,
                counter_grondstof: counter_grondstof
            },
            success: function (result) {
                var grondstof_overzichtberekening_target = $("#grondstof_overzichtberekening_target_grondstoffen");

                var html = '';
                // berekening message tonen
                // indien "counter_grondstof" 1 is, dan moet er eerst de titel aan toegevoegd worden
                if (counter_grondstof == 1) {
                    html += '<div class="text-muted" >% Berekening = FractiePercentage &times AankoopPrijs/Fractie</div>';
                    html += '<div class="text-muted" style="margin-bottom: 10px">kg Berekening = AankoopPrijs &times; Eenheid</div>';
                }
                html += '<div id="grondstofitem' + counter_grondstof + '" class="grondstofitem fractieitem" style="margin-bottom:8px">';

                // message toevoegen
                html += '<p style="font-size:12px;margin-bottom: 0" >' + messageText + '</p>';
                html += result;
                html += '</div>';

                grondstof_overzichtberekening_target.append(html);
                updateGrondstofTotalenInOverzicht();
            },
            error: function (xhr, status, error) {
//                alert("-- ERROR IN ajax_getCalculation_grondstof_fractie --\n\n" + xhr.responseText);
            }
        });
    }

    function ajax_getCalculation_grondstof_nietfractie(messageText, grondstofid, waarde) {
        $.ajax({
            type: "POST",
            url: site_url + "/product/ajaxGetCalculation_grondstof_nietfractie",
            data: {
                waarde: waarde,
                grondstofid: grondstofid,
                counter_grondstof: counter_grondstof
            },
            success: function (result) {
                var grondstof_overzichtberekening_target = $("#grondstof_overzichtberekening_target_grondstoffen");
                // eigen html maken, anders maakt die automatisch ongewenste sluit-tags
                var html = '';
                // berekening message tonen
                // indien "counter_grondstof" 1 is, dan moet er eerst de titel aan toegevoegd worden
                if (counter_grondstof == 1) {
                    html += '<div class="text-muted">Berekening % = FractiePercentage &times AankoopPrijs/Fractie</div>';
                    html += '<div class="text-muted" style="margin-bottom: 10px">Berekening kg = percentage * AankoopPrijs</div>';
                }
                html += '<div id="grondstofitem' + counter_grondstof + '" class="grondstofitem nietfractieitem" style="margin-bottom:8px">';

                // message toevoegen
                html += '<p style="font-size:12px;margin-bottom: 0" >' + messageText + '</p>';
                html += result;
                html += '</div>';

                grondstof_overzichtberekening_target.append(html);
                updateGrondstofTotalenInOverzicht();
            },
            error: function (xhr, status, error) {
//                alert("-- ERROR IN ajax_getCalculation_grondstof_nietfractie --\n\n" + xhr.responseText);
            }
        });
    }

    function ajax_getCalculation_verpakkingskost() {
        var grondstof_overzichtberekening_target = $("#grondstof_overzichtberekening_target_verpakkingskost");
        // eigen html maken, anders maakt die automatisch ongewenste sluit-tags
        var html = '';
        var verpakkingskost = parseFloat($('select#product_verpakkingskostid option:selected').text());
        if (isNaN(verpakkingskost)) {
            verpakkingskost = 0.00;
        }

        var verpakkingskostDubbel = verpakkingskost * 2;
        var grondstoffen = parseFloat($("#berekeningresultaten_grondstoffen").val());
        var grondstoffenTotaal = (2 * verpakkingskost) + grondstoffen;
        var inhoud = $("#product_inhoudperzak").val();
        if (isNaN(inhoud)) {
            inhoud = 0;
        }
        var productiekost = (inhoud * grondstoffenTotaal) / 1000;
        var foliePrijsPerStuk = parseFloat($('input#berekeningresultaten_folie').val());

        var productiekostTotaal = productiekost + foliePrijsPerStuk;

        html += '<div class="text-muted">Verpakkingskost = €' + verpakkingskost + '</div>';
        html += '<div class="text-muted">GrondstoffenTotaal = Grondstoffen + (Verpakkingskost &times; 2)</div>';
        html += '<div class="">' + grondstoffen + ' + ' + verpakkingskostDubbel.toFixed(2) + ' = <span style="font-weight: 600">€ ' + grondstoffenTotaal.toFixed(2) + '</span></div>';
        html += '<br/>';

        html += '<div class="text-muted">Inhoud/zak = ' + inhoud + '</div>';
        html += '<div class="text-muted">Productiekost = (Inhoud &times; GrondstoffenTotaal) / 1000 </div>';
        html += '<div class="">(' + inhoud + ' &times; ' + grondstoffenTotaal.toFixed(2) + ') &divide; 1000 = <span style="font-weight: 600">€ ' + productiekost.toFixed(2) + '</span></div>';

        html += '<br/>';
        html += '<div class="text-muted">Folie prijs/zak = €' + foliePrijsPerStuk + '</div>';
        html += '<div class="text-muted">Berekening = Productiekost + Folie</div>';
        html += '<div class="">' + productiekost.toFixed(2) + ' + ' + foliePrijsPerStuk.toFixed(2) + ' = <span style="font-weight: 600">€ ' + productiekostTotaal.toFixed(2) + '</span></div>';

        grondstof_overzichtberekening_target.text("");
        grondstof_overzichtberekening_target.append(html);

        $('#overzichtberekening_totaal_verpakkingskost').text('€ ' + productiekostTotaal.toFixed(2));
        $('#overzicht_totaal_verpakkingskost').text('€ ' + productiekostTotaal.toFixed(2));

        // gegevens bijhouden in overzichtform
        $('input#berekeningresultaten_verpakkingskost').val(productiekostTotaal);
        updateKostenTotalenInOverzicht(); // even wachten op waarde "totaal"

    }
    // END AJAX ------------------------------------------------------------------------------------------------------

    // ALGEMEEN
    function algemeen_onKeyKup_toonInOverzicht() {
        $('#product_artikelcode').keyup(function () {
            $('#overzicht_artikelcode').html($(this).val());
        });
        $('#product_beschrijving').keyup(function () {
            $('#overzicht_beschrijving').html($(this).val());
        });
        $('#product_stuksperpallet').keyup(function () {
            $('#overzicht_stuksperpallet').html($(this).val());
        });
        $('#product_inhoudperzak').keyup(function () {
            $('#overzicht_inhoudperzak').html($(this).val());
        });
        // folieDropdown.change() staat in "algemeenBerekening_folieListener"
    }

    function algemeen_berekening_folieListener() {
        // bij dropdown.change - de folie prijs ophalen
        var controlDropdown_folie = $('select#product_folieid');
        controlDropdown_folie.change(function () {

            var folieid = parseInt(controlDropdown_folie.val());
            if (!isNaN(folieid)) {
                var selectedOptionText = $(this).children("option").filter(":selected").text();
                if (selectedOptionText == "Selecteer...") {
                    selectedOptionText = '';
                }

                // haal enkel de naam eruit
                var arr = selectedOptionText.split('-');
                $('#overzicht_folieid').html(arr[0]); // eerste element is de naam

                ajax_getFoliePrijs(folieid);
            }
        });
    }

    //    function algemeenBerekening_folieListener2() {
    //        // bij stuksperpallet.keyup of dropdown.change - de berekening ophalen en tonen
    //        var controlInput_stuksperpallet = $('input#product_stuksperpallet');
    //        var controlDropdown_folie = $('select#product_folieid');
    //
    //        controlInput_stuksperpallet.keyup(function (event) {
    //            // enkel numerieke karakters in het veld tonen
    //            if (event.which != 8 && isNaN(String.fromCharCode(event.which))) {
    //                event.preventDefault(); //stop character from entering input
    //                return;
    ////                console.log('keypress shift');
    //            }
    ////            console.log('keypress normal');
    //
    //            var stuksperpallet = parseInt(controlInput_stuksperpallet.val());
    //            var folieid = parseInt(controlDropdown_folie.val());
    ////            console.log(stuksperpallet);
    ////            console.log(folieid);
    //
    //
    //            // controleer of "stuksperpallet" EN de "folieid" ingevuld is
    //            if (!isNaN(stuksperpallet) && !isNaN(folieid)) {
    ////                console.log('ajax_getCalculation_folie');
    //                ajax_getCalculation_folie(stuksperpallet, folieid);
    //            }
    //        });
    //
    //        controlDropdown_folie.change(function () {
    ////            console.log('change');
    //            var stuksperpallet = parseInt(controlInput_stuksperpallet.val());
    //            var folieid = parseInt(controlDropdown_folie.val());
    ////            console.log(stuksperpallet);
    ////            console.log(folieid);
    //
    //            // controleer of "stuksperpallet" en de "folieid" ingevuld is
    //            if (!isNaN(stuksperpallet) && !isNaN(folieid)) {
    ////                console.log('ajax_getCalculation_folie');
    //
    //                ajax_getCalculation_folie(stuksperpallet, folieid);
    //            }
    //        });
    //    }

    function algemeen_inhoudListener() {
        $('input#product_inhoudperzak').keyup(function (e) {
            if (e.keyCode != 16) {
                ajax_getCalculation_verpakkingskost(); // even wachten op waarde "totaal"
            }
        });
    }

    function algemeen_verpakkingskostListener() {
        $('select#product_verpakkingskostid').change(function (e) {
            var geselecteerdeWaarde = parseFloat($(this).find('option:selected').text());
            $('input#berekeningresultaten_opgehaalde_verpakkingskost').val(geselecteerdeWaarde);
            ajax_getCalculation_verpakkingskost(); // even wachten op waarde "totaal"
        });
    }

    // GRONDSTOFFEN
    function grondstoffen_controleerPercentage(berekening, grondstofpercentage) {
        // percentage updaten
        var totaalPercentageTarget = $('span#overzicht_grondstoftotaalpercentage');
        var totaalPercentage = parseInt(totaalPercentageTarget.text());
        var nieuwTotaalPercentage = 0;
        if (berekening == 'plus') {
            nieuwTotaalPercentage = totaalPercentage + grondstofpercentage;
        } else if (berekening == 'min') {
            nieuwTotaalPercentage = totaalPercentage - grondstofpercentage;
        }
        //readyToSubmit_percentageIs100;
        if (nieuwTotaalPercentage === 100) {
            totaalPercentageTarget.removeClass('set-color-red');
            totaalPercentageTarget.addClass('set-color-green');
            readyToSubmit_percentageIs100 = true;
        } else {
            totaalPercentageTarget.removeClass('set-color-green');
            totaalPercentageTarget.addClass('set-color-red');
            readyToSubmit_percentageIs100 = false;
        }
        totaalPercentageTarget.text(nieuwTotaalPercentage + "%");
    }

    function grondstoffen_dropdownListener() {
        //dropdownoptions voor grondstoffen ophalen
        $("#product_grondstofcategorieid").change(function () {
            ajax_getGrondstofDropdownOptions_byCategorieId($(this).val());
        });
    }

    function grondstofWaardeSoort_dropdownChangeListener() {
        // bijhouden of het voor fracties is. Indien dit zo is, dan moet er rekening gehouden worden met percentages (controles), anders niet
        $("select#product_waardesoort").change(function () {
            var selectedOption = $(this).find(':selected');
            // array = 1 => kg, 2 => %
            if (selectedOption.val() === "1") {
                grondstofOmToeTeVoegen_isFractieCategorie = false;
            } else {
                grondstofOmToeTeVoegen_isFractieCategorie = true
            }
        });
    }

    var array_samenstelling_grondstofcounters = []; // nodig om indien je iets verwijderd, dat je weet welke index je in de andere arrays moet verwijderen
    var array_samenstelling_grondstofids = [];
    var array_samenstelling_waardes = [];
    var array_samenstelling_waardesoorten = [];
    var counter_grondstof = 0;
    function grondstoffen_grondstoffenToevoegenListener() {
        var grondstofwaarde = parseFloat($('input#product_waarde').val());
        var grondstofid = parseInt($('#product_grondstofid').val());
        var grondstofcategorieid = parseInt($('#product_grondstofcategorieid').val());

        // enkel goedkeuren indien alles goed is ingevuld
        if ((isNaN(grondstofwaarde)) || isNaN(grondstofid) || isNaN(grondstofcategorieid)) {
            return;
        }
        var grondstofcategorieid_text = $('#product_grondstofcategorieid option:selected').text();
        var grondstofid_text = $('#product_grondstofid option:selected').text();

        var waarde = grondstofwaarde;
        var waardeText = "%";// bv "%" of "kg"
        if (grondstofOmToeTeVoegen_isFractieCategorie == false) {
            waardeText = "kg";
        }

        // een itemNumber bijhouden. Deze is om indien je in het overzicht iets wil verwijderen, dat ook in de berekening hetzelfde verwijderd wordt
        counter_grondstof++;

        var messageText = grondstofid_text + ' (' + grondstofcategorieid_text + ')' + ' ' + waarde + waardeText;
        $('#grondstof_overzicht_target_grondstoffen').append(
            '<p style="font-size:12px;margin-bottom: 0" class="grondstofitem">' + messageText +
            '<span class="delete-grondstof delete-grondstof-icon" ' +
            'data-grondstofid="' + grondstofid + '" ' +
            'data-grondstofcategorieid="' + grondstofcategorieid + '" ' +
            'data-isfractie="' + grondstofOmToeTeVoegen_isFractieCategorie + '" ' +
            'data-fractiepercentage="' + grondstofwaarde + '" ' +
            'data-itemnummer="' + counter_grondstof + '" >' +
            '&times</span>' +
            '</p>'
        );

        // ids bijhouden in array voor tijdens de submit (counter_grondstof ook gebruiken indien je iets wil deleten aan de client-side, in backend zijn deze niet nodig)
        array_samenstelling_grondstofcounters.push(counter_grondstof);
        array_samenstelling_grondstofids.push(grondstofid);
        array_samenstelling_waardes.push(waarde);
        array_samenstelling_waardesoorten.push(waardeText);

        var samenstelling_grondstofids_controlInput = $('#form_product_beheren input#product_samenstelling_grondstoffen');
        var samenstelling_waardes_controlInput = $('#form_product_beheren input#product_samenstelling_waardes');
        var samenstelling_waardesoorten_controlInput = $('#form_product_beheren input#product_samenstelling_waardesoorten');

        samenstelling_grondstofids_controlInput.val(JSON.stringify(array_samenstelling_grondstofids));
        samenstelling_waardes_controlInput.val(JSON.stringify(array_samenstelling_waardes));
        samenstelling_waardesoorten_controlInput.val(JSON.stringify(array_samenstelling_waardesoorten));

        // ook de berekening ophalen en tonen
        if (grondstofOmToeTeVoegen_isFractieCategorie === true) {
            ajax_getCalculation_grondstof_fractie(messageText, grondstofid, waarde, counter_grondstof);
        } else {
            ajax_getCalculation_grondstof_nietfractie(messageText, grondstofid, waarde, counter_grondstof)
        }

        // enkel "fracties" controleren
        if (grondstofOmToeTeVoegen_isFractieCategorie == 1) {
            grondstoffen_controleerPercentage('plus', grondstofwaarde);
        }
        if (readyToSubmit_percentageIs100) {
            setTimeout(ajax_getCalculation_verpakkingskost, 500); // even wachten op waarde "totaal"
        } else {
            empty_foliekost();
        }
    }

    function grondstoffen_grondstofVerwijderenListener() {
        $("#grondstof_overzicht_target_grondstoffen").on('click', ".delete-grondstof", function () {
            //"percentage" en "isfractie" uit de span halen
            var teVerwijderenPercentage = $(this).data('fractiepercentage');
            var grondstofOmToeVerwijderen_isFractieCategorie = $(this).data('isfractie');
            var itemnummer = $(this).data('itemnummer');

            // verwijderen uit arrays
            var index = $.inArray(itemnummer, array_samenstelling_grondstofcounters);// zoek index van dit item
            array_samenstelling_grondstofcounters.splice(index, 1);
            array_samenstelling_grondstofids.splice(index, 1);
            array_samenstelling_waardes.splice(index, 1);
            array_samenstelling_waardesoorten.splice(index, 1);

            //enkel fracties controleren
            if (grondstofOmToeVerwijderen_isFractieCategorie === true) {
                grondstoffen_controleerPercentage('min', teVerwijderenPercentage);
            }

            $(this).parent().remove();
            // ook verwijderen in  overzichtberekening
            var itemnummer = $(this).data('itemnummer');
            var foundElement = $('span#grondstof_overzichtberekening_target_grondstoffen').find('div#grondstofitem' + itemnummer);
            foundElement.remove();

            if (readyToSubmit_percentageIs100 == true) {
                setTimeout(ajax_getCalculation_verpakkingskost, 750); // even wachten op waarde "totaal"

            } else {
                empty_foliekost();
            }
            updateGrondstofTotalenInOverzicht();
        });
    }

    function empty_foliekost() {
        $("#grondstof_overzichtberekening_target_verpakkingskost").html('');

        $('#overzichtberekening_totaal_verpakkingskost').text('€ 0');
        $('#overzicht_totaal_verpakkingskost').text('€ 0');

        // gegevens bijhouden in overzichtform
        $('input#berekeningresultaten_verpakkingskost').val(0);

        updateGrondstofTotalenInOverzicht();
    }

    // TOTAALPRIJS (in overzicht)
    function updateTotaalPrijsInOverzicht() {
        // laatst opgeroepen functie -> het eindtotaal updaten
        var grondstoffen = parseFloat($('#berekeningresultaten_grondstoffen').val());
        var verpakkingskost = parseFloat($('#berekeningresultaten_verpakkingskost').val());
        var kosten = parseFloat($('#berekeningresultaten_kosten').val());
        var totaal = grondstoffen + verpakkingskost + kosten;
        var opgehaaldeVerpakkingskost = parseFloat($('input#berekeningresultaten_opgehaalde_verpakkingskost').val());
        totaal += opgehaaldeVerpakkingskost;

        $('input#berekeningresultaten_totaal').val(totaal);
        $('#overzicht_totaalprijs').text("€ " + totaal.toFixed(2));
        $('#overzichtberekening_totaalprijs').text("€ " + totaal.toFixed(2));

        $('span#overzichtberekening_target_totaal').text('');
        $('span#overzichtberekening_target_totaal').append(
            '<span class="text-muted">Berekening = som + verpakkingskost</span><br>' +
            '<span class="text-muted">' + (totaal - opgehaaldeVerpakkingskost).toFixed(2) + ' + ' + opgehaaldeVerpakkingskost.toFixed(2) + ' = ' + totaal.toFixed(2) + '</span><br>'
        );
    }

    function updateGrondstofTotalenInOverzicht() {
        var grondstof_overzichtberekening_target = $("#grondstof_overzichtberekening_target_grondstoffen");
        var totaal = 0;
        var items2 = grondstof_overzichtberekening_target.find('span.grondstofitem_span');

        // totaal berekenen
        items2.each(function (i) {
            totaal += parseFloat($(this).find('span.totaal').text());
        });

        // totaal tonen in de 2 views
        $('#overzicht_totaal_grondstof').text("€ " + totaal.toFixed(2));
        $('#overzichtberekening_totaal_grondstof').text("€ " + totaal.toFixed(2));

        // totaal ook bijhouden (om totaal te berekenen), en TOTAALPRIJS updaten
        $("input#berekeningresultaten_grondstoffen").val(totaal);
        updateTotaalPrijsInOverzicht();
    }

    function updateKostenTotalenInOverzicht() {
        var kost_omzet = parseFloat($('input#berekeningresultaten_kost_omzet').val());
        if (kost_omzet === 0) {
            kost_omzet = 1;
        }
        var kost_elektriciteit = parseFloat($('input#berekeningresultaten_kost_elektriciteit').val());
        var kost_gebouwen = parseFloat($('input#berekeningresultaten_kost_gebouwen').val());
        var kost_machines = parseFloat($('input#berekeningresultaten_kost_machines').val());
        var kost_personeel = parseFloat($('input#berekeningresultaten_kost_personeel').val());

        var subtotaal = kost_elektriciteit + kost_gebouwen + kost_machines + kost_personeel;
        var totaal = subtotaal / kost_omzet;
        var html = "<br>";
        html += '<span class="text-muted">Berekening = Totaal kosten/jaar &divide; Geschatte zakjes/jaar</span><br>';
        html += '<span>' + subtotaal + " &divide; " + kost_omzet + ' = <span style="font-weight: 600"> € ' + totaal.toFixed(2) + '</span>';

        $('#grondstof_overzichtberekening_target_kosten_berekening').text("");
        $('#grondstof_overzichtberekening_target_kosten_berekening').append(html);

        $('input#berekeningresultaten_kosten').val(totaal);

        // totaal tonen in de 2 views
        $('#overzicht_totaal_kosten').text("€ " + totaal.toFixed(2));
        $('#overzichtberekening_totaal_kosten').text("€ " + totaal.toFixed(2));
        updateTotaalPrijsInOverzicht();
    }

    // KOSTEN
    function kost_omzet_dropdownOnChangeListener() {
        $('select#product_kost_omzetid').change(function (e) {
            var text = $(this).text();
            var waarde = 0;
            var arr = text.split('-');
            var getalMetJaar = arr[1]; //  element geeft "89996/jaar ..."
            var arr2 = getalMetJaar.split('/');
            var getal = arr2[0]; // neem eerste element geeft "89996"
            var waardeOmTesten = parseFloat(getal);
            if (!isNaN(waardeOmTesten)) {
                waarde = waardeOmTesten;
            }
            $('span#grondstof_overzicht_target_kosten_omzet').text('Geschatte zakjes/jaar = ' + waarde.toFixed(0));
            $('span#grondstof_overzichtberekening_target_kosten_omzet').text('Geschatte zakjes/jaar = ' + waarde.toFixed(0));

            $('input#berekeningresultaten_kost_omzet').val(waarde);

            updateKostenTotalenInOverzicht();
            $('select#product_kost_personeelid').trigger('change'); // trigger indien de gebuiker eerst personeel heeft gekozen en nadien deze dropdown veranderd
        });
    }

    function kost_elektriciteit_dropdownOnChangeListener() {
        $('select#product_kost_elektriciteitid').change(function (e) {
            var waarde = 0;
            if ($(this).val() == '') {
                waarde = 0;
            } else {
                var text = $(this).parent().find('option:selected').text();

                var arr = text.split('€');
                var getalMetJaar = arr[arr.length - 1]; // neem laatste element geeft "89996/jaar"
                var arr2 = getalMetJaar.split('/');
                var getal = arr2[0]; // neem eerste element geeft "89996"
                waarde = parseFloat(getal);
            }

            $('span#grondstof_overzicht_target_kosten_elektriciteit').text('Elektriciteit = € ' + waarde.toFixed(2) + '/jaar');
            $('span#grondstof_overzichtberekening_target_kosten_elektriciteit').text('Elektriciteit = € ' + waarde.toFixed(2) + '/jaar');

            $('input#berekeningresultaten_kost_elektriciteit').val(waarde);
            updateKostenTotalenInOverzicht();
        });
    }

    function kost_gebouwen_dropdownOnChangeListener() {
        $('select#product_kost_gebouwenid').change(function (e) {
            var geselecteerdeWaardes = $(this).val();
            var totaalWaarde = 0;
            // 2 arrays maken op te gebruiken op het einde van deze functie
            var namenArray = [];
            var getallenArray = [];

            if (geselecteerdeWaardes == '-1') {
                // alle options ophalen, behalve de eerste (dat -1) is
                var alleOptionControlsVanFrom = $(this).parent().find('option');
                alleOptionControlsVanFrom.splice(0, 1); // eerste element verwijderen (is "-1" voor alles deze functie dus))

                for (var j = 0; j < alleOptionControlsVanFrom.length; j++) {
                    var _text = alleOptionControlsVanFrom.get(j).innerHTML; // text uit control halen
                    var _arr = _text.split('€');
                    // string"getal" bewerken
                    var _getalMetJaar = _arr[_arr.length - 1]; // neem laatste element geeft "89996/jaar"
                    var _arr2 = _getalMetJaar.split('/');
                    var _getal = _arr2[0]; // neem eerste element geeft "89996"

                    var _waarde = parseFloat(_getal);
                    getallenArray.push(_waarde);
                    totaalWaarde += _waarde;

                    // string"naam" bewerken
                    var _naam = _arr[0].substr(0, _arr[0].length - 2); // op het einde van de string " - " verwijderen
                    namenArray.push(_naam);
                }
            } else {
                // array opvullen met text van alle geselecteerde option
                for (var i = 0; i < geselecteerdeWaardes.length; i++) {
                    var text = $(this).parent().find('option[value="' + geselecteerdeWaardes[i] + '"]').text();

                    var arr = text.split('€');
                    var getalMetJaar = arr[arr.length - 1]; // neem laatste element geeft "89996/jaar"
                    var arr2 = getalMetJaar.split('/');
                    var getal = arr2[0]; // neem eerste element geeft "89996"

                    var waarde = parseFloat(getal);
                    getallenArray.push(waarde);
                    totaalWaarde += waarde;

                    // string"naam" bewerken
                    var naam = arr[0].substr(0, arr[0].length - 2); // op het einde van de string " - " verwijderen
                    namenArray.push(naam);
                }
            }

            $('span#grondstof_overzicht_target_kosten_gebouwen').text('Gebouwen = € ' + totaalWaarde.toFixed(2) + '/jaar');
            $('span#grondstof_overzichtberekening_target_kosten_gebouwen').text('Gebouwen = € ' + totaalWaarde.toFixed(2) + '/jaar');
            var html = "<br>";
            for (var k = 0; k < namenArray.length; k++) {

                html += '<span class="text-muted">' + namenArray[k] + ' € ' + getallenArray[k] + '<span><br>';
            }
            $('span#grondstof_overzichtberekening_target_kosten_gebouwen').append(html.substr(0, html.length - 4)); // laatste "<br>" eruithalen

            $('input#berekeningresultaten_kost_gebouwen').val(totaalWaarde);
            updateKostenTotalenInOverzicht();
        });
    }

    function kost_machines_dropdownOnChangeListener() {
        $('select#product_kost_machinesid').change(function (e) {
            var geselecteerdeWaardes = $(this).val();
            var totaalWaarde = 0;
            // 2 arrays maken op te gebruiken op het einde van deze functie
            var namenArray = [];
            var getallenArray = [];

            if (geselecteerdeWaardes == '-1') {
                // alle options ophalen, behalve de eerste (dat -1) is
                var alleOptionControlsVanFrom = $(this).parent().find('option');
                alleOptionControlsVanFrom.splice(0, 1); // eerste element verwijderen (is "-1" voor alles deze functie dus))

                for (var j = 0; j < alleOptionControlsVanFrom.length; j++) {
                    var _text = alleOptionControlsVanFrom.get(j).innerHTML; // text uit control halen
                    var _arr = _text.split('€');
                    // string"getal" bewerken
                    var _getalMetJaar = _arr[_arr.length - 1]; // neem laatste element geeft "89996/jaar"
                    var _arr2 = _getalMetJaar.split('/');
                    var _getal = _arr2[0]; // neem eerste element geeft "89996"

                    var _waarde = parseFloat(_getal);
                    getallenArray.push(_waarde);
                    totaalWaarde += _waarde;

                    // string"naam" bewerken
                    var _naam = _arr[0].substr(0, _arr[0].length - 2); // op het einde van de string " - " verwijderen
                    namenArray.push(_naam);
                }
            } else {
                // array opvullen met text van alle geselecteerde option
                for (var i = 0; i < geselecteerdeWaardes.length; i++) {
                    var text = $(this).parent().find('option[value="' + geselecteerdeWaardes[i] + '"]').text();

                    var arr = text.split('€');
                    var getalMetJaar = arr[arr.length - 1]; // neem laatste element geeft "89996/jaar"
                    var arr2 = getalMetJaar.split('/');
                    var getal = arr2[0]; // neem eerste element geeft "89996"

                    var waarde = parseFloat(getal);
                    getallenArray.push(waarde);
                    totaalWaarde += waarde;

                    // string"naam" bewerken
                    var naam = arr[0].substr(0, arr[0].length - 2); // op het einde van de string " - " verwijderen
                    namenArray.push(naam);
                }
            }

            $('span#grondstof_overzicht_target_kosten_machines').text('Machines = € ' + totaalWaarde.toFixed(2) + '/jaar');
            $('span#grondstof_overzichtberekening_target_kosten_machines').text('Machines = € ' + totaalWaarde.toFixed(2) + '/jaar');
            var html = "<br>";
            for (var k = 0; k < namenArray.length; k++) {

                html += '<span class="text-muted">' + namenArray[k] + ' € ' + getallenArray[k] + '<span><br>';
            }
            $('span#grondstof_overzichtberekening_target_kosten_machines').append(html.substr(0, html.length - 4)); // laatste "<br>" eruithalen

            $('input#berekeningresultaten_kost_machines').val(totaalWaarde);
            updateKostenTotalenInOverzicht();
        });
    }

    function kost_personeel_dropdownOnChangeListener() {
        $('select#product_kost_personeelid').change(function (e) {
            // wordt ook herberekend indien de dropdown van "geschatte omzet" wordt gewijzigd (daar staat trigger)

            var waardePerJaar = 0;
            if ($(this).val() == '') {
                waarde = 0;
            } else {
                var text = $(this).parent().find('option:selected').text();

                var arr = text.split('€');
                var getalMetJaar = arr[arr.length - 1]; // neem laatste element geeft "89996/jaar"
                var arr2 = getalMetJaar.split('/');
                var getal = arr2[0]; // neem eerste element geeft "89996"
                waardePerJaar = parseFloat(getal);
            }

            var aantalWerkdagen = 365;
            var selectedOmzet_controlDropdown = $('select#product_kost_omzetid option:selected');
            if (selectedOmzet_controlDropdown.val() > 0) {
                var array = selectedOmzet_controlDropdown.text().split('/');
                var werkdagMetJaar = array[array.length - 2]; // neem voorlaatste element geeft "dag x 250 dagen"
                aantalWerkdagen = parseInt(werkdagMetJaar.match(/\d+/)[0]);// haal enkel het nummer "250" eruit
            }

            var waarde = (waardePerJaar / 365) * aantalWerkdagen;

            $('span#grondstof_overzicht_target_kosten_personeel').text('Personeel = € ' + waarde.toFixed(2) + '/jaar');
            $('span#grondstof_overzichtberekening_target_kosten_personeel').text('Personeel = € ' + waarde.toFixed(2) + '/jaar (' + aantalWerkdagen + ' werkdagen)');

            $('input#berekeningresultaten_kost_personeel').val(waarde);
            updateKostenTotalenInOverzicht();
        });
    }

    function formEditListener_vervangKommasDoorPunt() {
        var controlInput_inhoudperzak = $("input#product_inhoudperzak");
        var controlInput_grondstofwaarde = $("input#product_waarde");
        controlInput_inhoudperzak.add(controlInput_grondstofwaarde).keyup(function () {
            var currentValue = $(this).val();
            var correctValue;
            if (currentValue.includes(",")) {
                correctValue = currentValue.replace(",", ".");
                $(this).val(correctValue);
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

    function formSubmitListener() {
        $("#form_product_beheren").on('submit', function (e) {
            e.stopImmediatePropagation();
            if (readyToSubmit_percentageIs100) {
                readyToSubmit_percentageIs100 = true; // reset
                return true; // doorgaan met submit (formulier is reeds gevalideerd door voorgaande loop in deze functie)
            }
            e.preventDefault();
            alert('De grondstoffen zijn niet 100%');
            return false;
        });
    }

    function ajaxTable_bewerkListener() {
        $(".trigger-bewerkrij").click(function () {
            //controls
            var clickedIconSVG = $(this).find('i');
            var clickedRow = $(this).parent().parent();
            var targetInputField_artikelcode = clickedRow.find('input#editableInput_artikelcode');
            var targetInputField_beschrijving = clickedRow.find('input#editableInput_beschrijving');
            var targetInputField_stuksperpallet = clickedRow.find('input#editableInput_stuksperpallet');
            var targetInputField_inhoudperzak = clickedRow.find('input#editableInput_inhoudperzak');
            var targetDropdownField_folieid = clickedRow.find('select#editableInput_folieid');
            var targetDropdownField_verpakkingskostid = clickedRow.find('select#editableInput_verpakkingskostid');

            //data
            var productId = $(this).data('id');

            targetInputField_artikelcode.toggleClass('agricon-is-editable-input');

            //wanneer het "editable" is -> icoontje veranderen + autofocus op de input + een class toevoegen
            if (targetInputField_artikelcode.hasClass('agricon-is-editable-input')) {
                clickedRow.addClass('trGlow');
                targetInputField_artikelcode.focus();
                targetInputField_artikelcode.removeAttr('readonly');
                targetInputField_beschrijving.removeAttr('readonly');
                targetInputField_stuksperpallet.removeAttr('readonly');
                targetInputField_inhoudperzak.removeAttr('readonly');
                targetDropdownField_folieid.removeAttr('disabled');
                targetDropdownField_verpakkingskostid.removeAttr('disabled');

                clickedIconSVG.removeClass('fa-pencil-alt');
                clickedIconSVG.addClass('fa-save');
            } else {
                // anders alles terugzetten + gegevens updaten in de database
                clickedRow.removeClass('trGlow');
                targetInputField_artikelcode.attr('readonly', 'readonly');
                targetInputField_beschrijving.attr('readonly', 'readonly');
                targetInputField_stuksperpallet.attr('readonly', 'readonly');
                targetInputField_inhoudperzak.attr('readonly', 'readonly');
                targetDropdownField_folieid.attr('disabled', 'disabled');
                targetDropdownField_verpakkingskostid.attr('disabled', 'disabled');

                clickedIconSVG.removeClass('fa-save');
                clickedIconSVG.addClass('fa-pencil-alt');

                //hidden form opvullen
                var productArtikelcode = targetInputField_artikelcode.val();
                var productBeschrijving = targetInputField_beschrijving.val();
                var productStuksperpallet = targetInputField_stuksperpallet.val();
                var productInhoudperzak = targetInputField_inhoudperzak.val();
                var productFolieId = targetDropdownField_folieid.val();
                var productVerpakkingsKostId = targetDropdownField_verpakkingskostid.val();

                if (productArtikelcode != "" && productArtikelcode != null && productId != 0 && productId != null) {
                    $("#form_product_update input#product_id_update").val(productId);
                    $("#form_product_update input#product_naam_update").val(productArtikelcode + ' - ' + productBeschrijving);
                    $("#form_product_update input#product_artikelcode_update").val(productArtikelcode);
                    $("#form_product_update input#product_beschrijving_update").val(productBeschrijving);
                    $("#form_product_update input#product_stuksperpallet_update").val(productStuksperpallet);
                    $("#form_product_update input#product_inhoudperzak_update").val(productInhoudperzak);
                    $("#form_product_update input#product_folieid_update").val(productFolieId);
                    $("#form_product_update input#product_verpakkingskostid_update").val(productVerpakkingsKostId);

                    $("#form_product_update").submit();
                }
            }
        });
    }

    function ajaxTable_bewerkListener_vervangKommasDoorPunt() {
        var controlInput_inhoudperzak = $("input#editableInput_inhoudperzak");
        controlInput_inhoudperzak.keyup(function () {
            var inhoud = $(this).val();
            var correctValue;
            if (inhoud.includes(",")) {
                correctValue = inhoud.replace(",", ".");
                $(this).val(correctValue);
            }
        });
    }

    function ajaxTable_verwijderListener_showModal() {
        $(".agricon-delete-icon").click(function () {
            // hidden form opvullen
            var productId = $(this).data('id');
            var productNaam = $(this).data('productnaam');

            if (productId != 0 && productId != null) {
                $("#form_product_delete input#product_id_delete").val(productId);
                $("#form_product_delete input#product_naam_delete").val(productNaam);
            }
            $('#deleteModal').modal('show');
        });
    }

    function ajaxTable_verwijderModalListener() {
        $('#deleteAllData').click(function (e) {
            $('#deleteModal').modal('hide');
            $("#form_product_delete").submit();
        });
    }

    function ajaxTable_show_berekeningenListener() {
        $('div.trigger-show-berekeningen').click(function (e) {
            console.log('TRIGGER');




            var productId = $(this).data('productid');
            var productieKostId = $(this).data('productiekostid');
            var productNaam = $(this).data('productnaam');
            ajax_getCalulationMessage_product(productNaam, productId, productieKostId);
        });
    }


    function ajaxTable_show_grondstoffenListener() {
        $('div.trigger-show-grondstoffen').click(function (e) {
            e.stopImmediatePropagation();
            var productid = $(this).data('productid');
            var productnaam = $(this).data('productnaam');
            window.location.href = site_url + "/product/product_grondstoffenBeheren/" + productid + '/' + productnaam;
        });
    }

    function ajaxTable_show_productiekostenListener() {
        $('div.trigger-show-productiekosten').click(function (e) {
            e.stopImmediatePropagation();
            var productid = $(this).data('productid');
            var productnaam = $(this).data('productnaam');
            window.location.href = site_url + "/product/product_productiekostenBeheren/" + productid + '/' + productnaam;

        });
    }


    $(document).ready(function () {
        get_byZoekFunctie($("#zoeknaam").val());

        formEditListener_vervangKommasDoorPunt();
        formListener_zoekOpNaam();
        switchViewListener();
        algemeen_onKeyKup_toonInOverzicht();
        algemeen_berekening_folieListener();
        algemeen_inhoudListener();
        algemeen_verpakkingskostListener();
        grondstoffen_dropdownListener();
        grondstoffen_grondstofVerwijderenListener();
        kost_omzet_dropdownOnChangeListener();
        kost_elektriciteit_dropdownOnChangeListener();
        kost_gebouwen_dropdownOnChangeListener();
        kost_machines_dropdownOnChangeListener();
        kost_personeel_dropdownOnChangeListener();
    });

    $(document).ajaxComplete(function () {
        grondstofWaardeSoort_dropdownChangeListener();
        formSubmitListener();
        ajaxTable_bewerkListener();
        ajaxTable_bewerkListener_vervangKommasDoorPunt();
        ajaxTable_verwijderListener_showModal();
        ajaxTable_verwijderModalListener();
        ajaxTable_show_berekeningenListener();
        ajaxTable_show_productiekostenListener();
        ajaxTable_show_grondstoffenListener();
    });

</script>
