<main role="main" class="container" id="content_product_bekijken_productiekosten">
    <div class="row agricon-content-title">
        <h3 style='position:relative'><?php echo $title; ?> </h3>
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
                                <div class=" agricon-table-container agricon-wijzigbestaande-ajaxtable"
                                     style="padding-left: 35px;padding-top: 25px">
                                    <?php
                                    if (isset($productieKost)) { ?>
                                        <div>
                                            <p>
                                                <span style="display:inline-block;width: 150px">Geschatte omzet:</span><?php echo $productieKost->geschatteOmzet; ?>
                                            </p>
                                        </div>
                                        <div>
                                            <p>
                                                <span style="display:inline-block;width: 150px">Elektriciteit:</span><?php echo $productieKost->elektriciteit; ?>
                                            </p>
                                        </div>
                                        <div>
                                            <p>
                                                <span style="display:inline-block;width: 150px">Personeel:</span><?php echo $productieKost->personeel; ?>
                                            </p>
                                        </div>
                                        <div>
                                            <p>
                                                <span style="display:inline-block;width: 150px">Gebouwen:</span><?php echo $productieKost->gebouwen_titel; ?>
                                                <br/>
                                                <?php
                                                foreach ($productieKost->gebouwen as $gebouw) {
                                                    echo '<span class="text-muted" style="display:inline-block;width: 150px">' . $gebouw->gebouwNaam . '</span>' . $gebouw->gebouwText . '<br/>';
                                                }
                                                ?>
                                            </p>
                                        </div>
                                        <div>
                                            <p>
                                                <span style="display:inline-block;width: 150px">Machines:</span><?php echo $productieKost->machines_titel; ?>
                                                <br/>
                                                <?php
                                                foreach ($productieKost->machines as $machine) {
                                                    echo '<span class="text-muted" style="display:inline-block;width: 150px">' . $machine->machineNaam . '</span>' . $machine->machineText . '<br/>';
                                                    echo '<span class="text-muted" style="display:inline-block;width: 150px;padding-left: 10px">Onderhoud</span>' . $machine->onderhoudText . '<br/>';
                                                    foreach ($machine->reparaties as $reparatie) {
                                                        echo '<span class="text-muted" style="display:inline-block;width: 150px;padding-left: 10px">' . $reparatie->reparatieNaam . '</span>' . $reparatie->reparatieText . '<br/>';
                                                    }
                                                }
                                                ?>
                                            </p>
                                        </div>
                                    <?php } ?>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>