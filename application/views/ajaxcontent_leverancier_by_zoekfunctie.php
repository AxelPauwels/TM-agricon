<div class="form-row agricon-table-container agricon-wijzigbestaande-ajaxtable">
    <?php
    // de "selecteer..." optie verwijderen voor deze dropdowns
    if (isset($steden_dropdownOptions)) {
        unset($steden_dropdownOptions['']);
    }
    if (isset($leveranciersoorten_dropdownOptions)) {
        unset($leveranciersoorten_dropdownOptions['']);
    }

    if (isset($leveranciers)) {
        $template = array('table_open' => '<table id="leverancier_table" class="agricon-table table table-responsive-sm table-sm table-striped noHoverAllowed tablesorter " border="0" cellpadding="4" cellspacing="0">');
        $this->table->set_template($template);

        $sortIcon = '<div class="agricon-sort-icon"><i class="fas fa-sort"></i></div>';
        $th_gewijzigdOp = ['data' => 'Gewijzigd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];
        $th_toegevoedOp = ['data' => 'Toegevoegd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];

        $this->table->set_heading('', 'Naam' . $sortIcon, 'Straat' . $sortIcon, 'Nr' . $sortIcon, 'Stad' . $sortIcon, 'Soort' . $sortIcon, 'BTWnummer' . $sortIcon, $th_gewijzigdOp,
            'Door' . $sortIcon, $th_toegevoedOp, 'Door' . $sortIcon, '', '');
        $rijNummer = 0;
        foreach ($leveranciers as $leverancier) {
            $rijNummer++;
            // <span hidden></span> gebruiken om te sorteren via tablesorter() -> de inputvelden kunnen editable gemaakt worden met jQuery
            $this->table->add_row($rijNummer,
                '<span hidden>' . ucfirst($leverancier->naam) . '</span><input id="editableInput_naam" readonly="readonly" value="' . ucfirst($leverancier->naam) . '" onfocus="var temp_value=this.value; this.value=\'\'; this.value=temp_value">',
                '<span hidden>' . ucfirst($leverancier->straat) . '</span><input id="editableInput_straat" readonly="readonly" value="' . ucfirst($leverancier->straat) . '" >',
                '<span hidden>' . ucfirst($leverancier->huisnummer) . '</span><input id="editableInput_huisnummer" readonly="readonly" value="' . ucfirst($leverancier->huisnummer) . '" >',
                '<span hidden>' . $leverancier->stadGemeenteId . '</span>' . form_dropdown('edit_leverancier_stadgemeenteid', $steden_dropdownOptions, $leverancier->stadGemeenteId, 'id="editableInput_stadgemeente" disabled="disabled" class="agricon-editable-dropdown form-control" required="required" '),
                '<span hidden>' . $leverancier->leverancierSoortId . '</span>' . form_dropdown('edit_leverancier_leveranciersoortid', $leveranciersoorten_dropdownOptions, $leverancier->leverancierSoortId, 'id="editableInput_leveranciersoort" disabled="disabled" class="agricon-editable-dropdown form-control" required="required" '),
                '<span hidden>' . ucfirst($leverancier->BTWnummer) . '</span><input id="editableInput_btwnummer" readonly="readonly" value="' . ucfirst($leverancier->BTWnummer) . '" >',
                $leverancier->gewijzigdOp_datum . ' ' . $leverancier->gewijzigdOp_tijd,
                ucfirst($leverancier->gewijzigdDoorUser),
                $leverancier->toegevoegdOp_datum . ' ' . $leverancier->toegevoegdOp_tijd,
                ucfirst($leverancier->toegevoegdDoorUser),
                '<div class="trigger-bewerkrij agricon-changeable-icon" data-id="' . $leverancier->id . '"><i class="fas fa-pencil-alt"></i></div>',
                '<div class="agricon-delete-icon" data-id="' . $leverancier->id . '" data-leveranciernaam="' . $leverancier->naam . '"><i class="fas fa-times"></i></div>'
            );
        }
        echo $this->table->generate();
    } ?>
</div>