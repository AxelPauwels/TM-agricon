<div class="form-row agricon-table-container agricon-wijzigbestaande-ajaxtable">
    <?php
    // de "selecteer..." optie verwijderen voor deze dropdowns
    if (isset($landen_dropdownOptions)) {
        unset($landen_dropdownOptions['']);
    }

    if (isset($steden)) {
        $template = array('table_open' => '<table id="stadgemeente_table" class="agricon-table table table-responsive-sm table-sm table-striped noHoverAllowed tablesorter " border="0" cellpadding="4" cellspacing="0">');
        $this->table->set_template($template);

        $sortIcon = '<div class="agricon-sort-icon"><i class="fas fa-sort"></i></div>';
        $th_gewijzigdOp = ['data' => 'Gewijzigd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];
        $th_toegevoedOp = ['data' => 'Toegevoegd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];

        $this->table->set_heading('', 'Naam' . $sortIcon, 'Postcode' . $sortIcon, 'Land' . $sortIcon, $th_gewijzigdOp,
            'Door' . $sortIcon, $th_toegevoedOp, 'Door' . $sortIcon, '', '');
        $rijNummer = 0;

        foreach ($steden as $stadgemeente) {
            $rijNummer++;

            // <span hidden></span> gebruiken om te sorteren via tablesorter() -> de inputvelden kunnen editable gemaakt worden met jQuery
            $this->table->add_row($rijNummer,
                '<span hidden>' . $stadgemeente->naam . '</span><input id="editableInput_naam" readonly="readonly" value="' . ucfirst($stadgemeente->naam) . '" onfocus="var temp_value=this.value; this.value=\'\'; this.value=temp_value">',
                '<span hidden>' . $stadgemeente->postcode . '</span><input id="editableInput_postcode" readonly="readonly" value="' . $stadgemeente->postcode . ' ">',
                '<span hidden>' . $stadgemeente->landId . '</span>' . form_dropdown('edit_stadgemeente_landid', $landen_dropdownOptions, $stadgemeente->landId, 'id="editableInput_landid" disabled="disabled" class="agricon-editable-dropdown form-control" required="required" '),
                $stadgemeente->gewijzigdOp_datum . ' ' . $stadgemeente->gewijzigdOp_tijd,
                ucfirst($stadgemeente->gewijzigdDoorUser),
                $stadgemeente->toegevoegdOp_datum . ' ' . $stadgemeente->toegevoegdOp_tijd,
                ucfirst($stadgemeente->toegevoegdDoorUser),
                '<div class="trigger-bewerkrij agricon-changeable-icon" data-id="' . $stadgemeente->id . '"><i class="fas fa-pencil-alt"></i></div>',
                '<div class="agricon-delete-icon" data-id="' . $stadgemeente->id . '" data-stadgemeentenaam="' . $stadgemeente->naam . '"><i class="fas fa-times"></i></div>'
            );
        }
        echo $this->table->generate();
    } ?>
</div>