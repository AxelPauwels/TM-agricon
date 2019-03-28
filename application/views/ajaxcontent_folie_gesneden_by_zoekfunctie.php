<div class="form-row agricon-table-container agricon-wijzigbestaande-ajaxtable">
    <?php
    // de "selecteer..." optie verwijderen voor deze dropdowns
    if (isset($folies_dropdownOptions)) {
        unset($folies_dropdownOptions['']);
    }

    if (isset($foliesGesneden)) {
        $template = array('table_open' => '<table id="folie_gesneden_table" class="agricon-table table table-responsive-sm table-sm table-striped noHoverAllowed tablesorter " border="0" cellpadding="4" cellspacing="0">');
        $this->table->set_template($template);

        $sortIcon = '<div class="agricon-sort-icon"><i class="fas fa-sort"></i></div>';
        $th_gewijzigdOp = ['data' => 'Gewijzigd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];
        $th_toegevoedOp = ['data' => 'Toegevoegd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];

        $this->table->set_heading('', 'Naam' . $sortIcon, 'Afslag' . $sortIcon, 'Breedte' . $sortIcon, 'Ruwe Folie' . $sortIcon, 'Zakjes/rol' . $sortIcon, 'Prijs/zakje' . $sortIcon, $th_gewijzigdOp,
            'Door' . $sortIcon, $th_toegevoedOp, 'Door' . $sortIcon, '', '');
        $rijNummer = 0;
        foreach ($foliesGesneden as $folieGesneden) {
            $rijNummer++;
            // <span hidden></span> gebruiken om te sorteren via tablesorter() -> de inputvelden kunnen editable gemaakt worden met jQuery
            $this->table->add_row($rijNummer,
                '<span hidden>' . ucfirst($folieGesneden->naam) . '</span><input id="editableInput_naam" readonly="readonly" value="' . ucfirst($folieGesneden->naam) . '" onfocus="var temp_value=this.value; this.value=\'\'; this.value=temp_value">',
                '<span hidden>' . $folieGesneden->lengteAfslag . '</span><input id="editableInput_lengte" readonly="readonly" value="' . $folieGesneden->lengteAfslag . '" >',
                '<span hidden>' . $folieGesneden->breedte . '</span><input id="editableInput_breedte" readonly="readonly" value="' . $folieGesneden->breedte . '" >',
                '<span hidden>' . $folieGesneden->folieRuwId . '</span>' . form_dropdown('edit_folie_ruw_folieruwid', $folies_dropdownOptions, $folieGesneden->folieRuwId, 'id="editableInput_folieruwid" disabled="disabled" class="agricon-editable-dropdown form-control" required="required" '),
                '<span hidden>' . $folieGesneden->aantalZakjesPerRol . '</span><input readonly="readonly" value="' . $folieGesneden->aantalZakjesPerRol . '" >',
                '<span hidden>' . $folieGesneden->prijsPerZakje . '</span><input readonly="readonly" style="font-weight: 600" value="' . $folieGesneden->prijsPerZakje . '" >',

                $folieGesneden->gewijzigdOp_datum . ' ' . $folieGesneden->gewijzigdOp_tijd,
                ucfirst($folieGesneden->gewijzigdDoorUser),
                $folieGesneden->toegevoegdOp_datum . ' ' . $folieGesneden->toegevoegdOp_tijd,
                ucfirst($folieGesneden->toegevoegdDoorUser),
                '<div class="trigger-bewerkrij agricon-changeable-icon" data-id="' . $folieGesneden->id . '"><i class="fas fa-pencil-alt"></i></div>',
                '<div class="agricon-delete-icon" data-id="' . $folieGesneden->id . '" data-folieruwnaam="' . $folieGesneden->naam . '"><i class="fas fa-times"></i></div>'
            );
        }
        echo $this->table->generate();
    } ?>
</div>