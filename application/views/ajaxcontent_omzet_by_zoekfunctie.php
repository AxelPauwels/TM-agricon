<div class="form-row agricon-table-container agricon-wijzigbestaande-ajaxtable">
    <?php
    if (isset($omzetten)) {
        $template = array('table_open' => '<table id="config_omzet_table" class="agricon-table table table-responsive-sm table-sm table-striped noHoverAllowed tablesorter " border="0" cellpadding="4" cellspacing="0">');
        $this->table->set_template($template);

        $sortIcon = '<div class="agricon-sort-icon"><i class="fas fa-sort"></i></div>';
        $th_gewijzigdOp = ['data' => 'Gewijzigd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];
        $th_toegevoedOp = ['data' => 'Toegevoegd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];

        $this->table->set_heading('', 'Naam' . $sortIcon, 'Zakjes/Dag' . $sortIcon, 'Dagen/Jaar' . $sortIcon, 'Zakjes/Jaar' . $sortIcon,
            $th_gewijzigdOp, 'Door' . $sortIcon, $th_toegevoedOp, 'Door' . $sortIcon, '', '');
        $rijNummer = 0;
        foreach ($omzetten as $omzet) {
            $rijNummer++;
            // <span hidden></span> gebruiken om te sorteren via tablesorter() -> de inputvelden kunnen editable gemaakt worden met jQuery
            $this->table->add_row(
                $rijNummer,
                '<span hidden>' . ucfirst($omzet->naam) . '</span><input id="editableInput_naam" readonly="readonly" value="' . ucfirst($omzet->naam) . '" onfocus="var temp_value=this.value; this.value=\'\'; this.value=temp_value">',
                '<span hidden>' . $omzet->zakjesPerDag . '</span><input id="editableInput_zakjesperdag" readonly="readonly" value="' . ucfirst($omzet->zakjesPerDag) . '" onfocus="var temp_value=this.value; this.value=\'\'; this.value=temp_value">',
                '<span hidden>' . $omzet->dagenPerJaar . '</span><input id="editableInput_dagenperjaar" readonly="readonly" value="' . ucfirst($omzet->dagenPerJaar) . '" onfocus="var temp_value=this.value; this.value=\'\'; this.value=temp_value">',
                '<span hidden>' . $omzet->aantalZakjesPerJaar . '</span><input id="notEditableInput_dagenperjaar" readonly="readonly" style="font-weight: 600" value="' . ucfirst($omzet->aantalZakjesPerJaar) . '" onfocus="var temp_value=this.value; this.value=\'\'; this.value=temp_value">',
                $omzet->gewijzigdOp_datum . ' ' . $omzet->gewijzigdOp_tijd,
                ucfirst($omzet->gewijzigdDoorUser),
                $omzet->toegevoegdOp_datum . ' ' . $omzet->toegevoegdOp_tijd,
                ucfirst($omzet->toegevoegdDoorUser),
                '<div class="trigger-bewerkrij agricon-changeable-icon" data-id="' . $omzet->id . '"><i class="fas fa-pencil-alt"></i></div>',
                '<div class="agricon-delete-icon" data-id="' . $omzet->id . '" data-omzetnaam="' . $omzet->naam . '"><i class="fas fa-times"></i></div>'
            );
        }
        echo $this->table->generate();
    } ?>
</div>
