<main role="main" class="container" id="content_product_beheren_productiekosten">
    <div class="row agricon-content-title">
        <h3 style='position:relative'><?php echo $title . ' €' . $productieKostPrijs . '/jaar'; ?> </h3>
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
                                     style="padding-left: 35px">
                                    <?php
                                    if (isset($productieKost)) {

                                        $dataOpen = array(
                                            'id' => 'form_product_beheren_productiekost',
                                            'name' => 'form_product_beheren_productiekost',
                                            'data-toggle' => 'validator',
                                            'role' => 'form',
                                            'style' => 'width:96%;margin-top:15px;margin-bottom:15px');

                                        $dataSubmit = array(
                                            'id' => 'submit_product_beheren_productiekost',
                                            'name' => 'submit_product_beheren_productiekost',
                                            'type' => 'submit',
                                            'value' => 'Update',
                                            'class' => 'btn btn-outline-success agricon-formsubmit-button');
                                        ?>
                                        <?php echo form_open('product/update_productiekosten', $dataOpen); ?>

                                        <div class="form-row">
                                            <label for="product_kost_omzetid"
                                                   class="form-text text-muted">Geschatte omzet *</label>
                                            <?php echo form_dropdown('product_kost_omzetid', $kost_omzet_dropdownOptions, $productieKost->omzetId, 'id="product_kost_omzetid" class="form-control" required="required" name="geschatte jaar omzet" '); ?>
                                        </div>


                                        <div class="form-row agricon-formcolumn">
                                            <div class="col-6">
                                                <label for="product_kost_elektriciteitid"
                                                       class="form-text text-muted">Elektriciteit *</label>
                                                <?php echo form_dropdown('product_kost_elektriciteitid', $kost_elektriciteit_dropdownOptions, $productieKost->elektriciteit->id, 'id="product_kost_elektriciteitid" class="form-control" required="required" name="elektriciteit" '); ?>
                                            </div>
                                            <div class="col-6">
                                                <label for="product_kost_personeelid"
                                                       class="form-text text-muted">Personeel *</label>
                                                <?php echo form_dropdown('product_kost_personeelid', $kost_personeel_dropdownOptions, $productieKost->personeel->id, 'id="product_kost_personeelid" class="form-control" required="required" name="personeel" '); ?>
                                            </div>

                                        </div>
                                        <div class="form-row agricon-formcolumn">
                                            <div class="col-6">
                                                <label for="product_kost_gebouwenid"
                                                       class="form-text text-muted">Gebouwen *</label>
                                                <?php echo form_multiselect('product_kost_gebouwenid[]', $kost_gebouwen_dropdownOptions, $selectedGebouwenValues, 'id="product_kost_gebouwenid" class="form-control" required="required" multiple="multiple" '); ?>
                                            </div>
                                            <div class="col-6">
                                                <label for="product_kost_machinesid"
                                                       class="form-text text-muted">Machines *</label>
                                                <?php echo form_multiselect('product_kost_machinesid[]', $kost_machines_dropdownOptions, $selectedMachinesValues, 'id="product_kost_machinesid" class="form-control" required="required"  '); ?>
                                            </div>
                                        </div>
                                        <input hidden id="productid" name="productid"
                                               value="<?php echo $productId; ?>">
                                        <input hidden id="productiekostid" name="productiekostid"
                                               value="<?php echo $productieKostId; ?>">
                                        <input hidden id="productiekostprijs" name="productiekostprijs"
                                               value="<?php echo $productieKostPrijs; ?>">
                                        <input hidden id="productnaam" name="productnaam"
                                               value="<?php echo $productNaam; ?>">

                                        <div class="form-row agricon-formsubmit-container">
                                            <?php
                                            echo form_submit($dataSubmit);
                                            ?>
                                        </div>

                                        <?php
                                    }
                                    ?>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>