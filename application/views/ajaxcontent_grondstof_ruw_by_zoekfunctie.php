<div class="form-row agricon-table-container agricon-wijzigbestaande-ajaxtable">
    <?php

    // de "selecteer..." optie verwijderen voor deze dropdowns
    if (isset($grondstofCategorieen_dropdownOptions)) {
        unset($grondstofCategorieen_dropdownOptions['']);
    }
    if (isset($eenheden_dropdownOptions)) {
        unset($eenheden_dropdownOptions['']);
    }

    if (isset($grondstoffenRuw)) {
        $template = array('table_open' => '<table id="grondstof_ruw_table" class="agricon-table table table-responsive-sm table-sm table-striped noHoverAllowed tablesorter " border="0" cellpadding="4" cellspacing="0">');
        $this->table->set_template($template);

        $sortIcon = '<div class="agricon-sort-icon"><i class="fas fa-sort"></i></div>';
        $th_gewijzigdOp = ['data' => 'Gewijzigd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];
        $th_toegevoedOp = ['data' => 'Toegevoegd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];

        $this->table->set_heading('', 'Naam' . $sortIcon, '', 'Aankoopprijs' . $sortIcon, '/Per' . $sortIcon, "Fracties", $th_gewijzigdOp,
            'Door' . $sortIcon, $th_toegevoedOp, 'Door' . $sortIcon, '', '');
        $rijNummer = 0;

        foreach ($grondstoffenRuw as $grondstof) {
            $fractieIcon = "";
            if ($grondstof->categorie->isFractieCategorie) {
                $fractieIcon = '<div style="text-align:center;cursor:pointer" class="trigger-show-fractions" data-id="' . $grondstof->id . '" data-grondstofruwnaam="' . $grondstof->naam . '"><i class="far fa-eye"></i></div>';
                $rijNummer++;

                // <span hidden></span> gebruiken om te sorteren via tablesorter() -> de inputvelden kunnen editable gemaakt worden met jQuery
                $this->table->add_row($rijNummer,
                    '<span hidden>' . $grondstof->naam . '</span><input id="editableInput_naam" readonly="readonly" value="' . ucfirst($grondstof->naam) . '" onfocus="var temp_value=this.value; this.value=\'\'; this.value=temp_value">',
                    '<span hidden>' . $grondstof->grondstofCategorieId . '</span>' . form_dropdown('edit_grondstof_ruw_categorieid', $grondstofCategorieen_dropdownOptions, $grondstof->grondstofCategorieId, 'id="editableInput_grondstofcategorie" disabled="disabled" class="agricon-editable-dropdown form-control" required="required" '),
                    '<span hidden>' . $grondstof->aankoopprijs . '</span><input id="editableInput_prijs" readonly="readonly" value="' . $grondstof->aankoopprijs . '" >',
                    '<span hidden>' . $grondstof->eenheidId . '</span>' . form_dropdown('edit_grondstof_ruw_eenheidid', $eenheden_dropdownOptions, $grondstof->eenheidId, 'id="editableInput_grondstofeenheid" disabled="disabled" class="agricon-editable-dropdown form-control" required="required" '),
                    '<span hidden>0</span>' . $fractieIcon,
                    $grondstof->gewijzigdOp_datum . ' ' . $grondstof->gewijzigdOp_tijd,
                    ucfirst($grondstof->gewijzigdDoorUser),
                    $grondstof->toegevoegdOp_datum . ' ' . $grondstof->toegevoegdOp_tijd,
                    ucfirst($grondstof->toegevoegdDoorUser),
                    '<div class="trigger-bewerkrij agricon-changeable-icon" data-id="' . $grondstof->id . '"><i class="fas fa-pencil-alt"></i></div>',
                    '<div class="agricon-delete-icon" data-id="' . $grondstof->id . '" data-grondstofruwnaam="' . $grondstof->naam . '"><i class="fas fa-times"></i></div>'
                );
            }
        }
        echo $this->table->generate();
    } ?>
</div>