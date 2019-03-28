<div class="form-row agricon-table-container agricon-wijzigbestaande-ajaxtable">
    <?php
    if (isset($verpakkingskosten)) {
        $template = array('table_open' => '<table id="config_verpakkingskost_table" class="agricon-table table table-responsive-sm table-sm table-striped noHoverAllowed tablesorter " border="0" cellpadding="4" cellspacing="0">');
        $this->table->set_template($template);

        $sortIcon = '<div class="agricon-sort-icon"><i class="fas fa-sort"></i></div>';
        $th_gewijzigdOp = ['data' => 'Gewijzigd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];
        $th_toegevoedOp = ['data' => 'Toegevoegd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];

        $this->table->set_heading('', 'Naam' . $sortIcon, $th_gewijzigdOp,
            'Door' . $sortIcon, $th_toegevoedOp, 'Door' . $sortIcon, '', '');
        $rijNummer = 0;
        foreach ($verpakkingskosten as $verpakkingskost) {
            $rijNummer++;
            // <span hidden></span> gebruiken om te sorteren via tablesorter() -> de inputvelden kunnen editable gemaakt worden met jQuery
            $this->table->add_row($rijNummer,
                '<span hidden>' . ucfirst($verpakkingskost->verpakkingskost) . '</span><input id="editableInput_naam" readonly="readonly" value="' . ucfirst($verpakkingskost->verpakkingskost) . '" onfocus="var temp_value=this.value; this.value=\'\'; this.value=temp_value">',
                $verpakkingskost->gewijzigdOp_datum . ' ' . $verpakkingskost->gewijzigdOp_tijd,
                ucfirst($verpakkingskost->gewijzigdDoorUser),
                $verpakkingskost->toegevoegdOp_datum . ' ' . $verpakkingskost->toegevoegdOp_tijd,
                ucfirst($verpakkingskost->toegevoegdDoorUser),
                '<div class="trigger-bewerkrij agricon-changeable-icon" data-id="' . $verpakkingskost->id . '"><i class="fas fa-pencil-alt"></i></div>',
                '<div class="agricon-delete-icon" data-id="' . $verpakkingskost->id . '" data-verpakkingskostnaam="' . $verpakkingskost->verpakkingskost . '"><i class="fas fa-times"></i></div>'
            );
        }
        echo $this->table->generate();
    } ?>
</div>
