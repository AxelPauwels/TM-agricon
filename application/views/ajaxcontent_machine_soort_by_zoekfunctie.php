<div class="form-row agricon-table-container agricon-wijzigbestaande-ajaxtable">
    <?php
    if (isset($machine_soorten)) {
        $template = array('table_open' => '<table id="machine_soort_table" class="agricon-table table table-responsive-sm table-sm table-striped noHoverAllowed tablesorter " border="0" cellpadding="4" cellspacing="0">');
        $this->table->set_template($template);

        $sortIcon = '<div class="agricon-sort-icon"><i class="fas fa-sort"></i></div>';
        $th_gewijzigdOp = ['data' => 'Gewijzigd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];
        $th_toegevoedOp = ['data' => 'Toegevoegd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];

        $this->table->set_heading('', 'Naam' . $sortIcon, $th_gewijzigdOp,
            'Door' . $sortIcon, $th_toegevoedOp, 'Door' . $sortIcon, '', '');
        $rijNummer = 0;
        foreach ($machine_soorten as $machine_soort) {
            $rijNummer++;
            // <span hidden></span> gebruiken om te sorteren via tablesorter() -> de inputvelden kunnen editable gemaakt worden met jQuery
            $this->table->add_row($rijNummer,
                '<span hidden>' . ucfirst($machine_soort->naam) . '</span><input id="editableInput_naam" readonly="readonly" value="' . ucfirst($machine_soort->naam) . '" onfocus="var temp_value=this.value; this.value=\'\'; this.value=temp_value">',
                $machine_soort->gewijzigdOp_datum . ' ' . $machine_soort->gewijzigdOp_tijd,
                ucfirst($machine_soort->gewijzigdDoorUser),
                $machine_soort->toegevoegdOp_datum . ' ' . $machine_soort->toegevoegdOp_tijd,
                ucfirst($machine_soort->toegevoegdDoorUser),
                '<div class="trigger-bewerkrij agricon-changeable-icon" data-id="' . $machine_soort->id . '"><i class="fas fa-pencil-alt"></i></div>',
                '<div class="agricon-delete-icon" data-id="' . $machine_soort->id . '" data-machinesoortnaam="' . $machine_soort->naam . '"><i class="fas fa-times"></i></div>'
            );
        }
        echo $this->table->generate();
    } ?>
</div>