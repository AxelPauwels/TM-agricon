<div class="form-row agricon-table-container agricon-wijzigbestaande-ajaxtable">
    <?php
    // de "selecteer..." optie verwijderen voor deze dropdowns
    if (isset($leveranciers_dropdownOptions)) {
        unset($leveranciers_dropdownOptions['']);

    }

    if (isset($foliesRuw)) {
        $template = array('table_open' => '<table id="folie_ruw_table" class="agricon-table table table-responsive-sm table-sm table-striped noHoverAllowed tablesorter " border="0" cellpadding="4" cellspacing="0">');
        $this->table->set_template($template);

        $sortIcon = '<div class="agricon-sort-icon"><i class="fas fa-sort"></i></div>';
        $th_gewijzigdOp = ['data' => 'Gewijzigd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];
        $th_toegevoedOp = ['data' => 'Toegevoegd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];

        $this->table->set_heading('', 'Naam' . $sortIcon, 'LM prijs' . $sortIcon, 'LM eenheid' . $sortIcon, 'Micron' . $sortIcon, 'Leverancier' . $sortIcon, $th_gewijzigdOp,
            'Door' . $sortIcon, $th_toegevoedOp, 'Door' . $sortIcon, '', '');
        $rijNummer = 0;
        foreach ($foliesRuw as $folieRuw) {
            $rijNummer++;
            // <span hidden></span> gebruiken om te sorteren via tablesorter() -> de inputvelden kunnen editable gemaakt worden met jQuery
            $this->table->add_row($rijNummer,
                '<span hidden>' . ucfirst($folieRuw->naam) . '</span><input id="editableInput_naam" readonly="readonly" value="' . ucfirst($folieRuw->naam) . '" onfocus="var temp_value=this.value; this.value=\'\'; this.value=temp_value">',
                '<span hidden>' . $folieRuw->lopendeMeterPrijs . '</span><input id="editableInput_lmprijs" readonly="readonly" value="' . $folieRuw->lopendeMeterPrijs . '" >',
                '<span hidden>' . $folieRuw->lopendeMeterEenheid . '</span><input id="editableInput_lmeenheid" readonly="readonly" value="' . $folieRuw->lopendeMeterEenheid . '" >',
                '<span hidden>' . ucfirst($folieRuw->micronDikte) . '</span><input id="editableInput_micron" readonly="readonly" value="' . ucfirst($folieRuw->micronDikte) . '" >',
                '<span hidden>' . $folieRuw->leverancierId . '</span>' . form_dropdown('edit_folie_ruw_leverancierid', $leveranciers_dropdownOptions, $folieRuw->leverancierId, 'id="editableInput_leverancierid" disabled="disabled" class="agricon-editable-dropdown form-control" required="required" '),
                $folieRuw->gewijzigdOp_datum . ' ' . $folieRuw->gewijzigdOp_tijd,
                ucfirst($folieRuw->gewijzigdDoorUser),
                $folieRuw->toegevoegdOp_datum . ' ' . $folieRuw->toegevoegdOp_tijd,
                ucfirst($folieRuw->toegevoegdDoorUser),
                '<div class="trigger-bewerkrij agricon-changeable-icon" data-id="' . $folieRuw->id . '"><i class="fas fa-pencil-alt"></i></div>',
                '<div class="agricon-delete-icon" data-id="' . $folieRuw->id . '" data-folieruwnaam="' . $folieRuw->naam . '"><i class="fas fa-times"></i></div>'
            );
        }
        echo $this->table->generate();
    } ?>
</div>