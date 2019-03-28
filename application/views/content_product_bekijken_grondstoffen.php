<main role="main" class="container" id="content_product_bekijken_grondstoffen">
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

                                    <?php
                                    if (isset($samenstellingen)) {
                                        $template = array('table_open' => '<table id="product_grondstoffen_table" class="agricon-table table table-responsive-sm table-sm table-striped noHoverAllowed tablesorter " border="0" cellpadding="4" cellspacing="0">');
                                        $this->table->set_template($template);

                                        $sortIcon = '<div class="agricon-sort-icon"><i class="fas fa-sort"></i></div>';
                                        $th_gewijzigdOp = ['data' => 'Gewijzigd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];
                                        $th_toegevoedOp = ['data' => 'Toegevoegd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];

                                        $this->table->set_heading('', 'Naam' . $sortIcon, 'Hoeveelheid' . $sortIcon, 'Categorie' . $sortIcon, $th_gewijzigdOp,
                                            'Door' . $sortIcon, $th_toegevoedOp, 'Door' . $sortIcon);
                                        $rijNummer = 0;
                                        foreach ($samenstellingen as $samenstelling) {
                                            //naam
                                            if ($samenstelling->grondstofCategorie->isFractieCategorie == 1) {
                                                $grondstofNaam = '<span hidden>' . ucwords($samenstelling->grondstofRuw->naam) . ucfirst($samenstelling->grondstof->naam) . '</span>' . ucwords($samenstelling->grondstofRuw->naam) . ' ' . ucfirst($samenstelling->grondstof->naam);
                                            }
                                            else {
                                                $grondstofNaam = '<span hidden>' . ucfirst($samenstelling->grondstof->naam) . '</span>' . ucfirst($samenstelling->grondstof->naam);
                                            }
                                            //hoeveelheid
                                            if ($samenstelling->percentage != null) {
                                                $percentageOfGewicht = '<span hidden>' . $samenstelling->percentage . '</span>' . $samenstelling->percentage . '%';
                                            }
                                            else {
                                                $percentageOfGewicht = '<span hidden>' . $samenstelling->gewicht . '</span>' . $samenstelling->gewicht . 'kg';
                                            }


                                            $rijNummer++;
                                            // <span hidden></span> gebruiken om te sorteren via tablesorter() -> de inputvelden kunnen editable gemaakt worden met jQuery
                                            $this->table->add_row(
                                                $rijNummer,
                                                $grondstofNaam,
                                                $percentageOfGewicht,
                                                '<span hidden>' . $samenstelling->grondstofCategorie->naam . '</span>' . $samenstelling->grondstofCategorie->naam,



                                                $samenstelling->gewijzigdOp_datum . ' ' . $samenstelling->gewijzigdOp_tijd,
                                                ucfirst($samenstelling->gewijzigdDoorUser),
                                                $samenstelling->toegevoegdOp_datum . ' ' . $samenstelling->toegevoegdOp_tijd,
                                                ucfirst($samenstelling->toegevoegdDoorUser)
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
            </div>
        </div>

    </div>
</main>
